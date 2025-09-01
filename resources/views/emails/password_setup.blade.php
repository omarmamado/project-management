<!-- resources/views/emails/password_setup.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Account Setup</title>
</head>
<body>
    <h1>Welcome, {{ $user->name }}!</h1>
    <p>Your account has been created. You can log in using the following credentials:</p>
    
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Password:</strong> {{ $password }}</p>

    <p>You can log in using the following link:</p>
    <p><a href="{{ $loginLink }}">Click here to login</a></p>

    <p>We recommend that you change your password after your first login.</p>

    <p>Thank you!</p>
</body>
</html>
