# Laravel Passwordless Authentication

A simple, secure passwordless authentication system for Laravel applications. This package provides a complete solution for implementing magic link authentication in your Laravel projects.

## Installation

You can install the package via composer:

```bash
composer require jea/passwordless-auth
```

## Configuration

After installation, publish the package assets:

```bash
php artisan vendor:publish --provider="Jea\PasswordlessAuth\PasswordlessAuthServiceProvider"
```

This will publish:

-   Configuration file
-   Migration file
-   View templates
-   Route definitions

### Configuration Options

The published configuration file (`config/passwordless-auth.php`) contains the following options:

```php
return [
    // Time in minutes before a login token expires
    'token_expiration' => 15,

    // Where to redirect users after successful login
    'redirect_on_login' => '/dashboard',

    // Length of the generated security token
    'token_length' => 64,

    // User model to use for authentication
    'user_model' => \App\Models\User::class,

    // Field to use as login identifier (typically email)
    'login_identifier' => 'email',

    // Email template for login links
    'email_view' => 'passwordless-auth::emails.login-link',
];
```

## Database Setup

Run the migrations to create the necessary database tables:

```bash
php artisan migrate
```

This creates a `login_tokens` table to store the temporary login tokens.

## Queue Configuration

This package uses Laravel's queue system to send emails asynchronously for better performance. To configure the queue:

1. Set up your preferred queue driver in your .env file:

```
QUEUE_CONNECTION=database
```

2. If using the database driver, run the queue migration:

```
php artisan queue:table
php artisan migrate
```

3. Start the queue worker:

```
php artisan queue:work
```

## Route Integration

To include the passwordless authentication routes in your application, add the following line to your `routes/web.php` file:

```php
require_once(base_path('routes/passwordless-auth.php'));
```

## Available Routes

The package provides the following routes:

| Method | URI                                | Name                | Description                                |
| ------ | ---------------------------------- | ------------------- | ------------------------------------------ |
| GET    | /login/passwordless                | passwordless.login  | Displays the login form                    |
| POST   | /login/passwordless                | passwordless.send   | Processes the login request and sends link |
| GET    | /login/passwordless/verify/{token} | passwordless.verify | Verifies token and logs user in            |
| POST   | /logout                            | passwordless.logout | Logs the user out                          |

## Email Configuration

For the email functionality to work properly, ensure your Laravel application has proper email configuration in your `.env` file:

```plaintext
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-username
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

## Customization

### Publishing Specific Components

You can publish specific components of the package:

```bash
# Publish only configuration
php artisan vendor:publish --provider="Jea\PasswordlessAuth\PasswordlessAuthServiceProvider" --tag="config"

# Publish only migrations
php artisan vendor:publish --provider="Jea\PasswordlessAuth\PasswordlessAuthServiceProvider" --tag="migrations"

# Publish only views
php artisan vendor:publish --provider="Jea\PasswordlessAuth\PasswordlessAuthServiceProvider" --tag="views"

# Publish only routes
php artisan vendor:publish --provider="Jea\PasswordlessAuth\PasswordlessAuthServiceProvider" --tag="routes"

# Publish only email-related files
php artisan vendor:publish --provider="Jea\PasswordlessAuth\PasswordlessAuthServiceProvider" --tag="email"

# Publish only controllers
php artisan vendor:publish --provider="Jea\PasswordlessAuth\PasswordlessAuthServiceProvider" --tag="controllers"

# Publish only models
php artisan vendor:publish --provider="Jea\PasswordlessAuth\PasswordlessAuthServiceProvider" --tag="models"

# Publish all components at once
php artisan vendor:publish --provider="Jea\PasswordlessAuth\PasswordlessAuthServiceProvider" --tag="all"
```

### Customizing Views

After publishing the views, you can customize them in `resources/views/vendor/passwordless-auth/`.

## Usage Examples

### Adding Login Link to Your Application

```html
<a href="{{ route('passwordless.login') }}">Login without password</a>
```

### Adding Logout Button

```html
<form method="POST" action="{{ route('passwordless.logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>
```

### Login Flow

The passwordless authentication flow works as follows:

1. User visits the login page and enters their email address
2. A unique, secure token is generated and stored in the database
3. An email with a login link containing the token is sent to the user
4. User clicks the link in their email
5. The token is verified and the user is automatically logged in
6. The token is deleted to prevent reuse

## Troubleshooting

### Email Issues

If emails are not being sent:

1. Check your Laravel log files for errors: `storage/logs/laravel.log`
2. Verify your mail configuration in `.env`
3. Try using the log mail driver for testing: `MAIL_MAILER=log`
4. Ensure the user model has the `Notifiable` trait
5. Clear config cache: `php artisan config:clear`

### Route Issues

If routes are not working:

1. Make sure you've included the routes file in your `web.php`
2. Clear route cache: `php artisan route:clear`
3. Check for route conflicts with `php artisan route:list`

## Security Considerations

-   Login tokens expire after the configured time (default: 15 minutes)
-   Tokens are single-use and are deleted after successful login
-   Tokens are stored securely in the database with a unique constraint
-   The package uses Laravel's built-in CSRF protection

## Advanced Usage

### Custom User Provider

If you need to use a custom user provider, you can modify the `user_model` option in the configuration file.

### Custom Email Templates

You can create your own email templates by publishing the views and modifying the email template files.

### Integration with Existing Authentication

This package can be used alongside Laravel's traditional authentication system, providing users with multiple login options.

### Handling Failed Login Attempts

The package automatically handles failed login attempts by:

1. Validating the email exists in the users table
2. Checking if the token has expired
3. Providing appropriate error messages to the user

### Customizing Token Generation

If you need to customize how tokens are generated, you can publish the models and modify the `LoginToken` model.

## API Reference

### LoginToken Model

The `LoginToken` model provides the following methods:

-   `generateFor($userId)`: Generates a new token for the specified user
-   `hasExpired()`: Checks if the token has expired
-   `user()`: Relationship to the user model

### PasswordlessLoginController

The controller provides the following methods:

-   `showLoginForm()`: Displays the login form
-   `sendLoginLink(Request $request)`: Processes the login request and sends the link
-   `verifyToken(Request $request, $token)`: Verifies the token and logs the user in
-   `logout(Request $request)`: Logs the user out

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

```

```
