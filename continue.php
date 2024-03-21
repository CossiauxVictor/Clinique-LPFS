<?php
session_start();
if($_SESSION['Autorisation']!="Yes"){
    header("Location: index.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- META -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- LINKS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="src/css/choice.css">

    <!-- TITLE -->
    <title> Formulaire de Fin </title>
</head>
<body>
    <!-- FORMULAIRE DE CONNEXION -->
    <div class="formulaire_inscription">
        <form method="post" class="inscription">
            <a href="connexion.php" ><i class="fa-solid fa-arrow-left"></i></a> 
            <h1> Choisissez </h1>
            <h2> Veuillez choisir entre rajouter une autre personne ou télécharger le pdf  </h2> 
            <img src="src/img/LPFS_logo.png" alt="logo clinique LPFS">
            <br>
            <br>
            <div class="content_choice">
                <a href="personne.php" class="form_input"> Autre personne </a>              
                <a href="pdf.php " class="form_input"> Télécharger le pdf </a>
            </div>
            <div class='content_choice'>
                <a href="secretairemenu.php" class="form_input"> Terminer </a>
            </div>
            
        </form>
    </div>
</body>
</html>