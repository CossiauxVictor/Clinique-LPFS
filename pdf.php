<?php
require('src/fpdf/fpdf.php');

// Connexion à la base de données
require_once('config.php');
session_start();

$num_secu = $_SESSION['num_secu'];

    // Requête SQL pour récupérer toutes les informations concernant le patient, le médecin, le rendez-vous etc...
    $sql = "SELECT * FROM patient 
            INNER JOIN pre_admission ON patient.num_securite_social = pre_admission.num_securite_social 
            INNER JOIN user ON pre_admission.Id_User = user.Id_User 
            INNER JOIN service ON user.Id_Service = service.Id_Service
            WHERE patient.num_securite_social = $num_secu
            AND pre_admission.date_hospitalisation >= CURDATE()";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Créer un objet FPDF
        $pdf = new FPDF();
        $pdf->AddPage();

        $pdf->SetFont('Arial', 'U', 16); // U pour souligner
        $pdf->Cell(0, 10, 'PDF de vos prochains rendez-vous', 0, 1, 'C');

        $pdf->Ln(8); // Ajoute un saut de ligne 

        while ($row = $result->fetch_assoc()) {
            
            // Ajouter les informations au PDF
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(0, 10, "Nom du patient : " . $row['nom_naissance'], 0, 1);
            $pdf->Cell(0, 10, "Prenom du patient : " . $row['prenom'], 0, 1);
            $pdf->Cell(0, 10, "Numero de securite sociale du patient : " . $row['num_securite_social'], 0, 1);
            $pdf->Cell(0, 10, "Mail du medecin : " . $row['Mail'], 0, 1);
            $pdf->Cell(0, 10, "Service du medecin : " . $row['Nom'], 0, 1);
            $pdf->Cell(0, 10, "Votre rendez-vous : " . $row['date_hospitalisation'] . ' a ' . $row['heure_hospitalisation'], 0, 1);

            $pdf->Ln(8);
        }

        // Générer le nom du fichier PDF
        $filename = "PDF Rendez-vous du " . date('d-m-Y') . ".pdf";

        // Envoyer le PDF au navigateur pour téléchargement
        $pdf->Output($filename, 'D');
    } else {
        echo "Aucun résultat trouvé dans la base de données.";
    }
    $conn->close();
?>