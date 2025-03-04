<?php
session_start();
require_once 'php/Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($password !== $confirmPassword) {
        echo "❌ Les mots de passe ne correspondent pas.";
        exit();
    }

        // Vérifier si l'email existe déjà
    $checkEmail = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $checkEmail->execute([$email]);
    if ($checkEmail->fetch()) {
        $_SESSION['email_error'] = "❌ Cette adresse email est déjà utilisée.";
        header('Location: register.php');
        exit();
    }

    // Vérifier si le nom d'utilisateur existe déjà
    $checkUsername = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $checkUsername->execute([$username]);
    if ($checkUsername->fetch()) {
        $_SESSION['username_error'] = "❌ Ce nom d'utilisateur est déjà pris.";
        header('Location: register.php');
        exit();
    }


    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$username, $email, $passwordHash]);

    header('Location: login.php');
    exit();
}
?>
