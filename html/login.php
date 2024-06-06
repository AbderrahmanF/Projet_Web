<!DOCTYPE html>
<html lang="fr-FR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/root.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <script type="text/javascript" src="../js/app.js"></script>
    <title>Gestionnaire de CV</title>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let theme = '';
            if (localStorage.getItem('gestionnaire_theme')) {
                theme = localStorage.getItem('gestionnaire_theme');
                myRoot = document.documentElement;
                myRoot.classList.add(theme);
            }
            let head = document.querySelector(':root');
            let sun = document.querySelector('.bi-sun');
            let moon = document.querySelector('.bi-moon');
            if (!head.classList.contains('is-dark')) {
                sun.classList.add('is-hidden');
                moon.classList.remove('is-hidden');
                localStorage.setItem('gestionnaire_theme', '');
            } else {
                sun.classList.remove('is-hidden');
                moon.classList.add('is-hidden');
                localStorage.setItem('gestionnaire_theme', 'is-dark');
            }
        });
    </script>
</head>
<?php
session_start();
session_unset();
session_destroy();
if (isset($_GET['mdp']) && $_GET['mdp'] == 'incorrect') {
    echo '<script>alert("Mot de passe incorrect")</script>';
} elseif (isset($_GET['user']) && $_GET['user'] == 'incorrect') {
    echo '<script>alert("Nom d\'utilisateur incorrect")</script>';
}
?>

<body>
    <div class="home">
        <div class="box flex column">
            <div class="is-title-1">
                <h1 class="is-title">Projet web : Gestionnaire de CV</h1>
                <span class="apply-theme pointer" onclick="changeTheme()">
                    <i class="bi-moon icon"></i>
                    <i class="bi-sun icon is-hidden"></i>
                </span>
            </div>
            <div class="connexion-form">
                <form action="../php/Connexion.php" class="is-form flex colum ident" method="post"
                    enctype="multipart/form-data">
                    <input class="is-input-connexion" id="username" name="User" type="text"
                        placeholder="Nom d'utilisateur">
                    <div class="flex row connexion is-left">
                        <input class="is-input-connexion" name="Pass" id="password" type="password"
                            placeholder="Mot de passe">
                        <i class="pointer bi bi-eye-slash" id="togglePassword" onclick="togglePassword()"></i>
                    </div>
                    <button class="is-button pointer" type="submit">
                        Se connecter
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>