<?php

session_start();
$id_agence = $_SESSION['id_agence'];
if (!isset($id_agence)) {
    header("location:../php/acceill.php");
}
$id_article = $_GET["id"];
if (!isset($id_agence)) {
    header("location:acceill.php");
}
?>
<?php
require_once("../php/connexiondata.php");
$connexion = connexion_data("localhost", "root", "", "agences");
if ($connexion) {
    $recupererall = $connexion->prepare("SELECT * from article_location WHERE id_article_location =:id_article_location");
    $recupererall->bindParam(":id_article_location", $id_article);
    $recupererall->execute();
    $allresultat = $recupererall->fetch(PDO::FETCH_ASSOC);
    $info_suplimentaire = explode(",", $allresultat["info_supplimentaire"]);
}
// var_dump($allresultat);

?>
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
    <form class="form-container" action="valider_modification.php?id_article=<?= $id_article ?>" method="post" enctype="multipart/form-data" id="form_parent">

        <nav>
            <ul>
                <li><img class="logo" src="../<?= $logo_url ?>" alt="Logo agence" height="50"></li>
                <li><a href="acceill.php">accueil</a></li>
                <li><a href="tableagence.php">tabeau location</a></li>
                <li><a href="quitter.php">quitter</a></li>
            </ul>
            <h1>modifier article</h1>
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
                                    <option value="economique" <?= ($allresultat["categorie"] === "economique") ? "selected" : "" ?>>Economique</option>
                                    <option value="moyenne" <?= ($allresultat["categorie"] === "moyenne") ? "selected" : "" ?>>Moyenne</option>
                                    <option value="luxe" <?= ($allresultat["categorie"] === "luxe") ? "selected" : "" ?>>Luxe</option>
                                </select>

                            </div>
                        </div>

                        <div class="form-col">
                            <div class="form-group">
                                <label for="marque">Marque</label>
                                <select id="marque" name="marque">
                                    <option value="" disabled selected>Sélectionner une marque</option>
                                    <option value="Dacia" <?= ($allresultat["marque"] === "Dacia") ? "selected" : "" ?>>Dacia</option>
                                    <option value="Renault" <?= ($allresultat["marque"] === "Renault") ? "selected" : "" ?>>Renault</option>
                                    <option value="Peugeot" <?= ($allresultat["marque"] === "Peugeot") ? "selected" : "" ?>>Peugeot</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="type_marque">Modèle</label>
                        <input type="text" id="type_marque" name="type_marque" placeholder="Ex: Yaris" value="<?= ($allresultat["type_marque"]) ?>">
                    </div>

                    <div class="form-group">
                        <label for="modele">Année de modèle</label>
                        <input type="number" id="modele" name="modele" placeholder="Ex: 2023" value="<?= ($allresultat["modele"]) ?>">
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
                                    <option value="rouge" <?= ($allresultat["couleur"] === "rouge") ? "selected" : "" ?>>Rouge</option>
                                    <option value="bleu" <?= ($allresultat["couleur"] === "bleu") ? "selected" : "" ?>>Bleu</option>
                                    <option value="noir" <?= ($allresultat["couleur"] === "noir") ? "selected" : "" ?>>Noir</option>
                                    <option value="blanc" <?= ($allresultat["couleur"] === "blanc") ? "selected" : "" ?>>Blanc</option>
                                    <option value="gris" <?= ($allresultat["couleur"] === "gris") ? "selected" : "" ?>>Gris</option>
                                    <option value="vert" <?= ($allresultat["couleur"] === "vert") ? "selected" : "" ?>>Vert</option>
                                    <option value="jaune" <?= ($allresultat["couleur"] === "jaune") ? "selected" : "" ?>>Jaune</option>
                                    <option value="orange" <?= ($allresultat["couleur"] === "orange") ? "selected" : "" ?>>Orange</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-col">
                            <div class="form-group">
                                <label for="carburant">Carburant</label>
                                <select id="carburant" name="carburant">
                                    <option value="Essence" <?= ($allresultat["carburant"] === "Essence") ? "selected" : "" ?>>Essence</option>
                                    <option value="Diesel" <?= ($allresultat["carburant"] === "Diesel") ? "selected" : "" ?>>Diesel</option>
                                    <option value="Hybride" <?= ($allresultat["carburant"] === "Hybride") ? "selected" : "" ?>>Hybride</option>
                                    <option value="Électrique" <?= ($allresultat["carburant"] === "Électrique") ? "selected" : "" ?>>Électrique</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label for="type_boite">Boîte de vitesses</label>
                                <select id="type_boite" name="type_boite">
                                    <option value="Manuelle" <?= ($allresultat['type_boite'] === "Manuelle") ? "selected" : "" ?>>Manuelle</option>
                                    <option value="Automatique" <?= ($allresultat['type_boite'] === "Automatique") ? "selected" : "" ?>>Automatique</option>
                                </select>

                            </div>
                        </div>

                        <div class="form-col">
                            <div class="form-group">
                                <label for="kilometrage">Kilométrage</label>
                                <input type="number" id="kilometrage" name="kilometrage" value="<?= ($allresultat["kilometrage"]) ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label>Nombre de places</label>
                                <input type="number" name="nombre_place" min="2" value="<?= ($allresultat["nombre_place"]) ?>">
                            </div>
                        </div>

                        <div class="form-col">
                            <div class="form-group">
                                <label>Nombre de portes</label>
                                <input type="number" name="nombre_porte" min="2" value="<?= ($allresultat["nombre_porte"]) ?>">
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

                    <!-- <div class="accessoires">
                
                            <label><input type="checkbox" name="accessoires[]" value="climatisation"> Climatisation</label>
                            <label><input type="checkbox" name="accessoires[]" value="gps"> GPS</label>
                            <label><input type="checkbox" name="accessoires[]" value="bluetooth"> Bluetooth</label>
                            <label><input type="checkbox" name="accessoires[]" value="camera_recul"> Caméra de recul</label>
                            <label><input type="checkbox" name="accessoires[]" value="usb"> Port USB</label>
                            <label><input type="checkbox" name="accessoires[]" value="sieges_cuir"> Sièges cuir</label>
                            <label><input type="checkbox" name="accessoires[]" value="toit_ouvrant"> Toit ouvrant</label>
                            <label><input type="checkbox" name="accessoires[]" value="regulateur"> Régulateur de vitesse</label>
                    </div> -->

                    <?php
                    $accessoires_disponibles = [
                        "climatisation" => "Climatisation",
                        "gps" => "GPS",
                        "bluetooth" => "Bluetooth",
                        "camera_recul" => "Caméra de recul",
                        "usb" => "Port USB",
                        "sieges_cuir" => "Sièges cuir",
                        "toit_ouvrant" => "Toit ouvrant",
                        "regulateur" => "Régulateur de vitesse"
                    ];
                    ?>
                    <div class="accessoires">
                        <?php foreach ($accessoires_disponibles as $val => $label): ?>
                            <label>
                                <input type="checkbox" name="accessoires[]" value="<?= $val ?>"
                                    <?= in_array($val, $info_suplimentaire) ? "checked" : "" ?>>
                                <?= $label ?>
                            </label>
                        <?php endforeach; ?>
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
                        <input type="text" id="matricule" name="matricule" value="<?= ($allresultat["matricule"]) ?>">
                    </div>

                    <div class="form-group">
                        <label for="prix_location">Prix par jour (MAD)</label>
                        <input type="number" id="prix_location" name="prix_location" value="<?= ($allresultat["prix_location"]) ?>">
                    </div>

                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label for="date_debut">Date de début</label>
                                <input type="date" id="date_debut" name="date_debut" value="<?= ($allresultat["date_debut"]) ?>">
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group">
                                <label for="date_fin">Date de fin</label>
                                <input type="date" id="date_fin" name="date_fin" value="<?= ($allresultat["date_debut"]) ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="statut">Statut</label>
                        <select id="statut" name="statut">
                            <option value="disponible" <?= ($allresultat["statut"] === "disponible") ? "selected" : "" ?>>Disponible</option>
                            <option value="indisponible" <?= ($allresultat["statut"] === "indisponible") ? "selected" : "" ?>>Indisponible</option>
                            <option value="reserve" <?= ($allresultat["statut"] === "reserve") ? "selected" : "" ?>>Réservé</option>
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
                        <button type="submit" class="btn btn-submit">Modifier la Voiture <i class="fas fa-check"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script src="../js1/formajoutervoiture.js">
    </script>


</body>

</html>