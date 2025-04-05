<?php

namespace ParvezMia\LaravelPasswordlessAuth\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use ParvezMia\LaravelPasswordlessAuth\Models\LoginToken;
use ParvezMia\LaravelPasswordlessAuth\Notifications\PasswordlessLoginNotification;

class PasswordlessLoginController extends Controller
{
    /**
     * Show the login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('passwordless-auth::login');
    }

    /**
     * Send a login link to the user.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendLoginLink(Request $request)
    {
        $request->validate([
            config('passwordless-auth.login_identifier', 'email') => 'required|email|exists:users',
        ]);

        $identifier = $request->input(config('passwordless-auth.login_identifier', 'email'));
        $userModel = config('passwordless-auth.user_model');
        $user = $userModel::where(config('passwordless-auth.login_identifier', 'email'), $identifier)->first();

        // Delete any existing tokens for this user
        LoginToken::where('user_id', $user->id)->delete();

        // Generate a new token
        $token = LoginToken::generateFor($user->id);

        try {
            // Send the notification
            $user->notify(new PasswordlessLoginNotification($token->token));

            // Log successful email sending
            Log::info("Login link sent to user: {$user->id} at {$identifier}");

            return back()->with('status', 'We have emailed you a login link!');
        } catch (\Exception $e) {
            // Log the error
            Log::error("Failed to send login link: {$e->getMessage()}");

            return back()->with('error', 'We could not send the login link. Please try again later.');
        }
    }

    /**
     * Verify the login token and log the user in.
     *
     * @param  string  $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifyToken(Request $request, $token)
    {
        $loginToken = LoginToken::where('token', $token)->first();

        // Check if token exists and is valid
        if (! $loginToken || $loginToken->hasExpired()) {
            return redirect()->route('passwordless.login')
                ->with('error', 'Invalid or expired login link.');
        }

        // Log the user in
        Auth::login($loginToken->user);

        // Delete the token
        $loginToken->delete();

        return redirect(config('passwordless-auth.redirect_on_login', '/dashboard'));
    }

    /**
     * Log the user out.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
