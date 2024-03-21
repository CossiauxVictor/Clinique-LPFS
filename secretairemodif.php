<?php
session_start();
if($_SESSION['Autorisation']!="Yes"){
    header("Location: index.html");
    exit;
}
require_once('config.php');
$id_pre_admission=$_GET['id_pre_admission'];
if($_GET['boutton'] == 'Supprimer'){

    
    $sql = "DELETE FROM `pre_admission` WHERE `id_pre_admission`=$id_pre_admission;";
    // Exécuter la requête
    if ($conn->query($sql) === TRUE) {
        header("Location: secretaireplanning.php");
    } else {
        echo "Erreur lors de l'enregistrement : " . $conn->error;
    }
}

$sql_medecin = "SELECT * FROM `user` where Id_Role='3';";
$result_medecin = mysqli_query($connexion, $sql_medecin);

$sql_info_hospitalisation="SELECT * FROM pre_admission WHERE id_pre_admission=$id_pre_admission";
$result_info_hospitalisation = mysqli_query($connexion, $sql_info_hospitalisation);
$pre_admission = mysqli_fetch_assoc($result_info_hospitalisation);



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if($_POST['valider']=='retour'){
        header("Location: secretaireplanning.php");
    }else{
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
            $requete = "UPDATE `pre_admission` SET `pre_admission`='$pre_admission',`date_hospitalisation`='$date',`heure_hospitalisation`='$time',`chambre_particuliere`='$chambre_particuliere',`Id_User`='$Id_User' WHERE `id_pre_admission`='$id_pre_admission';";
    
            // Utilisez une déclaration préparée pour exécuter la requête
            $stmt = $connexion->prepare($requete);
    
            if ($stmt->execute()) {
                echo "Enregistrement réussi !";
            } else {
                echo "Erreur lors de l'enregistrement : " . $stmt->error;
            }
    
            header("Location: secretaireplanning.php");
        }else{
            Echo"Erreur dans la date et heure !";
        }
    }
}






?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- META -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Modification - Pre-admission</title>

    <!-- LINKS -->
    <link rel="stylesheet" href="src/css/patient.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<div class="formulaire_inscription">
        <form class="inscription" method="post">
        <a href="secretaireplanning.php"><i class="fa-solid fa-arrow-left"></i></a> 
            <h1> Modification </h1>
            <div class="div_formulaire">
                <label for="pre_admission">Pré-admission pour :</label>
                    <?php
                    echo"<div class='div_formulaire'>";
                        if($pre_admission['pre_admission']=='Ambulatoire chirurgie'){
                            ?>
                            <select id="pre_admission" name="pre_admission" class="form_input" required>
                                <option value="1" selected>Ambulatoire chirurgie</option>
                                <option value="2">Hospitalisation (au moins une nuit)</option>
                            </select>
                            <?php
                        }else{
                            ?>
                            <select id="pre_admission" name="pre_admission" class="form_input" required>
                                <option value="1">Ambulatoire chirurgie</option>
                                <option value="2" selected>Hospitalisation (au moins une nuit)</option>
                            </select>
                            <?php
                        }
                    echo"</div>";
                    ?>
            </div>

            <div class="div_formulaire">
                <label for="date">Date d'hospitalisation</label>
                    <?php
                        echo"<input type='date' name='date' class='form_input' value='$pre_admission[date_hospitalisation]' required>";
                    ?>
            </div>

            <div class="div_formulaire">
                <label for="time">Heure de l'intervention</label>
                    <?php
                        echo"<input type='time' name='time' class='form_input' value='$pre_admission[heure_hospitalisation]' required>";
                    ?>
            </div>

            <div class="div_formulaire">
                <label for="chambre_particuliere">Chambre particulière :</label>
                    <?php
                        if($pre_admission['chambre_particuliere']=='Oui'){
                            ?>
                                <select id="chambre_particuliere" name="chambre_particuliere" class="form_input" required>
                                    <option value="1">Non</option>
                                    <option value="2" selected>Oui</option>
                                </select>
                            <?php
                        }else{
                            ?>
                                <select id="chambre_particuliere" name="chambre_particuliere" class="form_input" required>
                                    <option value="1" selected>Non</option>
                                    <option value="2">Oui</option>
                                </select>
                            <?php
                        }
                    ?>
            </div>

            <label for="medecin">Médecin :</label>
            <?php
            
            echo "<select id='Id_User' name='Id_User' class='form_input' required>";
            foreach ($result_medecin as $option) {
                if($pre_admission['Id_User']==$option['Id_User']){
                    echo "<option value='" . $option["Id_User"] . "' selected>" . $option["Nom"] . " " . $option["Prenom"] . "</option>";
                }else{
                    echo "<option value='" . $option["Id_User"] . "'>" . $option["Nom"] . " " . $option["Prenom"] . "</option>";
                }
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