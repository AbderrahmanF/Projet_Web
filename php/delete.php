<?php
// Configuration de la base de données

// Recevoir les données JSON
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['profiles']) && is_array($data['profiles'])) {
    $profiles = $data['profiles'];

    // Préparer une requête SQL pour chaque profil
    $stmt = $pdo->prepare("DELETE FROM votre_table WHERE nom = ?");

    foreach ($profiles as $profile) {
        $stmt->bind_param("s", $profile);
        if ($stmt->execute()) {
            echo "Le profil '$profile' a été supprimé avec succès.\n";
        } else {
            echo "Erreur lors de la suppression du profil '$profile' : " . $stmt->error . "\n";
        }
    }

    $stmt->close();
} else {
    echo "Aucun profil sélectionné.";
}

// Fermer la connexion
$conn->close();