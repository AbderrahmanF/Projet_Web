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
    function console_log($output, $with_script_tags = true)
    {
        $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . ');';
        if ($with_script_tags) {
            $js_code = '<script>' . $js_code . '</script>';
        }
        echo $js_code;
    }

    try {
        require ("connexion.inc.php");
        $id_postulant = $_GET['id'];
        $nom = $_GET['nom'];
        $prenom = $_GET['prenom'];
        $telephone = $_GET['telephone'];
        $courriel = $_GET['courriel'];
        $cv = isset($_GET['cv']) ? $_GET['cv'] : null; // CV est facultatif
        $offres = json_decode($_GET['metier'], true);

        // Rechercher l'utilisateur existant par son ID
        $sql = "SELECT id_postulant, id_cv FROM postulant WHERE id_postulant = :id_postulant";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_postulant', $id_postulant);
        $stmt->execute();
        $postulant = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($postulant) {
            $id_cv = $postulant['id_cv'];

            try {
                $pdo->beginTransaction();

                // Mettre à jour le CV si fourni
                if ($cv) {
                    $sql = "UPDATE cv SET pdf = :cv WHERE id_cv = :id_cv";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':cv', $cv);
                    $stmt->bindParam(':id_cv', $id_cv);
                    $stmt->execute();
                }

                // Mettre à jour les informations personnelles
                $sql = "UPDATE postulant SET nom = :nom, prenom = :prenom, telephone = :telephone, email = :courriel WHERE id_postulant = :id_postulant";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':nom', $nom);
                $stmt->bindParam(':prenom', $prenom);
                $stmt->bindParam(':telephone', $telephone);
                $stmt->bindParam(':courriel', $courriel);
                $stmt->bindParam(':id_postulant', $id_postulant);
                $stmt->execute();

                // Supprimer les offres existantes du postulant
                $sql = "DELETE FROM postuler WHERE id_postulant = :id_postulant";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id_postulant', $id_postulant);
                $stmt->execute();

                // Insérer les nouvelles offres
                foreach ($offres as $offre) {
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

                // Valider la transaction
                $pdo->commit();
                echo "Le postulant a été mis à jour avec succès.";
                header("Location: ../html/gestionnaire.php");
            } catch (Exception $e) {
                // En cas d'erreur, annuler la transaction
                $pdo->rollback();
                echo 'Erreur : ' . $e->getMessage();
            }
        } else {
            echo "Postulant non trouvé.";
        }

    } catch (PDOException $e) {
        die("Erreur: " . $e->getMessage());
    }
    ?>
</body>

</html>