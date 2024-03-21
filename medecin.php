<?php
    // Connexion à la base de données (à personnaliser selon votre configuration)
    require_once("config.php");

    // Récupération de la liste des médecins (à personnaliser selon votre structure de base de données)
    $requete_medecins = "SELECT Id_User, Nom, Prenom FROM user WHERE Id_role = 3";
    $resultat_medecins = $connexion->query($requete_medecins);

    // Vérification de la requête
    if (!$resultat_medecins) {
        die("Erreur lors de l'exécution de la requête : " . $connexion->error);
    }

    // Affichage de la liste des médecins dans un formulaire
    echo "<div class='formulaire_inscription'>";
    echo "<form method='post' class='inscription'>";
    echo "<a href='connexion.php' ><i class='fa-solid fa-arrow-left'></i></a>";
    echo"<h1> Choix du médecin </h1>";
    echo "<label for='medecin'>Choisissez un médecin*</label>";
    echo "<select name='medecin' id='medecin'  class='form_input'>";
    while ($row_medecin = $resultat_medecins->fetch_assoc()) {
        echo "<option value='" . $row_medecin['Id_User'] ."'>" . $row_medecin['Nom'] ." ".  $row_medecin['Prenom'] . "</option>";
    }
    echo "</select>";
    echo "</br>";
    echo "</br>";
    echo "<input type='submit' value='Afficher les rendez-vous' class='form_button'>";
    echo"</br>";
    echo"</br>";
    echo "</form>";

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération de l'ID du médecin sélectionné
    $id_medecin_selectionne = $_POST['medecin'];

    // Suppression des rendez-vous passés
    $date_actuelle = date("Y-m-d");
    $requete_suppression = "DELETE FROM pre_admission WHERE Id_User = $id_medecin_selectionne AND date_hospitalisation < '$date_actuelle'";
    $resultat_suppression = $connexion->query($requete_suppression);

    if (!$resultat_suppression) {
        die("Erreur lors de la suppression des rendez-vous passés : " . $connexion->error);
    }

    // Fonction de tri pour les rendez-vous par date et heure
    function trierRendezVous($a, $b) {
    // Compare les dates d'abord
    $dateComparison = strcmp($a['date_hospitalisation'], $b['date_hospitalisation']);

    // Si les dates sont égales, compare les heures
    if ($dateComparison == 0) {
        return strcmp($a['heure_hospitalisation'], $b['heure_hospitalisation']);
    }

    return $dateComparison;
    }

    // Récupération des rendez-vous pour le prochain mois
    $date_fin_mois = date("Y-m-d", strtotime("+1 month"));
    $requete_rendez_vous = "SELECT * FROM pre_admission INNER JOIN patient ON pre_admission.num_securite_social = patient.num_securite_social WHERE Id_User = $id_medecin_selectionne AND date_hospitalisation <= '$date_fin_mois'";
    $resultat_rendez_vous = $connexion->query($requete_rendez_vous);

    if (!$resultat_rendez_vous) {
        die("Erreur lors de l'exécution de la requête : " . $connexion->error);
    }

    // Stocker les rendez-vous dans un tableau pour le tri
    $rendezVousArray = array();
    while ($row_rendez_vous = $resultat_rendez_vous->fetch_assoc()) {
        $rendezVousArray[] = $row_rendez_vous;
    }

    // Tri du tableau des rendez-vous en utilisant la fonction de tri personnalisée
    usort($rendezVousArray, 'trierRendezVous');

    echo "<ul>";
    // Affichage des rendez-vous triés
    foreach ($rendezVousArray as $rendezVous) {
        echo "<li>" . "Le " . $rendezVous['date_hospitalisation'] . " à " . $rendezVous['heure_hospitalisation'] ." pour " .$rendezVous['nom_naissance']." ".$rendezVous['prenom'] ." à contacter au  " .$rendezVous['telephone']."</li>";
    }
    echo "</ul>";
}

// Fermeture de la connexion à la base de données
$connexion->close();
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
    <link rel="stylesheet" href="src/css/medecin.css">

    <!-- TITLE -->
    <title> Rendez-vous patients </title>
</head>
<body>
</body>
</html>