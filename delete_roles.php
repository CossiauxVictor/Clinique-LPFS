<?php
    // Database connection
    require_once('config.php');

    // Vérification de la connexion
    if (!$connexion) {
        die("La connexion à la base de données a échoué : " . mysqli_connect_error());
    }

    // Traitement des données soumises par le formulaire de modification
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_role = $_POST["id_role"];
    
    // Supprimer le role de la base de données
    $deletesql = "DELETE FROM role WHERE Id_Role=?";
    $deletestmt = $connexion->prepare($deletesql);

    if ($deletestmt) {
        $deletestmt->bind_param("i", $id_role);
        if ($deletestmt->execute()) {
            header("Location: application_panel.php");
        } else {
            header("Location: delete_roles.php");
        }
        $deletestmt->close();
    } else {
        echo "Erreur de préparation de la requête de mise à jour : " . $connexion->error;
    }
    }

    // Récupérer tous les rôles de la base de données
    $roles = array();

    $sql = "SELECT Id_Role, Nom FROM role";
    $result = $connexion->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $roles[] = $row;
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
    <title> Supression rôle </title>
</head>
<body>
    <div class="formulaire_inscription">
        <form method="post" class="inscription">
            <a href="application_panel.php" ><i class="fa-solid fa-arrow-left"></i></a> 
            <h1> Supprimer un rôle </h1>
            <label for="id_role">Sélectionnez un rôle*</label>
            <select id="id_role" name="id_role" class="form_input">
                <?php
                foreach ($roles as $role) {
                    $roleid = $role['Id_Role'];
                    $rolenom = $role['Nom'];
                    echo "<option value='$roleid'>$rolenom</option>";
                }
                ?>
            </select>
            </br></br>
            <input type="submit" value="Supprimer" class="form_button">
    </div>
    </form>
</body>
</html>