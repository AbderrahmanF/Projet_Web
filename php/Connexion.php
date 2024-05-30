<?php
// Adresse du serveur SQL
$host = 'localhost';
// Nom d'utilisateur MySQL
$utilisateur = 'webProjet';
// Mot de passe MySQL
$mdp = 'root';
// Nom de la base de données
$base_de_donnees = 'projet_ava_bdd';

try {
    // Connexion à la base de données en utilisant PDO
    $dsn = "mysql:host=$host;dbname=$base_de_donnees;charset=utf8";
    $connexion = new PDO($dsn, $utilisateur, $mdp);
    // Définir le mode d'erreur de PDO sur Exception
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérifier si les valeurs du formulaire existent
    if (isset($_POST["User"]) && isset($_POST["Pass"])) {
        $username = $_POST["User"];
        $password = $_POST["Pass"];

// Requête SQL pour récupérer le nom d'utilisateur et le mot de passe associé à l'utilisateur donné
$sql = "SELECT Username, Mdp 
        FROM utilisateurs AS us
        INNER JOIN authentification AS au ON us.Id_MDP = au.Id_Mdp 
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
        $mdpBd = $row["Mdp"];

        // Vérifier si le mot de passe saisi correspond au mot de passe dans la base de données
        if ($password == $mdpBd) {
            // Rediriger vers la page gestionnaire.html
            header("Location: ../html/gestionnaire.html");
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

// Fermer la connexion
$connexion->close();
