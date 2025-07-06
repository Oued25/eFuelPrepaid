<?php
include'../includes/connection.php';
include'../includes/sidebar.php';
?>

<?php  
// Inclusion du fichier de connexion PDO
include '../includes/connection.php';

// Requête pour vérifier le type de l'utilisateur
$query = 'SELECT ID, t.TYPE FROM users u JOIN type t ON t.TYPE_ID=u.TYPE_ID WHERE ID = :member_id';
$stmt = $connexion->prepare($query);
$stmt->bindParam(':member_id', $_SESSION['MEMBER_ID']);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$Aa = $row['TYPE'];

// Si l'utilisateur est de type "User", redirection vers la page POS
if ($Aa == 'User'){
?>
<script type="text/javascript">
    alert("Page restreinte ! Vous serez redirigé vers POS");
    window.location = "pos.php";
</script>
<?php
}

// Affichage du formulaire pour ajouter une station 
?>
<center>
    <div class="card shadow mb-4 col-xs-12 col-md-8 border-bottom-primary">
        <div class="card-header py-3">
            <h4 class="m-2 font-weight-bold text-primary">Ajouter Station</h4>
        </div>
        <a href="customer.php" type="button" class="btn btn-primary bg-gradient-primary">Retour</a>
        <div class="card-body">
            <div class="table-responsive">
                <form role="form" method="post" action="cust_transac.php?action=add">
                    <div class="form-group">
                        <input class="form-control" placeholder="Nom Station" name="firstname" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Adresse" name="lastname" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Compte Paiement" name="lastname" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Localisation" name="lastname" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Numéro de téléphone" name="phonenumber" required>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-success btn-block"><i class="fa fa-check fa-fw"></i>Enregistrer</button>
                    <button type="reset" class="btn btn-danger btn-block"><i class="fa fa-times fa-fw"></i>Réinitialiser</button>
                </form>  
            </div>
        </div>
    </div>
</center>
<?php
include '../includes/footer.php';
?>
