<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Voiture - Formulaire Étape par Étape</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/formajoutervoiture.css">
</head>

<body>

    <?php
    session_start();
    $id_agence = $_SESSION['id_agence'] ?? null;

    require_once("connexiondata.php");
    $conn = connexion_data('localhost', 'root', '', 'agences');

    // Vérifier que l'ID est bien présent
    // if (!$id_agence) {
    //     die("Aucune agence spécifiée.");
    // }
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
    <form class="form-container" action="ajoutervoiture.php" method="post" enctype="multipart/form-data" id="form_parent">
        <nav>
            <ul>
                <li><img class="logo" src="../<?= $logo_url ?>" alt="Logo agence" height="50"></li>
                <li><a href="Accueil.php">accueil</a></li>
                <li><a href="tableagence.php">tabeau location</a></li>
                <li><a href="quitter.php">quitter</a></li>
            </ul>
            <h1>ajouter voiture en location</h1>
        </nav>

        <div class="parent">

            <!-- Barre de progression verticale -->
            <div class="progress-container">
                <div class="progress-bar">
                    <div class="progress-fill" id="progress-fill"></div>
                </div>

                <div class="steps">
                    <div class="step active" data-step="1">
                        <div class="step-icon">1</div>
                        <div class="step-content">
                            <div class="step-title">Type de véhicule</div>
                            <div class="step-description">Catégorie et marque</div>
                        </div>
                    </div>

                    <div class="step" data-step="2">
                        <div class="step-icon">2</div>
                        <div class="step-content">
                            <div class="step-title">Caractéristiques</div>
                            <div class="step-description">Spécifications techniques</div>
                        </div>
                    </div>

                    <div class="step" data-step="3">
                        <div class="step-icon">3</div>
                        <div class="step-content">
                            <div class="step-title">Comfort & Accessoires</div>
                            <div class="step-description">Équipements intérieurs</div>
                        </div>
                    </div>

                    <div class="step" data-step="4">
                        <div class="step-icon">4</div>
                        <div class="step-content">
                            <div class="step-title">Disponibilité</div>
                            <div class="step-description">Période et tarif</div>
                        </div>
                    </div>

                    <div class="step" data-step="5">
                        <div class="step-icon">5</div>
                        <div class="step-content">
                            <div class="step-title">Images & Validation</div>
                            <div class="step-description">Ajout des photos</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contenu du formulaire par étape -->
            <div class="form-content">
                <!-- Étape 1: Type de véhicule -->
                <div class="form-section active" id="step-1">
                    <div class="form-header">
                        <h2>Type de véhicule</h2>
                        <p>Sélectionnez la catégorie et la marque de la voiture à ajouter</p>
                    </div>

                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label for="select_type">Type de class</label>
                                <select name="categorie" id="select_type">
                                    <option value="economique">Economique</option>
                                    <option value="moyenne">Moyenne</option>
                                    <option value="luxe">Luxe</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-col">
                            <div class="form-group">
                                <label for="marque">Marque</label>
                                <select id="marque" name="marque">
                                    <option value="" disabled selected>Sélectionner une marque</option>
                                    <option value="Dacia">Dacia</option>
                                    <option value="Renault">Renault</option>
                                    <option value="Peugeot">Peugeot</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="type_marque">Modèle</label>
                        <input type="text" id="type_marque" name="type_marque" placeholder="Ex: Yaris">
                    </div>

                    <div class="form-group">
                        <label for="modele">Année de modèle</label>
                        <input type="number" id="modele" name="modele" placeholder="Ex: 2023">
                    </div>

                    <div class="form-actions">
                        <div></div> <!-- Espace vide pour aligner le bouton à droite -->
                        <button type="button" class="btn btn-next" onclick="nextStep(1)">Suivant <i class="fas fa-arrow-right"></i></button>
                    </div>
                </div>

                <!-- Étape 2: Caractéristiques -->
                <div class="form-section" id="step-2">
                    <div class="form-header">
                        <h2>Caractéristiques techniques</h2>
                        <p>Définissez les spécifications techniques de la voiture</p>
                    </div>

                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label for="couleur">Couleur</label>
                                <select id="couleur" name="couleur">
                                    <option value="rouge">Rouge</option>
                                    <option value="bleu">Bleu</option>
                                    <option value="noir">Noir</option>
                                    <option value="blanc">Blanc</option>
                                    <option value="gris">Gris</option>
                                    <option value="vert">Vert</option>
                                    <option value="jaune">Jaune</option>
                                    <option value="orange">Orange</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-col">
                            <div class="form-group">
                                <label for="carburant">Carburant</label>
                                <select id="carburant" name="carburant">
                                    <option value="Essence">Essence</option>
                                    <option value="Diesel">Diesel</option>
                                    <option value="Hybride">Hybride</option>
                                    <option value="Électrique">Électrique</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label for="type_boite">Boîte de vitesses</label>
                                <select id="type_boite" name="type_boite">
                                    <option value="Manuelle">Manuelle</option>
                                    <option value="Automatique">Automatique</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-col">
                            <div class="form-group">
                                <label for="kilometrage">Kilométrage</label>
                                <input type="number" id="kilometrage" name="kilometrage" placeholder="Ex: 45000">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label>Nombre de places</label>
                                <input type="number" name="nombre_place" min="2" placeholder="Ex: 5">
                            </div>
                        </div>

                        <div class="form-col">
                            <div class="form-group">
                                <label>Nombre de portes</label>
                                <input type="number" name="nombre_porte" min="2" placeholder="Ex: 4">
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn btn-prev" onclick="prevStep(2)"><i class="fas fa-arrow-left"></i> Précédent</button>
                        <button type="button" class="btn btn-next" onclick="nextStep(2)">Suivant <i class="fas fa-arrow-right"></i></button>
                    </div>
                </div>

                <!-- Étape 3: Comfort & Accessoires -->
                <div class="form-section" id="step-3">
                    <div class="form-header">
                        <h2>Équipements et confort</h2>
                        <p>Sélectionnez les équipements disponibles dans la voiture</p>
                    </div>

                    <div class="info-note">
                        <i class="fas fa-info-circle"></i> Cochez les équipements disponibles dans cette voiture
                    </div>

                    <div class="accessoires">
                        <label><input type="checkbox" name="accessoires[]" value="climatisation"> Climatisation</label>
                        <label><input type="checkbox" name="accessoires[]" value="gps"> GPS</label>
                        <label><input type="checkbox" name="accessoires[]" value="bluetooth"> Bluetooth</label>
                        <label><input type="checkbox" name="accessoires[]" value="camera_recul"> Caméra de recul</label>
                        <label><input type="checkbox" name="accessoires[]" value="usb"> Port USB</label>
                        <label><input type="checkbox" name="accessoires[]" value="sieges_cuir"> Sièges cuir</label>
                        <label><input type="checkbox" name="accessoires[]" value="toit_ouvrant"> Toit ouvrant</label>
                        <label><input type="checkbox" name="accessoires[]" value="regulateur"> Régulateur de vitesse</label>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn btn-prev" onclick="prevStep(3)"><i class="fas fa-arrow-left"></i> Précédent</button>
                        <button type="button" class="btn btn-next" onclick="nextStep(3)">Suivant <i class="fas fa-arrow-right"></i></button>
                    </div>
                </div>

                <!-- Étape 4: Disponibilité -->
                <div class="form-section" id="step-4">
                    <div class="form-header">
                        <h2>Disponibilité et tarification</h2>
                        <p>Définissez les périodes de disponibilité et le tarif de location</p>
                    </div>

                    <div class="form-group">
                        <label for="matricule">Matricule</label>
                        <input type="text" id="matricule" name="matricule" placeholder="Ex: 40 /b / 20033E3">
                    </div>

                    <div class="form-group">
                        <label for="prix_location">Prix par jour (MAD)</label>
                        <input type="number" id="prix_location" name="prix_location" placeholder="Ex: 300">
                    </div>

                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label for="date_debut">Date de début</label>
                                <input type="date" id="date_debut" name="date_debut">
                            </div>
                        </div>

                        <div class="form-col">
                            <div class="form-group">
                                <label for="date_fin">Date de fin</label>
                                <input type="date" id="date_fin" name="date_fin">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="statut">Statut</label>
                        <select id="statut" name="statut">
                            <option value="disponible">Disponible</option>
                            <option value="indisponible">Indisponible</option>
                            <option value="reserve">Réservé</option>
                        </select>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn btn-prev" onclick="prevStep(4)"><i class="fas fa-arrow-left"></i> Précédent</button>
                        <button type="button" class="btn btn-next" onclick="nextStep(4)">Suivant <i class="fas fa-arrow-right"></i></button>
                    </div>
                </div>

                <!-- Étape 5: Images & Validation -->
                <div class="form-section" id="step-5">
                    <div class="form-header">
                        <h2>Photos et validation</h2>
                        <p>Ajoutez des photos de la voiture et validez votre saisie</p>
                    </div>

                    <div class="form-group">
                        <label for="photos">Choisir des images</label>
                        <input type="file" id="photos" name="images[]" accept="image/*" multiple>
                        <div class="info-note">
                            <i class="fas fa-info-circle"></i> Vous pouvez sélectionner plusieurs images (max 5)
                        </div>
                    </div>

                    <div class="info-note">
                        <i class="fas fa-check-circle"></i> Vérifiez toutes les informations avant de soumettre le formulaire
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn btn-prev" onclick="prevStep(5)"><i class="fas fa-arrow-left"></i> Précédent</button>
                        <button type="submit" class="btn btn-submit">Ajouter la Voiture <i class="fas fa-check"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script src="../js1/formajoutervoiture.js">
    </script>
</body>

</html>