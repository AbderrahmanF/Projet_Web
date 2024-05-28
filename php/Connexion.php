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
        $sql = "SELECT username, mot_passe 
                FROM utilisateurs AS us
                INNER JOIN authentification AS au ON us.Id_mot_passe = au.Id_mot_passe 
                WHERE Username = :username";
        $stmt = $connexion->prepare($sql);

        if ($stmt) {
            // Lier les paramètres
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);

            // Exécuter la requête
            $stmt->execute();

            // Récupérer le résultat
            if ($stmt->rowCount() == 1) {
                // Si l'utilisateur est trouvé dans la base de données
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $mdpBd = $row["mot_passe"];

                // Vérifier si le mot de passe saisi correspond au mot de passe dans la base de données
                if ($password == $mdpBd) {
                    // Rediriger vers la page gestionnaire.php
                    header("Location: ../html/gestionnaire.php");
                    exit;
                } else {
                    echo "Mot de passe incorrect.";
                }
            } else {
                echo "Utilisateur non trouvé.";
            }
        } else {
            echo "Erreur de préparation de la requête.";
        }
    } else {
        echo "Les champs User et Pass doivent être définis.";
    }
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}
