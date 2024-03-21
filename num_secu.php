<?php
session_start();
if($_SESSION['Autorisation']!="Yes"){
    header("Location: index.html");
    exit;
}
require_once('config.php');

if (isset($_POST["valider"])) {
    $num_secu = $_POST["num_secu"];
    $_SESSION['num_secu']=$num_secu;

    // SQL query to retrieve user data
    $sql_patient = "SELECT * FROM `patient`;";
    $result_patient = mysqli_query($mysqli, $sql_patient);

    $patientdaje=false;

    while ($row_patient = mysqli_fetch_array($result_patient, MYSQLI_NUM)) {
        if ($row_patient[0] == $num_secu) {
            $patientdaje = true;
            break; // Exit the loop when a matching user is found
        }
    }

    if($patientdaje){
        header("Location: patientcree.php");
        exit;
    }else{
        header("Location: patient.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <!--META-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--LINKS-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="src/css/patient.css">

    <!--TITLE-->
    <title> Numéro de sécurité sociale</title> 
</head>
<body>
    <!-- FORMULAIRE D'INSCRIPTION -->
    <div class="formulaire_inscription">
        <form class="inscription" method="post" action="num_secu.php">
            <a href="secretairemenu.php"><i class="fa-solid fa-arrow-left"></i></a> 
            <h1> Choix du patient </h1>
            <div class="div_formulaire">
            <input type="text" name="num_secu" class="form_input" placeholder="Num sécurité social" maxlength="13" required>
            </div>
            <input type="submit" name="valider" value="Suivant " class="form_button">
        </form>
    </div>
</body>
</html>