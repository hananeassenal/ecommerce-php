<?php
include 'includes/conn.php';
session_start();

// On vérifie si on est dans le dossier admin ou non
$isAdminPath = strpos($_SERVER['REQUEST_URI'], '/admin/') !== false;

// Si on n'est pas dans le dossier admin et qu'on est connecté en admin
if(!$isAdminPath && isset($_SESSION['admin'])){
    header('location: admin/home.php');
    exit();
}

// Si on est dans le dossier admin mais qu'on n'est pas connecté en admin
if($isAdminPath && !isset($_SESSION['admin'])){
    header('location: ../login.php');
    exit();
}

// Gestion des utilisateurs normaux
if(isset($_SESSION['user'])){
    $conn = $pdo->open();

    try{
        $stmt = $conn->prepare("SELECT * FROM users WHERE id=:id");
        $stmt->execute(['id'=>$_SESSION['user']]);
        $user = $stmt->fetch();
    }
    catch(PDOException $e){
        echo "There is some problem in connection: " . $e->getMessage();
    }

    $pdo->close();
}
?>