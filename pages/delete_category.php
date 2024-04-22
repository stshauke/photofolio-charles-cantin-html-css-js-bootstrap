<?php
// Vérifier si le nom de la catégorie à supprimer a été envoyé
if (isset($_POST['category'])) {
    // Chemin vers le répertoire des catégories
    $categoryDirectory = '../assets/img/gallery/categories/';

    // Récupérer le nom de la catégorie à supprimer depuis la requête POST
    $categoryToDelete = $_POST['category'];

    // Chemin complet de la catégorie à supprimer
    $categoryPath = $categoryDirectory . $categoryToDelete;

    // Initialiser une variable pour stocker le résultat de la suppression
    $success = false;

    // Vérifier si le répertoire de la catégorie existe avant de le supprimer
    if (is_dir($categoryPath)) {
        // Supprimer le répertoire de la catégorie et son contenu récursivement
        if (rrmdir($categoryPath)) {
            $success = true;
        }
    }

    // Envoyer une réponse JSON indiquant le résultat de la suppression
    if ($success) {
        echo json_encode(['success' => true, 'message' => 'Catégorie supprimée avec succès.', 'category' => $categoryToDelete]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erreur lors de la suppression de la catégorie.', 'category' => null]);
    }

} else {
    // Envoyer une réponse JSON si le nom de la catégorie n'a pas été fourni
    echo json_encode(['success' => false, 'message' => 'Aucune catégorie spécifiée pour la suppression.', 'category' => null]);
}

// Fonction récursive pour supprimer un répertoire et son contenu
function rrmdir($dir) {
    foreach(glob($dir . '/*') as $file) {
        if(is_dir($file)) rrmdir($file); else unlink($file);
    }
    return rmdir($dir);
}
