<?php
    // Database connection
    require_once('config.php');

    // Vérification de la connexion
    if (!$connexion) {
        die("La connexion à la base de données a échoué : " . mysqli_connect_error());
    }

    // Traitement des données soumises par le formulaire de modification
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_user = $_POST["id_user"];
    
    // Supprimer l'utilisateur de la base de données
    $deletesql = "DELETE FROM user WHERE Id_User=?";
    $deletestmt = $connexion->prepare($deletesql);

    if ($deletestmt) {
        $deletestmt->bind_param("i", $id_user);
        if ($deletestmt->execute()) {
            header("Location: application_panel.php");
        } else {
            header("Location: delete_user.php");
        }
        $deletestmt->close();
    } else {
        echo "Erreur de préparation de la requête de mise à jour : " . $connexion->error;
    }
    }

    // Récupérer tous les utilisateurs de la base de données
    $users = array();

    $sql = "SELECT * FROM user";
    $result = $connexion->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
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
    <link rel="stylesheet" href="src/css/users.css">

    <!-- TITLE -->
    <title> Supression utilisateur </title>
</head>
<body>
    <div class="formulaire_inscription">
        <form method="post" class="inscription">
        <a href="application_panel.php" ><i class="fa-solid fa-arrow-left"></i></a>
            <h1> Supprimer un utilisateur </h1>
            <label for="id_user">Sélectionnez un utilisateur*</label>
            <select id="id_user" name="id_user" class="form_input">
                <?php
                foreach ($users as $user) {
                    $userid = $user['Id_User'];
                    $usermail = $user['Mail'];
                    if ($user['Id_Role'] != '3') {
                        echo "<option value='$userid'>$usermail</option>";
                    }
                }
                ?>
            </select>
   
            </br></br>
                <input type="submit" value="Supprimer" id_user="ajoute" class="form_button">
        </form>
</body>
</html>