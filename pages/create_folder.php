<?php
// Vérifier si le nom du dossier à créer a été envoyé en POST
if (isset($_POST['folderName'])) {
    // Chemin vers le répertoire où créer La ctégorie
    $directory = '../assets/img/gallery/categories/';

    // Récupérer le nom du dossier à créer depuis la requête POST
    $folderName = $_POST['folderName'];

    // Vérifier si La ctégorie existe déjà
    if (!file_exists($directory . $folderName)) {
        // Créer La ctégorie
        if (mkdir($directory . $folderName)) {
            echo 'La ctégorie "' . $folderName . '" a été créé avec succès.';
        } else {
            echo 'Erreur : Impossible de créer la ctégorie.';
        }
    } else {
        echo 'Erreur : La ctégorie "' . $folderName . '" existe déjà.';
    }
} else {
    echo 'Erreur : Aucun nom de catégorie spécifié.';
}

