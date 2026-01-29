<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des stagiaires</title>

</head>
<body>
    <h1>Gestion des stagiaires</h1>
    
    <div class="menu">
        <a href="ajouter.php">Ajouter</a>
        <a href="modifier.php">Modifier</a>
        <a href="supprimer.php">Supprimer</a>
        <a href="menu.php">Lister</a>
    </div>
    
    <?php
    $conn = new PDO('mysql:host=localhost;dbname=tpcrud', 'root' ,'');
        $stmt = $conn->prepare("SELECT * FROM stagiaire");
    $stagiaires = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo '<table>
                <tr>
                    <th>ID</th>
                    <th>CIN</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Age</th>
                </tr>';
        
 foreach ($stagiaires as $stagiaire) {
            echo '<tr>
                    <td>'.$stagiaire['id'].'</td>
                    <td>'.$stagiaire['cin'].'</td>
                    <td>'.$stagiaire['nom'].'</td>
                    <td>'.$stagiaire['prenom'].'</td>
                    <td>'.$stagiaire['age'].'</td>
                  </tr>';
        }
        
        echo '</table>';
    
    ?>
</body>
</html>