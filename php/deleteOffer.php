<?php
try {
    require ("connexion.inc.php");
    $nom_poste = $_POST['select-poste'];
    $nom_secteur = $_POST['select-cat'];
    $select_query = "SELECT id_secteur FROM secteurs WHERE nom_secteur = :nom_secteur;";
    $result = $pdo->prepare($select_query);
    $result->bindParam(':nom_secteur', $nom_secteur, PDO::PARAM_STR);
    $result->execute();
    $result->setFetchMode(PDO::FETCH_ASSOC);
    $rows = $result->fetchAll();
    $id_secteur = $rows[0]['id_secteur'];
    $select_query = "SELECT id_offre FROM offres WHERE nom_poste = :nom_poste AND id_secteur = :id_secteur;";
    $result = $pdo->prepare($select_query);
    $result->bindParam(':nom_poste', $nom_poste, PDO::PARAM_STR);
    $result->bindParam(':id_secteur', $id_secteur, PDO::PARAM_INT);
    $result->execute();
    $result->setFetchMode(PDO::FETCH_ASSOC);
    $rows = $result->fetchAll();
    $id_offre = $rows[0]['id_offre'];
    $delete_query = "DELETE FROM offres WHERE id_offre = :id_offre;";
    $result = $pdo->prepare($delete_query);
    $result->bindParam(':id_offre', $id_offre, PDO::PARAM_INT);
    $result->execute();
    $delete_query = "DELETE FROM postuler WHERE id_offre = :id_offre;";
    $result = $pdo->prepare($delete_query);
    $result->bindParam(':id_offre', $id_offre, PDO::PARAM_INT);
    $result->execute();
    echo "Offre supprimée avec succès";
    header("Location: ../html/gestionnaire.php");
} catch (PDOException $e) {
    die("Erreur: " . $e->getMessage());
}