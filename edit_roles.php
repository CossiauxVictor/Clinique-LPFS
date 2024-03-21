<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- META -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- LINKS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="src/css/users.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https : //fonts.googleapis.com/css2?family= Montserrat :wght@100 & display=swap" rel="stylesheet">

    <!-- TITLE -->
    <title> Modification Service </title>
</head>
<body>

<?php
//La fonction require_once ou include_once permet d'avoir accés à la page de connexion à la BDD
require_once('config.php');

// Traitement des données soumises par le formulaire de modification
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_role = $_POST["id_role"];
    $newNom = $_POST["nom"];
    
    // Requête SQL pour la mise à jour
    $updateSql = "UPDATE role SET Nom=? WHERE Id_Role=?";
    $updateStmt = $connexion->prepare($updateSql);

    if ($updateStmt) {
        $updateStmt->bind_param("si", $newNom, $id_role);
        if ($updateStmt->execute()) {
            header("Location: application_panel.php");
        } else {
            echo "Erreur lors de la mise à jour du produit : " . $updateStmt->error;
        }
        $updateStmt->close();
    } else {
        echo "Erreur de préparation de la requête de mise à jour : " . $connexion->error;
    }
}

// Récupérer tous les produits de la base de données
$roles = array();

$sql = "SELECT Id_Role, Nom FROM role";
$result = $connexion->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $roles[] = $row;
    }
}

// Fermeture de la connexion à la base de données
$connexion->close();
?>

<div class="formulaire_inscription">
    <form method="post" class="inscription">
    <a href="application_panel.php" ><i class="fa-solid fa-arrow-left"></i></a> 
    <h1> Modifier un rôle</h1>
        <div class="div_formulaire">
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
        <br><br>

        <div class="div_formulaire">
            <label for="nom">Nom du rôle* </label>
            <input type="text" id="nom" name="nom" class="form_input" required><br><br>
        </div>

        <div class="content_user">
            <input type="submit" value="Modifier" id_user="ajoute" class="form_button">
            <div class="icons">
                <a href="role.php"><i class="fa-solid fa-plus" title="Créer un role"></i></a>
                <a href="delete_roles.php"><i class="fa-solid fa-trash-can"  title="Supprimer un role"></i></a>
            </div>
    </form>
</div>
</body>
</html>