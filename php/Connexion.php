<?php
// Adresse du serveur SQL
$host = 'localhost';
// Nom d'utilisateur MySQL
$utilisateur = 'root';
// Mot de passe MySQL
$mdp = '';
// Nom de la base de données
$base_de_donnees = 'projet_ava_bdd';
print_r($_POST);
try {
    // Connexion à la base de données en utilisant PDO
    require ("./connexion.inc.php");
    // Vérifier si les valeurs du formulaire existent
    if (isset($_POST["User"]) && isset($_POST["Pass"])) {
        $username = $_POST["User"];
        $password = $_POST["Pass"];

        // Requête SQL pour récupérer le nom d'utilisateur et le mot de passe associé à l'utilisateur donné
        $select_query = "SELECT utilisateurs.username, authentification.mot_passe 
            FROM utilisateurs 
            INNER JOIN authentification 
            ON utilisateurs.id_mot_passe = authentification.id_mot_passe 
            WHERE utilisateurs.username = :username";
        $result = $pdo->prepare($select_query);
        $result->bindParam(':username', $username, PDO::PARAM_STR);
        $result->execute();
        // $result = $pdo->query($select_query);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        if ($result->rowCount() > 0) {
            $rows = $result->fetchAll();
            $mdpBd = $rows[0]["mot_passe"];
            if ($password == $mdpBd) {
                header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
                header("Cache-Control: post-check=0, pre-check=0", false);
                header("Pragma: no-cache");
                session_start();
                $_SESSION['post_data'] = $_POST;
                // Rediriger vers la page gestionnaire.php
                header("Location: ../html/gestionnaire.php");
                exit;
            } else {
                echo "Mot de passe incorrect.";
                header("Location: ../html/login.html");

            }
        } else {
            header("Location: ../html/login.html");
            echo "Utilisateur non trouvé.";
        }
        // $stmt = $pdo->prepare($sql);

        // if ($stmt) {
        //     // Lier les paramètres
        //     $stmt->bind_param("s", $username);

        //     // Exécuter la requête
        //     $stmt->execute();

        //     // Récupérer le résultat
        //     $resultat = $stmt->get_result();

        //     if ($resultat->num_rows == 1) {
        //         // Si l'utilisateur est trouvé dans la base de données
        //         $row = $resultat->fetch_assoc();
        //         $mdpBd = $row["Mdp"];

        //         // Vérifier si le mot de passe saisi correspond au mot de passe dans la base de données
        //     if ($password == $mdpBd) {
        //         // Rediriger vers la page gestionnaire.php
        //         header("Location: ../html/gestionnaire.php");
        //         exit;
        //     } else {
        //         echo "Mot de passe incorrect.";
        //     }
        // } else {
        //     echo "Utilisateur non trouvé.";
        // }

        // // Fermer la requête préparée
        // $stmt->close();
    } else {
        echo "Erreur de préparation de la requête.";
    }
    // } else {
    //     echo "Veuillez remplir tous les champs.";
    // }

    // Fermer la connexion
} catch (PDOException $e) {
    die("Erreur: " . $e->getMessage());
}