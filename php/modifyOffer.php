<?php
try {
    require ("connexion.inc.php");
    $nom_poste = $_POST['select-poste'];
    $nom_secteur = $_POST['select-cat'];
    $nouveau_nom = $_POST['nomOffreModif'];
    $select_query = "SELECT id_secteur FROM secteurs WHERE nom_secteur = :nom_secteur;";
    $result = $pdo->prepare($select_query);
    $result->bindParam(':nom_secteur', $nom_secteur, PDO::PARAM_STR);
    $result->execute();
    $result->setFetchMode(PDO::FETCH_ASSOC);
    $rows = $result->fetchAll();
    $id_secteur = $rows[0]['id_secteur'];
    $update_query = "UPDATE offres SET nom_poste = :nouveau_nom WHERE nom_poste = :nom_poste AND id_secteur = :id_secteur;";
    $result = $pdo->prepare($update_query);
    $result->bindParam(':nouveau_nom', $nouveau_nom, PDO::PARAM_STR);
    $result->bindParam(':nom_poste', $nom_poste, PDO::PARAM_STR);
    $result->bindParam(':id_secteur', $id_secteur, PDO::PARAM_INT);
    $result->execute();
    echo "Offre modifiée avec succès";
    header("Location: ../html/gestionnaire.php");
} catch (PDOException $e) {
    die("Erreur: " . $e->getMessage());
}