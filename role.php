<?php
// Database connection
require_once('config.php');

// Vérification de la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// Vérification si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des valeurs du formulaire
    $nom = $_POST["nom"];

    // Préparer la requête SQL d'insertion
    $sql = "INSERT INTO role (Nom)
    VALUES ('$nom')";

    // Exécuter la requête
    if ($conn->query($sql) === TRUE) {

    // Rediriger vers connexion.php
    header("Location: application_panel.php");
    exit(); 
    } else {
    echo "Erreur lors de l'enregistrement : " . $conn->error;
    }
}

// Fermeture de la connexion à la base de données
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <!-- META -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- LINKS -->
    <link rel="stylesheet" href="src/css/users.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- TITLE -->
    <title> Création rôle </title>
</head>
<body>

<div class="formulaire_inscription">
    <form class="inscription" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <a href="application_panel.php" ><i class="fa-solid fa-arrow-left"></i></a> 
        <h1> Créer un rôle</h1>
        <div class="div_formulaire">
            <label for="nom"> Nom*</label>
            <input type="text" name="nom" class="form_input" required>
        </div>

        <div class="content_user">
            <input type="submit" value="Créer" class="form_button">
            <div class="icons">
                <a href="edit_roles.php"><i class="fa-solid fa-pen" title="Modifier un rôle"></i></a>
                <a href="delete_roles.php"><i class="fa-solid fa-trash-can"  title="Supprimer un rôle"></i></a>
            </div>
        </div>
    </form>
</div>

</body>
</html>