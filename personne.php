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
    $Nom = $_POST["Nom"];
    $Prenom = $_POST["Prenom"];
    $Adresse = $_POST["Adresse"];
    $Téléphone = $_POST["Téléphone"];

    // Vérification si au moins une case est cochée
    if (!isset($_POST["Confiance"]) && !isset($_POST["Prevenir"])) {
        echo "Veuillez cocher au moins une option (Confiance ou Prévenir)";
    } else {
        $Confiance = isset($_POST["Confiance"]) ? $_POST["Confiance"] : null;
        $Prevenir = isset($_POST["Prevenir"]) ? $_POST["Prevenir"] : null;

        // Vérifier si l'entrée existe dans la base de données
        $query = "SELECT * FROM personne WHERE nom = '$Nom' AND prenom = '$Prenom' AND telephone = '$Téléphone' AND adresse = '$Adresse'";
        $result = $connexion->query($query);

        if ($result->num_rows > 0) {
            // L'entrée existe déjà
            $requete = "SELECT * FROM `personne` WHERE nom = '$Nom' AND prenom = '$Prenom' AND telephone = '$Téléphone' AND adresse = '$Adresse'";
            $resultat = mysqli_query($connexion, $requete);
            $ligne = mysqli_fetch_assoc($resultat);
            $id = $ligne['id_personne'];

            if ($Confiance != null) {
                $requeteSQL = "INSERT INTO `personne_confiance`(`id_personne`, `nom_securite_social`) VALUES ($id,'$num_secu')";
                $resultat = $connexion->query($requeteSQL);
            }

            if ($Prevenir != null) {
                $requeteSQL = "INSERT INTO `personne_prevenir`(`id_personne`, `nom_securite_social`) VALUES ($id,'$num_secu')";
                $resultat = $connexion->query($requeteSQL);
            }

            header("Location: continue.php");
        } else {
            // L'entrée n'existe pas, la créer
            $insert_query = "INSERT INTO `personne`(`nom`, `prenom`, `telephone`, `adresse`) VALUES ('$Nom','$Prenom','$Téléphone','$Adresse')";

            if ($connexion->query($insert_query) === TRUE) {

                $requete = "SELECT * FROM `personne` WHERE nom = '$Nom' AND prenom = '$Prenom' AND telephone = '$Téléphone' AND adresse = '$Adresse'";
                $resultat = mysqli_query($connexion, $requete);
                $ligne = mysqli_fetch_assoc($resultat);
                $id = $ligne['id_personne'];

                if ($Confiance != null) {
                    $requeteSQL = "INSERT INTO `personne_confiance`(`id_personne`, `nom_securite_social`) VALUES ($id,'$num_secu')";
                    $resultat = $connexion->query($requeteSQL);
                }

                if ($Prevenir != null) {
                    $requeteSQL = "INSERT INTO `personne_prevenir`(`id_personne`, `nom_securite_social`) VALUES ($id,'$num_secu')";
                    $resultat = $connexion->query($requeteSQL);
                }

                header("Location: continue.php");
            } else {
                echo "Erreur lors de la création de l'entrée : " . $connexion->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Personne </title>
    <link rel="stylesheet" href="src/css/patient.css">
</head>

<body>
    <div class="formulaire_inscription">
        <form class="inscription" method="post">
            <h1> Contact </h1>
            <div class="div_formulaire">
                <label for="assure"> Nom*</label>
                <input type="text" name="Nom" class="form_input" placeholder="Nom" required>
            </div>

            <div class="div_formulaire">
                <label for="assure"> Prenom*</label>
                <input type="text" name="Prenom" class="form_input" placeholder="Prenom">
            </div>


            <div class="div_formulaire">
                <label for="assure"> Adresse*</label>
                <input type="text" name="Adresse" class="form_input" placeholder="Adresse" required>
            </div>

            <div class="div_formulaire">
                <label for="assure"> Téléphone*</label>
                <input type="text" name="Téléphone" class="form_input" placeholder="Téléphone" maxlength="10" required>
            </div>

            <div class="div_formulaire">
                    <div>
                        
                    </div>
                        <label for="categorie">Catégorie :</label>
                    <div>
                        <input type="checkbox" id="Confiance" name="Confiance" value="Confiance"> Confiance
                    </div>
                    <div>
                        <input type="checkbox" id="Prevenir" name="Prevenir" value="Prevenir"> Prévenir
                    </div>
            </div>
                           
            <input type="submit" name="valider" value="Suivant" class="form_button">
        </form>
    </div>
</body>

</html>