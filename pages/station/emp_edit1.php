<?php
//var_dump($_POST);
include '../../includesStation/connection.php'; 

$zz = $_POST['id'];
$nom = $_POST['nom'];
$pnom = $_POST['prenom'];
$gen = $_POST['genre'];
$cnt = $_POST['contact'];
$adr = $_POST['adresse']; 

// Requête de Modification avec PDO
$sql = 'UPDATE gestionnaire
        SET
           nom = :nom, 
           prenom = :pnom, 
           genre = :gen,
           contact = :cnt, 
           adresse = :adr,
           date_modif = :dmo  
        WHERE  id = :zz';

$req = $connection->prepare($sql);
$req->bindParam(':zz', $zz);
$req->bindParam(':nom', $nom);
$req->bindParam(':pnom', $pnom);
$req->bindParam(':gen', $gen);
$req->bindParam(':cnt', $cnt);
$req->bindParam(':adr', $adr);
$req->bindParam(':dmo', $dmo); // Utilisation de ":zz" pour lier l'ID

$result = $req->execute();

if ($result) {
    ?>
    <script type="text/javascript">
        alert("Vous avez mis à jour avec succès.");
        window.location = "employee.php";
    </script>
    <?php
} else {
    ?>
    <script type="text/javascript">
        alert("Une erreur s'est produite lors de la mise à jour.");
        window.location = "employee.php";
    </script>
    <?php
}
?>
