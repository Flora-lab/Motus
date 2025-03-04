<?php
session_start();
$emailError = $_SESSION['email_error'] ?? '';
$usernameError = $_SESSION['username_error'] ?? '';
unset($_SESSION['email_error'], $_SESSION['username_error']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - Motus+</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <h1><span class="motus">Motus+</span> - Inscription</h1>
    <form action="register_action.php" method="POST">
    <input type="text" name="username" placeholder="Nom d'utilisateur" required>
    <?php if ($usernameError): ?>
        <p class="error-message"><?= $usernameError ?></p>
    <?php endif; ?>
        <input type="email" name="email" placeholder="Adresse email" required>
        <?php if ($emailError): ?>
            <p class="error-message"><?= $emailError ?></p>
        <?php endif; ?>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <input type="password" name="confirm_password" placeholder="Confirmez le mot de passe" required>
        <input type="submit" value="S'inscrire">
    </form>
    <p>Déjà inscrit ? <a class="link" href="login.php">Se connecter</a></p>
    <a href="index.php" class="link">← Retour à l'accueil</a>
</div>

</body>
</html>
