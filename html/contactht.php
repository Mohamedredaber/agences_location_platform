<?php
session_start();
if (!empty($_SESSION['success_contact'])) {
    echo "<script>alert('" . addslashes($_SESSION['success_contact']) . "');</script>";
    unset($_SESSION['success_contact']);
}
if(!empty($_SESSION['error_contact'])){
    echo "<script>alert('" . addslashes($_SESSION['error_contact']) . "');</script>";
    unset($_SESSION['error_contact']);
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact</title>
    <link rel="stylesheet" href="../css/contact.css">
    <link rel="stylesheet" href="../css/acc.css" />
</head>

<body>
    <nav>
        <div class="nav-container">
            <!-- Logo à gauche -->
            <!-- <a href="#" class="nav-logo">
                <img src="../img/logo-class-pour-location-de-voiture-1.jpg" alt="Logo" />
            </a> -->

            <!-- Menu -->
            <ul class="nav-menu">
            <img class="imgnav" src="../img/logo-class-pour-location-de-voiture-1.jpg" alt="">

                <li><a href="../php/Accueil.php">ACCUEIL</a></li>
                <li><a href="../html/loginht.php">SE CONNECTER</a></li>
                <li><a href="../html/verifierht.php">SIGN UP</a></li>
                <li><a href="../php/contact.php">CONTACT</a></li>
                <li><a href="aboutusht.php">ABOUT US</a></li>
            </ul>
        </div>
    </nav>
    <div class="contact-wrapper">
        <div class="contact-image">
            <img src="../img/logo-class-pour-location-de-voiture-1.jpg" alt="Image contact">
        </div>

        <div class="contact-section">
            <h2>Contactez-nous</h2>

            <div class="message success" style="display:none;">Message envoyé avec succès !</div>
            <div class="message error" style="display:none;">Erreur lors de l'envoi !</div>

            <form method="post" action="../php/contact.php">
                <input type="text" name="nom" placeholder="Votre nom" required>
                <input type="email" name="email" placeholder="Votre email" required>
                <textarea name="message" rows="5" placeholder="Votre message" required></textarea>
                <button type="submit">Envoyer</button>
            </form>
        </div>
    </div>
</body>


</html>