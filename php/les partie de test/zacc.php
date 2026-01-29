<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="ofrre.css">
    <link rel="stylesheet" href="../css/acc.css">
</head>
<body class='body'>
        <nav>
          <ul>
            <img class="imgnav" src="../img/logo-class-pour-location-de-voiture-1.jpg" alt="">
            <li><a href=""> ACCUEIL</a></li>
            <li><a href="../html/loginht.php"> SE CONECTER </a></li>
            <li><a href="../html/verifierht.php"> SING UP</a> </li>
            <li><a href=""> CONTACT</a> </li>
            <li><a href=""> ABOUT US</a> </li>
          </ul>
        </nav>
<!-- *************************************************************************************************************** -->
        <div class='navv' style='width:100%;height:300px;box-shadow:0 5px 15px rgb(188, 0, 0);'>
        </div>
<!-- *************************************************************************************************************** -->
 
<div class="container">
<!-- *************************************************************************************************************** -->
    <div class="row filtrer">
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

<!-- *************************************************************************************************************** -->

<div class="affichage">
    
<!-- *************************************************************************************************************** -->
<?php

foreach ($articles  as $offre) {
echo "<div class='ofr'>";

// Affichage de l'agence
echo "<h3 style='font-weight:900;text-transform: uppercase;color:red;margin:10px;'><center>" . $offre['nom'] . "</center></h3>";

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
echo "<center><span>PRIX</span><h3 style='size:40px;color: #15d215c9;'>" . $offre['prix_location'] . " DH</h3></center>";
// $total = $offre['prix_location'] + 100;
// echo "<center><h4 style='color:red;text-decoration: line-through;size:10px;'>" . $total . " DH</h4></center>";

// Description véhicule
echo "<div class='disc'>";
echo "<span>place : <h3>" . $offre['nombre_place'] . "</h3></span>";
echo "<span>porte : <h3>" . $offre['nombre_porte'] . "</h3></span>";
echo "<span>carburant : <h3>" . $offre['carburant'] . "</h3></span>";
echo "<span>kilométrage : <h3>" . $offre['kilometrage'] . "</h3></span>";
// echo "<span>type de boîte : <h3>" . $offre['type_boite'] . "</h3></span>";
echo "</div>";


echo "<a href='reserver.php?id_article_location=" . $offre['id_article_location'] . "'>
    <button class='btnreser'>Réserver</button>
</a>";
echo "<form method='post' action='voirplus.php?id=" . $offre['id_article_location'] . "'>
    <input type='hidden' name='id_agence' value='" . $offre['id_agence'] . "'>
    <button type='submit' class='btnsavoir' '>En savoir plus</button>
</form>";



echo "</div>";










}

?>

</div>

<!-- *************************************************************************************************************** -->
</div>










    
</body>
</html>