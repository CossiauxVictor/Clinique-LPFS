<?php
   // Connexion à la base de données
    require_once('config.php');

    // Vérification de la connexion
    if (!$connexion) {
        die("La connexion à la base de données a échoué : " . mysqli_connect_error());
    }

    // Fonction pour vérifier si un service à des médecins
    function hasAppointments($connexion, $id_service) {
        $sql = "SELECT COUNT(*) AS count FROM user WHERE Id_Service = ?";
        $stmt = $connexion->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("i", $id_service);
            $stmt->execute();
            $result = $stmt->get_result();
        
            if ($result) {
                $row = $result->fetch_assoc();
                return $row['count'] > 0;
            }
        }
        return false;
    }

    // Traitement des données soumises par le formulaire de suppression
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_service = $_POST["id_service"];

        // Vérifier si le médecin a des rendez-vous
        if (hasAppointments($connexion, $id_service)) {
            echo "Le service à des médecins et ne peux être supprimé.";
        } else {
            // Supprimer le service de la base de données
            $deletesql = "DELETE FROM service WHERE Id_Service=?";
            $deletestmt = $connexion->prepare($deletesql);

            if ($deletestmt) {
                $deletestmt->bind_param("i", $id_service);
                if ($deletestmt->execute()) {
                    header("Location: application_panel.php");
                } else {
                    header("Location: delete_services.php");
                }
                $deletestmt->close();
            } else {
                echo "Erreur de préparation de la requête de suppression : " . $connexion->error;
            }
        }
    }   

    // Récupérer tous les services de la base de données
    $services = array();

    $sql = "SELECT Id_Service, Nom FROM service";
    $result = $connexion->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $services[] = $row;
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
    <title> Supression service </title>
</head>
<body>
    <div class="formulaire_inscription">
        <form method="post" class="inscription">
            <a href="application_panel.php" ><i class="fa-solid fa-arrow-left"></i></a> 
            <h1> Supprimer un service </h1>
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
            </br></br>
            <input type="submit" value="Supprimer" class="form_button">
    </div>
    </form>
</body>
</html>