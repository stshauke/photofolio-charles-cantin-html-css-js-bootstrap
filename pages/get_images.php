<?php

$directory = '../assets/img/gallery/categories/';

// Vérifier si le dossier existe et est accessible en lecture
if (is_dir($directory) && is_readable($directory)) {
    // Récupérer la catégorie sélectionnée
    $category = isset($_GET['category']) ? $_GET['category'] : '';

    // Initialiser un tableau pour stocker les images
    $images = [];
    // Si la catégorie est "Tous", récupérer toutes les images de toutes les catégories
    if ($category === 'Tous'|| $category === 'tous') {
       
        // Lire le contenu de chaque dossier de catégorie
        $categories = array_diff(scandir($directory), array('..', '.')); // Exclure les dossiers "." et ".."
        foreach ($categories as $cat) {
            $catDirectory = $directory . $cat . '/';

            if (is_dir($catDirectory) && is_readable($catDirectory)) {
                $catImages = array_diff(scandir($catDirectory), array('..', '.')); // Exclure les fichiers "." et ".."
                foreach ($catImages as $img) {
                    $images[] = $catDirectory . $img;
                }
            }
        }
    } else {
        // Lire le contenu du dossier de la catégorie sélectionnée
        $categoryDirectory = $directory . $category . '/';
        if (is_dir($categoryDirectory) && is_readable($categoryDirectory)) {
            $images = array_diff(scandir($categoryDirectory), array('..', '.')); // Exclure les fichiers "." et ".."
            $images = array_map(function ($img) use ($categoryDirectory) {
                return $categoryDirectory . $img;
            }, $images);
        }
    }
    
    // Renvoyer les images au format JSON
    echo json_encode(['success' => true, 'images' => array_values($images)]);
   
} else {
    // Erreur si le dossier n'existe pas ou n'est pas accessible en lecture
    echo json_encode(['success' => false]);
}

