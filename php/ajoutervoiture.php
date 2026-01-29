<?php
// ajoutervoiture.php
require_once("connexiondata.php");

function enregistrer_images($id_agence, $id_article, $conn)
{
    $dossier = "uploads/agence_$id_agence/";
    if (!file_exists($dossier)) {
        mkdir($dossier, 0777, true);
    }
    $chemins = [];
    $types_autorises = ['jpg', 'jpeg', 'png', 'webp'];

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
                    // Enregistrer dans la base de données
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
        session_start();
        // Vérifier l'existence du cookie d'agence
        if (!isset($_SESSION['id_agence'])) {
            throw new Exception('ID agence manquant. Veuillez vous connecter.');
        }

        $id_agence = $_SESSION['id_agence'];

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
        // Vérifier les dates
        $date_debut = new DateTime($_POST['date_debut']);
        $date_fin = new DateTime($_POST['date_fin']);

        if ($date_fin < $date_debut) {
            $erreurs[] = "La date de fin doit être après la date de début.";
        }

        // Vérifier les fichiers images
        if (empty($_FILES['images']['name'][0])) {
            $erreurs[] = "Veuillez sélectionner au moins une image.";
        }

        // Si erreurs, les afficher
        if (!empty($erreurs)) {
            throw new Exception(implode('<br>', $erreurs));
        }
        // Préparer les données
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
        // Gérer les accessoires
        $accessoires = isset($_POST['accessoires']) ? $_POST['accessoires'] : [];
        $info_sup = !empty($accessoires) ? implode(',', $accessoires) : 'Aucun';
        // Connexion à la base de données
        $conn = connexion_data("localhost", "root", "", "agences");

        // Insérer l'article
        $sql = "INSERT INTO article_location (
            categorie, marque, type_marque, modele, couleur, carburant,
            type_boite, kilometrage, nombre_place, nombre_porte, matricule,
            info_supplimentaire, statut, date_debut, date_fin, prix_location, id_agence
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
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
            $id_agence
        ]);

        // Récupérer l'ID du nouvel article
        $id_article = $conn->lastInsertId();

        // Traitement des images
        $images = enregistrer_images($id_agence, $id_article, $conn);
        if (empty($images)) {
            throw new Exception("Erreur lors de l'enregistrement des images.");
        }
        // Redirection avec message de succès
        header("Location: tableagence.php?success=1");
        exit;
    } catch (Exception $e) {
        // Afficher l'erreur
        echo "<div style='background:#f8d7da;color:#721c24;padding:20px;margin:20px;border-radius:5px;'>
                <h3>Erreur</h3>
                <p>{$e->getMessage()}</p>
                <a href='javascript:history.back()'>Retour au formulaire</a>
              </div>";
    }
}
