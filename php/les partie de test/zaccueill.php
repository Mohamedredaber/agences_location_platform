<?php
session_start();
require_once("connexiondata.php");

// Connexion DB
$conn = connexion_data("localhost", "root", "", "agences");

// Initialisation des variables
$date_actuel = date("Y-m-d");
$articles = [];
$filters = [];

// Gestion des filtres
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Nettoyage des entrées
    $filters = [
        'marque' => !empty($_POST['marque']) ? htmlspecialchars($_POST['marque']) : null,
        'prix' => !empty($_POST['prix']) ? (int)$_POST['prix'] : null,
        'categorie' => !empty($_POST['class']) ? htmlspecialchars($_POST['class']) : null,
        'modele' => !empty($_POST['model']) ? htmlspecialchars($_POST['model']) : null,
        'carburant' => !empty($_POST['carburant']) ? htmlspecialchars($_POST['carburant']) : null,
        'type_boite' => !empty($_POST['type_boite']) ? htmlspecialchars($_POST['type_boite']) : null,
        'nombre_place' => !empty($_POST['nombre_place']) ? (int)$_POST['nombre_place'] : null,
        'couleur' => !empty($_POST['couleur']) ? htmlspecialchars($_POST['couleur']) : null
    ];
}

// Construction de la requête
$requette = "SELECT a.*, i.chemin, ag.nom 
             FROM article_location a
             LEFT JOIN images i ON a.id_article_location = i.id_article_location
             LEFT JOIN agence ag ON a.id_agence = ag.id_agence
             WHERE a.statut = 'disponible' 
             AND a.date_fin > :date_actuel 
             AND a.date_debut <= :date_actuel";

$params = [":date_actuel" => $date_actuel];

// Application des filtres
if (!empty($filters['marque'])) {
    $requette .= " AND a.marque = :marque";
    $params[':marque'] = $filters['marque'];
}

if (!empty($filters["prix"])) {
    $prix_ranges = [
        1 => [100, 499],
        2 => [500, 999],
        3 => [1000, 1999],
        4 => [2000, 5000]
    ];
    
    if (isset($prix_ranges[$filters["prix"]])) {
        $range = $prix_ranges[$filters["prix"]];
        $requette .= " AND (a.prix_location BETWEEN {$range[0]} AND {$range[1]})";
    }
}

// Ajoutez les autres filtres de la même manière...

try {
    $stmt = $conn->prepare($requette);
    $stmt->execute($params);
    $resultat = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Organisation des articles
    foreach ($resultat as $row) {
        $id = $row['id_article_location'];
        
        if (!isset($articles[$id])) {
            $articles[$id] = [
                'id_article_location' => $row['id_article_location'],
                'marque' => $row['marque'],
                'modele' => $row['modele'],
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
                'categorie' => $row['categorie'],
                'images' => [],
            ];
        }

        if (!empty($row['chemin'])) {
            $articles[$id]['images'][] = $row['chemin'];
        }
    }
} catch (PDOException $e) {
    die("Erreur de base de données : " . $e->getMessage());
}

// Récupération des valeurs uniques pour les filtres
try {
    $marques = $conn->query("SELECT DISTINCT marque FROM article_location")->fetchAll(PDO::FETCH_COLUMN);
    $modeles = $conn->query("SELECT DISTINCT modele FROM article_location")->fetchAll(PDO::FETCH_COLUMN);
    // Ajoutez les autres requêtes pour les filtres...
} catch (PDOException $e) {
    // Gérer l'erreur ou initialiser à un tableau vide
    $marques = [];
    $modeles = [];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Résultats de location</title>
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <style>
    :root {
      --bg-color: #f8f9fa;
      --primary-color: #dc3545;
      --secondary-color: #6c757d;
    }
    
    body {
      background-color: var(--bg-color);
      padding-top: 80px;
    }
    
    .navbar-custom {
      background-color: #343a40;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .filter-section {
      background: white;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      padding: 20px;
      margin-bottom: 20px;
    }
    
    .offre-card {
      background: white;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      transition: transform 0.3s;
      margin-bottom: 20px;
    }
    
    .offre-card:hover {
      transform: translateY(-5px);
    }
    
    .offre-img {
      height: 200px;
      object-fit: cover;
      width: 100%;
    }
    
    .price-tag {
      font-size: 1.5rem;
      color: var(--primary-color);
      font-weight: bold;
    }
    
    .btn-reserver {
      background-color: var(--primary-color);
      border: none;
    }
    
    .btn-details {
      background-color: var(--secondary-color);
      border: none;
    }
    
    @media (max-width: 768px) {
      .filter-section {
        margin-bottom: 20px;
      }
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top navbar-custom">
    <div class="container">
      <a class="navbar-brand" href="#">
        <img src="../img/logo-class-pour-location-de-voiture-1.jpg" height="40" alt="Logo">
      </a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item"><a class="nav-link" href="#">ACCUEIL</a></li>
          <li class="nav-item"><a class="nav-link" href="../html/loginht.php">SE CONNECTER</a></li>
          <li class="nav-item"><a class="nav-link" href="../html/verifierht.php">S'INSCRIRE</a></li>
          <li class="nav-item"><a class="nav-link" href="#">CONTACT</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container mt-4">
    <div class="row">
      <!-- Section Filtres -->
      <div class="col-md-3">
        <div class="filter-section">
          <h4 class="mb-4">Filtrer les résultats</h4>
          <form method="post" id="filterForm">
            <!-- Marque -->
            <div class="form-group">
              <label>Marque</label>
              <select name="marque" class="form-control">
                <option value="">Toutes les marques</option>
                <?php foreach ($marques as $marque): ?>
                  <option value="<?= htmlspecialchars($marque) ?>" 
                    <?= (!empty($filters['marque']) && $filters['marque'] === $marque) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($marque) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            
            <!-- Prix -->
            <div class="form-group">
              <label>Prix</label>
              <select name="prix" class="form-control">
                <option value="">Tous les prix</option>
                <option value="1" <?= (!empty($filters['prix']) && $filters['prix'] == 1) ? 'selected' : '' ?>>100 - 499 DH</option>
                <option value="2" <?= (!empty($filters['prix']) && $filters['prix'] == 2) ? 'selected' : '' ?>>500 - 999 DH</option>
                <option value="3" <?= (!empty($filters['prix']) && $filters['prix'] == 3) ? 'selected' : '' ?>>1000 - 1999 DH</option>
                <option value="4" <?= (!empty($filters['prix']) && $filters['prix'] == 4) ? 'selected' : '' ?>>2000 - 5000 DH</option>
              </select>
            </div>
            
            <!-- Ajoutez les autres filtres de la même manière -->
            
            <button type="submit" class="btn btn-primary btn-block">Appliquer les filtres</button>
            <button type="reset" class="btn btn-secondary btn-block">Réinitialiser</button>
          </form>
        </div>
      </div>
      
      <!-- Section Résultats -->
      <div class="col-md-9">
        <div class="row">
          <?php if (empty($articles)): ?>
            <div class="col-12">
              <div class="alert alert-info">Aucun véhicule disponible ne correspond à vos critères.</div>
            </div>
          <?php else: ?>
            <?php foreach ($articles as $offre): ?>
              <div class="col-md-6 col-lg-4 mb-4">
                <div class="offre-card h-100">
                  <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($offre['marque']) ?> <?= htmlspecialchars($offre['modele']) ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted"><?= htmlspecialchars($offre['nom']) ?></h6>
                    
                    <?php if (!empty($offre['images'])): ?>
                      <img src="<?= htmlspecialchars($offre['images'][0]) ?>" class="offre-img mb-3" alt="Véhicule">
                    <?php else: ?>
                      <img src="../img/default-car.jpg" class="offre-img mb-3" alt="Véhicule par défaut">
                    <?php endif; ?>
                    
                    <div class="price-tag mb-3"><?= htmlspecialchars($offre['prix_location']) ?> DH/jour</div>
                    
                    <ul class="list-unstyled">
                      <li><strong>Places:</strong> <?= htmlspecialchars($offre['nombre_place']) ?></li>
                      <li><strong>Carburant:</strong> <?= htmlspecialchars($offre['carburant']) ?></li>
                      <li><strong>Boîte:</strong> <?= htmlspecialchars($offre['type_boite']) ?></li>
                    </ul>
                    
                    <div class="d-flex justify-content-between">
                      <a href="voirplus.php?id=<?= $offre['id_article_location'] ?>" class="btn btn-details text-white">Détails</a>
                      <a href="reserver.php?id_article_location=<?= $offre['id_article_location'] ?>" class="btn btn-reserver">Réserver</a>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <script src="../js/bootstrap.bundle.min.js"></script>
  <script>
    // Script pour améliorer l'UX
    document.addEventListener('DOMContentLoaded', function() {
      // Mise en évidence des filtres actifs
      const form = document.getElementById('filterForm');
      const inputs = form.querySelectorAll('select, input');
      
      inputs.forEach(input => {
        if (input.value) {
          input.classList.add('is-valid');
        }
        
        input.addEventListener('change', function() {
          this.classList.add('is-valid');
        });
      });
    });
  </script>
</body>
</html>