<?php
session_start();
require_once 'php/Database.php';

// Fonction pour récupérer les scores par difficulté
function getTopScores($pdo, $difficulty) {
    $stmt = $pdo->prepare("
        SELECT username, attempts, time 
        FROM scores 
        WHERE difficulty = ? 
        ORDER BY attempts ASC, time ASC 
        LIMIT 5
    ");
    $stmt->execute([$difficulty]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Récupération des scores
$easyScores = getTopScores($pdo, 'easy');
$mediumScores = getTopScores($pdo, 'medium');
$hardScores = getTopScores($pdo, 'hard');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>🏅 Wall of Fame 🏅</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <h1>🏅 Wall of Fame 🏅</h1>

    <!-- Affichage des scores Facile -->
    <h2>Top 5 - Facile</h2>
    <?php displayScores($easyScores); ?>

    <!-- Affichage des scores Moyen -->
    <h2>Top 5 - Moyen</h2>
    <?php displayScores($mediumScores); ?>

    <!-- Affichage des scores Difficile -->
    <h2>Top 5 - Difficile</h2>
    <?php displayScores($hardScores); ?>

    <a href="index.php" class="button">🏠 Retour à l'accueil</a>
</div>

</body>
</html>

<?php
// Fonction pour afficher un tableau de scores
function displayScores($scores) {
    if (empty($scores)) {
        echo "<p>Aucun score disponible pour ce niveau.</p>";
        return;
    }

    echo "<table>
        <thead>
            <tr>
                <th>Rang</th>
                <th>Joueur</th>
                <th>Essais</th>
                <th>Temps (s)</th>
            </tr>
        </thead>
        <tbody>";

    $rank = 1;
    foreach ($scores as $score) {
        echo "<tr>
            <td>{$rank}</td>
            <td>" . htmlspecialchars($score['username']) . "</td>
            <td>{$score['attempts']}</td>
            <td>{$score['time']}</td>
        </tr>";
        $rank++;
    }

    echo "</tbody></table>";
}
?>
