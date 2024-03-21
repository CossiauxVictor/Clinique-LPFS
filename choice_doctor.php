<?php
    session_start();
    require_once('config.php');

    if (isset($_POST["valider"])) {
        echo"blabla, $_POST[nom]";
        $nom = $_POST["nom"];
        $_SESSION['nom']=$nom;


        // SQL query to retrieve user data
        $sql_medecin = "SELECT * FROM `medecin`;";
        $result_medecin = mysqli_query($mysqli, $sql_medecin);

        $medecindaje=false;

        while ($row_medecin = mysqli_fetch_array($result_medecin, MYSQLI_NUM)) {
            if ($row_medecin[1] == $nom) {
                $medecindaje = true;
                echo"gdyzfydfaud";
                break;
            }
        }
        if($medecindaje == true){
            header("Location: edit_doctor.php");
            exit;
        }else{
            echo "Erreur : " . $conn->error;
            exit;
        }
    }

    // Récupérer tous les médecins de la base de données
    $medecins = array();

    $sql = "SELECT id_medecin, nom FROM medecin";
    $result = $connexion->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $medecins[] = $row;
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
    <link rel="stylesheet" href="src/css/users.css">

    <!-- TITLE -->
    <title> Choix médecin</title>
</head>
<body>
    <div class="formulaire_inscription">
        <form method="post" class="inscription">
            <h1> Choisir un médecin </h1>
            <label for="nom">Sélectionnez un medecin*</label>
            <select id="nom" name="nom" class="form_input">
                <?php
                foreach ($medecins as $medecin) {
                    $medecinid = $medecin['id_medecin'];
                    $medecinnom = $medecin['nom'];
                    echo "<option value='$medecinnom'>$medecinnom</option>";
                }
                ?>
            </select>
            </br></br>
            <input type="submit" name="valider" value="Choisir" class="form_button">
    </div>
    </form>
</body>
</html>