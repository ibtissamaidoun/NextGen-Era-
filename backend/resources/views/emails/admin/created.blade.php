<!DOCTYPE html>
<html>
<head>
    <title>Admin Account Created</title>
</head>
<body>
    <h1>Hello {{ $name }},</h1>
    <p>Your admin account has been created successfully. Here are your login details:</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Password:</strong> {{ $password }}</p>
    <p>Please change your password after your first login and update your personal data.</p>
</body>
</html>