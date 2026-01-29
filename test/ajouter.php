<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new PDO('mysql:host=localhost;dbname=tpcrud', 'root', '');
    
    $cin = $_POST['cin'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $age = $_POST['age'];
    
    $stmt = $conn->prepare("INSERT INTO stagiaire (cin, nom, prenom, age) VALUES (:cin, :nom, :prenom, :age)");
    $stmt->execute([':cin'=> $cin, ':nom'=>$nom, ':prenom'=>$prenom, ':age'=>$age]);
    
    header('Location: menu.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un stagiaire</title>
    <!-- <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .menu { display: flex; gap: 10px; margin-bottom: 20px; }
        .menu a { padding: 10px 15px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; }
        .menu a:hover { background: #0056b3; }
        form { max-width: 500px; margin: 20px 0; }
        label { display: block; margin: 10px 0 5px; }
        input { width: 100%; padding: 8px; margin-bottom: 10px; }
        button { padding: 10px 15px; background: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #218838; }
    </style> -->
</head>
<body>
    <h1>Ajouter un stagiaire</h1>
    
    <div class="menu">
        <a href="menu.php">Retour</a>
    </div>
    
    <form method="POST">
        <label for="cin">CIN:</label>
        <input type="text" id="cin" name="cin" required>
        
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" required>
        
        <label for="prenom">Prénom:</label>
        <input type="text" id="prenom" name="prenom" required>
        
        <label for="age">Age:</label>
        <input type="number" id="age" name="age" required>
        
        <button type="submit">Ajouter</button>
    </form>
</body>
</html>