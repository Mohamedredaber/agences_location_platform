<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// PHPMailer inclus
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/Exception.php';

if (isset($_POST['submit'])) {
    require_once("../php/connexiondata.php");
    $conn = connexion_data("localhost", "root", "", "agences");

    $emailStmt = $conn->prepare("SELECT adress FROM agence WHERE adress = :adress");
    $emailStmt->bindParam(":adress", $_POST['email']);
    $emailStmt->execute();
    $resultat = $emailStmt->fetch(PDO::FETCH_ASSOC);
    // Vérifie si l’email existe
    if ($resultat) {
        $_SESSION['error_email_exist'] = "Cet email n'existe pas dans notre base.";
        header('Location: ../html/verifierht.php');
        exit();
    }

    // Crée l'objet mail
    $mail = new PHPMailer(true);

    try {
        $code = rand(100000, 999999);
        $_SESSION['otp'] = $code;
        $_SESSION['email'] = $_POST['email'];

        // Configuration SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'locationvoiturema@gmail.com';      // Adresse Gmail
        $mail->Password   = 'kahulanwxogkyayf';                 // App password Gmail
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Expéditeur et destinataire
        $mail->setFrom('locationvoiturema@gmail.com', 'Location Voiture MA');
        $mail->addAddress($_POST['email']);

        // Contenu du mail
        $mail->isHTML(true);
        $mail->Subject = 'Votre code de vérification';
        $mail->Body    = "Bonjour,<br><br>Voici votre code de vérification : 
                          <strong style='color:red;font-size:20px;'>$code</strong><br><br>Merci.";
        $mail->AltBody = "Votre code de vérification est : $code";

        $mail->send();

        header('Location: ../html/otpht.php');
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = "Erreur lors de l'envoi de l'email : " . $mail->ErrorInfo;
        header('Location: ../html/verifierht.php');
        exit();
    }
}
