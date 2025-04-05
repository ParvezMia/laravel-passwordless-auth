<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Token Expiration Time
    |--------------------------------------------------------------------------
    |
    | Here you may specify the amount of minutes the login token should be
    | considered valid. If this time is exceeded, the token will be invalid.
    |
    */
    'token_expiration' => 15, // minutes

    /*
    |--------------------------------------------------------------------------
    | Login Route
    |--------------------------------------------------------------------------
    |
    | This is the route where users will be redirected after successful login.
    |
    */
    'redirect_on_login' => '/dashboard',

    /*
    |--------------------------------------------------------------------------
    | Token Length
    |--------------------------------------------------------------------------
    |
    | This value defines the length of the token that will be generated.
    |
    */
    'token_length' => 64,

    /*
    |--------------------------------------------------------------------------
    | User Model
    |--------------------------------------------------------------------------
    |
    | This is the model used for authentication.
    |
    */
    'user_model' => \App\Models\User::class,

    /*
    |--------------------------------------------------------------------------
    | Login Identifier
    |--------------------------------------------------------------------------
    |
    | This defines which field in the user model will be used as the identifier
    | for login (typically email).
    |
    */
    'login_identifier' => 'email',

    /*
    |--------------------------------------------------------------------------
    | Email View
    |--------------------------------------------------------------------------
    |
    | This is the view that will be used for the login email.
    |
    */
    'email_view' => 'passwordless-auth::emails.login-link',
];