<html lang="fr-FR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/root.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <script src="../js/app.js"></script>
</head>

<body>
    <?php
    // Adresse du serveur SQLfunction console_log($output, $with_script_tags = true)
    function console_log($output, $with_script_tags = true)
    {
        $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
            ');';
        if ($with_script_tags) {
            $js_code = '<script>' . $js_code . '</script>';
        }
        echo $js_code;
    }
    try {
        require ("connexion.inc.php");

        print_r($_GET);
        $nom = $_GET['nom'];
        $prenom = $_GET['prenom'];
        $telephone = $_GET['telephone'];
        $courriel = $_GET['courriel'];
        $cv = $_GET['cv'];
        $offres = json_decode($_GET['metier'], true);

        try {
            $pdo->beginTransaction();

            // Insérer le CV
            $sql = "INSERT INTO cv (pdf) VALUES (:cv)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':cv', $cv);
            $stmt->execute();
            $id_cv = $pdo->lastInsertId();

            // Insérez les informations du postulant dans la table `postulant`
            $sql = "INSERT INTO postulant (nom, prenom, telephone, email, id_cv) VALUES (:nom, :prenom, :telephone, :courriel, :id_cv)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':telephone', $telephone);
            $stmt->bindParam(':courriel', $courriel);
            $stmt->bindParam(':id_cv', $id_cv);

            $stmt->execute();

            // Récupérer l'ID du postulant inséré
            $id_postulant = $pdo->lastInsertId();

            // Insérer les offres auxquelles le postulant postule dans la table `postuler`
            foreach ($offres as $offre) {
                // $offre_data = json_decode($offre, true);
                print_r($offre);
                $nom_offre = $offre['offre'];
                $nom_secteur = $offre['secteur'];

                // Recherche de l'ID du secteur correspondant au nom donné
                $sql = "SELECT id_secteur FROM secteurs WHERE nom_secteur = :nom_secteur";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':nom_secteur', $nom_secteur);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if (!$row) {
                    throw new Exception("Secteur non trouvé pour le nom donné : $nom_secteur");
                }
                console_log($row);
                $id_secteur = $row['id_secteur'];

                // Recherche de l'ID de l'offre correspondant au nom donné et au secteur donné
                $sql = "SELECT id_offre FROM offres WHERE nom_poste = :nom_offre AND id_secteur = :id_secteur";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':nom_offre', $nom_offre);
                $stmt->bindParam(':id_secteur', $id_secteur);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if (!$row) {
                    throw new Exception("Offre non trouvée pour le nom donné : $nom_offre et le secteur donné : $nom_secteur");
                }
                $id_offre = $row['id_offre'];

                // Insérer l'entrée correspondante dans la table `postuler`
                $sql = "INSERT INTO postuler (id_postulant, id_offre) VALUES (:id_postulant, :id_offre)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(":id_postulant", $id_postulant);
                $stmt->bindParam(":id_offre", $id_offre);
                $stmt->execute();
            }

            // Validez la transaction
            $pdo->commit();
            header("Location: ../html/gestionnaire.php");
            //echo "Le postulant a été inséré avec succès.";
        } catch (Exception $e) {
            // En cas d'erreur, annuler la transaction
            $connexion->rollback();
            echo 'Erreur : ' . $e->getMessage();
        }

    } catch (PDOException $e) {
        die("Erreur: " . $e->getMessage());
    }
    ?>
</body>

</html>