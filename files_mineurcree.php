<?php
    // Assurez-vous que la session est démarrée en haut du fichier
    session_start();
if($_SESSION['Autorisation']!="Yes"){
    header("Location: index.html");
    exit;
}
    $num_secu = $_SESSION['num_secu'];
    require_once('config.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupération des données du formulaire
        $livret_famille = isset($_POST["livret_famille"]) ? $_POST["livret_famille"] : NULL;
        $responsable_legaux = isset($_POST["responsable_legaux"]) ? $_POST["responsable_legaux"] : NULL;
        $autorisation_juge = isset($_POST["autorisation_juge"]) ? $_POST["autorisation_juge"] : NULL;
        $carte_identite = isset($_POST["carte_identite"]) ? $_POST["carte_identite"] : NULL;
        $carte_vitale = isset($_POST["carte_vitale"]) ? $_POST["carte_vitale"] : NULL;
        $carte_mutuelle = isset($_POST["carte_mutuelle"]) ? $_POST["carte_mutuelle"] : NULL;
    
        $requete = "INSERT INTO `piece_jointe_patient_mineur`(`livret_famille`, `responsable_legaux`, `autorisation_juge`, `num_securite_social`, `carte_identite`, `carte_vitale`, `carte_mutuelle`) VALUES (?, ?, ?, ?, ?, ?, ?)";
    
        // Préparer la requête
        $statement = $connexion->prepare($requete);
    
        // Binder les paramètres
        $statement->bind_param("sssssss", $livret_famille, $responsable_legaux, $autorisation_juge, $num_secu, $carte_identite, $carte_vitale, $carte_mutuelle);
    
        // Exécuter la requête
        $resultat = $statement->execute();
    
        // Vérifier si l'insertion a réussi
        if ($resultat) {
            echo "Enregistrement dans la base de données réussi.";
        } else {
            echo "Erreur lors de l'enregistrement dans la base de données : " . $statement->error;
        }
    
        // Rediriger vers la page personne.php
        header("Location: personne.php");
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
        <h1> Piece jointes mineur </h1>
            <!-- Existing Documents for Download -->
            <h2>Documents existants :</h2>
            <br>
            <ul>
                <li><a>Carte d'identité</a></li>
                <li><a>Carte vitale</a></li>
                <li><a>Carte de mutuelle</a></li>
                <li><a>Livret de famille</a></li>
                <li><a>Signature des responsables legaux</a></li>
                <li><a>Autorisation du juge</a></li>
            </ul>

            <!-- Upload/Replace Document Section -->
            <br><br>
            <label for="file">Carte d'identité (recto verdso)*</label>
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
            <label for="file">Livret de famille*</label>
            <input type="file" name="livret_famille" id="livret_famille" class="form_input" accept=".jpg, .jpeg, .png, .pdf">
            <br>
            <br>
            <label for="file">Signature des responsables legaux*</label>
            <input type="file" name="responsable_legaux" id="responsable_legaux" class="form_input" accept=".jpg, .jpeg, .png, .pdf">
            <br>
            <br>
            <label for="file">Autorisation du juge*</label>
            <input type="file" name="autorisation_juge" id="autorisation_juge" class="form_input" accept=".jpg, .jpeg, .png, .pdf">
            <br>
            <br>
        <input type="submit" name="submit" value="Envoyer" class="form_button">
    </form>



    </div>
</body>
</html>