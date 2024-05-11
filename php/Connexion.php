<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
// adresse serveur SQL
$host = 'localhost';
// Nom d'utilisateur MySQL
$utilisateur = 'webProjet';
// Mot de passe MySQL
$mdp = 'root';
// Nom de la base de données
$base_de_donnees = 'gestioncv'; 

// Connexion à la base de données
$connexion = new mysqli($host, $utilisateur, $mdp, $base_de_donnees);

// Vérifier la connexion
if ($connexion->connect_error) {
    die("Échec de la connexion : " . $connexion->connect_error);
} else {
    echo "Connexion réussie !";
}

// Récupère les valeurs du formulaire
$username = $_POST["User"];
$password = $_POST["Pass"];

// Requête SQL pour récupérer le mot de passe associé à l'utilisateur donné
$sql = "SELECT Username, Mdp 
        FROM utilisateurs AS us
        INNER JOIN authentification AS au ON us.Id_MDP = au.Id_Mdp";

$resultat = $connexion->query($sql);

if ($resultat->num_rows > 0) {
    // Si l'utilisateur est trouvé dans la base de données
    $row = $resultat->fetch_assoc();
    $mdpBd = $row["Mdp"];
    
    // Vérifier si le mot de passe saisi correspond au mot de passe dans la base de données
    if ($password == $mdpBd) {
        // Rediriger vers la page gestionnaire.html
        header("Location: gestionnaire.html");
        exit; // Assurez-vous de terminer le script ici pour éviter toute exécution supplémentaire
    } else {
        echo "Mot de passe incorrect.";
    }
} else {
    echo "Utilisateur non trouvé.";
}

// Fermer la connexion
$connexion->close();

?>
