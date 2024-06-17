<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Compte Administrateur Créé</title>
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
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background: #FFA500; /* Orange */
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .email-body {
            padding: 30px;
            line-height: 1.6;
            color: #070707;
        }
        .email-body h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .email-body p {
            font-size: 16px;
            margin-bottom: 15px;
        }
        .email-body strong {
            color: #FFA500;
        }
        .email-footer {
            text-align: center;
            padding: 20px;
            background: #f4f4f4;
            color: #777777;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>NextGen Era</h1>
        </div>
        <div class="email-body">
            <h1>Bonjour {{ $name }},</h1>
            <p>Votre compte administrateur a été créé avec succès. Voici vos détails de connexion :</p>
            <p><strong>Email :</strong> {{ $user->email }}</p>
            <p><strong>Mot de passe :</strong> {{ $password }}</p>
            <p>Veuillez changer votre mot de passe après votre première connexion et mettre à jour vos données personnelles.</p>
        </div>
        <div class="email-footer">
            Cordialement,<br>
            L'équipe de NextGen Era
        </div>
    </div>
</body>
</html>
