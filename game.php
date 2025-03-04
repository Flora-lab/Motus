<?php
session_start();
require_once 'php/Database.php';
require_once 'php/Game.php';

// Vérification que l'utilisateur est connecté
if (!isset($_SESSION['user_id'], $_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$difficulty = $_GET['difficulty'] ?? 'medium';
$length = ['easy' => 4, 'medium' => 6, 'hard' => 8][$difficulty] ?? 6;
$secretWord = Game::getRandomWord($length);

if (!$secretWord) {
    die("Aucun mot trouvé !");
}

$firstLetter = $secretWord[0];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motus+ - Jeu</title>
    <link rel="stylesheet" href="css/style.css">
    <script>
        const secretWord = "<?= $secretWord ?>";
        const secretWordLength = <?= strlen($secretWord); ?>;
        const firstLetter = "<?= $firstLetter ?>";
        const difficulty = "<?= $difficulty ?>";
    </script>
    <script src="js/motus.js" defer></script>
</head>
<body>

<div class="container">
    <h1>Motus+ 🎮</h1>
    <p><strong>Difficulté :</strong> <?= ucfirst($difficulty) ?></p>
    <p id="motADeviner"></p>
    <p id="timer">Temps écoulé : 0 seconde</p>
    
    <form id="guessForm">
        <input type="text" id="guess" maxlength="<?= $length ?>" placeholder="Entrez un mot de <?= $length ?> lettres" required autofocus>
        <input type="submit" value="Essayer">
    </form>

    <div id="result"></div>

    <button id="replayButton" style="display:none;" class="button" onclick="location.reload()">🔄 Rejouer</button>
    <a href="walloffame.php" id="scoreButton" style="display:none;" class="button">🏆 Voir le Wall of Fame</a>
    <a href="index.php" class="button">🏠 Retour à l'accueil</a>
</div>

<script>
let seconds = 0;
let attempts = 0;
const maxAttempts = 6;
const userId = "<?= $_SESSION['user_id'] ?>";
const username = "<?= $_SESSION['username'] ?>";

// Timer
setInterval(() => {
    seconds++;
    document.getElementById('timer').innerText = `Temps écoulé : ${seconds} seconde${seconds > 1 ? 's' : ''}`;
}, 1000);

document.getElementById('motADeviner').innerText = `Le mot à trouver est ${firstLetter}${'_ '.repeat(secretWordLength - 1)}`;

const form = document.getElementById('guessForm');
const result = document.getElementById('result');
const replayButton = document.getElementById('replayButton');
const scoreButton = document.getElementById('scoreButton');

form.addEventListener('submit', (e) => {
    e.preventDefault();
    const guessInput = document.getElementById('guess');
    const guess = guessInput.value.toUpperCase();
    attempts++;

    let feedback = '';
    for (let i = 0; i < secretWord.length; i++) {
        const letter = guess[i] || '';
        if (letter === secretWord[i]) {
            feedback += `<span class="correct">${letter}</span>`;
        } else if (secretWord.includes(letter)) {
            feedback += `<span class="wrong">${letter}</span>`;
        } else {
            feedback += `<span class="absent">${letter}</span>`;
        }
    }

    result.innerHTML += `<p>${feedback}</p>`;
    guessInput.value = '';

    if (guess === secretWord) {
        alert(`🎉 Bravo ! Mot trouvé en ${attempts} tentatives.`);
        saveScore();
        replayButton.style.display = 'block';
        scoreButton.style.display = 'block';
    } else if (attempts >= maxAttempts) {
        alert(`❌ Perdu ! Le mot était ${secretWord}.`);
        saveScore();
        replayButton.style.display = 'block';
        scoreButton.style.display = 'block';
    }
});

// Envoi du score à score.php
function saveScore() {
    fetch('score.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `attempts=${attempts}&time=${seconds}&difficulty=${difficulty}`
    });
}
</script>

</body>
</html>
