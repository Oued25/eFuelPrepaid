<?php
include '../../includes/connection.php';  

if(isset($_POST['code_station'], 
         $_POST['nom_station'], 
         $_POST['id_compagnie'], 
         $_POST['contact'], 
         $_POST['adresse'], 
         $_POST['localisation'],
         $_POST['compte_paiementStation'],
         )) {
    
    $cs = $_POST['code_station'];
    $snom = $_POST['nom_station'];
    $tel = $_POST['id_compagnie'];
    $contact = $_POST['contact'];
    $adr = $_POST['adresse'];
    $loc = $_POST['localisation'];
    $paie = $_POST['compte_paiementStation']; 
    
    try {
        $sql = "INSERT INTO station (id, code_station, nom_station, id_compagnie, contact, adresse, localisation, compte_paiementStation, date_creation,  estActif, compte_paiementStationActif)
                  VALUES (NULL, :cs , :snom, :tel, :contact, :adr, :loc, :paie, :dcre, 1, 1)";
        $req = $connection->prepare($sql);
        $req->bindParam(':cs', $cs );
        $req->bindParam(':snom', $snom);
        $req->bindParam(':tel', $tel);
        $req->bindParam(':contact', $contact);
        $req->bindParam(':adr', $adr);
        $req->bindParam(':loc', $loc);
        $req->bindParam(':paie', $paie);
        $req->bindParam(':dcre', $dcre);
        
        $req->execute();
        
        header("Location: station.php");
        exit();
    } catch(PDOException $e) {
        echo "Erreur lors de l'ajout du Sation : " . $e->getMessage();
    }
} else {
    echo "Erreur : Données manquantes dans la requête POST.";
}
?>
