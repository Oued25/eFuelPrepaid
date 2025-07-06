<?php
include '../../includesCompag/connection.php';  

if(isset($_POST['nom'], 
         $_POST['prenom'], 
         $_POST['genre'], 
         $_POST['contact'], 
         $_POST['adresse'],
         $_POST['date_creation'], 
         )) {
    
    $nom = $_POST['nom'];
    $pnom = $_POST['prenom']; 
    $gen = $_POST['genre'];
    $cnt = $_POST['contact'];
    $adr = $_POST['adresse'];
    $dcre = $_POST['date_creation']; 
    
    try {
        $sql = "INSERT INTO gestionnaire (id, nom, prenom, genre, contact, adresse, date_creation, estActif)
                  VALUES (NULL, :nom, :pnom, :gen, :cnt, :adr, :dcre, 1)";
        $req = $connection->prepare($sql);
        $req->bindParam(':nom', $nom);
        $req->bindParam(':pnom', $pnom);
        $req->bindParam(':gen', $gen);
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
