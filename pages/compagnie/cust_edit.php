<?php
include '../../includesCompag/connection.php';  
include '../../includesCompag/sidebar.php'; 

$id_station = $_GET['id'];

// Requête SQL pour récupérer les détails de la station et le nom de la compagnie associée
$sql = "SELECT S.id AS id, s.code_station, s.nom_station, cpa.nom_compagnie, s.contact, s.adresse, s.localisation, s.compte_paiementStation
        FROM station AS s
        JOIN compagnie AS cpa ON cpa.id = s.id_compagnie
        WHERE s.id = :id";

// Préparation de la requête
$req = $connection->prepare($sql); 

// Liaison des paramètres
$req->bindParam(':id', $id_station);

// Exécution de la requête
$req->execute();

// Vérification des erreurs de requête
if (!$req) {
    die("Erreur dans la requête SQL: " . $connection->error);
}

// Récupération des résultats
while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
    $zz = $row['id'];
    $zzz = $row['code_station'];
    $A = $row['nom_station'];
    $C = $row['contact'];
    $D = $row['adresse'];
    $E = $row['localisation'];
    $F = $row['compte_paiementStation'];
}
?>
<center>
    <div class="card shadow mb-4 col-xs-12 col-md-8 border-bottom-primary">
        <div class="card-header py-3">
            <h4 class="m-2 font-weight-bold text-primary">Modifier Station</h4>
        </div>
        <a type="button" class="btn btn-primary bg-gradient-primary btn-block" href="customer.php?">
            <i class="fas fa-flip-horizontal fa-fw fa-share"></i> Retour
        </a>
        <div class="card-body">
            <form role="form" method="post" action="cust_edit1.php">
                <input type="hidden" name="id" value="<?php echo $zz; ?>" />

                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                        Code Station:
                    </div>
                    <div class="col-sm-9">
                        <input class="form-control" placeholder="Code Station" name="code_station" value="<?php echo $zzz; ?>" required>
                    </div>
                </div>

                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                        Nom Station:
                    </div>
                    <div class="col-sm-9">
                        <input class="form-control" placeholder="Nom Station" name="nom_station" value="<?php echo $A; ?>" required>
                    </div>
                </div>

                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                        Adresse Mail:
                    </div>
                    <div class="col-sm-9">
                        <input class="form-control" placeholder="Adresse Mail" name="adresse" value="<?php echo $D; ?>" required>
                    </div>
                </div>

                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                        Téléphone:
                    </div>
                    <div class="col-sm-9">
                        <input class="form-control" placeholder="Téléphone" name="contact" value="<?php echo $C; ?>" required>
                    </div>
                </div>

                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                        Localisation:
                    </div>
                    <div class="col-sm-9">
                        <input class="form-control" placeholder="Localisation" name="localisation" value="<?php echo $E; ?>" required>
                    </div>
                </div>

                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                        Compte Paiement:
                    </div>
                    <div class="col-sm-9">
                        <input class="form-control" placeholder="Compte Paiement" name="compte_paiementStation" value="<?php echo $F; ?>" required>
                    </div>
                </div>
                <hr>

                <button type="submit" class="btn btn-warning btn-block"><i class="fa fa-edit fa-fw"></i>Modifier</button> 
            </form>  
        </div>
    </div>
</center>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/Projet_eFuelPrepaid_fin/includesCompag/footer.php'); ?>
