<?php
    // Connexion à la base de données
    $servername="localhost";
    $username="root";
    $password="";
    $dbname="CliniqueLPFS";

    mysqli_report (MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = mysqli_connect ($servername, $username, $password, $dbname);
    mysqli_set_charset ($mysqli, 'utf8mb4');
    mysqli_select_db($mysqli, $dbname);

    // Créer une connexion
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }  


    $connexion = new mysqli($servername, $username, $password, $dbname);

    // Vérification de la connexion
    if ($connexion->connect_error) {
        die("La connexion à la base de données a échoué : " . $connexion->connect_error);
    }


?>
    