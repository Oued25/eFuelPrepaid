<?php
//var_dump($_POST);
include '../../includes/connection.php';
// Récupération des valeurs des champs du formulaire 
$zz = $_POST['id'];
$cp = $_POST['code_produit'];
$pnom = $_POST['nom_produit'];
$desc = $_POST['description'];
$pr = $_POST['prix_unitaire'];
$cat = $_POST['id_categorie'];

// Requête SQL avec PDO
$sql = 'UPDATE produit AS p, categorie AS c  
        SET p.code_produit = :cp,
            p.nom_produit = :pnom, 
            p.description = :desc, 
            p.prix_unitaire = :pr, 
            p.id_categorie = :cat, 
            p.date_modif = :dmo 
        WHERE p.id = :id  
        AND c.id = p.id_categorie';

// Préparation de la requête
$req = $connection->prepare($sql);

// Liaison des paramètres
$req->bindParam(':id', $zz);
$req->bindParam(':cp', $cp);
$req->bindParam(':pnom', $pnom);
$req->bindParam(':desc', $desc);
$req->bindParam(':pr', $pr);
$req->bindParam(':cat', $cat);
$req->bindParam(':dmo', $dmo);


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
