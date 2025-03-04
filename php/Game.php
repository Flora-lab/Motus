<?php
require_once 'Database.php';

class Game {
    public static function getRandomWord($length) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT word FROM words WHERE CHAR_LENGTH(word) = ? ORDER BY RAND() LIMIT 1");
        $stmt->execute([$length]);
        return strtoupper($stmt->fetchColumn());
    }
}
?>

