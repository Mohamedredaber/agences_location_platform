<?php
session_start();
unset($_SESSION['connecter']);
unset($_SESSION['id_agence']);
session_destroy(); 
$_SESSION["is_quitter"]=true;
header("Location: ../php/acceill.php");
exit();
