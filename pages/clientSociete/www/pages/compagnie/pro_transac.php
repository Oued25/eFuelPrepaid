<?php
include '../../includesCompag/connection.php';  

if(isset($_POST['code_produit'], 
         $_POST['nom_produit'], 
         $_POST['id_categorie'], 
         $_POST['id_compagnie'], 
         $_POST['description'], 
         $_POST['prix_unitaire']
         )) {
    
    $cp = $_POST['code_produit'];
    $pnom = $_POST['nom_produit'];
    $desc = $_POST['description'];
    $comp = $_POST['id_compagnie'];
    $cat = $_POST['id_categorie'];
    $pr = $_POST['prix_unitaire']; 
    
    try {
        $sql = "INSERT INTO produit (id, code_produit, nom_produit, description, date_creation, prix_unitaire, id_compagnie, id_categorie,estActif)
                  VALUES (NULL, :cp, :pnom, :desc, :dcre, :pr, :comp, :cat, 1)";
        $req = $connection->prepare($sql);
        $req->bindParam(':cp', $cp);
        $req->bindParam(':pnom', $pnom);
        $req->bindParam(':desc', $desc);
        $req->bindParam(':dcre', $dcre);
        $req->bindParam(':pr', $pr);
        $req->bindParam(':comp', $comp);
        $req->bindParam(':cat', $cat);
        
        $req->execute();
        
        header("Location: product.php");
        exit();
    } catch(PDOException $e) {
        echo "Erreur lors de l'ajout du produit : " . $e->getMessage();
    }
} else {
    echo "Erreur : Données manquantes dans la requête POST.";
}
?>
