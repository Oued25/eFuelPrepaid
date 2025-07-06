<?php
//var_dump($_POST);
include '../../includesCompag/connection.php'; 

// Récupération des valeurs des champs du formulaire
//$zz = $_POST['id'];
$cp = $_POST['code_produit'];
$pnom = $_POST['nom_produit'];
$desc = $_POST['description'];
$pr = $_POST['prix_unitaire'];
$cat = $_POST['id_categorie'];

// Requête SQL avec PDO
$sql = 'UPDATE produit AS p, categorie AS c  
        SET p.nom_produit = :pnom, 
            p.description = :desc, 
            p.prix_unitaire = :pr, 
            p.id_categorie = :cat, 
            p.date_modif = :dmo 
        WHERE p.code_produit = :cp 
        AND c.id = p.id_categorie';

// Préparation de la requête
$req = $connection->prepare($sql);

// Liaison des paramètres
$req->bindParam(':pnom', $pnom);
$req->bindParam(':pr', $pr);
$req->bindParam(':desc', $desc);
$req->bindParam(':cat', $cat);
$req->bindParam(':dmo', $dmo);
$req->bindParam(':cp', $cp);

// Exécution de la requête
$result = $req->execute();

// Vérification de l'exécution de la requête
if ($result) {
    ?>
    <script type="text/javascript">
        alert("Produit modifier avec succès.");
        window.location = "product.php";
    </script>
    <?php
} else {
    echo "Erreur de la Modification du product";
    
}

?>
