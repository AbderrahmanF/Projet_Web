<html lang="fr-FR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/root.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <script src="../js/app.js"></script>
</head>

<body id="html-adder">

    <div id="adder-window" style="display : none">
        <div class="blur" onclick="hideAdder()">
        </div>
        <div id="user-adder">
            <form class="form-adder">
                <h2 class="is-title no-top">Formulaire d'ajout</h2>
                <!-- <label class="is-label" for="#nom">Nom</label> -->
                <input id="nom-form" name="nom" class="is-input" type="text" placeholder="Nom" required>
                <!-- <label class="is-label" for="#prenom">Prenom</label> -->
                <input id="prenom-form" name="prenom" class="is-input" type="text" placeholder="Prénom" required>
                <!-- <label class="is-label" for="#telephone">Téléphone</label> -->
                <input id="telephone-form" name="telephone" class="is-input" type="text" placeholder="Téléphone" required>
                <!-- <label class="is-label" for="#courriel">Courriel</label> -->
                <input id="courriel-form" name="courriel" class="is-input" type="text" placeholder="Courriel" required>
                <div class="flex column gap-5 is-left cent">
                    <p class="is-label" for="#pdf-file">
                        CV :
                    </p>
                    <input id="pdf-file" class="pointer" name="cv" type="file" accept="application/pdf" required>
                </div>
                <div class="is-centered cent">
                    <select name="select-cat" id="select-cat-ajout" class="is-select" onchange="selectPosteAjout()">
                    </select>
                    <select name="select-poste" id="select-poste-ajout" class="is-select">
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
                        // console_log($rows);
                        foreach ($rows as $row) {
                            // console_log($row["offres"]);
                            echo "<script>addCats('#select-cat-ajout'," . $row["secteurs"] . ");
                            addOffres('#select-poste-ajout'," . $row["offres"] . ")
                            </script>";
                        }
                    } catch (PDOException $e) {
                        die("Erreur: " . $e->getMessage());
                    }
                    ?>
                    <p class="submit-poste is-button pointer" onclick="addPosteAjout()">Ajouter</p>
                </div>
                <div id="choix-poste" name="postes">
                </div>
                <p onclick="tryPoste()" class="is-button cent">Ajouter</p>
                <input type="text" required name="" id="verif-poste">
            </form>
        </div>
    </div>
</body>

</html>