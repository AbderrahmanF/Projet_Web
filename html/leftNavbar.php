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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let theme = '';
        if (localStorage.getItem('gestionnaire_theme')) {
            theme = localStorage.getItem('gestionnaire_theme')
            myRoot = document.documentElement
            myRoot.classList.add(theme)
        }
        let head = document.querySelector(':root')
        let sun = document.querySelector('.bi-sun')
        let moon = document.querySelector('.bi-moon')
        if (!head.classList.contains('is-dark') && sun && moon) {
            sun.classList.add('is-hidden')
            moon.classList.remove('is-hidden')
            localStorage.setItem('gestionnaire_theme', '')

        } else if (sun && moon) {
            sun.classList.remove('is-hidden')
            moon.classList.add('is-hidden')
            localStorage.setItem('gestionnaire_theme', 'is-dark')
        }
    })
</script>

<body>
    <div class="left-navbar">
        <div class="first-row">
            <h1 class="is-title-1 pointer" onclick="goLogin()">Gestionnaire de CV</h1>
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
        </div>
        <div class="row" id="admin-options">
            <div class="flex column navbarRow">
                <button class="is-button is-admin not-admin cent" name="offerButton">Gérer offres</button>
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
            session_start();
            $post_data = $_SESSION['post_data'];
            // Utilisez les données POST selon vos besoins
            // print_r($post_data);
            // Nettoyer les données POST de la session après utilisation si nécessaire
            $username = $post_data["User"];
            $select_query = "SELECT droits from utilisateurs WHERE username = :username;";
            $result = $pdo->prepare($select_query);
            $result->bindParam(':username', $username, PDO::PARAM_STR);
            $result->execute();
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $rows = $result->fetchAll();
            // print_r($rows[0]["droits"]);
            if ($rows[0]["droits"] == "Admin") {
                echo '<script>isAdmin()</script>';
            } else {
                echo '<script>isNotAdmin()</script>';
            }
        } catch (PDOException $e) {
            die("Erreur: " . $e->getMessage());
        }
        ?>
        <div class="row">
            <div class="flex column navbarRow">
                <h3 class="is-title">Filtrer les postes</h3>
                <div class="is-centered ">
                    <select name="select-cat " id="select-cat" class="is-select select-cat"
                        onchange="selectPoste('#select-cat','#select-poste')">
                    </select>
                    <select name="select-poste " id="select-poste" class="is-select">
                    </select>
                    <button class="submit-poste is-button pointer" onclick="addPoste()">Ajouter</button>
                </div>
            </div>
        </div>
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
                echo "<script>addCats('#select-cat'," . $row["secteurs"] . ");
                            addOffres('#select-poste'," . $row["offres"] . ")
                            </script>";
            }
        } catch (PDOException $e) {
            die("Erreur: " . $e->getMessage());
        }
        ?>
        <div class="row">
            <div id="filtre-poste">
            </div>
        </div>
    </div>
</body>

</html>