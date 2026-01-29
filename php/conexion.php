<?php

try {
    
    $conexion = new PDO("mysql:host=localhost;dbname=agences", 'root', '');
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


} catch (PDOException $err) {
    if (isset($conexion) && $conexion->inTransaction()) {
        $conexion->rollBack();
        echo "Transaction annulée.<br>";
    }
    echo "Erreur : " . $err->getMessage();
}


?>