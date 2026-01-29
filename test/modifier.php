<?php
$conn = new PDO('mysql:host=localhost;dbname=tpcrud', 'root', '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cin = $_POST['cin'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $age = $_POST['age'];
    
    $stmt = $conn->prepare("UPDATE stagiaire SET nom = :nom, prenom = :prenom, age = :age WHERE cin = :cin");
    $stmt->execute([':nom'=>$nom, ':prenom'=>$prenom, ':age'=>$age , ':cin'=> $cin]);
    
    header('Location: menu.php');
    exit;
}

$stagiaire = null;
if (isset($_GET['cin'])) {
    $stmt = $conn->prepare("SELECT * FROM stagiaire WHERE cin = ?");
    $stmt->execute([$_GET['cin']]);
    $stagiaire = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un stagiaire</title>
    
</head>
<body>
    <h1>Modifier un stagiaire</h1>
    
    <div class="menu">
        <a href="menu.php">Retour</a>
    </div>
    
    <form method="POST">
        <label for="cin">CIN du stagiaire à modifier:</label>
        <input type="text" id="cin" name="cin" value="<?= $stagiaire['cin'] ?? '' ?>" required>
        
        <label for="nom">Nouveau nom:</label>
        <input type="text" id="nom" name="nom" value="<?= $stagiaire['nom'] ?? '' ?>" required>
        
        <label for="prenom">Nouveau prénom:</label>
        <input type="text" id="prenom" name="prenom" value="<?= $stagiaire['prenom'] ?? '' ?>" required>
        
        <label for="age">Nouvel age:</label>
        <input type="number" id="age" name="age" value="<?= $stagiaire['age'] ?? '' ?>" required>
        
        <button type="submit">Modifier</button>
    </form>
</body>
</html>