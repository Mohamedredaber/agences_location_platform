  <?php
    session_start();
    
    if (!isset($_SESSION['connecter']) || $_SESSION['connecter'] !== true) {
        header("Location: ../php/Accueil.php");
        exit();
    }
    $id_agence = $_SESSION['id_agence'];

    if (!isset($id_agence)) {

        header("location:./php/Accueil.php");
    }
    if (!empty($_GET['modification'])) {
        echo "<script>alert('la modification est validée')</script>";
    }
    ?>
  <?php if (isset($_GET['msg']) && $_GET['msg'] === 'suppression_success'): ?>
      <script>
          window.alert("Voiture supprimée avec succès ✅")
      </script>
  <?php endif; ?>

  <!DOCTYPE html>
  <html lang="fr">

  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Gestion des Produits</title>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
      <link rel="stylesheet" href="../css/tableagence.css">
  </head>

  <body>
      <?php
        $id_agence = $_SESSION['id_agence'] ?? null;
        require_once("connexiondata.php");
        $conn = connexion_data('localhost', 'root', '', 'agences');
        // Vérifier que l'ID est bien présent
        if (!$id_agence) {
            die("Aucune agence spécifiée.");
        }
        try {
            $logo_stmt = $conn->prepare('SELECT logo FROM agence WHERE id_agence = :id_agence');
            $logo_stmt->bindParam(':id_agence', $id_agence, PDO::PARAM_INT);
            $logo_stmt->execute();
            $resultat = $logo_stmt->fetch(PDO::FETCH_ASSOC);
            $logo_url = (!empty($resultat['logo'])) ? htmlspecialchars($resultat['logo']) : 'images/logo_par_defaut.png';
        } catch (PDOException $e) {
            die("Erreur de base de données : " . htmlspecialchars($e->getMessage()));
        }

        ?>


      <div class="container">
          <nav>
              <ul>
                  <li><img class="logo" src="../<?= $logo_url ?>" alt="Logo agence" height="50"></li>
                  <li><a href="Accueil.php"> <i class="fas fa-home"></i> accueil</a></li>
                  <!-- <li><a href="acceill.php"> <i class="fas fa-home"></i> accueil</a></li> -->

                  <li><a href="formajoutervoiture.php">ajouter produit</a></li>
                  <li><a href="quitter.php"> <i class="fas fa-sign-out-alt"></i>quitter</a></li>
              </ul>
              <form class="search-bar" action="recherche.php" method="GET">
                  <input type="text" name="query" placeholder="Rechercher..." id="rechercher">
                  <!-- <button type="submit">🔍</button> -->
              </form>
          </nav>
          <header>
              <div class="header-content">
                  <?php
                    require_once("connexiondata.php");
                    $con = connexion_data("localhost", "root", "", "agences");
                    $id_agence = $_SESSION["id_agence"];
                    $inserer_name = $con->prepare("SELECT nom from agence where id_agence =:id_agence");
                    $inserer_name->bindParam(':id_agence', $id_agence);
                    $inserer_name->execute();
                    $results = $inserer_name->fetch(PDO::FETCH_ASSOC);
                    if ($results) {
                        $name = $results['nom'];
                    }
                    $heure = date("H"); // Récupère l'heure (00 à 23)
                    $b = null;
                    $heure = date("H");
                    if ($heure >= 6 && $heure < 12) {
                        $b = "Bonjour $name";
                    } elseif ($heure >= 12 && $heure < 24 || $heure < 6) {
                        $b = "Bonsoir $name";
                    }
                    echo "<h1>$b</h1>";
                    $query = $con->prepare("
                    SELECT a.*, i.chemin
                    FROM article_location a
                    LEFT JOIN images i ON a.id_article_location = i.id_article_location
                    WHERE a.id_agence = :id_agence
                ");

                    $query->bindParam(':id_agence', $id_agence);
                    $query->execute();
                    $resultats = $query->fetchAll(PDO::FETCH_ASSOC);
                    $articles = [];
                    foreach ($resultats as $row) {
                        $id = $row['id_article_location'];

                        if (!isset($articles[$id])) {
                            $articles[$id] = $row;
                            $articles[$id]['images'] = [];
                        }
                        if ($row['chemin']) {
                            $articles[$id]['images'][] = $row['chemin'];
                        }
                    }
                    ?>

              </div>
              <div class="date-display">
                  <i class="fas fa-calendar-alt"></i>
                  <?php
                    $date_actuel = date("Y-m-d");
                    echo $date_actuel;
                    ?>
              </div>
          </header>

          <div class="table-container">
              <table>
                  <thead>
                      <tr>
                          <th>Image</th>
                          <th>Marque </th>
                          <th>Modèle</th>
                          <th>Prix / Jour</th>
                          <th>Statut</th>
                          <th>Date Début</th>
                          <th> Date Fin</th>
                          <th>ACTION</th>
                      </tr>
                  </thead>
                  <tbody id='tbody'>
                      <?php
                        if (count($articles) === 0) {
                            echo "<td colspan='8' class='aucune'>La liste des locations est vide</td>";
                        }

                        ?>
                      <?php foreach ($articles as $id_article => $article): ?>
                          <tr>
                              <td>
                                  <?php if (!empty($article['images'])): ?>
                                      <img class="images" src=" <?= htmlspecialchars($article['images'][0]) ?>" alt="Voiture" width="150" />
                                  <?php else: ?>
                                      <span>Aucune image</span>
                                  <?php endif; ?>
                              </td>
                              <td><?= htmlspecialchars($article['marque']) ?></td>
                              <td><?= htmlspecialchars($article['modele']) ?></td>
                              <td><?= htmlspecialchars($article['prix_location']) ?> DH</td>
                              <td class="statut"><?= htmlspecialchars($article['statut']) ?></td>
                              <td><?= htmlspecialchars($article['date_debut']) ?></td>
                              <td><?= htmlspecialchars($article['date_fin']) ?></td>
                              <td class="action-cell">
                                  <div class="action-buttons">
                                      <?php
                                        $id_article = $article['id_article_location'];

                                        ?>
                                      <a class="btn btn-view" href="voirplus.php?id=<?= urlencode($id_article) ?>"> <i class=" fas fa-eye"></i> Voir</a>
                                      <a class="btn btn-edit" href="modifier_article.php?id=<?= urlencode($id_article) ?>"><i class="fas fa-edit"></i> Modifier</a>
                                      <a class="btn btn-delete" href="supprimerarticle.php?id=<?= urlencode($id_article) ?>" onclick="return confirm('Confirmer la suppression ?')"><i class="fas fa-trash"></i> Supprimer</a>
                                  </div>
                              </td>
                          </tr>
                      <?php endforeach; ?>
                  </tbody>

              </table>
          </div>
          <!-- 
        <div class="table-footer">
            <div class="pagination">
                <button class="pagination-btn active">1</button>
                <button class="pagination-btn">2</button>
                <button class="pagination-btn">3</button>
                <button class="pagination-btn"><i class="fas fa-chevron-right"></i></button>
            </div>
        </div>  -->
      </div> <!-- .table-footer -->
      </div> <!-- .container -->

      <script>
          let statut = document.querySelectorAll(".statut");
          statut.forEach((elem) => {
              if (elem.textContent.trim().toLowerCase() === "disponible") {
                  elem.style.color = 'green';
              } else if (elem.textContent.trim().toLowerCase() === "indisponible") {
                  elem.style.color = 'red';
              } else if (elem.textContent.trim().toLowerCase() === "reserve") {
                  elem.style.color = 'orange';
              }
          });
          const rechercher = document.getElementById("rechercher");
          const tbody = document.getElementById("tbody");
          rechercher.addEventListener("input", function() {
              const valeurActuelle = this.value.trim().toLowerCase();
              Array.from(tbody.rows).forEach(row => {
                  const cellules = Array.from(row.cells);
                  let match = false;
                  // On peut chercher sur toutes les colonnes sauf la dernière (actions)
                  for (let i = 0; i < cellules.length - 1; i++) {
                      const texte = cellules[i].textContent.trim().toLowerCase();
                      if (texte.includes(valeurActuelle)) {
                          match = true;
                          break;
                      }
                  }
                  // Affiche la ligne si correspondance, sinon cache-la
                  row.style.display = match ? "" : "none";
              });
          });
      </script>
  </body>

  </html>