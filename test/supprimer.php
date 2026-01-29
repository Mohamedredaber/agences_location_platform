<?php
$conn = new PDO('mysql:host=localhost;dbname=tpcrud', 'root', '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cin = $_POST['cin'];
    
    $stmt = $conn->prepare("DELETE FROM stagiaire WHERE cin = ?");
    $stmt->execute([$cin]);
    
    header('Location: menu.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer un stagiaire</title>
 
</head>
<body>
    <h1>Supprimer un stagiaire</h1>
    
    <div class="menu">
        <a href="menu.php">Retour</a>
    </div>
    
    <form method="POST">
        <label for="cin">CIN du stagiaire à supprimer:</label>
        <input type="text" id="cin" name="cin" required>
        
        <button type="submit">Supprimer</button>
    </form>
</body>
</html>