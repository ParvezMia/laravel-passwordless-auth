@component('mail::message')
# Your Login Link

You requested a passwordless login link. Click the button below to log in:

@component('mail::button', ['url' => $url])
Log In
@endcomponent

If you didn't request this link, you can safely ignore this email.

This link will expire in {{ config('passwordless-auth.token_expiration', 15) }} minutes.

If you're having trouble clicking the button, copy and paste the URL below into your web browser:
{{ $url }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent