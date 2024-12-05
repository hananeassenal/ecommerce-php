<?php
// admin/includes/auth.php

// Check if not logged in
if(!isset($_SESSION['admin'])){
    header('location: ../login.php');
    exit();
}

// Get admin details
$conn = $pdo->open();
try{
    $stmt = $conn->prepare("SELECT * FROM users WHERE id=:id");
    $stmt->execute(['id'=>$_SESSION['admin']]);
    $admin = $stmt->fetch();
}
catch(PDOException $e){
    echo "There is some problem in connection: " . $e->getMessage();
}
$pdo->close();
?>