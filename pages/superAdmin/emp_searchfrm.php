<?php
include '../../includes/connection.php'; 
include '../../includes/sidebar.php';

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
        <h4 class="m-2 font-weight-bold text-primary">Détails Client</h4>
    </div>
    <a href="employee.php" type="button" class="btn btn-primary bg-gradient-primary btn-block"> <i class="fas fa-flip-horizontal fa-fw fa-share"></i> Retour </a>
    <div class="card-body">
    <?php

        $id_client = $_GET['id'];

        // Requête SQL avec PDO
        $sql = "SELECT c.id AS id, c.nom, c.prenom, c.genre, nom_societe, tel_payement, c.contact, c.adresse, t.nom_type, c.doc_identification, c.num_doc, c.date_creation, c.date_modif
                FROM client c, type t
                WHERE  c.id_type = t.id
                AND    c.id = :id";

        // Préparation de la requête
        $req = $connection->prepare($sql);

        // Liaison des paramètres
        $req->bindParam(':id', $id_client);

        // Exécution de la requête
        $req->execute();

        // Vérification des erreurs de requête
        if (!$req) {
            die("Erreur dans la requête SQL: " . $connection->error);
        }

        // Récupération des résultats
        while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
            //$zz = $row['id'];
            $zzz = $row['nom'];
            $i = $row['prenom'];
            $a = $row['genre'];
            $soct = $row['nom_societe'];
            $b = $row['contact'];
            $c = $row['adresse'];
            $d = $row['doc_identification'];
            $e = $row['num_doc'];
            $f = $row['date_creation'];
            $g = $row['date_modif'];
            $h = $row['nom_type'];
            $j = $row['tel_payement'];
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
                Type du Client<br>
                </h5>
            </div>
            <div class="col-sm-9">
                <h5>
                <?php echo $h; ?> <br>
                </h5>
            </div>
        </div>
        <div class="form-group row text-left">
            <div class="col-sm-3 text-primary">
                <h5>
                Nom Entrprise<br>
                </h5>
            </div>
            <div class="col-sm-9">
                <h5>
                <?php echo $soct; ?> <br>
                </h5>
            </div>
        </div>
        <div class="form-group row text-left">
            <div class="col-sm-3 text-primary">
                <h5>
                Tél Payement<br>
                </h5>
            </div>
            <div class="col-sm-9">
                <h5>
                <?php echo $j; ?> <br>
                </h5>
            </div>
        </div>
        <div class="form-group row text-left">
            <div class="col-sm-3 text-primary">
                <h5>
                Document D'identification<br>
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
                N° Document<br>
                </h5>
            </div>
            <div class="col-sm-9">
                <h5>
                <?php echo $e; ?> <br>
                </h5>
            </div>
        </div>
        <div class="form-group row text-left">
            <div class="col-sm-3 text-primary">
                <h5>
                    Contact<br>
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
                    Adresse<br>
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
                    Date Creation<br>
                </h5>
            </div>
            <div class="col-sm-9">
                <h5>
                <?php echo $f; ?> <br>
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
                <?php echo $g; ?> <br>
                </h5>
            </div>
        </div>
    </div>
</div></center>
<?php include '../../includes/footer.php'; ?>
