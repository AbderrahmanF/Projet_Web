<?php

// Adresse du serveur SQL
$host = 'localhost';
// Nom d'utilisateur MySQL
$utilisateur = 'webProjet';
// Mot de passe MySQL
$mdp = 'root';
// Nom de la base de données
$base_de_donnees = 'projet_ava_bdd';

// Connexion à la base de données
$connexion = new mysqli($host, $utilisateur, $mdp, $base_de_donnees);

// Vérifier la connexion
if ($connexion->connect_error) {
    die("Échec de la connexion : " . $connexion->connect_error);
}

// Vérifier si les valeurs du formulaire existent
if (isset($_POST["User"]) && isset($_POST["Pass"])) {
    $username = $_POST["User"];
    $password = $_POST["Pass"];

    // Requête SQL pour récupérer le nom d'utilisateur et le mot de passe associé à l'utilisateur donné
    $sql = "SELECT username, mot_passe 
            FROM utilisateurs AS us
            INNER JOIN authentification AS au ON us.Id_mot_passe = au.Id_mot_passe 
            WHERE Username = ?";
    $stmt = $connexion->prepare($sql);

    if ($stmt) {
        // Lier les paramètres
        $stmt->bind_param("s", $username);

        // Exécuter la requête
        $stmt->execute();

        // Récupérer le résultat
        $resultat = $stmt->get_result();

        if ($resultat->num_rows == 1) {
            // Si l'utilisateur est trouvé dans la base de données
            $row = $resultat->fetch_assoc();
            $mdpBd = $row["mot_passe"];

            // Vérifier si le mot de passe saisi correspond au mot de passe dans la base de données
            if ($password == $mdpBd) {
                // Rediriger vers la page gestionnaire.html
                header("Location: ../html/gestionnaire.php");
                exit;
            } else {
                echo "Mot de passe incorrect.";
            }
        } else {
            echo "Utilisateur non trouvé.";
        }

        // Fermer la requête préparée
        $stmt->close();
    } else {
        echo "Erreur de préparation de la requête.";
    }
} else {
    echo "Les champs User et Pass doivent être définis.";
}

// Fermer la connexion
$connexion->close();
