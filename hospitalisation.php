<?php
// Assurez-vous que la session est démarrée en haut du fichier
session_start();
if($_SESSION['Autorisation']!="Yes"){
    header("Location: index.html");
    exit;
}



require_once('config.php');

$sql_medecin = "SELECT * FROM `user` where Id_Role='3';";
$result_medecin = mysqli_query($connexion, $sql_medecin);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérez les données du formulaire
    $num_secu = $_SESSION['num_secu'];

    // Assurez-vous de définir des valeurs par défaut si le formulaire ne sélectionne rien
    $pre_admission = "null";
    $chambre_particuliere = "null";

    if (isset($_POST['pre_admission'])) {
        $pre_admission_val = intval($_POST['pre_admission']);
        if ($pre_admission_val === 1) {
            $pre_admission = "Ambulatoire chirurgie";
        } elseif ($pre_admission_val === 2) {
            $pre_admission = "Hospitalisation (au moins une nuit)";
        }
    }

    if (isset($_POST['chambre_particuliere'])) {
        $chambre_particuliere_val = intval($_POST['chambre_particuliere']);
        if ($chambre_particuliere_val === 1) {
            $chambre_particuliere = "Non";
        } elseif ($chambre_particuliere_val === 2) {
            $chambre_particuliere = "Oui";
        }
    }
    $Id_User=$_POST['Id_User'];
    $date = $_POST["date"];
    $time = $_POST["time"];

    $dateEtHeureActuelles = date("Y-m-d H:i:s");
    $datetime="$date $time";

    if($datetime>$dateEtHeureActuelles){
        // Préparez la requête SQL avec des déclarations préparées pour éviter les injections SQL
    $requete = "INSERT INTO `pre_admission`(`pre_admission`, `date_hospitalisation`, `heure_hospitalisation`, `chambre_particuliere`, `Id_User`, `num_securite_social`) VALUES (?, ?, ?, ?, ?, ?)";

    // Utilisez une déclaration préparée pour exécuter la requête
    $stmt = $connexion->prepare($requete);
    $stmt->bind_param("ssssss", $pre_admission, $date, $time, $chambre_particuliere, $Id_User, $num_secu);

    if ($stmt->execute()) {
        echo "Enregistrement réussi !";
    } else {
        echo "Erreur lors de l'enregistrement : " . $stmt->error;
    }

   

    // Calculer l'âge du patient
    $date_de_naissance = new DateTime($_SESSION['date_naissance']);
    $aujourd_hui = new DateTime();
    $age = $aujourd_hui->diff($date_de_naissance)->y;


    if($_SESSION['patientdaje']==true){
        if ($age >= 18) {
            header("Location: filescree.php");
        } else {
            header("Location: files_mineurcree.php");
        }
    }else{
        if ($age >= 18) {
            header("Location: files.php");
        } else {
            header("Location: files_mineur.php");
        }
    }

    // Fermez la déclaration préparée
    $stmt->close();

    // Fermez la connexion à la base de données
    $connexion->close();
    }else{
        Echo"La date que vous avez insérée est passé, veuillez insérer une date ultérieure";
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
    <link rel="stylesheet" href="src/css/patient2.css">

    <!-- TITLE -->
    <title> Hospitalisation</title>
</head>
<body>
    <!-- FORMULAIRE D'INSCRIPTION -->
    <div class="formulaire_inscription">
        <form class="inscription" method="post">
            <a href="patient2cree.php"><i class="fa-solid fa-arrow-left"></i></a> 
            <h1> Hospitalisation </h1>
            <div class="div_formulaire">
                <label for="pre_admission">Pré-admission*</label>
                <select id="pre_admission" name="pre_admission" class="form_input" required>
                    <option value="">Choix</option>
                    <option value="1">Ambulatoire chirurgie</option>
                    <option value="2">Hospitalisation (au moins une nuit)</option>
                </select>
            </div>

            <div class="div_formulaire">
                <label for="date">Date d'hospitalisation*</label>
                <input type="date" name="date" class="form_input" required>
            </div>

            <div class="div_formulaire">
                <label for="time">Heure de l'intervention*</label>
                <input type="time" name="time" class="form_input" required>
            </div>

            <div class="div_formulaire">
                <label for="chambre_particuliere">Chambre particulière*</label>
                <select id="chambre_particuliere" name="chambre_particuliere" class="form_input" required>
                    <option value="">Choix</option>
                    <option value="1">Non</option>
                    <option value="2">Oui</option>
                </select>
            </div>

            <label for="medecin">Médecin :</label>
            <?php
            
            echo "<select id='Id_User' name='Id_User' class='form_input' required>";
            echo "<option value=''>Choix</option>";
            foreach ($result_medecin as $option) {
                echo "<option value='" . $option["Id_User"] . "'>" . $option["Nom"] . " " . $option["Prenom"] . "</option>";
            };
            echo "</select>";
            ?>

            <br>
            <br>
            <input type="submit" name="valider" value="Suivant" class="form_button">
        </form>
    </div>
</body>
</html>
