    const form = document.getElementById('guessForm');
    const result = document.getElementById('result');
    const replayButton = document.getElementById('replayButton');
    const scoreButton = document.getElementById('scoreButton');
    const messageZone = document.getElementById('gameMessage');

    let attempts = 0;
    let seconds = 0;
    const maxAttempts = 6;

    setInterval(() => {
        seconds++;
        document.getElementById('timer').innerText = `Temps écoulé : ${seconds} seconde${seconds > 1 ? 's' : ''}`;
    }, 1000);

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const guessInput = document.getElementById('guess');
        const guess = guessInput.value.toUpperCase();
        attempts++;

        let feedback = '';
        let success = true;
        for (let i = 0; i < secretWord.length; i++) {
            const letter = guess[i] || '';
            if (letter === secretWord[i]) {
                feedback += `<span class="correct">${letter}</span>`;
            } else if (secretWord.includes(letter)) {
                feedback += `<span class="wrong">${letter}</span>`;
                success = false;
            } else {
                feedback += `<span class="absent">${letter}</span>`;
                success = false;
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
        } else {
            messageZone.innerText = "❌ Échec, essayez encore...";
        }
    });

    function saveScore() {
        fetch('score.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `attempts=${attempts}&time=${seconds}&difficulty=${difficulty}`
        });
    }
