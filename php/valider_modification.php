<?php
// valider_modification.php
require_once("connexiondata.php");
session_start();

if (!isset($_SESSION['id_agence'])) {
    die("<p>ID agence manquant. Veuillez vous connecter.</p>");
}
if (!isset($_GET['id_article'])) {
    die("<p>ID de l'article manquant.</p>");
}

$id_agence = $_SESSION['id_agence'];
$id_article = intval($_GET['id_article']);
$conn = connexion_data("localhost", "root", "", "agences");

function enregistrer_images($id_agence, $id_article, $conn)
{
    if (empty($_FILES['images']['name'][0])) {
        return []; // aucune image soumise
    }

    // Supprimer les anciennes images
    $stmt_select = $conn->prepare("SELECT chemin FROM images WHERE id_article_location = ?");
    $stmt_select->execute([$id_article]);
    $anciennes_images = $stmt_select->fetchAll(PDO::FETCH_ASSOC);

    foreach ($anciennes_images as $img) {
        if (file_exists($img['chemin'])) {
            unlink($img['chemin']);
        }
    }

    $stmt_delete = $conn->prepare("DELETE FROM images WHERE id_article_location = ?");
    $stmt_delete->execute([$id_article]);

    // Enregistrer les nouvelles images
    $dossier = "uploads/agence_$id_agence/";
    if (!file_exists($dossier)) {
        mkdir($dossier, 0777, true);
    }
    $types_autorises = ['jpg', 'jpeg', 'png', 'webp'];
    $chemins = [];

    foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
        $nom_fichier = $_FILES['images']['name'][$key];
        $tmp_fichier = $_FILES['images']['tmp_name'][$key];
        $erreur = $_FILES['images']['error'][$key];

        if ($erreur === UPLOAD_ERR_OK) {
            $extension = strtolower(pathinfo($nom_fichier, PATHINFO_EXTENSION));
            if (in_array($extension, $types_autorises)) {
                $nom_unique = uniqid('img_') . '.' . $extension;
                $chemin = $dossier . $nom_unique;

                if (move_uploaded_file($tmp_fichier, $chemin)) {
                    $chemins[] = $chemin;
                    $stmt = $conn->prepare("INSERT INTO images (chemin, id_article_location) VALUES (?, ?)");
                    $stmt->execute([$chemin, $id_article]);
                }
            }
        }
    }

    return $chemins;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validation des champs obligatoires
        $champs_obligatoires = [
            'categorie',
            'marque',
            'type_marque',
            'modele',
            'couleur',
            'carburant',
            'type_boite',
            'kilometrage',
            'nombre_place',
            'nombre_porte',
            'matricule',
            'prix_location',
            'date_debut',
            'date_fin',
            'statut'
        ];

        $erreurs = [];
        foreach ($champs_obligatoires as $champ) {
            if (empty(trim($_POST[$champ]))) {
                $erreurs[] = "Le champ " . ucfirst(str_replace('_', ' ', $champ)) . " est obligatoire.";
            }
        }

        $date_debut = new DateTime($_POST['date_debut']);
        $date_fin = new DateTime($_POST['date_fin']);
        if ($date_fin < $date_debut) {
            $erreurs[] = "La date de fin doit être après la date de début.";
        }

        if (!empty($erreurs)) {
            throw new Exception(implode('<br>', $erreurs));
        }

        $categorie = htmlspecialchars(trim($_POST['categorie']));
        $marque = htmlspecialchars(trim($_POST['marque']));
        $type_marque = htmlspecialchars(trim($_POST['type_marque']));
        $modele = intval($_POST['modele']);
        $couleur = htmlspecialchars(trim($_POST['couleur']));
        $carburant = htmlspecialchars(trim($_POST['carburant']));
        $type_boite = htmlspecialchars(trim($_POST['type_boite']));
        $kilometrage = intval($_POST['kilometrage']);
        $nombre_place = intval($_POST['nombre_place']);
        $nombre_porte = intval($_POST['nombre_porte']);
        $matricule = htmlspecialchars(trim($_POST['matricule']));
        $prix_location = floatval($_POST['prix_location']);
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
        $statut = htmlspecialchars(trim($_POST['statut']));
        $accessoires = isset($_POST['accessoires']) ? $_POST['accessoires'] : [];
        $info_sup = !empty($accessoires) ? implode(',', $accessoires) : 'Aucun';

        // Mise à jour de l'article
        $sql = "UPDATE article_location SET 
            categorie = ?, marque = ?, type_marque = ?, modele = ?, couleur = ?, carburant = ?, 
            type_boite = ?, kilometrage = ?, nombre_place = ?, nombre_porte = ?, matricule = ?, 
            info_supplimentaire = ?, statut = ?, date_debut = ?, date_fin = ?, prix_location = ? 
            WHERE id_article_location = ?";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            $categorie,
            $marque,
            $type_marque,
            $modele,
            $couleur,
            $carburant,
            $type_boite,
            $kilometrage,
            $nombre_place,
            $nombre_porte,
            $matricule,
            $info_sup,
            $statut,
            $date_debut,
            $date_fin,
            $prix_location,
            $id_article
        ]);

        // Traitement des images
        $images = enregistrer_images($id_agence, $id_article, $conn);

        // Succès
        header("Location: tableagence.php?modification=1");
        exit;
    } catch (Exception $e) {
        echo "<div style='background:#f8d7da;color:#721c24;padding:20px;margin:20px;border-radius:5px;'>
                <h3>Erreur</h3>
                <p>{$e->getMessage()}</p>
                <a href='javascript:history.back()'>Retour</a>
              </div>";
    }
}
