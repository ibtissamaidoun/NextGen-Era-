<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réinitialisation de votre mot de passe</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border: 1px solid #dddddd;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background: #004a99;
            color: #ffffff;
            padding: 10px 20px;
            text-align: center;
        }
        .email-body {
            padding: 20px;
            line-height: 1.5;
            color: #333333;
        }
        .email-footer {
            text-align: center;
            padding: 10px 20px;
            background: #f4f4f4;
            color: #777777;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 20px 0;
            color: #ffffff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            
        </div>
        <div class="email-body">
            <h1>Réinitialisation de votre mot de passe</h1>
            <p>Bonjour,</p>
            <p>Vous recevez cet email parce que nous avons reçu une demande de réinitialisation du mot de passe pour votre compte.</p>
            <a href="{{ url('password/reset', $token) }}" class="button">Réinitialiser le mot de passe</a>
            <p>Si vous n'avez pas demandé de réinitialisation de mot de passe, aucune action supplémentaire n'est requise.</p>
        </div>
        <div class="email-footer">
            Cordialement,<br>
            L'équipe de NextGen Era
        </div>
    </div>
</body>
</html>
