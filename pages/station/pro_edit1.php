<?php

include('../includes/connection.php');

$zz = $_POST['id'];
$pc = $_POST['prodcode'];
$pname = $_POST['prodname'];
$desc = $_POST['description'];
$cat = $_POST['category'];

$query = 'UPDATE product SET NAME=:pname, DESCRIPTION=:desc,  CATEGORY_ID=:cat WHERE PRODUCT_CODE=:pc';
$stmt = $connexion->prepare($query);
$stmt->bindParam(':pname', $pname);
$stmt->bindParam(':desc', $desc);
$stmt->bindParam(':cat', $cat);
$stmt->bindParam(':pc', $pc);
$result = $stmt->execute();

if ($result) {
    ?>
    <script type="text/javascript">
        alert("You've Update Product Successfully.");
        window.location = "product.php";
    </script>
    <?php
} else {
    echo "Error updating product";
}

?>
