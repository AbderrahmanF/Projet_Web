<?php
try {
    require ("connexion.inc.php");
    $select_query = "SELECT * FROM postulant";
    $res = $pdo->query($select_query);
    echo json_encode($res->fetchAll());
} catch (PDOException $e) {
    die("Erreur: " . $e->getMessage());
}


