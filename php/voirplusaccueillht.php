<?php
session_start();
$id_article = $_GET["id"];
$id_agence = $_POST["id_agence"];
if (!$id_agence || !$id_article) {
    die("Paramètres manquants.");
}

require_once("../php/connexiondata.php");
$conn = connexion_data('localhost', 'root', '', 'agences');
// Récupération du logo
try {
    $logo_stmt = $conn->prepare('SELECT logo FROM agence WHERE id_agence = :id_agence');
    $logo_stmt->bindParam(':id_agence', $id_agence, PDO::PARAM_INT);
    $logo_stmt->execute();
    $resultat = $logo_stmt->fetch(PDO::FETCH_ASSOC);
    $logo_url = (!empty($resultat['logo'])) ? htmlspecialchars($resultat['logo']) : 'images/logo_par_defaut.png';
} catch (PDOException $e) {
    die("Erreur de base de données : " . htmlspecialchars($e->getMessage()));
}

// Récupération des données du véhicule
try {
    $query = $conn->prepare("
        SELECT a.*, i.chemin, ag.nom AS nom_agence
        FROM article_location a
        LEFT JOIN images i ON a.id_article_location = i.id_article_location
        LEFT JOIN agence ag ON a.id_agence = ag.id_agence
        WHERE a.id_article_location = :id_article
    ");
    $query->bindParam(':id_article', $id_article);
    $query->execute();
    $resultats = $query->fetchAll(PDO::FETCH_ASSOC);

    if (count($resultats) === 0) {
        die("Véhicule non trouvé.");
    }

    $article = $resultats[0];
    $images = [];

    foreach ($resultats as $row) {
        if ($row['chemin']) {
            $images[] = $row['chemin'];
        }
    }
    // Si aucune image, utiliser une image par défaut
    if (count($images) === 0) {
        $images[] = 'images/default-car.jpg';
    }
} catch (PDOException $e) {
    die("Erreur de base de données : " . htmlspecialchars($e->getMessage()));
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail Voiture de L ocation - <?= htmlspecialchars($article['marque']) ?> <?= htmlspecialchars($article['modele']) ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/voirplusaccueillht.css">
    <link rel="stylesheet" href="ofrre.css">
</head>

<body>
    <div class="container">
        <!-- <nav>
            <div class="nav-container">
                <a href="#" class="nav-logo">
                    <img src="../img/logo-class-pour-location-de-voiture-1.jpg" alt="Logo" />
                </a>

                <ul class="nav-menu">
                    <li><a href="../php/Accueil.php">ACCUEIL</a></li>
                    <li><a href="../html/loginht.php">SE CONNECTER</a></li>
                    <li><a href="../html/verifierht.php">SIGN UP</a></li>
                    <li><a href="../php/contact.php">CONTACT</a></li>
                    <li><a href="../html/aboutusht.php">ABOUT US</a></li>
                </ul>
            </div>
        </nav> -->
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

        <div class="detail-container">
            <!-- Section Carrousel -->
            <div class="carousel-section">
                <div class="carousel-container">
                    <div class="carousel">
                        <?php foreach ($images as $image):  ?>
                           
                            <div class="slide" style="background-image:url('<?= htmlspecialchars($image) ?>');"></div>
                        <?php endforeach; ?>
                    </div>
                    <div class="carousel-nav">
                        <button class="nav-btn prev-btn">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="nav-btn next-btn">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                    <div class="dots-container"></div>
                </div>
                <a href='../php/reserver.php?id_article_location=<?php echo  $id_article;  ?>'  >
    <button class='btnreser'>Réserver</button></a> 

                    </div>
                    <!-- Section Informations -->
                    <div class="info-section">
                        <div class="car-title">
                            <h2><?= htmlspecialchars($article['marque']) ?> <?= htmlspecialchars($article['type_marque']) ?></h2>
                            <div class="model-year">Modele : <?= htmlspecialchars($article['modele']) ?></div>
                            <div class="badge-container">
                                <span class="badge category-badge"><?= htmlspecialchars($article['categorie']) ?></span>
                                <?php
                                $statut = strtolower(trim($article['statut']));
                                $classes = 'badge status-badge';

                                if ($statut === "disponible") {
                                    $classes .= ' disponible';
                                } elseif ($statut === "reserve") {
                                    $classes .= ' reserve';
                                } elseif ($statut === "indisponible") {
                                    $classes .= ' indisponible';
                                }

                                echo '<span class="' . $classes . '">' . htmlspecialchars($statut) . '</span>';
                                ?>

                                <!-- <span class="badge status-badge"><?= htmlspecialchars($article['statut']) ?></span> -->
                            </div>
                        </div>
                        <div class="car-specs">
                            <div class="spec-card">
                                <i class="fas fa-gas-pump"></i>
                                <h3>CARBURANT</h3>
                                <p><?= htmlspecialchars($article['carburant']) ?></p>
                            </div>
                            <div class="spec-card">
                                <i class="fas fa-cog"></i>
                                <h3>BOÎTE DE VITESSE</h3>
                                <p><?= htmlspecialchars($article['type_boite']) ?></p>
                            </div>
                            <div class="spec-card">
                                <i class="fas fa-tachometer-alt"></i>
                                <h3>KILOMÉTRAGE</h3>
                                <p><?= number_format($article['kilometrage'], 0, ',', ' ') ?> km</p>
                            </div>
                            <div class="spec-card">
                                <i class="fas fa-car"></i>
                                <h3>PORTES</h3>
                                <p><?= htmlspecialchars($article['nombre_porte']) ?> portes</p>
                            </div>
                            <div class="spec-card">
                                <i class="fas fa-users"></i>
                                <h3>PASSAGERS</h3>
                                <p><?= htmlspecialchars($article['nombre_place']) ?> places</p>
                            </div>
                            <div class="spec-card">
                                <i class="fas fa-palette"></i>
                                <h3>COULEUR</h3>
                                <p><?= htmlspecialchars($article['couleur']) ?></p>
                            </div>
                        </div>
                        <div class="car-pricing">
                            <div class="price-display">
                                <div class="price"><?= number_format($article['prix_location'], 2, ',', ' ') ?> dh</div>
                                <div class="per-day">par jour</div>
                            </div>
                            <div class="dates">
                                <div class="date-card">
                                    <h3>DÉBUT DE LOCATION</h3>
                                    <p><?= date('d M Y', strtotime($article['date_debut'])) ?></p>
                                </div>
                                <div class="date-card">
                                    <h3>FIN DE LOCATION</h3>
                                    <p><?= date('d M Y', strtotime($article['date_fin'])) ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="additional-info">
                            <h3>Informations supplémentaires</h3>
                            <div class="info-grid">
                                <div class="info-item">
                                    <i class="fas fa-id-card"></i>
                                    <div>
                                        <p>Matricule</p>
                                        <p><?= htmlspecialchars($article['matricule']) ?></p>
                                    </div>
                                </div>

                                <div class="info-item">
                                    <i class="fas fa-store"></i>
                                    <div>
                                        <p>Agence</p>
                                        <p><?= htmlspecialchars($article['nom_agence']) ?></p>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-car-alt"></i>
                                    <div>
                                        <p>Type de marque</p>
                                        <p><?= htmlspecialchars($article['type_marque']) ?></p>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-info-circle"></i>
                                    <div>
                                        <p>Informations</p>
                                        <p><?= htmlspecialchars($article['info_supplimentaire']) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <footer>
                <p>&copy; <?= date('Y') ?> Location de Voitures Premium - Tous droits réservés</p>
            </footer>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const carousel = document.querySelector('.carousel');
                const slides = document.querySelectorAll('.slide');
                const prevBtn = document.querySelector('.prev-btn');
                const nextBtn = document.querySelector('.next-btn');
                const dotsContainer = document.querySelector('.dots-container');
                let currentIndex = 0;
                const slideCount = slides.length;
                let slideInterval;

                // Créer les indicateurs (dots)
                function createDots() {
                    dotsContainer.innerHTML = '';
                    for (let i = 0; i < slideCount; i++) {
                        const dot = document.createElement('div');
                        dot.classList.add('dot');
                        if (i === 0) dot.classList.add('active');
                        dot.addEventListener('click', () => goToSlide(i));
                        dotsContainer.appendChild(dot);
                    }
                }

                // Mettre à jour le carrousel
                function updateCarousel() {
                    carousel.style.transform = `translateX(-${currentIndex * 100}%)`;
                    const dots = document.querySelectorAll('.dot');
                    dots.forEach((dot, i) => {
                        dot.classList.toggle('active', i === currentIndex);
                    });
                }

                // Aller à un slide spécifique
                function goToSlide(index) {
                    currentIndex = index;
                    updateCarousel();
                    resetTimer();
                }

                // Slide suivant
                function nextSlide() {
                    currentIndex = (currentIndex + 1) % slideCount;
                    updateCarousel();
                    resetTimer();
                }

                // Slide précédent
                function prevSlide() {
                    currentIndex = (currentIndex - 1 + slideCount) % slideCount;
                    updateCarousel();
                    resetTimer();
                }

                // Défilement automatique
                function startAutoSlide() {
                    slideInterval = setInterval(nextSlide, 5000);
                }

                // Réinitialiser le timer
                function resetTimer() {
                    clearInterval(slideInterval);
                    startAutoSlide();
                }

                // Initialisation
                function initCarousel() {
                    if (slideCount > 0) {
                        createDots();
                        startAutoSlide();

                        // Événements
                        prevBtn.addEventListener('click', prevSlide);
                        nextBtn.addEventListener('click', nextSlide);

                        // Pause au survol
                        const carouselContainer = document.querySelector('.carousel-container');
                        carouselContainer.addEventListener('mouseenter', () => {
                            clearInterval(slideInterval);
                        });

                        carouselContainer.addEventListener('mouseleave', resetTimer);
                    }
                }

                // Démarrer le carrousel
                initCarousel();
            });
        </script>
</body>

</html>