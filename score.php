<?php
session_start();
require_once 'php/Database.php';

if (isset($_SESSION['user_id'], $_SESSION['username'], $_POST['attempts'], $_POST['time'], $_POST['difficulty'])) {
    $stmt = $pdo->prepare("INSERT INTO scores (user_id, username, difficulty, attempts, time, played_at) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->execute([
        $_SESSION['user_id'],
        $_SESSION['username'],
        $_POST['difficulty'],
        $_POST['attempts'],
        $_POST['time']
    ]);
}
?>

