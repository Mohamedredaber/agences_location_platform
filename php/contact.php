<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/Exception.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = htmlspecialchars(trim($_POST['nom'] ?? ''));
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    $message = htmlspecialchars(trim($_POST['message'] ?? ''));

    if (empty($nom) || !$email || empty($message)) {
        $_SESSION['error'] = "Veuillez remplir tous les champs correctement.";
        header('Location: contact.php');
        exit();
    }

    $mail = new PHPMailer(true);

    try {
        // Config SMTP Gmail
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'locationvoiturema@gmail.com';
        $mail->Password = 'kahulanwxogkyayf';  // Mot de passe app Gmail
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Expéditeur et destinataire
        $mail->setFrom($email, $nom); // L'adresse de l'utilisateur comme expéditeur (optionnel)
        $mail->addAddress('locationvoiturema@gmail.com', 'Location Voiture MA');

        // Contenu
        $mail->isHTML(true);
        $mail->Subject = 'Nouveau message de contact';
        $mail->Body = "
            <p><strong>Nom :</strong> {$nom}</p>
            <p><strong>Email :</strong> {$email}</p>
            <p><strong>Message :</strong><br>" . nl2br($message) . "</p>
        ";
        $mail->AltBody = "Nom: $nom\nEmail: $email\nMessage:\n$message";
        $mail->send();

        $_SESSION['success_contact'] = "Votre message a été envoyé avec succès. Merci de nous avoir contactés.";
        header('Location: ../html/contactht.php');
        exit();
    } catch (Exception $e) {
        $_SESSION['error_contact'] = "Erreur lors de l'envoi du message : " . $mail->ErrorInfo;
        header('Location: ../html/contactht.php');
        exit();
    }
} else {
    header('Location: ../html/contactht.php');
    exit();
}
