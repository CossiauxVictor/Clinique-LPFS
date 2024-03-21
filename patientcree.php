<?php
    session_start();
if($_SESSION['Autorisation']!="Yes"){
    header("Location: index.html");
    exit;
}

    $num_secu = $_SESSION['num_secu'];

    require_once('config.php');


    $sql_patient = "SELECT * FROM `patient`;";
    $result_patient = mysqli_query($mysqli, $sql_patient);

    

    while ($row_patient = mysqli_fetch_array($result_patient, MYSQLI_NUM)) {
        if ($row_patient[0] == $num_secu) {
            $nom_naissance = $row_patient[1];
            if($row_patient[2] == NULL){
                $nom_epouse = NULL ;
            }else{
                $nom_epouse = $row_patient[2];
            }
            $prenom = $row_patient[3];
            $civilite = $row_patient[4];
            $date_naissance = $row_patient[5];
            $adresse = $row_patient[6];
            $cp = $row_patient[7];
            $ville = $row_patient[8];
            if($row_patient[9] == NULL){
                $mail = NULL ;
            }else{
                $mail = $row_patient[9];
            }
            if($row_patient[10] == NULL){
                $telephone = NULL ;
            }else{
                $telephone = $row_patient[10];
            }
        }
    }

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
                $sql = "UPDATE `patient` SET `nom_naissance`='$nom_naissance',`nom_epouse`='$nom_epouse',`prenom`='$prenom',`civilite`='$civilite',`date_naissance`='$date_naissance',`adresse`='$adresse',`cp`='$cp',`ville`='$ville',`email`='$mail',`telephone`='$telephone' WHERE num_securite_social=$num_secu";

                // Exécuter la requête
                if ($conn->query($sql) === TRUE) {
                    // Rediriger vers patient2.php
                    header("Location: patient2cree.php");
                    exit(); 
                } else {
                    echo "Erreur lors de l'enregistrement : " . $conn->error;
                }
            }
        }
    }




      
    // Vérifier si le formulaire a été soumis
    if (isset($_POST["valider"])) {
        // Récupérer les données du formulaire
           
        
        

        // Vérifier que le numéro de sécurité sociale commence par "1" pour Homme ou "2" pour Femme
        if ((substr($num_secu, 0, 1) == "1" && $civilite != "homme") ||
        (substr($num_secu, 0, 1) == "2" && $civilite != "femme")) {
            echo "Le numéro de sécurité sociale ne correspond pas à la civilité choisie.";
        } else {
//----------------------------------------------------------------------------------------------------------------
            // Préparer la requête SQL d'insertion
            $sql = "UPDATE `patient` SET `nom_naissance`='[value-2]',`nom_epouse`='[value-3]',`prenom`='[value-4]',`civilite`='[value-5]',`date_naissance`='[value-6]',`adresse`='[value-7]',`cp`='[value-8]',`ville`='[value-9]',`email`='[value-10]',`telephone`='[value-11]' WHERE num_securite_social=";

            // Exécuter la requête
            if ($conn->query($sql) === TRUE) {
                // Rediriger vers patient2.php
                header("Location: patient2cree.php");
                exit(); 
            } else {
                echo "Erreur lors de l'enregistrement : " . $conn->error;
            }
//------------------------------------------------------------------------------------------------------------------
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
    <link rel="stylesheet" href="src/css/patient.css">


    <!-- TITLE -->
    <title> Formulaire patient </title>

</head>
<body>
    <!-- FORMULAIRE D'INSCRIPTION -->
    <div class="formulaire_inscription">
        <form class="inscription" method="post" action="patientcree.php">
            <a href="num_secu.php"><i class="fa-solid fa-arrow-left"></i></a> 
            <h1> Formulaire patients </h1>
            <div class="div_formulaire">
                <label for="assure"> Numéro de sécurité socials*</label>
                <?php echo"<input type='text' id='numero_secu' name='numero_secu' class='form_input' value='$num_secu' maxlength='13' required readonly>";?>
            </div>
            <div class="div_formulaire">
                <label for="assure"> Nom naissance*</label>
                <?php echo"<input type='text' id='nom_naissance' name='nom_naissance' class='form_input' value='$nom_naissance' maxlength='13' required>";?>
            </div>
            <div class="div_formulaire">
                <label for="assure"> Nom epouse</label>
                <?php 
                if($nom_epouse==NULL){
                    echo"<input type='text' name='nom_epouse' class='form_input' placeholder='Nom epouse'>";
                }else{
                    echo"<input type='text' id='nom_epouse' name='nom_epouse' class='form_input' value='$nom_epouse' maxlength='13' required>";
                }
                ?>
            </div>
            <div class="div_formulaire">
                <label for="assure"> Prénom*</label>
                <?php echo"<input type='text' id='prenom' name='prenom' class='form_input' value='$prenom' maxlength='13' required>";?>
            </div>

            <div class="div_formulaire">
                <label for="assure"> Civilite*</label>
                <?php
                    if($civilite=='homme'){
                        ?>
                            <select name="civilite" id="civilite" class="form_input" required>
                                <option value="homme" selected>Homme</option>
                                <option value="femme">Femme</option>
                            </select>
                        <?php
                    }else{
                        ?>
                            <select name="civilite" id="civilite" class="form_input" required>
                                <option value="homme">Homme</option>
                                <option value="femme" selected>Femme</option>
                            </select>
                        <?php
                    }
                ?>
            </div>

            <div class="div_formulaire">
                <label for="assure"> Date naissance*</label>
                <?php echo"<input type='date' id='date_naissance' name='date_naissance' class='form_input' value='$date_naissance' maxlength='13' required>";?>
            </div>

            <div class="div_formulaire">
                <label for="assure"> Adresse*</label>
                <?php echo"<input type='text' id='adresse' name='adresse' class='form_input' value='$adresse' maxlength='13' required>";?>
            </div>

            <div class="div_formulaire">
                <label for="assure"> Code postal*</label>
                <?php echo"<input type='text' id='cp' name='cp' class='form_input' value='$cp' maxlength='13' required>";?>
            </div>

            <div class="div_formulaire">
                <label for="assure"> Ville*</label>
                <?php echo"<input type='text' id='ville' name='ville' class='form_input' value='$ville' maxlength='13' required>";?>
            </div>

            <div class="div_formulaire">
                <label for="assure"> Mail*</label>
                <?php echo"<input type='text' id='mail' name='mail' class='form_input' value='$mail' maxlength='13' required>";?>
            </div>

            <div class="div_formulaire">
                <label for="assure"> Téléphone*</label>
                <?php echo"<input type='text' id='telephone' name='telephone' class='form_input' value='$telephone' maxlength='13' required>";?>
            </div>
                           
            <input type="submit" name="valider" value="Suivant" class="form_button" required>
        </form>
    </div>
</body>
</html>