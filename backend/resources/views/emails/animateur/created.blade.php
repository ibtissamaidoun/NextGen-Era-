<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to Our Platform</title>
</head>
<body>
    <h1>Hello {{ $name }},</h1>
    <p>Your account as an Animateur has been created successfully. Here are your login details:</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Password:</strong> {{ $password }}</p>
    <p>Please change your password upon your first login, and update your personal data for security reasons.</p>
</body>
</html>