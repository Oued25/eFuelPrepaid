<?php

include '../../includes/connection.php'; 

// Récupération des valeurs des champs du formulaire 
$zz = $_POST['id'];
$cs = $_POST['code_station'];
$snom = $_POST['nom_station'];
$cpa = $_POST['id_compagnie'];
$contact = $_POST['contact'];
$adr = $_POST['adresse'];
$loc = $_POST['localisation'];
$paie = $_POST['compte_paiementStation'];
 
// Requête SQL avec PDO
$sql = "UPDATE station AS s, compagnie AS cpa
        SET s.code_station = :cs,
            s.nom_station = :snom,
            s.id_compagnie = :cpa,
            s.contact = :contact,
            s.adresse = :adr,
            s.localisation = :loc,
            s.compte_paiementStation = :paie,
            s.date_modif = :dmo
        WHERE s.id = :id 
        AND cpa.id = s.id_compagnie"; 

// Préparation de la requête
$req = $connection->prepare($sql);

// Liaison des paramètres
$req->bindParam(':id', $zz);
$req->bindParam(':snom', $snom);
$req->bindParam(':cpa', $cpa);
$req->bindParam(':contact', $contact);
$req->bindParam(':adr', $adr);
$req->bindParam(':loc', $loc);
$req->bindParam(':paie', $paie);
$req->bindParam(':dmo', $dmo);
$req->bindParam(':cs', $cs);

// Exécution de la requête
$result = $req->execute();

// Vérification de l'exécution de la requête
if ($result) {
    ?>
    <script type="text/javascript">
        alert("Station modifiée avec succès.");
        window.location = "station.php";
    </script>
    <?php
} else {
    echo "Erreur lors de la mise à jour de la station.";
}

?>
