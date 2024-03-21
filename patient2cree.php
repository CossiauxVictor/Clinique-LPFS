<?php
        session_start();
if($_SESSION['Autorisation']!="Yes"){
    header("Location: index.html");
    exit;
}
        $num_secu=$_SESSION['num_secu'];
        require_once('config.php');
        $_SESSION['patientdaje']=true;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Récupération des données du formulaire
        $numero_secu = $_POST['numero_secu'];
        $assure = ($_POST['assure'] == 'Oui') ? 1 : 0; // Conversion en booléen
        $ald = ($_POST['ald'] == 'Oui') ? 1 : 0; // Conversion en booléen    
        $nom_assurance = $_POST['nom_assurance'];
        $adherent = $_POST['adherent'];

        
    

        // Préparation de la requête SQL
        $requete = "UPDATE `couverture_sociale` SET `patient_assure`='$assure',`patient_ald`='$ald',`nom_assurance`='$nom_assurance',`num_adherent`='$adherent' WHERE `num_securite_social`='$numero_secu'";
    
        // Exécution de la requête
        if ($connexion->query($requete) === TRUE) {
            header('Location: hospitalisation.php');
            exit;
        } else {
            echo "Erreur lors de l'enregistrement : " . $connexion->error;
        }
    
        // Fermeture de la connexion à la base de données
        $connexion->close();
    }





    $sql_couverture_sociale = 'SELECT * FROM `couverture_sociale`;';
    $result_couverture_sociale = mysqli_query($mysqli, $sql_couverture_sociale);

    while ($row_couverture_sociale = mysqli_fetch_array($result_couverture_sociale, MYSQLI_NUM)) {
        if ($row_couverture_sociale[5] == $num_secu) {
            $patient_assure = $row_couverture_sociale[1];
            $patient_ald = $row_couverture_sociale[2];
            $nom_assurance = $row_couverture_sociale[3];
            $num_adherent = $row_couverture_sociale[4];
        }
    }
?>

<!DOCTYPE html>
<html lang='fr'>
<head>
    <!-- META -->
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>

    <!-- LINKS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel='stylesheet' href='src/css/patient2.css'>


    <!-- TITLE -->
    <title> Formulaire patient 2 </title>

</head>
<body>
    <!-- FORMULAIRE D'INSCRIPTION -->
    <div class='formulaire_inscription'>
        <form class='inscription' method='post'>
            <a href="patientcree.php"><i class="fa-solid fa-arrow-left"></i></a> 
            <h1> Formulaire patients </h1>
            <div class='div_formulaire'>
                <label for='assure'> Numéro de sécurité social*</label>
                <?php echo"<input type='text' id='numero_secu' name='numero_secu' class='form_input' value='$num_secu' maxlength='13' required readonly>";?>
            </div>

            <div class='div_formulaire'>
                <label for='assure'> Le patient est-il assuré ?*</label>
                <?php
                if($patient_assure==0){
                    ?>
                        <select name='assure' id='assure' class='form_input' required>
                            <option selected> Non</option>
                            <option> Oui</option>
                        </select> 
                    <?php
                }else{
                    ?>
                        <select name='assure' id='assure' class='form_input' required>
                            <option selected> Oui</option>
                            <option> Non</option>
                        </select> 
                    <?php
                }
                ?>    
            </div>

            <div class='div_formulaire'>
            <label for='assure'> Le patient est-il en ALD ?*</label>
            <?php
                if($patient_ald=='0'){
                    ?>
                        <select name='assure' id='assure' class='form_input' required>
                            <option selected> Non</option>
                            <option> Oui</option>
                        </select> 
                    <?php
                }else{
                    ?>
                        <select name='assure' id='assure' class='form_input' required>
                            <option selected> Oui</option>
                            <option> Non</option>
                        </select> 
                    <?php
                }
                ?>    
            </div>
            <div class='div_formulaire'>
                <label for='assure'> Nom de l'assurance ou de la mutuelle* </label>
                <?php echo"<input type='text' name='nom_assurance' class='form_input' value='$nom_assurance' required>";?>
            </div>

            <div class='div_formulaire'>
                <label for='assure'> Numéro d'adhérent*</label>
                <?php echo"<input type='text' name='adherent' class='form_input' value='$num_adherent' required>";?>
            </div>
                           
            <input type='submit' name='valider' value='Suivant' class='form_button' >
        </form>
    </div>
</body>
</html>