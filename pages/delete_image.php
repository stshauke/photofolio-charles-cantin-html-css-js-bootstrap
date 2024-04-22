<?php
// Vérifier si le nom de l'image à supprimer a été envoyé
if (isset($_POST['image'])) {
    // Chemin vers le dossier des images
    $imageDirectory = '../assets/img/gallery/categories/';

    // Récupérer le nom de l'image à supprimer depuis la requête POST
    $imageToDelete = $_POST['image'];

   // Récupérer la catégorie de l'image à partir de son chemin
   $category = $_POST['category'];

    // Initialiser une variable pour stocker le résultat de la suppression
    $success = false;

    // Vérifier si la catégorie sélectionnée est "Tous"
    if ($category === 'Tous' || $category === 'tous') {
        // Lister tous les dossiers de catégorie
        $categories = array_diff(scandir($imageDirectory), array('..', '.'));
        foreach ($categories as $cat) {
            $catDirectory = $imageDirectory . $cat . '/';
            // Vérifier si le fichier existe dans chaque catégorie
            $imagePath = $catDirectory . $imageToDelete;
            if (file_exists($imagePath)) {
                // Supprimer l'image
                if (unlink($imagePath)) {
                    $success = true;
                    // Sortir de la boucle une fois que l'image a été trouvée et supprimée
                    break;
                }
            }
        }
    } else {
        // Chemin complet de l'image à supprimer
        $imagePath = $imageDirectory .$category."/". $imageToDelete;

        // Vérifier si le fichier existe avant de le supprimer
        if (file_exists($imagePath)) {
            // Supprimer le fichier de l'image
            if (unlink($imagePath)) {
                $success = true;
            }
        }
    }

    // Envoyer une réponse JSON indiquant le résultat de la suppression
    if ($success) {
        echo json_encode(['success' => true, 'message' => 'Image supprimée avec succès.', 'category' => $category, 'imagePath' => $imagePath]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erreur lors de la suppression de l\'image.', 'category' => null, 'imagePath' => null]);
    }

} else {
    // Envoyer une réponse JSON si le nom de l'image n'a pas été fourni
    echo json_encode(['success' => false, 'message' => 'Aucune image spécifiée pour la suppression.', 'category' => null]);
}

