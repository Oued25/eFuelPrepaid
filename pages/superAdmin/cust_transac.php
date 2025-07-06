<?php
include '../../includes/connection.php';  

if(isset($_POST['code_compagnie'], 
         $_POST['nom_compagnie'], 
         $_POST['contact'], 
         $_POST['adresse'], 
         $_POST['localisation'],
         $_POST['compte_paiement']
         )) {
    
    $cc = $_POST['code_compagnie'];
    $cnom = $_POST['nom_compagnie'];
    $contact = $_POST['contact'];
    $adr = $_POST['adresse'];
    $loc = $_POST['localisation'];
    $paie = $_POST['compte_paiement']; 
    
    try {
        $sql = "INSERT INTO compagnie (id, code_compagnie, nom_compagnie,  contact, adresse, localisation, compte_paiement, date_creation,  estActif, compte_paiementActif)
                  VALUES (NULL, :cc , :cnom,  :contact, :adr, :loc, :paie, :dcre, 1,1)";
        $req = $connection->prepare($sql);
        $req->bindParam(':cc', $cc );
        $req->bindParam(':cnom', $cnom);
        $req->bindParam(':contact', $contact);
        $req->bindParam(':adr', $adr);
        $req->bindParam(':loc', $loc);
        $req->bindParam(':paie', $paie);
        $req->bindParam(':dcre', $dcre);
        
        $req->execute();
        
        header("Location: customer.php");
        exit();
    } catch(PDOException $e) {
        echo "Erreur lors de l'ajout du Compagnie : " . $e->getMessage();
    }
} else {
    echo "Erreur : Données manquantes dans la requête POST.";
}
?>
