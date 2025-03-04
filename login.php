<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Motus+</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <h1><span class="motus">Motus+</span> - Connexion</h1>
    <form action="login_action.php" method="POST">
        <input type="text" name="username" placeholder="Nom d'utilisateur" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <input type="submit" value="Se connecter">
    </form>
    <p>Pas encore inscrit ? <a class="link" href="register.php">Créer un compte</a></p>
    <a href="index.php" class="link">← Retour à l'accueil</a>
</div>

</body>
</html>
