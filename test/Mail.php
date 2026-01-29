<?php include 'conexion.php'?>
<?php

 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\Exception;
 
 // require les fichiers
 require 'PHPMailer/PHPMailer.php';
 require 'PHPMailer/SMTP.php';
 require 'PHPMailer/Exception.php';


$email=$_GET['email'];
    
echo $email; 
    // $mail = new PHPMailer(true);
    
    // try {

    //   $code = rand(100000, 999999);

    //     // Paramètres SMTP Gmail
    //     $mail->isSMTP();
    //     $mail->Host       = 'smtp.gmail.com';
    //     $mail->SMTPAuth   = true;
    //     $mail->Username   = 'locationvoiturema@gmail.com';         // Gmail dyalk
    //     $mail->Password   = 'kahulanwxogkyayf';            // App Password, machi password normal
    //     $mail->SMTPSecure = 'tls';
    //     $mail->Port       = 587;
    
    //     // Expéditeur & Destinataire
    //     $mail->setFrom('locationvoiturema.email@gmail.com');
    //     $mail->addAddress($adress);
    
    //     // Contenu
    //     $mail->isHTML(true);
    //     $mail->Subject = 'TON CODE : ';
    //     $mail->Body    = "Bonjour,\n\nVoici ton code de vérification (OTP) : $code\n\nMerci.";
    //     $mail->AltBody = 'Voici un email de test depuis localhost avec PHPMailer.';
    
    //     $mail->send();
    //     // echo 'Message envoyé avec succès';

    // } catch (Exception $e) {
    //     echo "<script>alert($mail->ErrorInfo)</script>";
    //}
   

?>