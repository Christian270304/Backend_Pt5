<?php
    // Christian Torres Barrantes

    $servername = "localhost";
    $usernamebd = "root";
    $password = "";
    $dbname = "pt05_christian_torres";

    try {
        // Cremos una conexion PDO.
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $usernamebd, $password); 
    } catch (PDOException $e) {
        die("Error al conectar a la base de datos: " . $e->getMessage());
    }
?>