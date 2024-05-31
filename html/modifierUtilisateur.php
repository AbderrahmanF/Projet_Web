<!DOCTYPE html>
<html lang="fr-FR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/root.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <script src="../js/app.js"></script>
</head>

<body id="html-adder">

    <div id="modifier-window" style="display : none">
        <div class="blur" onclick="hideModifier()">
        </div>
        <div id="user-modifier">
            <form action="" class="form-adder">
                <h2 class="is-title no-top">Formulaire de modification</h2>
                <input id="nom-modif" class="is-input" type="text" placeholder="Nom" required>
                <input id="prenom-modif" class="is-input" type="text" placeholder="Prénom" required>
                <input id="telephone-modif" class="is-input" type="text" placeholder="Téléphone" required>
                <input id="courriel-modif" class="is-input" type="text" placeholder="Courriel" required>
                <div class="flex column gap-5 is-left cent">
                    <p class="is-label" for="#pdf-file">CV :</p>
                    <input id="pdf-file-modif" class="pointer" type="file" accept="application/pdf">
                </div>
                <div class="is-centered">
                    <select name="select-cat-modif" id="select-cat-modif" class="is-select"
                        onchange="selectPosteModif()">
                    </select>
                    <select name="select-poste-modif" id="select-poste-modif" class="is-select">

                        <option class="is-option Commercial" value="Vendeur">Vendeur</option>
                    </select>
                    <?php
                    try {
                        require ("../php/connexion.inc.php");

                        $select_query = "SELECT 
    (
        SELECT 
            CONCAT(
                '[',
                GROUP_CONCAT(
                    JSON_OBJECT(
                        'nom_secteur', secteurs.nom_secteur
                    )
                    SEPARATOR ','
                ),
                ']'
            ) AS secteurs
        FROM 
            secteurs
    ) AS secteurs,
    (
        SELECT 
            CONCAT(
                '[',
                GROUP_CONCAT(
                    JSON_OBJECT(
                        'nom_offre', offres.nom_poste,
                        'nom_secteur', secteurs.nom_secteur
                    )
                    SEPARATOR ','
                ),
                ']'
            ) AS offres
        FROM 
            offres
        INNER JOIN 
            secteurs ON offres.id_secteur = secteurs.id_secteur
    ) AS offres;";
                        $result = $pdo->query($select_query);
                        $result->setFetchMode(PDO::FETCH_ASSOC);
                        $rows = $result->fetchAll();
                        $secteurs = array();
                        $offres = array();
                        foreach ($rows as $row) {
                            // console_log($row["offres"]);
                            echo "<script>addCats('#select-cat-modif'," . $row["secteurs"] . ");
                            addOffres('#select-poste-modif'," . $row["offres"] . ")
                            </script>";
                        }
                    } catch (PDOException $e) {
                        die("Erreur: " . $e->getMessage());
                    }
                    ?>
                    <p class="submit-poste is-button pointer" onclick="addPosteModif()">Ajouter</p>
                </div>
                <div id="choix-poste-modif">
                </div>
                <input type="text" required name="verif-poste-modif" id="verif-poste-modif">
                <p onclick="tryPosteModif()" class="is-button cent">Enregistrer</p>
            </form>
        </div>
    </div>
</body>

</html>