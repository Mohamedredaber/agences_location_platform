<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .body{
            background-color: rgb(0, 0, 0);
        }
    .resclass{

    font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
    width: 30vw;
    /* height: 20vw; */
    /* background: rgb(0, 0, 0); */
    /* padding: 30px; */
    border-radius: 12px;
    /* box-shadow:  rgba(0, 0, 0, 0.29); */
    position: relative;
    /* justify-content: center;
    align-items: center; */
    /* top:30vh; */
    /* porsontage makikhdmx hnaya  */
    left:35%;
    border: 1px solid #ffffff;
    box-shadow:  0 13px 30px rgb(255, 255, 255);
    /* color: #ffffff; */


    }
.slider{
    display: flex;
    justify-content: center;
   
}


.slider div {
      width: 15vw;
     height: 25vw;
     
     border: 2px solid rgb(0, 0, 0);
     border-radius: 10px;
 }
.slider div:hover {
    width: 29vw; 
    transition: width 0.5s ease, transform 0.3s ease;/* hadi dyaal dak tswira mli n7tt curseur x7aal lmoda ikhashaa  baxx tkbr kamla  */ 
    transform: scale(1.1); 
}

.btn:hover{
  background-color:rgb(34, 170, 0) ;
  cursor: pointer;
  /* color:red; */
}
.btn{
  margin:5px;
  background-color:rgb(48, 153, 0);
  color: white; 
  padding: 10px; 
  border: none; 
  border-radius: 5px;
  width: 98%;
}

input[type="date"] {
  width: 98%;
  /* width: auto; */
  /* padding: 12px 40px 12px 15px;  */
  padding-top:10px; 
  padding-bottom:10px; 
  border: 2px solid #db3434;
  border-radius: 6px;
  font-size: 16px;
  background-color: #fff4ec;
  appearance: none; /* Disables default styling */
}



    </style>
    <link rel="stylesheet" href="ofrre.css">
    <link rel="stylesheet" href="../css/acc.css">
</head>

<body class='body'>

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





<div style='position:relative;top:100px;'>


<?php

include 'conexion.php';
    $id = $_GET['id_article_location'];
    // echo $id;
    // $id = 123 ;
    $select =$conexion->prepare('SELECT * FROM article_location WHERE id_article_location = :id_article_location');
    $select->execute([':id_article_location'=>$id]);
    $article = $select->fetch(PDO::FETCH_ASSOC);


    $selectn = $conexion->prepare('SELECT * from agence WHERE id_agence = :id_agence');
    $selectn->execute([':id_agence'=>$article['id_agence']]);
    $agence =$selectn->fetch(PDO::FETCH_ASSOC);

    $selimg = $conexion->prepare('SELECT chemin FROM images WHERE id_article_location = :id_article_location');
    $selimg->execute([':id_article_location'=>$article['id_article_location']]);
    $imagelogo = $selimg->fetchAll(PDO::FETCH_ASSOC);
    // print_r($imagelogo);
    
    echo"<div class='resclass'>";
    echo"<center><h1 style='text-transform:uppercase;color:white;'>".$article['marque']."</h1>";

    echo"<section class='slider'>";
        $x=0;       
        // $x = "_121476237_gettyimages-1224583750.jpg";
           foreach($imagelogo as $image){

            $x++;
            echo"<div style='background-image:url(".$image['chemin'].");background-position:center;transition: width 0.5s ease;'></div>"; // - - -  $imagelogo['chemin'][0]
        }
           
            // echo"<div style='background-image:url(".$imagelogo[1]['chemin'].");background-position:center;transition: width 0.5s ease;'></div>"; // - - -  $imagelogo['chemin'][1]
            // echo"<div style='background-image:url(".$imagelogo[2]['chemin'].");background-position:center;transition: width 0.5s ease;'></div>"; // - - -  $imagelogo['chemin'][2]
            // // echo"<img src='".$imagelogo['chemin'][0]."'>";
            // echo"<img src='".$imagelogo['chemin'][1]."'>";
            // echo"<img src='".$imagelogo['chemin'][2]."'>";
    echo"</section>";


        echo"<h3 style='color:red;'> Disponible à : ".$article['date_fin']."</h3>";
    echo"<div class='form-group'>
                        <form action='reserver.php' method='post'>
                        <label for='df' style='color:white;'>Date Fin</label>
                        <input required type='date' name='datefin' id='df'>
                        <label style='color:white;' for='dd'>Date Debut</label>
                        <input required type='date' name='datedebut' id='dd'>
                        <span id='span'></span>
                        
                        </form>
                        
                    </div>";
                   
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $dateDebut = $_POST['datedebut'];
                        $dateFin = $_POST['datefin'];
                        
                    
                        if ($dateFin > $article['date_fin']) {
                            echo " La date de fin doit être supérieure à la date d'aujourd'hui.";
                            exit;
                        }
                    
                        // Ici tu continues avec la réservation…
                    }
                     
                      
                  
                    



    echo"<h3 style='color:white;'>RESERVER PAR :</h3>";


    echo"<div style='display:flex;flex-direction:column;'>";
    // $n =   775613122 ;
    echo "<a href='https://wa.me/" . $agence['numerotel'] . "?text=Salut%2C%20je%20veux%20réserver%20votre%20voiture%20" 
    . urlencode($article['marque'] . " modèle " . $article['modele']) . "' target='_blank'>
        <button class='btn'>
           WhatsApp20
           
        </button>
      </a>";

        // echo"<a href='https://wa.me/".$agence['numerotel']."?text=Salut%2C%20je%20veux%20réserver%20votre%20voiture%20".$article['marque'] ."modele". $article['model']."' target='_blank'>
        //     <button class='btn'>
        //        WhatsApp
        //     </button>
        // </a>";
    // echo"<a href='mailto:".$agence['adress']."?text=Salut%2C%20je%20veux%20réserver%20votre%20voiture' target='_blank'>
    //         <button class='btn'>
    //             EMAIL
    //         </button>
    //     </a>";
    // echo "<a href='mailto:".$agence['adress']."?subject=" . urlencode("reservation") . "&body=" . urlencode("bonjour tu peux reserve cette voiture") . "' target='_blank'>
    //         <button class='btn'>
    //             EMAIL
    //         </button>
    //       </a>";
        
    echo"</div>";



?>
</div>



</body>

</html>