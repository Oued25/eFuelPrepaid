<?php

include '../../includesStation/connection.php'; 
include '../../includesStation/sidebar.php'; 

$id_gestionnaire = $_GET['id'];

// Requête SQL avec PDO
$sql = "SELECT id, nom, prenom, genre, contact, adresse 
        FROM gestionnaire
        WHERE  id = :id"; 
        
$req = $connection->prepare($sql);

// Liaison des paramètres
$req->bindParam(':id', $id_gestionnaire);

// Exécution de la requête
$req->execute();

// Vérification des erreurs de requête
if (!$req) {
    die("Erreur dans la requête SQL: " . $connection->error);
}

// Récupération des résultats
while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
    $zz = $row['id'];
    $zzz = $row['nom'];
    $A = $row['prenom'];
   // $B = $row['genre'];
    $C = $row['contact'];
    $D = $row['adresse'];
    //$E = $row['nom_station'];
    
}

?>
<center><div class="card shadow mb-4 col-xs-12 col-md-8 border-bottom-primary">
    <div class="card-header py-3">
        <h4 class="m-2 font-weight-bold text-primary">Modifier Mananger</h4>
    </div><a  type="button" class="btn btn-primary bg-gradient-primary btn-block" href="employee.php"> <i class="fas fa-flip-horizontal fa-fw fa-share"></i>Retour</a>
    <div class="card-body">
        <form role="form" method="post" action="emp_edit1.php">
            <input type="hidden" name="id" value="<?php echo $zz; ?>" />
            <div class="form-group row text-left text-warning">
                <div class="col-sm-3" style="padding-top: 5px;">
                    Nom:
                </div>
                <div class="col-sm-9">
                    <input class="form-control" placeholder="Nom" name="nom" value="<?php echo $zzz; ?>" required>
                </div>
            </div>
            <div class="form-group row text-left text-warning">
                <div class="col-sm-3" style="padding-top: 5px;">
                    Prénom:
                </div>
                <div class="col-sm-9">
                    <input class="form-control" placeholder="Prenon" name="prenom" value="<?php echo $A; ?>" required>
                </div>
            </div>
            <div class="form-group row text-left text-warning">
                <div class="col-sm-3" style="padding-top: 5px;">
                    Genre:
                </div>
                <div class="col-sm-9">
                    <select class='form-control' name='genre' required>
                        <option value="" disabled selected hidden>Select Genre</option>
                        <option value="Homme">Homme</option>
                        <option value="Femme">Femme</option>
                    </select>
                </div>
            </div>
            <div class="form-group row text-left text-warning">
                <div class="col-sm-3" style="padding-top: 5px;">
                    Email:
                </div>
                <div class="col-sm-9">
                    <input class="form-control" placeholder="Email" name="adresse" value="<?php echo $D; ?>" required>
                </div>
            </div>
            <div class="form-group row text-left text-warning">
                <div class="col-sm-3" style="padding-top: 5px;">
                    Telephone:
                </div>
                <div class="col-sm-9">
                    <input class="form-control" placeholder="Téléphone" name="contact" value="<?php echo $C; ?>" required>
                </div>
            </div>
            <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                        Date Modification:
                    </div>
                    <div class="col-sm-9">
                    <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" class="form-control" placeholder=" Date Modification" name="date_modif" required>
                    </div>
                </div>
            <hr>
            <button type="submit" class="btn btn-warning btn-block"><i class="fa fa-edit fa-fw"></i>Modifier</button>    
        </form>  
    </div>
</div></center>
<?php include '../../includesStation/footer.php'; ?>