
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
        <link rel="stylesheet" href="ofrre.css">
        <link rel="stylesheet" href="../css/acc.css">

</head>
<body>
    




<?php
session_start();




// Forcer la suppression de la session
session_unset();       // Vide $_SESSION[]
session_destroy();     // Supprime la session côté serveur
// Supprimer le cookie de session (important si redirection continue malgré session_destroy)

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
);
}
require_once("connexiondata.php");
$conn = connexion_data("localhost", "root", "", "agences");


$date_actuel = date("Y-m-d");

$requette = "SELECT a.*, i.chemin, ag.nom 
    FROM article_location a
    LEFT JOIN images i ON a.id_article_location = i.id_article_location
    LEFT JOIN agence ag ON a.id_agence = ag.id_agence
    WHERE a.statut = 'disponible' 
    AND a.date_fin > :date_actuel 
    AND a.date_debut >= :date_actuel";

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
        $requette .=  " AND modele =:model";
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
$resultat = $stmt->fetchAll(PDO::FETCH_ASSOC);
$articles = [];
foreach ($resultat as $row) {
    $id = $row['id_article_location'];

    if (!isset($articles[$id])) {
        $articles[$id] = [
            'id_article_location' => $row['id_article_location'],
            'date_debut' => $row['date_debut'],
            'date_fin' => $row['date_fin'],
            'statut' => $row['statut'],
            'nom' => $row['nom'],
            'marque'=>$row['marque'],
            'categorie'=>$row['categorie'],
            'prix_location' => $row['prix_location'],
            'id_agence' => $row['id_agence'],
            'nombre_place' => $row['nombre_place'],
            'nombre_porte' => $row['nombre_porte'],
            'carburant' => $row['carburant'],
            'kilometrage' => $row['kilometrage'],
            'type_boite' => $row['type_boite'],
            'images' => [],
        ];
    }

    if (!empty($row['chemin'])) {
        $articles[$id]['images'][] = $row['chemin'];
    }
}

?>

<!-- <!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Page d’accueil</title>

    <link rel="stylesheet" href="../css/acc1.css" />
</head>

<body> -->

    <nav>
        <div class="nav-container">
          
            <!-- <a href="#" class="nav-logo">
                <img src="../img/logo-class-pour-location-de-voiture-1.jpg" alt="Logo" />
            </a> -->

           
            <ul class="nav-menu">
            <img class="imgnav" src="../img/logo-class-pour-location-de-voiture-1.jpg" alt="">
                <li><a href="Accueil.php">ACCUEIL</a></li>
                <li><a href="../html/loginht.php">SE CONNECTER</a></li>
                <li><a href="../html/verifierht.php">SIGN UP</a></li>
                <li><a href="../html/contactht.php">CONTACT</a></li>
                <li><a href="../html/aboutusht.php">ABOUT US</a></li>
            </ul>
        </div>
    </nav>
    <div class='navv' style='width:100%;height:300px;box-shadow:0 5px 15px rgb(255, 151, 151);'>

</div>


<div class="container">

<!-- *************************************************************************************************************** -->
    <!-- <div style='width:23%;background-color:black;'>.</div> -->
            <div class="row filtrer">
            <!-- <div class='pfi'> -->
                <h1>Filtrer par</h1>

                <form action="" method="post">
                    <select name="marque" onchange="this.form.submit()">
                        <option value="" disabled <?= (empty($_POST['marque'])) ? 'selected' : '' ?>>Filtrer par marque disponible</option>
                        <?php
                        // Récupérer toutes les marques uniques
                        $stmt = $conn->query("SELECT DISTINCT marque FROM article_location WHERE statut = 'disponible' ");
                        $marques = $stmt->fetchAll(PDO::FETCH_COLUMN);

                        foreach ($marques as $marque):
                            $selected = (!empty($_POST['marque']) && $_POST['marque'] == $marque) ? 'selected' : '';
                        ?>
                            <option value="<?= htmlspecialchars($marque) ?>" <?= $selected ?>>
                                <?= htmlspecialchars($marque) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>

                <form action="" method="post">
                    <select name="prix" onchange="this.form.submit()">
                        <option value="" disabled <?= (empty($_POST['prix'])) ? 'selected' : '' ?>>Filtrer par prix</option>
                        <?php
                        $prix_options = [
                            "1" => "100 - 499",
                            "2" => "500 - 999",
                            "3" => "1000 - 1999",
                            "4" => "2000 - 5000",
                        ];
                        foreach ($prix_options as $key => $label):
                            $selected = (!empty($_POST['prix']) && $_POST['prix'] == $key) ? 'selected' : '';
                        ?>
                            <option value="<?= $key ?>" <?= $selected ?>><?= $label ?></option>
                        <?php endforeach; ?>
                    </select>
                </form>

                <form action="" method="post">
                    <select name="class" onchange="this.form.submit()">
                        <option value="" disabled <?= (empty($_POST['class'])) ? 'selected' : '' ?>>Filtrer par classe</option>
                        <?php
                        $classes = ['économique', 'moyenne', 'luxe'];
                        foreach ($classes as $classe):
                            $selected = (!empty($_POST['class']) && $_POST['class'] == $classe) ? 'selected' : '';
                        ?>
                            <option value="<?= htmlspecialchars($classe) ?>" <?= $selected ?>><?= htmlspecialchars($classe) ?></option>
                        <?php endforeach; ?>
                    </select>
                </form>

                <form action="" method="post">
                    <select name="model" onchange="this.form.submit()">
                        <option value="" disabled <?= (empty($_POST['model'])) ? 'selected' : '' ?>>Filtrer par modèle</option>
                        <?php
                        $anne_actuel = (int) date("Y");
                        for ($i = $anne_actuel - 5; $i <= $anne_actuel; $i++):
                            $selected = (!empty($_POST['model']) && $_POST['model'] == $i) ? 'selected' : '';
                        ?>
                            <option value="<?= $i ?>" <?= $selected ?>><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </form>

                <form action="" method="post">
                    <select name="carburant" onchange="this.form.submit()">
                        <option value="" disabled <?= (empty($_POST['carburant'])) ? 'selected' : '' ?>>Filtrer par type de carburant</option>
                        <?php
                        $carburants = ['Essence', 'Diesel', 'Hybride', 'Électrique'];
                        foreach ($carburants as $carburant):
                            $selected = (!empty($_POST['carburant']) && $_POST['carburant'] == $carburant) ? 'selected' : '';
                        ?>
                            <option value="<?= htmlspecialchars($carburant) ?>" <?= $selected ?>><?= htmlspecialchars($carburant) ?></option>
                        <?php endforeach; ?>
                    </select>
                </form>

                <form action="" method="post">
                    <select name="type_boite" onchange="this.form.submit()">
                        <option value="" disabled <?= (empty($_POST['type_boite'])) ? 'selected' : '' ?>>Filtrer par type de boîte</option>
                        <?php
                        $boites = ['Manuelle', 'Automatique'];
                        foreach ($boites as $boite):
                            $selected = (!empty($_POST['type_boite']) && $_POST['type_boite'] == $boite) ? 'selected' : '';
                        ?>
                            <option value="<?= htmlspecialchars($boite) ?>" <?= $selected ?>><?= htmlspecialchars($boite) ?></option>
                        <?php endforeach; ?>
                    </select>
                </form>

                <form action="" method="post">
                    <select name="couleur" onchange="this.form.submit()">
                        <option value="" disabled <?= (empty($_POST['couleur'])) ? 'selected' : '' ?>>Filtrer par couleur</option>
                        <?php
                        $stmt = $conn->prepare("SELECT DISTINCT couleur FROM article_location");
                        $stmt->execute();
                        $couleurs = $stmt->fetchAll(PDO::FETCH_COLUMN);
                        foreach ($couleurs as $couleur):
                            $selected = (!empty($_POST['couleur']) && $_POST['couleur'] == $couleur) ? 'selected' : '';
                        ?>
                            <option value="<?= htmlspecialchars($couleur) ?>" <?= $selected ?>><?= htmlspecialchars($couleur) ?></option>
                        <?php endforeach; ?>
                    </select>
                </form>

                <form action="" method="post">
                    <select name="nombre_place" onchange="this.form.submit()">
                        <option value="" disabled <?= (empty($_POST['nombre_place'])) ? 'selected' : '' ?>>Filtrer par nombre de places</option>
                        <?php
                        $stmt = $conn->prepare("SELECT DISTINCT nombre_place FROM article_location");
                        $stmt->execute();
                        $places = $stmt->fetchAll(PDO::FETCH_COLUMN);
                        foreach ($places as $place):
                            $selected = (!empty($_POST['nombre_place']) && $_POST['nombre_place'] == $place) ? 'selected' : '';
                        ?>
                            <option value="<?= htmlspecialchars($place) ?>" <?= $selected ?>><?= htmlspecialchars($place) ?></option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>
            <!-- </div> -->
<!-- *************************************************************************************************************** -->

            <div class="offres">
                        

                <?php

                foreach ($articles  as $offre) {
                    echo "<div class='ofr'>";

                    // Affichage de l'agence
                    echo "<h3 style='font-weight:900;text-transform: uppercase;color:white;margin:10px;'><center>AGENCE - " . $offre['nom'] . "</center></h3>";

                    // Vérifier s'il y a des images
                    if (!empty($offre['images'])) {
                        // Afficher la première image
                        $firstImage = $offre['images'][0];
                        echo "<center><img class='imgoff' width='270px' height='350px' src='$firstImage'></center>";
                    } else {
                        // Image par défaut si aucune n'est disponible
                        // echo "<img class='imgoff' width='270px' height='350px' src='../imgclient/logos/default.jpg'>";
                    }
                    // Prix
                    echo "<center><span style='padding-top: 20px;'>PRIX PAR JOUR</span><h3 style='size:45px;color: #15d215c9;'>" . $offre['prix_location'] . " DH</h3></center>";
                    // $total = $offre['prix_location'] + 100;
                    // echo "<center><h4 style='color:red;text-decoration: line-through;size:10px;'>" . $total . " DH</h4></center>";

                    // Description véhicule
                    echo "<div class='disc'>";
                    echo "<span>Marque : <h3>" . $offre['marque'] . "</h3></span>";
                    echo "<span>categorie : <h3>" . $offre['categorie'] . "</h3></span>";
                    echo "<span>place : <h3>" . $offre['nombre_place'] . "</h3></span>";
                    echo "<span>porte : <h3>" . $offre['nombre_porte'] . "</h3></span>";
                    echo "<span>carburant : <h3>" . $offre['carburant'] . "</h3></span>";
                    echo "<span>kilométrage : <h3>" . $offre['kilometrage'] . "</h3></span>";
                    // echo "<span>type de boîte : <h3>" . $offre['type_boite'] . "</h3></span>";
                    echo "</div>";

                    echo "<form method='post' action='voirplusaccueillht.php?id=" . $offre['id_article_location'] . "'>
                    <input type='hidden' name='id_agence' value='" . $offre['id_agence'] . "'>
                    <button type='submit' class='btnsavoir' '>En savoir plus</button>
                </form>";
                    echo "<a href='reserver.php?id_article_location=" . $offre['id_article_location'] . "'>
                            <button class='btnreser'>Réserver</button>
                        </a>";
                   
                    
                
                    
                    echo "</div>";










                }

                ?>

            </div>

</div>


</body>

</html>