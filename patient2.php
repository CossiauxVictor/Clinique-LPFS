<?php
        session_start();
if($_SESSION['Autorisation']!="Yes"){
    header("Location: index.html");
    exit;
}
        $num_secu=$_SESSION['num_secu'];
        $_SESSION['patientdaje']=false;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupération des données du formulaire
        $numero_secu = $_POST["numero_secu"];
        $assure = ($_POST["assure"] == "Oui") ? 1 : 0; // Conversion en booléen
        $ald = ($_POST["ald"] == "Oui") ? 1 : 0; // Conversion en booléen    
        $nom_assurance = $_POST["nom_assurance"];
        $adherent = $_POST["adherent"];

        require_once('config.php');

        // Préparation de la requête SQL
        $requete = "INSERT INTO couverture_sociale (patient_assure, patient_ald, nom_assurance, num_adherent, num_securite_social) VALUES ('$assure', '$ald', '$nom_assurance', '$adherent', '$numero_secu')";
    
        // Exécution de la requête
        if ($connexion->query($requete) === TRUE) {
            header("Location: hospitalisation.php");
            exit;
        } else {
            echo "Erreur lors de l'enregistrement : " . $connexion->error;
        }
    
        // Fermeture de la connexion à la base de données
        $connexion->close();
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
    <link rel="stylesheet" href="src/css/patient2.css">


    <!-- TITLE -->
    <title> Formulaire patient 2 </title>

</head>
<body>
    <!-- FORMULAIRE D'INSCRIPTION -->
    <div class="formulaire_inscription">
        <form class="inscription" method="post">
            <h1> Formulaire patients </h1>
            <div class="div_formulaire">
                <label for="assure"> Numéro de sécurité social*</label>
                <?php echo"<input type='text' id='numero_secu' name='numero_secu' class='form_input' value='$num_secu' maxlength='13' required readonly>";?>
            </div>

            <div class="div_formulaire">
                <label for="assure"> Le patient est-il assuré ?*</label>
                <select name="assure" id="assure" class="form_input" required>
                    <option> Oui</option>
                    <option> Non</option>
                </select>         
            </div>

            <div class="div_formulaire">
            <label for="assure"> Le patient est-il en ALD ?*</label>
                <select name="ald" id="ald" class="form_input" required>
                    <option> Oui</option>
                    <option> Non</option>
                </select>   
            </div>
            <div class="div_formulaire">
                <label for="assure"> Nom de l'assurance ou de la mutuelle* </label>
                <input type="text" name="nom_assurance" class="form_input" placeholder="Nom de la mutuelle ou de l'assurance" required>
            </div>

            <div class="div_formulaire">
                <label for="assure"> Numéro d'adhérent*</label>
                <input type="text" name="adherent" class="form_input" placeholder="Numéro de l'adhérent" required>
            </div>
                           
            <input type="submit" name="valider" value="Suivant" class="form_button" >
        </form>
    </div>
</body>
</html>