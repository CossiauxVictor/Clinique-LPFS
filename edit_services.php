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
    $id_service = $_POST["id_service"];
    $newNom = $_POST["nom"];
    
    // Requête SQL pour la mise à jour
    $updateSql = "UPDATE service SET Nom=? WHERE Id_Service=?";
    $updateStmt = $connexion->prepare($updateSql);

    if ($updateStmt) {
        $updateStmt->bind_param("si", $newNom, $id_service);
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
$produits = array();

$sql = "SELECT Id_Service, Nom FROM service";
$result = $connexion->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $services[] = $row;
    }
}

// Fermeture de la connexion à la base de données
$connexion->close();
?>

<div class="formulaire_inscription">
    <form method="post" class="inscription">
    <a href="application_pannel.php" ><i class="fa-solid fa-arrow-left"></i></a> 
    <h1> Modifier un service </h1>
        <div class="div_formulaire">
        <label for="id_service">Sélectionnez un service*</label>
        <select id="id_service" name="id_service" class="form_input">
            <?php
            foreach ($services as $service) {
                $serviceid = $service['Id_Service'];
                $servicenom = $service['Nom'];
                echo "<option value='$serviceid'>$servicenom</option>";
            }
            ?>
        </select>
        <br><br>

        <div class="div_formulaire">
            <label for="nom">Nom du service* </label>
            <input type="text" id="nom" name="nom" class="form_input" required><br><br>
        </div>

        <div class="content_user">
            <input type="submit" value="Modifier" id_user="ajoute" class="form_button">
            <div class="icons">
                <a href="services.php"><i class="fa-solid fa-plus" title="Créer un service"></i></a>
                <a href="delete_services.php"><i class="fa-solid fa-trash-can"  title="Supprimer un service"></i></a>
            </div>
    </form>
</div>
</body>
</html>