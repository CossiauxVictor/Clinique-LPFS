<?php
session_start();
if($_SESSION['Autorisation']!="Yes"){
    header("Location: index.html");
    exit;
}
$num_secu = $_SESSION['num_secu'];
require_once('config.php');



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    
    // Récupération des données du formulaire
    $carte_identite = isset($_POST["carte_identite"]) ? $_POST["carte_identite"] : NULL;
    $carte_vitale = isset($_POST["carte_vitale"]) ? $_POST["carte_vitale"] : NULL;
    $carte_mutuelle = isset($_POST["carte_mutuelle"]) ? $_POST["carte_mutuelle"] : NULL;

    if (!empty($carte_identite) || !empty($carte_vitale) || !empty($carte_mutuelle)) {
        // Préparer la requête
        $requete = "INSERT INTO `piece_jointe_patient`(`carte_identite`, `carte_vitale`, `carte_mutuelle`, `num_securite_social`) VALUES (?, ?, ?, ?)";

        // Préparer la requête
        $statement = $connexion->prepare($requete);

        // Binder les paramètres
        $statement->bind_param("ssss", $carte_identite, $carte_vitale, $carte_mutuelle, $num_secu);

        // Exécuter la requête
        $resultat = $statement->execute();

        // Vérifier si l'insertion a réussi
        if ($resultat) {
            echo "Enregistrement dans la base de données réussi.";
        } else {
            echo "Erreur lors de l'enregistrement dans la base de données : " . $connexion->error;
        }

        // Fermer la connexion à la base de données
        $statement->close();

        // Rediriger vers la page personne.php
        header("Location: personne.php");

    } else {
        // Rediriger vers la page personne.php
        header("Location: personne.php");
    }


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
    <link rel="stylesheet" href="src/css/files.css">

    <!-- TITLE -->
    <title> Pièce jointes </title>
</head>
<body>
    <div class="formulaire_inscription">
        <form class="inscription" method="post">
            <a href="hospitalisation.php"><i class="fa-solid fa-arrow-left"></i></a> 
            <h1> Pièces jointes </h1>
            <!-- Existing Documents for Download -->
            <h2>Documents existants :</h2>
            <br>
            <ul>
                <li><a>Carte d'identité</a></li>
                <li><a>Carte vitale</a></li>
                <li><a>Carte de mutuelle</a></li>
            </ul>

            <!-- Upload/Replace Document Section -->
            <br><br>
            <h2>Si changement de pièces jointes :</h2>
            <br>
            <label for="file">Carte d'identité (recto verso)*</label>
            <input type="file" name="carte_identite" id="carte_identite" class="form_input" accept=".jpg, .jpeg, .png, .pdf">
            <br>
            <br>
            <label for="file">Carte vitale*</label>
            <input type="file" name="carte_vitale" id="carte_vitale" class="form_input" accept=".jpg, .jpeg, .png, .pdf">
            <br>
            <br>
            <label for="file">Carte de mutuelle*</label>
            <input type="file" name="carte_mutuelle" id="carte_mutuelle" class="form_input" accept=".jpg, .jpeg, .png, .pdf">
            <br>
            <br>
            <input type="submit" name="submit" value="Envoyer" class="form_button">
        </form>
    </div>
</body>
</html>
