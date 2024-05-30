<?php
try {
    require ("connexion.inc.php");
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $telephone = $_POST["telephone"];
    $courriel = $_POST["courriel"];
    $cv = $_POST["cv"];
    $metiers = $_POST["metier"];


} catch (PDOException $e) {
    die("Erreur: " . $e->getMessage());
}