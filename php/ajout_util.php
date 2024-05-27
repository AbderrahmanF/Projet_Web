<?php
// Adresse du serveur SQL
$host = 'localhost';
// Nom d'utilisateur MySQL
$utilisateur = 'webProjet';
// Mot de passe MySQL
$mdp = 'root';
// Nom de la base de données
$base_de_donnees = 'gestioncv'; 

// Connexion à la base de données
$connexion = new mysqli($host, $utilisateur, $mdp, $base_de_donnees);

// Vérifie la connexion
if ($connexion->connect_error) {
    die("Échec de la connexion : " . $connexion->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit']) && $_POST['submit'] == 'ajouter') {
    // Récupère les données du formulaire
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $telephone = $_POST['telephone'] ?? '';
    $courriel = $_POST['courriel'] ?? '';

    // Vérifier si un fichier PDF a été téléchargé
    if (!isset($_FILES['pdf_file']) || $_FILES['pdf_file']['error'] != UPLOAD_ERR_OK) {
        die('Erreur lors du téléchargement du fichier PDF.');
    }

    // Gestion du fichier PDF
    $pdf_file = $_FILES['pdf_file'];
    $upload_dir = 'uploads/';

    // Vérifier et créer le répertoire d'upload s'il n'existe pas
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    // Nom du fichier PDF sur le serveur
    $pdf_path = $upload_dir . basename($pdf_file['name']);

    // Déplacer le fichier téléchargé vers le répertoire d'upload
    if (!move_uploaded_file($pdf_file['tmp_name'], $pdf_path)) {
        die('Erreur lors du déplacement du fichier PDF.');
    }

    // Début de la transaction
    $connexion->begin_transaction();

    try {
        // Insertion du CV dans la table `cv`
        $cv_query = "INSERT INTO cv (PDF) VALUES (?)";
        $stmt_cv = $connexion->prepare($cv_query);
        if ($stmt_cv === false) {
            throw new Exception('Erreur de préparation (CV) : ' . $connexion->error);
        }
        $stmt_cv->bind_param("s", $pdf_path);
        if (!$stmt_cv->execute()) {
            throw new Exception('Erreur lors de l\'insertion du CV : ' . $stmt_cv->error);
        }
        $id_cv = $stmt_cv->insert_id;

        // Insertion du postulant dans la table `postulant`
        $postulant_query = "INSERT INTO postulant (Nom, Prenom, Telephone, Email, Id_Cv) VALUES (?, ?, ?, ?, ?)";
        $stmt_postulant = $connexion->prepare($postulant_query);
        if ($stmt_postulant === false) {
            throw new Exception('Erreur de préparation (Postulant) : ' . $connexion->error);
        }
        $stmt_postulant->bind_param("ssssi", $nom, $prenom, $telephone, $courriel, $id_cv);
        if (!$stmt_postulant->execute()) {
            throw new Exception('Erreur lors de l\'insertion du postulant : ' . $stmt_postulant->error);
        }

        // Valider la transaction
        $connexion->commit();
        echo "Nouvel enregistrement créé avec succès";
    } catch (Exception $e) {
        // En cas d'erreur, annuler la transaction
        $connexion->rollback();
        echo 'Erreur : ' . $e->getMessage();
    }

    // Fermer les statements et la connexion
    $stmt_cv->close();
    $stmt_postulant->close();
    $connexion->close();
}
?>
