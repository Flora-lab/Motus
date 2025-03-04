<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Motus+ - Accueil</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Bienvenue sur <span class="motus">Motus+</span></h1>
        <p>Choisissez votre niveau de difficulté :</p>

        <div class="buttons">
            <a href="game.php?difficulty=easy" class="btn">Facile</a>
            <a href="game.php?difficulty=medium" class="btn">Moyen</a>
            <a href="game.php?difficulty=hard" class="btn">Difficile</a>
        </div>

        <div class="auth-buttons">
            <a href="login.php" class="btn-secondary">Connexion</a>
            <a href="register.php" class="btn-secondary">Inscription</a>
        </div>

        <a href="walloffame.php" class="link">🎖️ Voir les meilleurs scores</a><br>
        <?php if (isset($_SESSION['username'])): ?>
        <a href="logout.php" class="button">🚪 Déconnexion</a>
        <?php endif; ?>
      
    </div>
    
</body>
</html>
