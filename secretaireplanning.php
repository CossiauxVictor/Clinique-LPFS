<?php
    session_start();
    if($_SESSION['Autorisation']!="Yes"){
        header("Location: index.html");
        exit;
    }

    $dateDuJour = date("Y-m-d");
    
    require_once('config.php');

    //SELECT * FROM `user` INNER JOIN `pre_admission` ON `user`.`Id_User` = `pre_admission`.`Id_User` JOIN `patient` ON `patient`.`num_securite_social` = `pre_admission`.`num_securite_social` WHERE `Id_Role` = '3' AND `pre_admission`.`date_hospitalisation` > '2023-11-01' ORDER BY `pre_admission`.`date_hospitalisation` ASC, `pre_admission`.`heure_hospitalisation` ASC;
    $sql_medecin = "SELECT (`pre_admission`.`id_pre_admission`)AS'id_pre_admission', (`user`.`Nom`)AS'Nom_Med', (`user`.`Prenom`)AS'Prenom_Med', (`pre_admission`.`date_hospitalisation`)AS'date_hospitalisation', (`pre_admission`.`heure_hospitalisation`)AS'heure_hospitalisation', (`patient`.`num_securite_social`)AS'num_securite_social' FROM `user` INNER JOIN `pre_admission` ON `user`.`Id_User` = `pre_admission`.`Id_User` JOIN `patient` ON `patient`.`num_securite_social` = `pre_admission`.`num_securite_social` WHERE `Id_Role` = '3' AND (`pre_admission`.`date_hospitalisation`)> '$dateDuJour' ORDER BY (`pre_admission`.`date_hospitalisation`) ASC, (`pre_admission`.`heure_hospitalisation`) ASC, (`pre_admission`.`heure_hospitalisation`) ASC;";
    $result_medecin = mysqli_query($connexion, $sql_medecin);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="src/css/planing.css">
    <title> Planning - Rendez-vous </title>
</head>
<body>
<a href="secretairemenu.php"><i class="fa-solid fa-arrow-left"></i></a> 
    <h1> Planning des rendez-vous</h1>
    <br><br>
    <?php
        echo "<table border='1'>";
            echo "<thead>";
                echo "<tr>";
                    echo "<th>Médecin</th>";
                    echo "<th>Date / Heure</th>";
                    echo "<th>Numero de securité sociale du patient</th>";
                    echo "<th>Action</th>";
                echo "</tr>";
            echo "</thead>";
            foreach ($result_medecin as $row) {
                echo "<tr>";
                    echo "<form action='secretairemodif.php'>";
                        echo "<input type='hidden' id='id_pre_admission' name='id_pre_admission' value='{$row['id_pre_admission']}'>";
                        echo "<td>{$row['Nom_Med']} . {$row['Prenom_Med']}</td>";
                        echo "<td>{$row['date_hospitalisation']} / {$row['heure_hospitalisation']}</td>";
                        echo "<td>{$row['num_securite_social']}</td>";
                        echo "<td><input type='submit' id='boutton' name='boutton' value='  Modifier  '> <input type='submit' id='boutton' name='boutton' value='Supprimer'>";
                    echo"</form>";
                echo "</tr>";
            };
        echo "</table>";
    ?>
</body>
</html>