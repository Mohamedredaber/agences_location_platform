<?php
session_start();
include '../php/conexion.php';
if($_SERVER['REQUEST_METHOD']==="POST"){
    $nom = $_POST['agencName'];
    $adress = $_SESSION['email']; 
    $password = $_POST['password'];
    $ville = $_POST['city'];
    $numerotel = $_POST['phone'];
    $horaired = $_POST['datedebut'];
    $horairef = $_POST['datefin'];
    $facebook = $_POST['facebook'];
    $instagrame = $_POST['instagram'];
    $linkedin = $_POST['linkedin'];
    $twiter = $_POST['twitter'];
}




$logo = null; // initialiser
if (isset($_FILES['agencLogo']) && $_FILES['agencLogo']['error'] === 0) {
    $dossier = '../imgclient/logos/';
    if (!is_dir($dossier)) {
        mkdir($dossier, 0755, true);
    }
    $ext = pathinfo($_FILES['agencLogo']['name'], PATHINFO_EXTENSION);
    $fichier_nom = 'img_' . uniqid() . '.' . $ext;
    $cheminFinal = $dossier . $fichier_nom;
    if (move_uploaded_file($_FILES['agencLogo']['tmp_name'], $cheminFinal)) {
        $logo = 'imgclient/logos/' . $fichier_nom; // stocker le chemin relatif correct
    }
}

try {
    $insert = $conexion->prepare("INSERT INTO agence (nom, adress, logo, password, ville, numerotel, horaired, horairef, facebook, instagrame, linkedin, twiter)
    VALUES (:nom, :adress, :logo, :password, :ville, :numerotel, :horaired, :horairef, :facebook, :instagrame, :linkedin, :twiter)");

    $insert->execute([
        ':nom' => $nom,
        ':adress' => $adress,
        ':logo' => $logo,
        ':password' => $password,
        ':ville' => $ville,
        ':numerotel' => $numerotel,
        ':horaired' => $horaired,
        ':horairef' => $horairef,
        ':facebook' => $facebook,
        ':instagrame' => $instagrame,
        ':linkedin' => $linkedin,
        ':twiter' => $twiter
    ]);

    unset($_SESSION['email']);
    header('Location: ../php/tableagence.php'); // Corrigé : pas php/php/acceill.php
    exit();
} catch (PDOException $e) {
    echo "Erreur lors de l'insertion : " . $e->getMessage();
}
