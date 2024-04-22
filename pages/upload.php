<?php
// Chemin vers le dossier de destination des images
$uploadDirectory = '../assets/img/gallery/categories/';

// Vérifier si le dossier de destination existe et est accessible en écriture
if (!is_dir($uploadDirectory) || !is_writable($uploadDirectory)) {
    echo json_encode(['success' => false, 'message' => 'Le dossier de destination des images n\'est pas accessible en écriture.']);
    exit();
}

// Vérifier si des données ont été envoyées
if (!isset($_FILES['image']) || !isset($_POST['selectedCategory'])) {
    echo json_encode(['success' => false, 'message' => 'Aucune image ou catégorie spécifiée.']);
    exit();
}

// Récupérer la catégorie spécifiée
$category = $_POST['selectedCategory'];

// Récupérer le nom du fichier
$fileName = $_FILES['image']['name'];

// Chemin complet du dossier de destination pour la catégorie spécifiée
$categoryDirectory = $uploadDirectory . $category . '/';

// Créer le dossier de catégorie s'il n'existe pas encore
if (!is_dir($categoryDirectory)) {
    mkdir($categoryDirectory, 0755, true); // Créer le dossier avec les permissions 0755
}

// Chemin complet du fichier image téléchargé dans la catégorie spécifiée
$filePath = $categoryDirectory . $fileName;

// Déplacer le fichier téléchargé vers le dossier de destination avec un nom unique
if (!move_uploaded_file($_FILES['image']['tmp_name'], $filePath)) {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'enregistrement de l\'image.']);
    exit();
}

// Si tout s'est bien passé, renvoyer une réponse de succès
echo json_encode(['success' => true, 'message' => 'Image enregistrée avec succès dans la catégorie ' . $category . '.']);
