<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/root.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <script src="../js/app.js"></script>
    <title>gestion des offres</title>
</head>

<body id="html-offer">
    <div id="offer-window" style="display : none">
        <div class="blur" onclick="hideOfferWindow()">
        </div>
        <div id="offer-gestion">
            <div class="row gestion-offres">
                <select name="choix-gestion-offre" id="choix-gestion-offre" class="is-select alone"
                    onchange="changeOfferForm(event)">
                    <option value="ajouter">Ajouter</option>
                    <option value="modifier">Modifier</option>
                    <option value="supprimer">Supprimer</option>
                </select>
            </div>
            <form class="offer-adder" id="form-offer" method="POST" action="../php/addOffer.php">
                <div id="add-offer" class="cent gap-5 flex wrap">
                    <h2 class="is-title no-top cent">Formulaire d'ajout d'offre</h2>
                    <label for="select-cat" class="label">Secteur : </label>
                    <div class="is-centered cent">
                        <select name="select-cat" id="select-cat-offerAdd" class="is-select"
                            onchange="checkOffres('#select-cat-offerAdd','#nom-offre-add')">
                        </select>
                    </div>
                    <input id="nom-offre-add" name="nomOffreAjout" class="is-input" type="text"
                        placeholder="Nom de l'offre" oninput="checkOffres('#select-cat-offerAdd','#nom-offre-add')"
                        required>
                    <label class="warning" for="nomOffreAjout">Attention ! Offre déjà existante !</label>
                    <button type="submit" class="is-button cent">Ajouter</button>
                </div>
                <div id="modif-offer" class="cent gap-5 flex wrap is-hidden">
                    <h2 class="is-title no-top cent">Formulaire de modification d'offre</h2>
                    <label for="select-cat" class="label">Choix de l'offre : </label>
                    <div class="is-centered cent">
                        <select name="select-cat" id="select-cat-offerModif" class="is-select select-cat"
                            onchange="selectPoste('#select-cat-offerModif','#select-poste-offerModif')">
                        </select>
                        <select name="select-poste" id="select-poste-offerModif" class="is-select select-poste">
                        </select>
                    </div>
                    <input id="nom-offre-modif" name="nomOffreModif" class="is-input" type="text"
                        placeholder="Nom de l'offre" oninput="checkOffres('#select-cat-offerModif','#nom-offre-modif')">
                    <label class="warning" for="nomOffreAjout">Attention ! Offre déjà existante !</label>
                    <button type="submit" class="is-button cent">Modifier</>
                </div>
                <div id="del-offer" class="cent gap-5 flex wrap is-hidden">
                    <h2 class="is-title no-top cent">Formulaire de suppression d'offre</h2>
                    <label for="select-cat" class="label">Choix de l'offre : </label>
                    <div class="is-centered cent">
                        <select name="select-cat" id="select-cat-offerDel" class="is-select select-cat"
                            onchange="selectPoste('#select-cat-offerDel','#select-poste-offerDel')">
                        </select>
                        <select name="select-poste" id="select-poste-offerDel"
                            class="is-select select-poste select-right">
                        </select>
                    </div>
                    <label class="warning">Attention</label>
                    <button type="submit" class="is-button cent">Supprimer</button>
                </div>
            </form>
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
                foreach ($rows as $row) {
                    echo "<script>
                            document.querySelector('#offer-gestion').setAttribute('secteurs',JSON.stringify(" . $row["secteurs"] . "));
                            document.querySelector('#offer-gestion').setAttribute('offres',JSON.stringify(" . $row["offres"] . "));
                            document.querySelector('#select-cat-offerAdd').setAttribute('offres',JSON.stringify(" . $row["offres"] . "));
                            addCats('#select-cat-offerAdd'," . $row["secteurs"] . ");
                            </script>";
                }
            } catch (PDOException $e) {
                die("Erreur: " . $e->getMessage());
            }
            ?>
        </div>
    </div>
    </div>
</body>

</html>