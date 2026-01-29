<?php
// filtrer par marque
require_once("connexiondata.php");
$conn = connexion_data("localhost", "root", "", "agences");
// Initialisation
$marque = '';
$resultats = [];
$date_actuel = date("Y-m-d");
$anne_actuel = (int) date("Y");
$requette = "SELECT * FROM article_location WHERE statut = 'disponible' AND date_fin > :date_actuel AND date_debut <= :date_actuel ";
$params = [":date_actuel" => $date_actuel];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['marque'])) {
        $requette .= " AND marque = :marque";

        $params[':marque'] = $_POST['marque'];
    }
    if (!empty($_POST["prix"])) {
        $prix = $_POST["prix"];
        $filtresPrix = [
            "1" => " AND (prix_location BETWEEN 100 AND 499)",
            "2" => " AND (prix_location BETWEEN 500 AND 999)",
            "3" => " AND (prix_location BETWEEN 1000 AND 1999)",
            "4" => " AND (prix_location BETWEEN 2000 AND 5000)"
        ];

        if (array_key_exists($prix, $filtresPrix)) {
            $requette .= " " . $filtresPrix[$prix];
        }
    }

    if (!empty($_POST["class"])) {
        $requette .= " AND categorie =:categorie";
        $params[':categorie'] = $_POST['class'];
    }
    if (!empty($_POST["model"])) {
        $requette .=  "         AND modele =:model";
        $params[':model'] = $_POST['model'];
    }
    if (!empty($_POST['carburant'])) {
        $requette .= " AND carburant =:carburant";
        $params[':carburant'] = $_POST['carburant'];
    }
    if (!empty($_POST['type_boite'])) {
        $requette .= " AND type_boite =:type_boite";
        $params[':type_boite'] = $_POST['type_boite'];
    }
    if (!empty($_POST['nombre_place'])) {
        $requette .= " AND nombre_place =:nombre_place";
        $params[':nombre_place'] = $_POST['nombre_place'];
    }
    if (!empty($_POST['couleur'])) {
        $requette .= " AND couleur = :couleur";
        $params[':couleur'] = $_POST['couleur'];
    }
}
$stmt = $conn->prepare($requette);
$stmt->execute($params);
$resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
session_start();

if (isset($_SESSION['error'])) {
    echo "<script>alert('" . addslashes($_SESSION['error']) . "');</script>";
    unset($_SESSION['error']); // Supprime l’erreur après affichage
}
require_once("connexiondata.php");
$con = connexion_data("localhost", "root", "", "agences");
if ($con) {
    $inserer_model = $con->prepare("SELECT DISTINCT marque FROM article_location");
    $inserer_model->execute();
    $resultat = $inserer_model->fetchAll(PDO::FETCH_ASSOC);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <title>Document</title>
    <link rel="stylesheet" href="../css/accueil.css">
    <link href="acceill.css" rel="stylesheet">
</head>

<body>
    <a href="../html/loginht.php">se connecter</a>
    <a href="../html/verifierht.php">creer accounts</a>
    <div class="parent">
        <div class="row filtrer">
            <div>
                <h1>Filtrer par</h1>
            </div>
            <!-- Avant ta balise <form> -->
            <!-- <?php 
            $marque_selectionnee = $_POST['marque'] ?? '';
            $_SESSION['marque_selectionnee']= $marque_selectionnee;
             ?>
            <div>
           
                <form action="" method="post">
                    <select name="marque" onchange="this.form.submit()">
                        <option value="" disabled <?= ($marque_selectionnee == '') ? 'selected' : '' ?>>Filtrer par marque disponible</option>

                        <?php foreach ($resultat as $elem): ?>
                            <option value="<?= htmlspecialchars($_SESSION['marque_selectionnee']) ?>" <?= ($marque_selectionnee == $_SESSION['marque_selectionnee']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($_SESSION['marque_selectionnee']) ?>
                            </option>
                    
                        <?php endforeach; ?>
                    </select>
                </form>
            </div> -->

            <div>
                <form action="" method="post">
                    <select name="marque" onchange="this.form.submit()">
                        <option style="color: white;" value="" selected disabled>Filtrer par marque disponible</option>
                        <?php foreach ($resultat as $elem): ?>
                            <option value="<?= htmlspecialchars($elem['marque']) ?>">
                                <?= htmlspecialchars($elem['marque']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>
            <div>
                <form action="" method="post">
                    <select name="prix" onchange="this.form.submit()">
                        <option style="color: white;" value="" selected disabled>Filtrer par prix</option>
                        <option value="1">100 - 499</option>
                        <option value="2">500 - 999</option>
                        <option value="3">1000 - 1999</option>
                        <option value="4">2000 - 5000</option>

                    </select>
                </form>
            </div>
            <div>
                <form action="" method="post">
                    <select name="class" onchange="this.form.submit()">
                        <option style="color: white;" value="" selected disabled>Filtrer par class</option>
                        <option value="économique">économique</option>
                        <option value="moyenne">moyenne</option>
                        <option value="luxe">luxe</option>
                    </select>
                </form>
            </div>
            <div>
                <form action="" method="post">
                    <select name="model" onchange="this.form.submit()">
                        <option style="color: white;" value="" selected disabled>Filtrer par modèle</option>
                        <?php
                        $anne_actuel = (int) date("Y");
                        for ($i = $anne_actuel - 5; $i <= $anne_actuel; $i++) {
                            echo "<option value=\"$i\">$i</option>";
                        }
                        ?>
                    </select>
                </form>
            </div>
            <div>
                <form action="" method="post">
                    <select name="carburant" onchange="this.form.submit()">
                        <option style="color: white;" value="" selected disabled>Filtrer par type de carburant</option>
                        <option value="Essence">Essence</option>
                        <option value="Diesel">Diesel</option>
                        <option value="Hybride">Hybride</option>
                        <option value="Électrique">Électrique</option>
                    </select>
                </form>
            </div>
            <div>
                <form action="" method="post">
                    <select name="type_boite" onchange="this.form.submit()">
                        <option style="color: white;" value="" selected disabled>Filtrer par type de boite</option>
                        <option value="Manuele">Manuele</option>
                        <option value="Automatique">Automatique</option>
                    </select>
                </form>
            </div>
            <div>
                <form action="" method="post">
                    <select name="type_boite" onchange="this.form.submit()">
                        <option style="color: white;" value="" selected disabled>Filtrer par type de couleur disponible</option>
                        <?php
                        $selecter_couleur = $con->prepare("SELECT DISTINCT couleur FROM article_location");
                        $selecter_couleur->execute();
                        $resultat_couleur = $selecter_couleur->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                        <?php foreach ($resultat_couleur as $couleur): ?>
                            <option value="<?= htmlspecialchars($couleur["couleur"])  ?>"><?= htmlspecialchars($couleur["couleur"])  ?></option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>
            <div>
                <form action="" method="post">
                    <select name="nombre_place" onchange="this.form.submit()">
                        <option style="color: white;" value="" selected disabled>Filtrer par nombre de place disponible</option>
                        <?php
                        $selecter_place = $con->prepare("SELECT DISTINCT nombre_place FROM article_location");
                        $selecter_place->execute();
                        $resultat_place = $selecter_place->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                        <?php foreach ($resultat_place as $place): ?>
                            <option value="<?= htmlspecialchars($place["nombre_place"])  ?>"><?= htmlspecialchars($place["nombre_place"])  ?></option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>
        </div>
    </div>

</body>

</html>