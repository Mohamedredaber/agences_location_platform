
<!-- HTML pour afficher les résultats -->
<h2>Résultats pour la marque : <?= htmlspecialchars($marque ?? '') ?></h2>

<?php if (!empty($resultats)): ?>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Marque</th>
            <th>Modèle</th>
            <th>Prix</th>
        </tr>
        <?php foreach ($resultats as $voiture): ?>
            <tr>
                <td><?= $voiture['id_article_location'] ?></td>
                <td><?= htmlspecialchars($voiture['marque']) ?></td>
                <td><?= htmlspecialchars($voiture['modele']) ?></td>
                <td><?= htmlspecialchars($voiture['prix_location']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>Aucune voiture trouvée.</p>
<?php endif; ?>