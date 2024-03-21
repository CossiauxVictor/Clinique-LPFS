<?php
    // Assurez-vous que la session est démarrée en haut du fichier
    session_start();
if($_SESSION['Autorisation']!="Yes"){
    header("Location: index.html");
    exit;
}
    $num_secu = $_SESSION['num_secu'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupération des données du formulaire
        $carte_identite = $_POST["carte_identite"];
        $carte_vitale = $_POST["carte_vitale"];
        $carte_mutuelle = $_POST["carte_mutuelle"];

        require_once('config.php');
        
        // Préparation de la requête SQL en utilisant des paramètres pour éviter les failles SQL Injection
        $requete = "INSERT INTO `piece_jointe_patient`(`carte_identite`, `carte_vitale`, `carte_mutuelle`, `num_securite_social`) VALUES (?, ?, ?, ?)";

        // Préparation de la requête
        $stmt = $connexion->prepare($requete);
        $stmt->bind_param("ssss", $carte_identite, $carte_vitale, $carte_mutuelle, $num_secu);

        // Exécution de la requête
        if ($stmt->execute()) {
            header("Location: personne.php");
        } else {
            echo "Erreur lors de l'enregistrement : " . $connexion->error;
        }

        // Fermeture du statement et de la connexion à la base de données
        $stmt->close();
        $connexion->close();
    }
?>

<!DOCTYPE html>
<html lang="fr">
<html>
<head>
    <!-- META -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- LINKS -->
    <link rel="stylesheet" href="src/css/files.css">

    <!-- TITLE -->
    <title> Pièce jointes </title>
</head>
<body>
    <div class="formulaire_inscription">
        <form class="inscription" method="post">
        <h1> Piece jointes </h1>
            <label for="file">Carte d'identité (recto verdso)*</label>
            <input type="file" name="carte_identite" id="carte_identite" class="form_input" accept=".jpg, .jpeg, .png, .pdf" required>
            <br>
            <br>
            <label for="file">Carte vitale*</label>
            <input type="file" name="carte_vitale" id="carte_vitale" class="form_input" accept=".jpg, .jpeg, .png, .pdf" required>
            <br>
            <br>
            <label for="file">Carte de mutuelle*</label>
            <input type="file" name="carte_mutuelle" id="carte_mutuelle" class="form_input" accept=".jpg, .jpeg, .png, .pdf" required>
            <br>
            <br>
        <input type="submit" name="submit" value="Envoyer" class="form_button">
    </form>


    </div>
</body>
</html>