<html lang="fr-FR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/root.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <script src="../js/app.js"></script>
    <script src="../js/admin.js"></script>
    <title>leftNavbar</title>
</head>

<body>
    <div class="left-navbar">
        <div class="first-row">
            <h1 class="is-title-1">Gestionnaire de CV</h1>
            <span class="apply-theme pointer" onclick="changeTheme()">
                <i class="bi-moon icon"></i>
                <i class="bi-sun icon is-hidden"></i>
            </span>
        </div>
        <div class="row">
            <div class="flex column navbarRow">
                <h3 class="is-title">Rechercher un profil</h3>
                <input type="search" class="is-input" oninput="filterCV()" name="serachBar" id="searchBar"
                    placeholder="Ecrire ici">
            </div>
        </div>
        <div class="row" id="admin-options">
            <div class="option">
                <div class="flex column navbarRow">
                    <h3 class="is-title">Options administrateur</h3>
                    <div class="is-spaced-evenly">
                        <button class="is-button is-admin not-admin" name="addButton">Ajouter</button>
                        <button class="is-button is-admin not-admin" name="delButton">Supprimer</button>
                    </div>
                </div>
            </div>

            <?php
            try {
                require ("../php/connexion.inc.php");
                function console_log($output, $with_script_tags = true)
                {
                    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
                        ');';
                    if ($with_script_tags) {
                        $js_code = '<script>' . $js_code . '</script>';
                    }
                    echo $js_code;
                }
                $select_query = "SELECT droits from utilisateurs WHERE username = 'kamaury'";
                $result = $pdo->query($select_query);
                $result->setFetchMode(PDO::FETCH_ASSOC);
                $rows = $result->fetchAll();
                if ($rows[0]["droits"] == "admin") {
                    echo '<script>isAdmin()</script>';
                } else {
                    echo '<script>isNotAdmin()</script>';
                }
            } catch (PDOException $e) {
                die("Erreur: " . $e->getMessage());
            }
            ?>
        </div>
        <div class="row">
            <div class="flex column navbarRow">
                <h3 class="is-title">Filtrer les postes</h3>
                <div class="is-centered ">
                    <select name="select-cat " id="select-cat" class="is-select" onchange="selectPoste()">
                    </select>
                    <select name="select-poste " id="select-poste" class="is-select">

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
                        'nom_offre', offre.nom_offre,
                        'nom_secteur', secteurs.nom_secteur
                    )
                    SEPARATOR ','
                ),
                ']'
            ) AS offres
        FROM 
            offre
        INNER JOIN 
            secteurs ON offre.id_secteur = secteurs.id_secteur
    ) AS offres;";
                        $result = $pdo->query($select_query);
                        $result->setFetchMode(PDO::FETCH_ASSOC);
                        $rows = $result->fetchAll();
                        $secteurs = array();
                        $offres = array();
                        foreach ($rows as $row) {
                            // console_log($row["offres"]);
                            echo "<script>addCats('#select-cat'," . $row["secteurs"] . ");
                            addOffres('#select-poste'," . $row["offres"] . ")
                            </script>";
                        }
                    } catch (PDOException $e) {
                        die("Erreur: " . $e->getMessage());
                    }
                    ?>
                    <button class="submit-poste is-button pointer" onclick="addPoste()">Ajouter</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div id="filtre-poste">
            </div>
        </div>
    </div>
</body>

</html>