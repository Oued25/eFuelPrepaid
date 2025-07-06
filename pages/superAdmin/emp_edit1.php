<?php
//var_dump($_POST);
include '../../includes/connection.php'; 

$zz = $_POST['id'];
$nom = $_POST['nom'];
$pnom= $_POST['prenom']; 
$gen = $_POST['genre'];
$soct = $_POST['nom_societe'];
$typ = $_POST['id_type'];
$telp= $_POST['tel_payement'];
$doc = $_POST['doc_identification'];
$num = $_POST['num_doc'];
$cnt = $_POST['contact'];
$adr = $_POST['adresse'];

// Requête de Modification avec PDO
$sql = 'UPDATE client
        SET
           nom = :nom, 
           prenom = :pnom, 
           genre = :gen,
           nom_societe = :soct,
           id_type = :typ, 
           tel_payement = :telp,
           doc_identification = :doc,
           num_doc = :num, 
           contact = :cnt, 
           adresse = :adr,
           date_modif = :dmo  
        WHERE  id = :id';

$req = $connection->prepare($sql);
$req->bindParam(':id', $zz);
$req->bindParam(':nom', $nom);
$req->bindParam(':pnom',$pnom);
$req->bindParam(':gen', $gen);
$req->bindParam(':soct',$soct);
$req->bindParam(':typ', $typ);
$req->bindParam(':telp',$telp);
$req->bindParam(':doc', $doc);
$req->bindParam(':num', $num);
$req->bindParam(':cnt', $cnt);
$req->bindParam(':adr', $adr);
$req->bindParam(':dmo', $dmo);// Utilisation de 

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
