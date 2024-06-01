<?php
try {
    require ("connexion.inc.php");
    $nom_poste = $_POST['nomOffreAjout'];
    $nom_secteur = $_POST['select-cat'];
    $select_query = "SELECT id_secteur FROM secteurs WHERE nom_secteur = :nom_secteur;";
    $result = $pdo->prepare($select_query);
    $result->bindParam(':nom_secteur', $nom_secteur, PDO::PARAM_STR);
    $result->execute();
    $result->setFetchMode(PDO::FETCH_ASSOC);
    $rows = $result->fetchAll();
    $id_secteur = $rows[0]['id_secteur'];
    $insert_query = "INSERT INTO offres (nom_poste, id_secteur) VALUES (:nom_poste, :id_secteur);";
    $result = $pdo->prepare($insert_query);
    $result->bindParam(':nom_poste', $nom_poste, PDO::PARAM_STR);
    $result->bindParam(':id_secteur', $id_secteur, PDO::PARAM_INT);
    $result->execute();
    echo "Offre ajoutée avec succès";
    header("Location: ../html/gestionnaire.php");
} catch (PDOException $e) {
    die("Erreur: " . $e->getMessage());
}