<?php


require_once('config.php');

session_start();



// Obtenez la date actuelle
$dateActuelle = date("Y-m-d");

// Obtenez la date il y a 90 jours à partir de la date actuelle
$dateIlYa90Jours = date("Y-m-d", strtotime("-90 days"));

// Obtenez la valeur stockée dans $_SESSION['Date_Mdp']
$dateSession = $_SESSION['Date_Mdp'];

if ($dateSession == NULL){
    $Date=false;
} else {
    // Vérifiez si la date dans $_SESSION['Date_Mdp'] est plus petite que la date actuelle de 90 jours
    if (strtotime($dateSession) < strtotime($dateIlYa90Jours)) {
        $Date=false;
    } else {
        $Date=true;
    }
}



if($_SESSION['Test_Premier_Co']==1 && $Date==true){
    if($_SESSION['Role']=='2'){
        $_SESSION['Autorisation']="Yes";
        header("Location: choice.php");
        exit;
    }elseif($_SESSION['Role']=='3'){
        $_SESSION['Autorisation']="Yes";
        header("Location: medecin.php");
        exit;
    }else{
        $_SESSION['Autorisation']="Yes";
        header("Location: secretairemenu.php");
        exit;
    }    
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si les champs New_Mdp et Verif_Mdp sont définis et non vides
    if (isset($_POST['New_Mdp']) && isset($_POST['Verif_Mdp']) && !empty($_POST['New_Mdp']) && !empty($_POST['Verif_Mdp'])) {
        $New_Mdp = $_POST['New_Mdp'];
        $Verif_Mdp = $_POST['Verif_Mdp'];

        // Vérifier si les mots de passe correspondent
        if ($New_Mdp === $Verif_Mdp ) {
            if($_SESSION['MDP'] != $New_Mdp){
                // Vérifier la complexité du mot de passe
                if (preg_match('/[!@#$%^&*(),.?":{}|<>]/', $New_Mdp) &&
                preg_match('/[A-Z]/', $New_Mdp) &&
                preg_match('/[a-z]/', $New_Mdp) &&
                preg_match('/[0-9]/', $New_Mdp)) {

                $hachage = hash('sha256', $New_Mdp);
                // Inclure le fichier de configuration
                require_once('config.php');


                // Utiliser des requêtes préparées pour éviter les injections SQL
                $sql = "UPDATE `user` SET `Password`=?, `Premier_Co`='1', `Date_Mdp`=? WHERE `Id_User`=?";
                $stmt = $conn->prepare($sql);

                if ($stmt) {
                    // Liage des paramètres avec les types correspondants
                    $stmt->bind_param("ssi", $hachage, $dateActuelle, $_SESSION['Id_User']);

                    // Exécuter la requête préparée
                    if ($stmt->execute()) {
                        // Rediriger vers patient2.php
                        if($_SESSION['Role']=='2'){
                            $_SESSION['Autorisation']="Yes";
                            header("Location: choice.php");
                            exit;
                        }elseif($_SESSION['Role']='3'){
                            $_SESSION['Autorisation']="Yes";
                            header("Location: medecin.php");
                            exit;
                        }else{
                            $_SESSION['Autorisation']=="Yes";
                            header("Location: secretairemenu.php");
                            exit;
                        }
                    } else {
                        echo "Une erreur s'est produite lors de la mise à jour du mot de passe.";
                    }

                    // Fermer la requête préparée
                    $stmt->close();
                } else {
                    echo "Une erreur s'est produite lors de la préparation de la requête.";
                }

                } else {
                echo "Le mot de passe doit contenir au moins une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.";
                }
            }else{
                echo "Le nouveau mots de passe ne peut pas etre les même que l'ancien";
            }
        } else {
            echo "Les mots de passe ne correspondent pas.";
        }
    } else {
        echo "Tous les champs doivent être remplis.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <!-- META -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- LINKS -->
    <link rel="stylesheet" href="src/css/password.css">
    <title> Mot de passe </title>
</head>
<body>
    <!-- FORMULAIRE D'INSCRIPTION -->
    <div class="formulaire_inscription">
        <form class="inscription" method="post">
            <h1> Changer votre mot de passe </h1>
            
            <div class="div_formulaire">
                <label for="new">Nouveau mot de passe</label>
                <input type="password" name="New_Mdp" class="form_input" required>
            </div>

            <div class="div_formulaire">
                <label for="verif">Vérification du mot de pass</label>
                <input type="password" name="Verif_Mdp" class="form_input" required>
            </div>

            <br>

            <input type="submit" name="valider" value=" Terminer" class="form_button">
        </form>
    </div>
</body>
</html>