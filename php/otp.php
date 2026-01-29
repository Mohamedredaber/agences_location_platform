<?php

session_start();
$otp = trim($_SESSION['otp']);
if($otp == $_POST['codeutil']){
    
    header('location:../html/formulaireht.php');
}else{
    header('location:../html/verifierht.php');
    echo'<script>alert("pas meme code ")</script>';
}

?>