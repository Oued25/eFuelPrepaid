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
$row = $stmt->fetch(PDO::FETCH_ASSOC); 
$Aa = $row['TYPE'];

if ($Aa == 'User') { 
?>
<script type="text/javascript">
    //then it will be redirected
    alert("Page restreinte ! Vous serez redirigé vers POS"); 
    window.location = "pos.php";
</script>
<?php
}

// Récupération des détails de l'employé
$query = 'SELECT EMPLOYEE_ID, FIRST_NAME, LAST_NAME, GENDER, EMAIL, PHONE_NUMBER, j.JOB_TITLE, HIRED_DATE, l.PROVINCE, l.CITY FROM employee e join location l on e.LOCATION_ID = l.LOCATION_ID join job j on j.JOB_ID=e.JOB_ID WHERE e.EMPLOYEE_ID = :id';
$stmt = $connexion->prepare($query);
$stmt->bindParam(':id', $_GET['id']);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$zz = $row['EMPLOYEE_ID'];
$i = $row['FIRST_NAME'];
$ii = $row['LAST_NAME'];
$iii = $row['GENDER'];
$a = $row['EMAIL'];
$b = $row['PHONE_NUMBER'];
$c = $row['JOB_TITLE'];
$d = $row['HIRED_DATE'];
$f = $row['PROVINCE'];
$g = $row['CITY'];
$id = $_GET['id'];
*/

?>
<center><div class="card shadow mb-4 col-xs-12 col-md-8 border-bottom-primary">
    <div class="card-header py-3">
        <h4 class="m-2 font-weight-bold text-primary">Détails Mananger</h4>
    </div>
    <a href="employee.php" type="button" class="btn btn-primary bg-gradient-primary btn-block"> <i class="fas fa-flip-horizontal fa-fw fa-share"></i> Retour </a>
    <div class="card-body">
    <?php

        $id_gestionnaire = $_GET['id'];

        // Requête SQL avec PDO
        $sql = "SELECT g.id AS id, g.nom, g.prenom, genre, g.contact, g.adresse, g.date_creation, g.date_modif, nom_station
        FROM gestionnaire AS g, station AS s
        WHERE  g.id = :id";

        // Préparation de la requête
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
            //$zz = $row['id_gestionnaire'];
            $zzz = $row['nom'];
            $i = $row['prenom'];
            $a = $row['genre'];
            $b = $row['contact'];
            $c = $row['adresse'];
            $d = $row['date_creation'];
            $e = $row['date_modif'];
            
        
        }

        ?>
        <div class="form-group row text-left">
            <div class="col-sm-3 text-primary">
                <h5>
                    Nom complet<br>
                </h5>
            </div>
            <div class="col-sm-9">
                <h5>
                <?php echo $zzz; ?> <?php echo $i; ?><br>
                </h5>
            </div>
        </div>
        <div class="form-group row text-left">
            <div class="col-sm-3 text-primary">
                <h5>
                    Genre<br>
                </h5>
            </div>
            <div class="col-sm-9">
                <h5>
                <?php echo $a; ?><br>
                </h5>
            </div>
        </div>
        <div class="form-group row text-left">
            <div class="col-sm-3 text-primary">
                <h5>
                    Email<br>
                </h5>
            </div>
            <div class="col-sm-9">
                <h5>
                <?php echo $c; ?><br>
                </h5>
            </div>
        </div>
        <div class="form-group row text-left">
            <div class="col-sm-3 text-primary">
                <h5>
                    Téléphone<br>
                </h5>
            </div>
            <div class="col-sm-9">
                <h5>
                <?php echo $b; ?> <br>
                </h5>
            </div>
        </div>
        <div class="form-group row text-left">
            <div class="col-sm-3 text-primary">
                <h5>
                    Date Creation<br>
                </h5>
            </div>
            <div class="col-sm-9">
                <h5>
                <?php echo $d; ?> <br>
                </h5>
            </div>
        </div>
        <div class="form-group row text-left">
            <div class="col-sm-3 text-primary">
                <h5>
                    Date Modification<br>
                </h5>
            </div>
            <div class="col-sm-9">
                <h5>
                <?php echo $e; ?> <br>
                </h5>
            </div>
        </div>
    </div>
</div></center>

<?php
 include '../../includesStation/footer.php'; 
?>
