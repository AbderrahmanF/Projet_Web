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

        // Récupération de la liste des IDs des postulants à supprimer depuis la requête POST
        $ids = json_decode($_GET['ids'], true);

        try {
            $pdo->beginTransaction();

            foreach ($ids as $id_postulant) {
                // Supprimer les entrées dans la table postuler
                $sql = "DELETE FROM postuler WHERE id_postulant = :id_postulant";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id_postulant', $id_postulant);
                $stmt->execute();

                // Récupérer l'ID du CV associé au postulant
                $sql = "SELECT id_cv FROM postulant WHERE id_postulant = :id_postulant";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id_postulant', $id_postulant);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($row) {
                    $id_cv = $row['id_cv'];

                    // Supprimer le CV
                    $sql = "DELETE FROM cv WHERE id_cv = :id_cv";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':id_cv', $id_cv);
                    $stmt->execute();
                }

                // Supprimer le postulant
                $sql = "DELETE FROM postulant WHERE id_postulant = :id_postulant";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id_postulant', $id_postulant);
                $stmt->execute();
            }

            // Validez la transaction
            $pdo->commit();
            echo "Les postulants ont été supprimés avec succès.";
            header("Location: ../html/gestionnaire.php");
        } catch (Exception $e) {
            // En cas d'erreur, annuler la transaction
            $pdo->rollback();
            echo 'Erreur : ' . $e->getMessage();
        }

    } catch (PDOException $e) {
        die("Erreur: " . $e->getMessage());
    }
    ?>
</body>

</html>