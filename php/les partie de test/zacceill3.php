<?php
session_start();

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


// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     if (!empty($_POST['marque'])) {
//         $requette .= " AND marque = :marque";
//         $params[':marque'] = $_POST['marque'];
//     }
//     if (!empty($_POST["prix"])) {
//         $prix = $_POST["prix"];
//         $filtresPrix = [
//             "1" => " AND (prix_location BETWEEN 100 AND 499)",
//             "2" => " AND (prix_location BETWEEN 500 AND 999)",
//             "3" => " AND (prix_location BETWEEN 1000 AND 1999)",
//             "4" => " AND (prix_location BETWEEN 2000 AND 5000)"
//         ];
        
//         if (array_key_exists($prix, $filtresPrix)) {
//             $requette .= " " . $filtresPrix[$prix];
//         }
//     }
//     if (!empty($_POST["class"])) {
//         $requette .= " AND categorie =:categorie";
//         $params[':categorie'] = $_POST['class'];
//     }
//     if (!empty($_POST["model"])) {
//         $requette .=  " AND modele =:model";
//         $params[':model'] = $_POST['model'];
//     }
//     if (!empty($_POST['carburant'])) {
//         $requette .= " AND carburant =:carburant";
//         $params[':carburant'] = $_POST['carburant'];
//     }
//     if (!empty($_POST['type_boite'])) {
//         $requette .= " AND type_boite =:type_boite";
//         $params[':type_boite'] = $_POST['type_boite'];
//     }
//     if (!empty($_POST['nombre_place'])) {
//         $requette .= " AND nombre_place =:nombre_place";
//         $params[':nombre_place'] = $_POST['nombre_place'];
//     }
//     if (!empty($_POST['couleur'])) {
//         $requette .= " AND couleur = :couleur";
//         $params[':couleur'] = $_POST['couleur'];
//     }
// }


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
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Résultats de location</title>
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <!-- <link rel="stylesheet" href="../css/accueill.css"> -->
  <!-- <link rel="stylesheet" href="../css/accueil1.css"> -->
  <link rel="stylesheet" href="ofrre.css">
   <!-- <link rel="stylesheet" href="../css/test.css"> -->
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

     <!-- <video src="../imgs/WhatsApp Video 2025-06-22 at 22.02.56_d92e656a.mp4" autoplay style='width:100vw;height:300px;'></video> -->

     <div class='navv' style='width:100%;height:300px;box-shadow:0 5px 15px rgb(188, 0, 0);'>

     </div>


<div class='pincipale'>
<div class='reda'>
 trait_exists
 Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quisquam deserunt ex, facere odit rerum minus sapiente ut fuga voluptatem molestias dolor, amet animi neque placeat accusamus soluta dolores odio. Quidem.
Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dolores explicabo voluptatum doloremque, quod tempore doloribus recusandae, distinctio impedit nemo unde sint nulla laborum nesciunt corporis molestias perspiciatis! Ex, dolores impedit.
Magni veritatis perferendis id facere beatae distinctio iste minus ipsum laboriosam natus quidem, voluptatum corporis rem praesentium. Fugiat illo debitis ad asperiores laboriosam perspiciatis esse sapiente molestias, voluptas harum neque.
Voluptatem ipsum impedit totam dignissimos officiis laboriosam, nisi magnam adipisci neque eveniet ad nemo, soluta saepe illum repellendus non tenetur sed magni praesentium cumque sapiente cum tempora repudiandae. Dolorum, sint?
Incidunt laudantium possimus earum iusto eaque architecto aliquid voluptate necessitatibus quasi ea sed sapiente in maiores iure similique itaque nam, dolor ducimus, aut, at excepturi nostrum! Doloremque quibusdam deleniti quidem.
Commodi ad reiciendis eum perspiciatis inventore est esse accusamus molestiae distinctio accusantium, quidem doloribus facere repellendus voluptatem ipsum. Nisi reprehenderit illo maiores incidunt corporis aperiam, assumenda culpa recusandae voluptatibus nihil?
Tempore velit ullam facere dolore suscipit quam mollitia distinctio expedita odit provident quia voluptatem aliquid vel, molestiae similique eum hic nesciunt quae maxime ab at sunt. Facilis temporibus officia eveniet?
Quas consectetur iste nam, laborum sit blanditiis molestias eaque. Ea unde sint dignissimos asperiores, enim impedit minima quibusdam, quia quidem tenetur eos itaque necessitatibus repellendus voluptate. Saepe mollitia a optio!
Nisi optio eaque error mollitia ratione adipisci sed doloremque aspernatur. Vel at quia ducimus vero, hic id, odit, esse placeat tempora cum enim magni! Obcaecati recusandae illo impedit? Dolores, animi.
Adipisci earum ad alias nostrum ea ipsa dolores aliquam sed modi eveniet? Quas incidunt, vitae nobis harum officia earum assumenda iste, quam error odio, quisquam repellat omnis ipsum soluta voluptatem?
Sint officia tenetur quidem voluptas nostrum ex aut odit impedit voluptatibus voluptate a animi, numquam optio quia laboriosam provident totam distinctio autem ducimus quaerat perspiciatis consequuntur quam, voluptatum cum! Veritatis.
Neque deserunt enim harum eaque laboriosam possimus eligendi, quibusdam reprehenderit deleniti, exercitationem eveniet sed maiores! At laboriosam ab hic, consectetur vitae repellendus fuga pariatur exercitationem nobis illum maxime possimus voluptate.
Nisi molestias commodi ut labore, magni distinctio, ab dolorem itaque molestiae totam nulla obcaecati ullam autem quisquam culpa voluptatem veritatis! Suscipit delectus neque architecto illo nostrum nemo nobis non sed?
Ea, repellendus veniam doloribus quam recusandae, eaque commodi nemo quos iure cumque pariatur. Et culpa incidunt facere excepturi? Reprehenderit, eius iure assumenda quisquam quod cumque dolorem corporis esse similique necessitatibus?
Fuga dolore maiores itaque nisi est, illo quod mollitia quidem deserunt perspiciatis! Deserunt distinctio magnam reiciendis quod a facere odio nulla. Voluptate, quas laborum? Sequi ducimus temporibus saepe architecto. Ipsam?
Tempore voluptas et in accusamus, ducimus nam voluptate repellendus ut magnam iusto consequuntur. Molestiae maiores illum enim quos harum ex tempore dolor. Error aut nemo nostrum, reprehenderit maxime pariatur? Saepe.
Modi, sapiente odit! Quasi facere ullam debitis provident delectus laudantium possimus totam quidem, dicta vitae rerum quaerat atque, optio, numquam magnam architecto odit sint voluptatum magni similique nulla. Aut, esse!
Sint, nam autem? Itaque labore dolorum fugit optio quos nostrum repellat reprehenderit ipsam placeat sunt sapiente, explicabo assumenda sit quidem corrupti? Perferendis, molestias? Quae veniam nemo modi tenetur, alias ea.
Pariatur magnam blanditiis nemo, ratione harum reiciendis fugit esse quae quo odio commodi, et similique atque nihil sapiente hic labore quod adipisci. Itaque sapiente perspiciatis cum qui? Dicta, libero. Laboriosam!
Unde, quo perspiciatis obcaecati dolorum, impedit corrupti debitis repellat maxime omnis delectus incidunt, nam eligendi amet tempore ipsam in doloribus culpa suscipit tempora. Voluptates placeat asperiores adipisci eos voluptate minima?
Vel eius omnis commodi pariatur rerum numquam aliquid, magnam laboriosam hic excepturi minima saepe tenetur dolorem eos. Corporis, doloremque dolore, soluta commodi consectetur deleniti sunt ad sequi reprehenderit obcaecati consequuntur.
</div>
<div class="offres">
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
</div>
</body>
</html>
