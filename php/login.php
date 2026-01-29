<?php
session_start();
include '../php/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $check = $conexion->prepare('SELECT * FROM agence WHERE adress = :adress');
    $check->execute([':adress' => $email]);
    $array = $check->fetch(PDO::FETCH_ASSOC);

    if ($array && $password === $array['password']) {
        $_SESSION["id_agence"] = $array['id_agence'];
        $_SESSION["connecter"] = true;
        
        header('Location: ../php/tableagence.php');
        exit();
    } else {
        $_SESSION['error_info_invalid'] = "Email ou mot de passe incorrect.";
        header('Location: ../html/loginht.php');
        exit();
    }
}
