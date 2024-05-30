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
    $upload_dir = '../CV/uploads/'; // Assurez-vous que ce chemin est correct

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
        // Vérifier si le postulant existe déjà
        $check_query = "SELECT Id_Postulant, Id_Cv FROM postulant WHERE Nom = ? AND Telephone = ?";
        $stmt_check = $connexion->prepare($check_query);
        if ($stmt_check === false) {
            throw new Exception('Erreur de préparation (Check) : ' . $connexion->error);
        }
        $stmt_check->bind_param("ss", $nom, $telephone);
        $stmt_check->execute();
        $result = $stmt_check->get_result();
        $postulant_exists = $result->num_rows > 0;

        if ($postulant_exists) {
            // Postulant existe déjà, effectuer une mise à jour
            $row = $result->fetch_assoc();
            $id_postulant = $row['Id_Postulant'];
            $id_cv = $row['Id_Cv'];

            // Mettre à jour le CV existant
            $update_cv_query = "UPDATE cv SET PDF = ? WHERE ID_CV = ?";
            $stmt_update_cv = $connexion->prepare($update_cv_query);
            if ($stmt_update_cv === false) {
                throw new Exception('Erreur de préparation (Update CV) : ' . $connexion->error);
            }
            $stmt_update_cv->bind_param("si", $pdf_path, $id_cv);
            if (!$stmt_update_cv->execute()) {
                throw new Exception('Erreur lors de la mise à jour du CV : ' . $stmt_update_cv->error);
            }

            // Mettre à jour les informations du postulant
            $update_postulant_query = "UPDATE postulant SET Prenom = ?, Email = ? WHERE Id_Postulant = ?";
            $stmt_update_postulant = $connexion->prepare($update_postulant_query);
            if ($stmt_update_postulant === false) {
                throw new Exception('Erreur de préparation (Update Postulant) : ' . $connexion->error);
            }
            $stmt_update_postulant->bind_param("ssi", $prenom, $courriel, $id_postulant);
            if (!$stmt_update_postulant->execute()) {
                throw new Exception('Erreur lors de la mise à jour du postulant : ' . $stmt_update_postulant->error);
            }

            echo "Enregistrement mis à jour avec succès";
        } else {
            // Postulant n'existe pas, effectuer une insertion

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

            echo "Nouvel enregistrement créé avec succès";
        }

        // Valider la transaction
        $connexion->commit();
    } catch (Exception $e) {
        // En cas d'erreur, annuler la transaction
        $connexion->rollback();
        echo 'Erreur : ' . $e->getMessage();
    }

    // Fermer les statements et la connexion
    if (isset($stmt_check)) $stmt_check->close();
    if (isset($stmt_update_cv)) $stmt_update_cv->close();
    if (isset($stmt_update_postulant)) $stmt_update_postulant->close();
    if (isset($stmt_cv)) $stmt_cv->close();
    if (isset($stmt_postulant)) $stmt_postulant->close();
    $connexion->close();
}
?>
