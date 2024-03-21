<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- META -->
    <meta charset="UTF-8">
    <meta name="viewport" content="wid_userth=device-wid_userth, initial-scale=1.0">

    <!-- LINKS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="src/css/users.css">
    <link href="https : //fonts.googleapis.com/css2?family= Montserrat :wght@100 & display=swap" rel="stylesheet">

    <!-- TITLE -->
    <title> Modification Utilisateur </title>

<body>
<?php
//La fonction require_once ou include_once permet d'avoir accés à la page de connexion à la BDD
require_once('config.php');

// Récupération des rôles depuis la table 'role'
$sql = "SELECT * FROM role";
$result = $conn->query($sql);

$roles = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $roles[$row['Id_Role']] = $row['Nom'];
    }
}

// Récupération des services depuis la table 'service'
$sql = "SELECT * FROM service";
$result = $conn->query($sql);

$service = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $service[$row['Id_Service']] = $row['Nom'];
    }
}

// Traitement des données soumises par le formulaire de modification
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_user = $_POST["id_user"];
    $newNom = $_POST["nom"];
    $newPrenom = $_POST["prenom"];
    $newMail = $_POST["mail"];
    $newRole = $_POST["role"];
    $newService = $_POST["service"];
    
    // Requête SQL pour la mise à jour
    $updateSql = "UPDATE user SET Nom=?, Prenom=?, Mail=?, Id_Role=?, Id_Service=? WHERE Id_User=?";
    $updateStmt = $connexion->prepare($updateSql);

    if ($updateStmt) {
        $updateStmt->bind_param("sssssi", $newNom, $newPrenom, $newMail, $newRole, $newService, $id_user);
        if ($updateStmt->execute()) {
            header("Location: application_panel.php");
            exit(); 
        } else {
            echo "Erreur lors de l'enregistrement : " . $conn->error;
            }
        $updateStmt->close();
    } else {
        echo "Erreur de préparation de la requête de mise à jour : " . $connexion->error;
    }
}

// Récupérer tous les users de la base de données
$users = array();

$sql = "SELECT * FROM user";
$result = $connexion->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

// Fermeture de la connexion à la base de données
$connexion->close();
?>

<div class="formulaire_inscription">
    <form method="post" class="inscription">
        <a href="application_panel.php" ><i class="fa-solid fa-arrow-left"></i></a> 
        <h1>Modifier un médecin</h1>
        <label for="id_user">Sélectionnez un médecin*</label>
        <select id="id_user" name="id_user" class="form_input">
            <?php
            foreach ($users as $user) {
                $userid = $user['Id_User'];
                $usermail = $user['Mail'];
                if ($user['Id_Role'] == 3) {
                    echo "<option value='$userid'>$usermail</option>";
                }
            }
            ?>
        </select>
        <br><br>

        <label for="nom">Nom*</label>
        <input type="text" id="nom" name="nom" class="form_input" required><br><br>

        <label for="prenom">Prenom*</label>
        <input type="text" id="prenom" name="prenom" class="form_input" required><br><br>

        <label for="mail">Mail*</label>
        <input type="text" id="mail" name="mail" class="form_input" required><br><br>

        <!-- Champs de sélection pour le rôle -->
        <label for="role">Rôle*</label>
            <select name="role" class="form_input" class="form_input">
                <?php foreach ($roles as $id_user => $role) { ?>
                    <?php if ($role == 'medecin') { ?>
                        <option value="<?php echo $id_user; ?>"><?php echo $role; ?></option>
                    <?php } ?>
                <?php } ?>
            </select>
            <br><br>

        <!-- Champs de sélection pour le service -->
        <label for="service">Services*</label>
        <select name="service" class="form_input">
            <?php foreach ($service as $id_user => $service) { ?>
                <?php if ($service == 'neurologie') { ?>
                <option value="<?php echo $id_user; ?>"><?php echo $service; ?></option>
                <?php } ?>
                <?php if ($service == 'radiologie') { ?>
                <option value="<?php echo $id_user; ?>"><?php echo $service; ?></option>
                <?php } ?>
                <?php if ($service == 'chirurgie') { ?>
                <option value="<?php echo $id_user; ?>"><?php echo $service; ?></option>
                <?php } ?>
            <?php } ?>
        </select>
        <br><br>

        <div class="content_user">
            <input type="submit" value="Modifier" id_user="ajoute" class="form_button">
            <div class="icons">
                <a href="doctor.php"><i class="fa-solid fa-plus" title="Créer un médecin"></i></a>
                <a href="delete_doctor.php"><i class="fa-solid fa-trash-can"  title="Supprimer un médecin"></i></a>
            </div>
</div>
</form>
</body>