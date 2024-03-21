<?php
// Database connection
require_once('config.php');

// Vérification de la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

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

// Vérification si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des valeurs du formulaire
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $email = $_POST["email"];
    $mot_de_passe = $_POST["mot_de_passe"];
    $role = $_POST["role"];
    $service = $_POST["service"];

    // Préparer la requête SQL d'insertion
    $sql = "INSERT INTO user (Nom, Prenom, Mail, Password, Id_Service, Id_Role)
    VALUES ('$nom', '$prenom', '$email', '$mot_de_passe', '$service', '$role')";

    // Exécuter la requête
    if ($conn->query($sql) === TRUE) {

    // Rediriger vers connexion.php
    header("Location: application_panel.php");
    exit(); 
    } else {
    echo "Erreur lors de l'enregistrement : " . $conn->error;
    }
}

// Fermeture de la connexion à la base de données
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <!-- META -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- LINKS -->
    <link rel="stylesheet" href="src/css/users.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- TITLE -->
    <title> Création médecin </title>
</head>
<body>

<div class="formulaire_inscription">
    <form class="inscription" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <a href="application_panel.php" ><i class="fa-solid fa-arrow-left"></i></a> 
        <h1> Créer un médecin</h1>
        <div class="div_formulaire">
            <label for="nom"> Nom*</label>
            <input type="text" name="nom" class="form_input" required>
        </div>
        <div class="div_formulaire">
            <label for="nom"> Prénom*</label>
            <input type="text" name="prenom" class="form_input" required>
        </div>
        <div class="div_formulaire">
            <label for="email"> Mail*</label>
            <input type="email" name="email" class="form_input" required>
        </div>
        <div class="div_formulaire">
            <label for="password"> Mot de passe*</label>
            <input type="password" name="mot_de_passe" class="form_input">
        </div>

        <!-- Champs de sélection pour le rôle -->
        <label for="role">Rôle*</label>
        <select name="role" class="form_input" >
            <?php foreach ($roles as $id => $role) { ?>
                <?php if ($role == 'medecin') { ?>
                 <option value="<?php echo $id; ?>"><?php echo $role; ?></option>
                <?php } ?>
            <?php } ?>
        </select>
        <br><br>

        <!-- Champs de sélection pour le service -->
        <label for="service">Services*</label>
        <select name="service" class="form_input">
            <?php foreach ($service as $id => $service) { ?>
                <?php if ($service == 'neurologie') { ?>
                <option value="<?php echo $id; ?>"><?php echo $service; ?></option>
                <?php } ?>
                <?php if ($service == 'radiologie') { ?>
                <option value="<?php echo $id; ?>"><?php echo $service; ?></option>
                <?php } ?>
                <?php if ($service == 'chirurgie') { ?>
                <option value="<?php echo $id; ?>"><?php echo $service; ?></option>
                <?php } ?>
                <?php if ($service == 'test3') { ?>
                <option value="<?php echo $id; ?>"><?php echo $service; ?></option>
                <?php } ?>
            <?php } ?>
        </select>
        <br><br>

        <div class="content_user">
            <input type="submit" value="Créer" class="form_button">
            <div class="icons">
                <a href="edit_doctor.php"><i class="fa-solid fa-pen" title="Modifier un médecin"></i></a>
                <a href="delete_doctor.php"><i class="fa-solid fa-trash-can"  title="Supprimer un médecin"></i></a>
            </div>
        </div>
    </form>
</div>

</body>
</html>