<?php
session_start();
if($_SESSION['Autorisation']!="Yes"){
    header("Location: index.html");
    exit;
}

if(isset($_GET['file'])) {
    $file = $_GET['file'];
    $filepath = 'uploads/' . $file;

    // Assurez-vous que le fichier existe
    if(file_exists($filepath)) {
        // Configuration des en-têtes HTTP pour le téléchargement du fichier
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $file . '"');
        
        // Envoyez les données du fichier
        readfile($filepath);
        exit;
    } else {
        echo "Le fichier n'existe pas.";
    }
} else {
    echo "Paramètre de fichier manquant.";
}
?>
