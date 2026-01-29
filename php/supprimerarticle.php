<?php
session_start(); 
$id_agence = $_SESSION['id_agence'] ?? null;
if (!isset($_GET['id']) || !is_numeric($_GET['id']) || $_GET['id'] <= 0) {
    die("ID invalide ou manquant.");
}
$id_voiture = (int) $_GET['id'];

require_once("connexiondata.php");
try {
    $con = connexion_data("localhost", "root", "", "agences");

    // Vérifier que l'article existe
    $verif = $con->prepare("SELECT COUNT(*) FROM article_location WHERE id_article_location = :id");
    $verif->bindParam(":id", $id_voiture, PDO::PARAM_INT);
    $verif->execute();

    if ($verif->fetchColumn() == 0) {
        die("L'article n'existe pas ou a déjà été supprimé.");
    }
    // Récupérer les images associées à cet article
    $stmt = $con->prepare("SELECT chemin FROM images WHERE id_article_location = :id"); 
    $stmt->bindParam(":id", $id_voiture, PDO::PARAM_INT);
    $stmt->execute();
    $images = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Supprimer les fichiers image du dossier
    foreach ($images as $img) {
        // Assure-toi que le champ 'chemin' contient juste le nom du fichier (ex: "image1.jpg")
        $dossier = "uploads/agence_$id_agence/";
        $chemin_image = "$dossier/" . basename($img['chemin']); // sécurise le chemin
        if (file_exists($chemin_image)) {
            if (unlink($chemin_image)) {
                echo "Image supprimée : $chemin_image<br>";
            } else {
                echo "Erreur lors de la suppression de : $chemin_image<br>";
            }
        } else {
            echo "Fichier introuvable : $chemin_image<br>";
        }
       
    }
    $contenu_dossier = array_diff(scandir($dossier), ['.', '..']);
    if (empty($contenu_dossier)) {
        if (rmdir($dossier)) {
            echo "Dossier supprimé : $dossier<br>";
        } else {
            echo "Impossible de supprimer le dossier : $dossier<br>";
        }
    }
    // Supprimer les images de la base de données
    $stmt_del_images = $con->prepare("DELETE FROM images WHERE id_article_location = :id");
    $stmt_del_images->bindParam(":id", $id_voiture, PDO::PARAM_INT);
    $stmt_del_images->execute();

    // Supprimer l'article
    $supprimer = $con->prepare("DELETE FROM article_location WHERE id_article_location = :id");
    $supprimer->bindParam(":id", $id_voiture, PDO::PARAM_INT);
    $supprimer->execute();
    // Redirection
    header("Location: tableagence.php?msg=suppression_success");
    exit();
} catch (PDOException $e) {
    echo "Erreur lors de la suppression : " . htmlspecialchars($e->getMessage());
}
