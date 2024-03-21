<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- META -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- LINKS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="src/css/application_panel.css">

    <!-- TITLE -->
    <title> Application panel administrateur </title>
</head>
<body>
    <!-- FORMULAIRE DE CONNEXION -->
    <div class="formulaire_inscription">
        <form method="post" class="inscription"> 
            <a href="choice.php" ><i class="fa-solid fa-arrow-left"></i></a>
            <h1> Application admin </h1>
            <h2> Veuillez choisir entre créer un utilisateur, créer un médecin, créer un services ou créer un rôle </h2>
            <p> Vous aurez la possibilité de modifier ou de supprimer les informations ! </p>
            <img src="src/img/LPFS_logo.png" alt="logo clinique LPFS">
            <br>
            <br>
            <div class="content_application">
                <div class="left">
                    <a href="users.php" class="form_input"> Partie Utilisateurs </a>              
                    <a href="services.php" class="form_input">  Partie Services </a>
                </div>

                <div class="right">
                    <a href="doctor.php" class="form_input"> Partie Médecins </a>              
                    <a href="role.php" class="form_input"> Partie Rôles </a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>