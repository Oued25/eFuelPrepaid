<?php
include '../../includesStation/connection.php'; 
include '../../includesStation/sidebar.php'; 

// Vérification du type d'utilisateur
/*$query = 'SELECT ID, t.TYPE
            FROM users u
            JOIN type t ON t.TYPE_ID=u.TYPE_ID WHERE ID = :member_id';
$stmt = $connexion->prepare($query);
$stmt->bindParam(':member_id', $_SESSION['MEMBER_ID']);
$stmt->execute();

$Aa = null;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $Aa = $row['TYPE'];
}

if ($Aa == 'User'){
?>
<script type="text/javascript">
    //then it will be redirected
    alert("Restricted Page! You will be redirected to POS");
    window.location = "pos.php";
</script>
<?php
}

// Récupération des catégories
$query = "SELECT DISTINCT CNAME, CATEGORY_ID FROM category ORDER BY CNAME ASC";
$stmt = $connexion->query($query);

$opt = "<select class='form-control' name='category' required>
        <option value='' disabled selected hidden>Select Category</option>";
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $opt .= "<option value='".$row['CATEGORY_ID']."'>".$row['CNAME']."</option>";
}
$opt .= "</select>";

// Récupération des informations du produit
$query = 'SELECT PRODUCT_ID,PRODUCT_CODE, NAME, DESCRIPTION, FROM product p JOIN category c ON p.CATEGORY_ID=c.CATEGORY_ID WHERE PRODUCT_ID = :product_id';
$stmt = $connexion->prepare($query);
$stmt->bindParam(':product_id', $_GET['id']);
$stmt->execute();

$zz = $zzz = $A = $B = null;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $zz = $row['PRODUCT_ID'];
    $zzz = $row['PRODUCT_CODE'];
    $A = $row['NAME'];
    $B = $row['DESCRIPTION'];
}

$id = $_GET['id'];
*/
?>

<center>
    <div class="card shadow mb-4 col-xs-12 col-md-8 border-bottom-primary">
        <div class="card-header py-3">
            <h4 class="m-2 font-weight-bold text-primary">Modifier Produit</h4>
        </div>
        <a href="product.php?action=add" type="button" class="btn btn-primary bg-gradient-primary">Retour</a>
        <div class="card-body">
            <form role="form" method="post" action="pro_edit1.php">
                <input type="hidden" name="id" value="<?php echo $zz; ?>" />
                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                       Code Produit:
                    </div>
                    <div class="col-sm-9">
                        <input class="form-control" placeholder=" Code Produit" name="prodcode" value="1234567890" readonly>
                    </div>
                </div>
                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                        Nom Produit:
                    </div>
                    <div class="col-sm-9">
                        <input class="form-control" placeholder="Nom Produit" name="prodname" value="Gaz Butan 6kg" required>
                    </div>
                </div>
                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                        Description:
                    </div>
                    <div class="col-sm-9">
                        <textarea class="form-control" placeholder="Description" name="description">R.A.S</textarea>
                    </div>
                </div>
                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                        Catégorie:
                    </div>
                    <div class="col-sm-9">
                    <select class="form-control" name="categorie" id="categorie">
                        <option value="">--Choisir une catégorie--</option><!-- cette option permette de ne pas afficher une Categorie par defaut dans le inpute-->
                        <option  value=""> produits Pétroliers Derivés</option>
                        <option  value=""> produits Shops</option>
                    </select>
                    </div>
                </div>
                <hr>
                <button type="submit" class="btn btn-warning btn-block"><i class="fa fa-edit fa-fw"></i>Modifier</button>
            </form>
        </div>
    </div>
</center>

<?php include '../../includesStation/footer.php'; ?>
