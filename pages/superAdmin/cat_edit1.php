<?php
include('../../includes/connection.php');

$zz = $_POST['id'];
$cat = $_POST['nom_categorie'];
$desc = $_POST['descrip_categorie'];

$sql = 'UPDATE categorie SET nom_categorie=:cat, descrip_categorie=:desc WHERE id=:zz';
$req = $connection->prepare($sql);
$req->bindParam(':cat', $cat);
$req->bindParam(':desc', $desc);
$req->bindParam(':zz', $zz);
$result = $req->execute();

if ($result) {
    ?>
    <script type="text/javascript">
        alert("Produit modifier avec succès.");
        window.location = "categorie.php";
    </script>
    <?php
} else {
    echo "Error updating ";
}

?>
