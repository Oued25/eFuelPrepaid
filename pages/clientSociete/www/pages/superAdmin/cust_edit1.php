<?php
//var_dump($_POST);
include '../../includes/connection.php'; 

// Récupération des valeurs des champs du formulaire
$zz = $_POST['id'];
$cc = $_POST['code_compagnie'];
$cnom = $_POST['nom_compagnie'];
$contact = $_POST['contact'];
$adr = $_POST['adresse'];
$loc = $_POST['localisation'];
$paie = $_POST['compte_paiement'];


// Requête SQL avec PDO
$sql = "UPDATE compagnie
        SET code_compagnie = :cc,
            nom_compagnie = :cnom,
            contact = :contact,
            adresse = :adr,
            localisation = :loc,
            compte_paiement = :paie,
            date_modif = :dmo
        WHERE  id = :id ";

// Préparation de la requête
$req = $connection->prepare($sql);

// Liaison des paramètres
$req->bindParam(':id', $zz);
$req->bindParam(':cnom', $cnom);
$req->bindParam(':contact', $contact);
$req->bindParam(':adr', $adr);
$req->bindParam(':loc', $loc);
$req->bindParam(':paie', $paie); 
$req->bindParam(':dmo', $dmo);
$req->bindParam(':cc', $cc);

// Exécution de la requête
$result = $req->execute();

// Vérification de l'exécution de la requête
if ($result) {
    ?>
    <script type="text/javascript">
        alert("Vous avez mis à jour les informations de le Compagnie avec succès..");
        window.location = "customer.php";
    </script>
    <?php
} else {
    echo "Erreur lors de la mise à jour de la Compagnie.";
}

?>
