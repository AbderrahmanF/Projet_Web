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
<?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
session_start();
function console_log($output, $with_script_tags = true)
{
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
        ');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}
if (!isset($_SESSION['post_data'])) {
    header("Location: login.php");
    exit();
}
console_log($_SESSION['post_data']);
?>
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
        } else if (sun && moon) {
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
        <iframe src="leftNavbar.php"
            onload="this.before((this.contentDocument.body||this.contentDocument).children[0]);this.remove()"></iframe>
        <div class="main">
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
                    $select_query = "SELECT 
postulant.nom AS nom,
    postulant.prenom AS prenom,
    postulant.email AS email,
    postulant.telephone AS telephone,
    postulant.id_postulant AS id_postulant,
    cv.pdf AS CvPath,
    CONCAT('[', IFNULL(GROUP_CONCAT(
        JSON_OBJECT(
            'offre', offres.nom_poste,
            'secteur', secteurs.nom_secteur
        ) ORDER BY offres.nom_poste SEPARATOR ', '), ''), ']') AS offres_secteurs
FROM 
    postulant
LEFT JOIN 
    postuler ON postulant.id_postulant = postuler.id_postulant
LEFT JOIN 
    offres ON postuler.id_offre = offres.id_offre
LEFT JOIN 
    secteurs ON offres.id_secteur = secteurs.id_secteur
LEFT JOIN 
    cv ON postulant.id_cv = cv.id_cv
GROUP BY 
    postulant.id_postulant;";
                    $result = $pdo->query($select_query);
                    $result->setFetchMode(PDO::FETCH_ASSOC);
                    $rows = $result->fetchAll();
                    $list = array();
                    foreach ($rows as $row) {
                        $person = array(
                            "prenom" => $row['prenom'],
                            "nom" => $row['nom'],
                            "telephone" => $row['telephone'],
                            "email" => $row['email'],
                            "cv" => $row['CvPath'],
                            "offres" => $row['offres_secteurs'],
                            "id" => $row['id_postulant'],
                        );
                        array_push($list, $person);
                    }
                    $list = json_encode($list);
                    echo '<script>getList(' . $list . ')</script>';
                    $result->closeCursor();
                } catch (PDOException $e) {
                    die("Erreur: " . $e->getMessage());
                }
                ?>
            </div>
            <div class="pdf-screen is-hidden">
                <div class="blur" onclick="hideCV()">
                </div>
                <div class="pdf-box ">
                    <iframe class="pdf-text" width="1000" height="900"></iframe>
                </div>
            </div>
        </div>
    </div>
    <?php
    include 'ajouterUtilisateur.php';
    include 'modifierUtilisateur.php';
    include 'gererOffres.php';
    ?>
</body>

</html>