<?php
$directory = '../assets/img/gallery/categories/';

// Vérifier si le dossier existe et est accessible en lecture
if (is_dir($directory) && is_readable($directory)) {
    // Lire le contenu du dossier
    $files = scandir($directory);

    // Filtrer les fichiers pour n'inclure que les dossiers
    $categories = array_filter($files, function($file) use ($directory) {
        return is_dir($directory . $file) && $file != '.' && $file != '..';
    });

    // Ajouter la catégorie par défaut "Tous"
    array_unshift($categories, 'Tous');

    // Renvoyer les catégories au format JSON
    echo json_encode(['success' => true, 'categories' => array_values($categories)]);
} else {
    // Erreur si le dossier n'existe pas ou n'est pas accessible en lecture
    echo json_encode(['success' => false]);
}
