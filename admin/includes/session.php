<?php
include '../includes/conn.php';

// Éviter le double démarrage de session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION['admin']) || trim($_SESSION['admin']) == ''){
    header('location: ../index.php');
    exit();
}

$conn = $pdo->open();

$stmt = $conn->prepare("SELECT * FROM users WHERE id=:id");
$stmt->execute(['id'=>$_SESSION['admin']]);
$admin = $stmt->fetch();

$pdo->close();
?>