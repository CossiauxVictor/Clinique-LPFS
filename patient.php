<?php
    session_start();
if($_SESSION['Autorisation']!="Yes"){
    header("Location: index.html");
    exit;
}

    $num_secu = $_SESSION['num_secu'];

    require_once('config.php');
      
    // Vérifier si le formulaire a été soumis
    if (isset($_POST["valider"])) {
        // Récupérer les données du formulaire
        $nom_naissance = $_POST["nom_naissance"];
        $nom_epouse = $_POST["nom_epouse"];
        $prenom = $_POST["prenom"];
        $civilite = $_POST["civilite"];
        $date_naissance = $_POST["date_naissance"];
        $_SESSION['date_naissance'] = $date_naissance;
        $adresse = $_POST["adresse"];
        $cp = $_POST["cp"];
        $ville = $_POST["ville"];
        $mail = $_POST["mail"];
        $telephone = $_POST["telephone"];  

        $dateDuJour = date("Y-m-d");

        if($date_naissance<$dateDuJour){
            // Vérifier que le numéro de sécurité sociale commence par "1" ou "2"
            if (substr($num_secu, 0, 1) != "1" && substr($num_secu, 0, 1) != "2") {
                echo "Le numéro de sécurité sociale doit commencer par '1' ou '2'."; 
            } else {

            // Vérifier que le numéro de sécurité sociale commence par "1" pour Homme ou "2" pour Femme
            if ((substr($num_secu, 0, 1) == "1" && $civilite != "homme") ||
            (substr($num_secu, 0, 1) == "2" && $civilite != "femme")) {
                echo "Le numéro de sécurité sociale ne correspond pas à la civilité choisie.";
            } else {

                // Préparer la requête SQL d'insertion
                $sql = "INSERT INTO patient (num_securite_social, nom_naissance, nom_epouse, prenom, civilite, date_naissance, adresse, cp, ville,email, telephone)
                        VALUES ('$num_secu', '$nom_naissance', '$nom_epouse', '$prenom', '$civilite', '$date_naissance', '$adresse', '$cp', '$ville', '$mail', '$telephone')";

                // Exécuter la requête
                if ($conn->query($sql) === TRUE) {
                    // Rediriger vers patient2.php
                    header("Location: patient2.php");
                    exit(); 
                } else {
                    echo "Erreur lors de l'enregistrement : " . $conn->error;
                }
            }
            }
        }else{
            echo"Veuillez saisir votre date de naissance n'est pas bonne !";
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
    <link rel="stylesheet" href="src/css/patient.css">


    <!-- TITLE -->
    <title> Formulaire patient </title>

</head>
<body>
    
    <!-- FORMULAIRE D'INSCRIPTION -->
    <div class="formulaire_inscription">
        <form class="inscription" method="post" action="patient.php">
            <a href=""><i class="fa-solid fa-arrow-left"></i></a> 
            <h1> Formulaire patients </h1>
            <div class="div_formulaire">
                <label for="assure"> Numéro de sécurité social*</label>
                <?php echo"<input type='text' id='numero_secu' name='numero_secu' class='form_input' value='$num_secu' maxlength='13' required readonly>";?>
            </div>
            <div class="div_formulaire">
                <label for="assure"> Nom naissance*</label>
                <input type="text" name="nom_naissance" class="form_input" placeholder="Nom naissance" required>
            </div>

            <div class="div_formulaire">
                <label for="assure"> Nom epouse</label>
                <input type="text" name="nom_epouse" class="form_input" placeholder="Nom epouse">
            </div>
            <div class="div_formulaire">
                <label for="assure"> Prénom*</label>
                <input type="text" name="prenom" class="form_input" placeholder="Prénom" required>
            </div>

            <div class="div_formulaire">
                <label for="assure"> Civilite*</label>
                <select name="civilite" id="civilite" class="form_input" required>
                    <option value="homme">Homme</option>
                    <option value="femme">Femme</option>
                </select>
            </div>

            <div class="div_formulaire">
                <label for="assure"> Date naissance*</label>
                <input type="date" id="date_naissance" class="form_input" name="date_naissance" required>
            </div>

            <div class="div_formulaire">
                <label for="assure"> Adresse*</label>
                <input type="text" name="adresse" class="form_input" placeholder="Adresse" required>
            </div>

            <div class="div_formulaire">
                <label for="assure"> Code postal*</label>
                <input type="text" name="cp" class="form_input" maxlength="5" placeholder="Code postal" required>
            </div>

            <div class="div_formulaire">
                <label for="assure"> Ville*</label>
                <input type="text" name="ville" class="form_input" placeholder="Ville" required>
            </div>

            <div class="div_formulaire">
                <label for="assure"> Mail*</label>
                <input type="text" name="mail" class="form_input" placeholder="Mail" required> 
            </div>

            <div class="div_formulaire">
                <label for="assure"> Téléphone*</label>
                <input type="text" name="telephone" class="form_input" placeholder="Téléphone" maxlength="10" required>
            </div>
                           
            <input type="submit" name="valider" value="Suivant" class="form_button" required>
        </form>
    </div>
</body>
</html>