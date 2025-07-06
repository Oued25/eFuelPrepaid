<?php
include '../../includes/connection.php';  

if(isset($_POST['nom'], 
         $_POST['prenom'], 
         $_POST['genre'], 
         $_POST['nom_societe'], 
         $_POST['id_type'],
         $_POST['tel_payement'],
         $_POST['doc_identification'], 
         $_POST['num_doc'],
         $_POST['contact'], 
         $_POST['adresse']
         )) {
    
    $nom = $_POST['nom'];
    $pnom = $_POST['prenom']; 
    $gen = $_POST['genre'];
    $soct = $_POST['nom_societe'];
    $typ = $_POST['id_type'];
    $telp = $_POST['tel_payement'];
    $doc = $_POST['doc_identification'];
    $num = $_POST['num_doc'];
    $cnt = $_POST['contact'];
    $adr = $_POST['adresse'];
    
    try {
        $sql = "INSERT INTO client (id, nom, prenom, genre,nom_societe, id_type, tel_payement, doc_identification, num_doc, contact, adresse, date_creation, estActif)
                VALUES (NULL, :nom, :pnom, :gen, :soct, :typ, :telp, :doc, :num, :cnt, :adr, :dcre, 1)";
        $req = $connection->prepare($sql);
        $req->bindParam(':nom', $nom);
        $req->bindParam(':pnom', $pnom);
        $req->bindParam(':gen', $gen);
        $req->bindParam(':soct', $soct);
        $req->bindParam(':typ', $typ);
        $req->bindParam(':telp', $telp);
        $req->bindParam(':doc', $doc);
        $req->bindParam(':num', $num);
        $req->bindParam(':cnt', $cnt);
        $req->bindParam(':adr', $adr);
        $req->bindParam(':dcre', $dcre);
        
        $req->execute();
        
        header("Location: employee.php");
        exit();
    } catch(PDOException $e) {
        echo "Erreur lors de l'ajout du Mananger : " . $e->getMessage();
    }
} else {
    echo "Erreur : Données manquantes dans la requête POST.";
}
?>
