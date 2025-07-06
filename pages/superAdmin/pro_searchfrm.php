<?php
include '../../includes/connection.php';
include '../../includes/sidebar.php';

$id_produit = $_GET['id'];

// Requête SQL avec PDO
$sql = "SELECT p.id AS id, p.code_produit, p.nom_produit, p.description, p.prix_unitaire, c.nom_categorie, p.date_creation, p.date_modif
        FROM produit AS p
        JOIN categorie AS c ON c.id = p.id_categorie
        WHERE p.id = :id";
// Préparation de la requête
$req = $connection->prepare($sql);

// Liaison des paramètres
$req->bindParam(':id', $id_produit, PDO::PARAM_INT);

// Exécution de la requête
$req->execute();

// Vérification des résultats
if ($row = $req->fetch(PDO::FETCH_ASSOC)) {
    $zzz = $row['code_produit'];
    $i = $row['nom_produit'];
    $a = $row['description'];
    $b = $row['prix_unitaire'];
    $c = $row['date_creation'];
    $e = $row['date_modif'];
    $d = $row['nom_categorie'];
} else {
    echo "<script>
        alert('Produit non trouvé.');
        window.location.href = 'product.php';
    </script>";
    exit();
}
?>

<center>
    <div class="card shadow mb-4 col-xs-12 col-md-8 border-bottom-primary">
        <div class="card-header py-3">
            <h4 class="m-2 font-weight-bold text-primary">Détails Produit</h4>
        </div>
        <a href="product.php?action=add" type="button" class="btn btn-primary bg-gradient-primary btn-block">
            <i class="fas fa-flip-horizontal fa-fw fa-share"></i> Retour
        </a>
        <div class="card-body">
            <div class="form-group row text-left">
                <div class="col-sm-3 text-primary">
                    <h5>Code Produit :</h5>
                </div>
                <div class="col-sm-9">
                    <h5><?php echo $zzz; ?></h5>
                </div>
            </div>
            <div class="form-group row text-left">
                <div class="col-sm-3 text-primary">
                    <h5>Nom Produit :</h5>
                </div>
                <div class="col-sm-9">
                    <h5><?php echo $i; ?></h5>
                </div>
            </div>
            <div class="form-group row text-left">
                <div class="col-sm-3 text-primary">
                    <h5>Description :</h5>
                </div>
                <div class="col-sm-9">
                    <h5><?php echo $a; ?></h5>
                </div>
            </div>
            <div class="form-group row text-left">
                <div class="col-sm-3 text-primary">
                    <h5>Prix :</h5>
                </div>
                <div class="col-sm-9">
                    <h5><?php echo $b; ?></h5>
                </div>
            </div>
            <div class="form-group row text-left">
                <div class="col-sm-3 text-primary">
                    <h5>Catégorie :</h5>
                </div>
                <div class="col-sm-9">
                    <h5><?php echo $d; ?></h5>
                </div>
            </div>
            <div class="form-group row text-left">
                <div class="col-sm-3 text-primary">
                    <h5>Date Création :</h5>
                </div>
                <div class="col-sm-9">
                    <h5><?php echo $c; ?></h5>
                </div>
            </div>
            <div class="form-group row text-left">
                <div class="col-sm-3 text-primary">
                    <h5>Date Modification :</h5>
                </div>
                <div class="col-sm-9">
                    <h5><?php echo $e; ?></h5>
                </div>
            </div>
        </div>
    </div>
</center>

<?php include '../../includes/footer.php'; ?>
