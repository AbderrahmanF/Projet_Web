<html lang="fr-FR">

<head id="theme_toggle">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/root.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <script src="../js/app.js"></script>
    <script src="../js/list.js"></script>
    <title>Gestionnaire</title>
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
            console.log('hep')
            sun.classList.add('is-hidden')
            moon.classList.remove('is-hidden')
            localStorage.setItem('gestionnaire_theme', '')

        }
        else if (sun && moon) {
            sun.classList.remove('is-hidden')
            moon.classList.add('is-hidden')
            localStorage.setItem('gestionnaire_theme', 'is-dark')
        }
    })
</script>

<body id="main">
    <span class="hide-navbar pointer" onclick="hideNavbar()">
        <i class="bi-chevron-left icon" id="arrow-button"></i>
    </span>
    <div class="primary-container">
        <!-- <iframe src="leftNavbar.html"></iframe> -->
        <iframe src="leftNavbar.html"
            onload="this.before((this.contentDocument.body||this.contentDocument).children[0]);this.remove()"></iframe>
        <div class="main">
            <!-- <div class="flex row">
                <h2 class="is-title">Liste des CV</h2>
            </div> -->
            <div class="select-flow">
                <div class="title">
                    <h2 class="is-title">Liste des CV</h2>
                    <div class="flex select-all-option">
                        <input onchange="selectAll()" type="checkbox" name="select-all" id="select-all">
                        <label for="select-all" id="label-select-all">Tout selectionner</label>
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
                    $select_query = "SELECT postulant.nom AS nom, postulant.prenom AS prenom, postulant.email AS email, postulant.telephone as telephone, cv.pdf AS CvPath, offre.nom_offre AS NomOffre, secteurs.nom_secteur AS NomSecteur FROM postulant INNER JOIN postuler ON postulant.id_postulant = postuler.id_postulant INNER JOIN offre ON postuler.id_offre = offre.id_offre INNER JOIN secteurs ON offre.id_secteur = secteurs.id_secteur INNER JOIN cv ON postulant.id_cv = cv.id_cv;";
                    $res = $pdo->query($select_query);
                    $res->setFetchMode(PDO::FETCH_ASSOC);
                    $list = array();
                    foreach ($res as $row) {
                        $person = array(
                            "prenom" => $row['prenom'],
                            "nom" => $row['nom'],
                            "telephone" => $row['telephone'],
                            "email" => $row['email'],
                            "cv" => $row['CvPath'],
                            "offre" => $row['NomOffre'],
                            "secteur" => $row['NomSecteur']
                        );
                        array_push($list, $person);
                    }
                    $list = json_encode($list);
                    echo '<script>getList(' . $list . ')</script>';
                    $res->closeCursor();
                    $select_query = "SELECT postulant.nom AS NomPostulant, postulant.prenom AS PrenomPostulant, postulant.email AS EmailPostulant, cv.pdf AS CvPath, offre.nom_offre AS NomOffre, secteurs.nom_secteur AS NomSecteur FROM postulant INNER JOIN postuler ON postulant.id_postulant = postuler.id_postulant INNER JOIN offre ON postuler.id_offre = offre.id_offre INNER JOIN secteurs ON offre.id_secteur = secteurs.id_secteur INNER JOIN cv ON postulant.id_cv = cv.id_cv;";
                    $res = $pdo->query($select_query);
                    $res->setFetchMode(PDO::FETCH_ASSOC);
                    foreach ($res as $row) {
                        console_log($row['NomPostulant'] . " " . $row['PrenomPostulant'] . " " . $row['EmailPostulant'] . " " . $row['NomOffre'] . " " . $row['NomSecteur']);
                    }
                } catch (PDOException $e) {
                    die("Erreur: " . $e->getMessage());
                }
                ?>
            </div>
            <div class="pdf-screen is-hidden">
                <div class="blur" onclick="hideCV()">
                </div>
                <div class="pdf-box ">
                    <h1 class="pdf-title">CV de </h1>
                    <p class="pdf-text"></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>