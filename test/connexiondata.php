<?php 
    // $servername = "localhost";
    // $username = "root";
    // $password = "redabrh1234";
    // $dataname = "db_ecole";
function connexion_data($servername, $username, $password, $dataname) {
    try {
        // DSN (Data Source Name) avec encodage UTF-8
        $dsn = "mysql:host=$servername;dbname=$dataname;charset=utf8";
        
        // Connexion PDO
        $conn = new PDO($dsn, $username, $password);
        
        // Activer le mode exception pour les erreurs
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        // Affichage de l'erreur (à éviter en production)
        echo "<script>alert('Erreur de connexion : " . addslashes($e->getMessage()) . "');</script>";
        return null;
    }
}
// cas d'utilisation de connexion_data 
// $conn = connexion_data("localhost", "root", "", "ma_base");

// if ($conn) {
//     echo "Connexion réussie !";
// }

function inserer_data($connexion, $table, $liste_colonne, $liste_valeur) {
    try {
        // Génère les noms de colonnes et les placeholders
        $str_colonne = implode(",", $liste_colonne);
        $placeholders = implode(",", array_map(fn($col) => ":$col", $liste_colonne));

        // Construction de la requête SQL avec paramètres nommés
        $sql = "INSERT INTO $table ($str_colonne) VALUES ($placeholders)";
        $stmt = $connexion->prepare($sql);

        // Construction du tableau associatif des paramètres
        $data = array_combine(
            array_map(fn($col) => ":$col", $liste_colonne),
            $liste_valeur
        );

        // Exécution de la requête
        $stmt->execute($data);

        echo "Insertion réussie !";

    } catch (PDOException $e) {
        echo "Erreur d'insertion : " . $e->getMessage();
    }
}
//cas d'utilisation de insert_data ex
// require_once 'connexion.php';
// $conn = connexion_data("localhost", "root", "", "ma_base");

// $titre = $_POST['titre'];
// $auteur = $_POST['auteur'];
// $date = $_POST['date'];

// inserer_data(
//     $conn,
//     'articles',
//     ['titre', 'auteur', 'date'],
//     [$titre, $auteur, $date]
// );

function recuperer_data($connexion, $table, $colonnes = [],$condition = "") {
    try {
        // Si aucune colonne spécifiée, on sélectionne toutes (*)
        $listeColonnes = empty($colonnes) ? '*' : implode(', ', $colonnes);
        
        // Construction de la requête SQL
        $sql = "SELECT $listeColonnes FROM $table ";
        if (!empty($condition)) {
            $sql .= "WHERE $condition";
        }
        // Préparation et exécution
        $stmt = $connexion->prepare($sql);
        $stmt->execute();

        // Retourner toutes les données sous forme de tableau associatif
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erreur lors de la récupération des données : " . $e->getMessage();
        return null;
    }
}
//cas d'utilisation de recuperer_data  exemple 
// require_once 'connexion.php';

// $conn = connexion_data("localhost", "root", "", "ma_base");

// $articles = recuperer_data($conn, "articles", ["id", "titre", "auteur", "date"],"id=3");

// foreach ($articles as $article) {
//     echo $article['titre'] . " écrit par " . $article['auteur'] . "<br>";
// }

function supprimer_data($connexion, $table, $condition) {
    try {
        // Construction de la requête SQL
        $sql = "DELETE FROM $table WHERE $condition";

        // Préparation et exécution
        $stmt = $connexion->prepare($sql);
        $stmt->execute();

        echo "Suppression réussie.";
    } catch (PDOException $e) {
        echo "Erreur lors de la suppression : " . $e->getMessage();
    }
}
// cas d utilisation supprimer_data 
// $conn = connexion_data("localhost", "root", "mot_de_passe", "ma_base");

// if ($conn) {
//     supprimer_data($conn, "livres", "id = 3");
// }

?>