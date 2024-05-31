<?php
$username = "root"; // Utilisateur de la BD
$password = ""; // Mot de passe
$db_name = "projet_ava_bdd"; // Nom de la BD
try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=$db_name",
        $username,
        $password
    );
    // définir le mode d'erreur PDO sur Exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Arrêter l'exécution du script et afficher un message d'erreur.
    die('Could not connect: ' . $e->getMessage());
}
?>