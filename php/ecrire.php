<?php
// Connexion à la base
$conn = new PDO("mysql:host=localhost;dbname=agences", "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Récupérer les marques disponibles
$marques = $conn->query("SELECT DISTINCT marque FROM article_location")->fetchAll(PDO::FETCH_ASSOC);

// Récupération des filtres
$marqueChoisie = $_POST['marque'] ?? '';
$prixMax = $_POST['prix_max'] ?? '';
// Préparer la requête
$sql = "SELECT * FROM article_location WHERE 1";
$params = [];
if (!empty($marqueChoisie)) {
    $sql .= " AND marque = ?";
    $params[] = $marqueChoisie;
}
if (!empty($prixMax)) {
    $sql .= " AND prix <= ?";
    $params[] = $prixMax;
}

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Page d'accueil avec filtres</title>
</head>

<body>
    <h1>Articles disponibles</h1>

    <!-- Formulaire de filtre -->
    <form method="POST">
        <label for="marque">Filtrer par marque :</label>
        <select name="marque" id="marque">
            <option value="">-- Toutes les marques --</option>
            <?php foreach ($marques as $marque): ?>
                <option value="<?= htmlspecialchars($marque['marque']) ?>" <?= ($marqueChoisie === $marque['marque']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($marque['marque']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="prix_max">Prix maximum :</label>
        <input type="number" name="prix_max" id="prix_max" value="<?= htmlspecialchars($prixMax) ?>" min="0" step="0.01">

        <button type="submit">Filtrer</button>
    </form>

    <!-- Affichage des résultats -->
    <?php if (!empty($articles)): ?>
        <table border="1" cellpadding="5" cellspacing="0">
            <tr>
                <th>ID</th>
                <th>Marque</th>
                <th>Nom</th>
                <th>Prix</th>
            </tr>
            <?php foreach ($articles as $article): ?>
                <tr>
                    <td><?= $article['id_article_location'] ?></td>
                    <td><?= htmlspecialchars($article['marque']) ?></td>
                    <td><?= htmlspecialchars($article['nom_article']) ?></td>
                    <td><?= htmlspecialchars($article['prix']) ?> DH</td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Aucun article trouvé.</p>
    <?php endif; ?>
</body>

</html>