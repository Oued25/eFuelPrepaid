<?php
include '../../includes/connection.php'; 
include '../../includes/sidebar.php';

$id_client = $_GET['id'];

// Requête SQL avec PDO
$sql = "SELECT c.id, nom, prenom, genre, nom_societe, contact, adresse, tel_payement, t.nom_type, c.doc_identification, c.num_doc
        FROM client AS c
        JOIN type AS t ON c.id_type = t.id 
        WHERE c.id = :id"; 
        
$req = $connection->prepare($sql);

// Liaison des paramètres
$req->bindParam(':id', $id_client, PDO::PARAM_INT);

// Exécution de la requête
$req->execute();

// Vérification des erreurs de requête
if (!$req) {
    die("Erreur dans la requête SQL: " . $connection->error);
}

// Récupération des résultats
$row = $req->fetch(PDO::FETCH_ASSOC);
if ($row) {
    $zz = $row['id'];
    $zzz = $row['nom'];
    $G = $row['nom_type'];
    $soct = $row['nom_societe'];
    $A = $row['prenom'];
    $B = $row['tel_payement'];
    $C = $row['doc_identification'];
    $D = $row['num_doc'];
    $E = $row['contact'];
    $F = $row['adresse'];
} else {
    die("Client non trouvé."); 
}

?>

<center>
<div class="card shadow mb-4 col-xs-12 col-md-8 border-bottom-primary">
    <div class="card-header py-3">
        <h4 class="m-2 font-weight-bold text-primary">Modifier Client</h4>
    </div>
    <a type="button" class="btn btn-primary bg-gradient-primary btn-block" href="employee.php">
        <i class="fas fa-flip-horizontal fa-fw fa-share"></i>Retour
    </a>
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
                    <input class="form-control" placeholder="Prenom" name="prenom" value="<?php echo $A; ?>" required>
                </div>
            </div>
            <div class="form-group row text-left text-warning">
                <div class="col-sm-3" style="padding-top: 5px;">
                    Genre:
                </div>
                <div class="col-sm-9">
                    <select class='form-control' name='genre' required>
                        <option value="" disabled selected hidden>Choisir un Genre</option>
                        <option value="Homme" <?php if ($row['genre'] == 'Homme') echo 'selected'; ?>>Homme</option>
                        <option value="Femme" <?php if ($row['genre'] == 'Femme') echo 'selected'; ?>>Femme</option>
                    </select>
                </div>
            </div>
            <div class="form-group row text-left text-warning">
                <div class="col-sm-3" style="padding-top: 5px;">
                    Tél Payement:
                </div>
                <div class="col-sm-9">
                    <input class="form-control" placeholder=" Tél Payement" name="tel_payement" value="<?php echo $B; ?>" required>
                </div>
            </div>
            <div class="form-group row text-left text-warning">
                <div class="col-sm-3" style="padding-top: 5px;">
                    Document Identification:
                </div>
                <div class="col-sm-9">
                    <input class="form-control" placeholder=" Document Identification" name="doc_identification" value="<?php echo $C; ?>" required>
                </div>
            </div>
            <div class="form-group row text-left text-warning">
                <div class="col-sm-3" style="padding-top: 5px;">
                    N° Document:
                </div>
                <div class="col-sm-9">
                    <input class="form-control" placeholder=" N° Document" name="num_doc" value="<?php echo $D; ?>" required>
                </div>
            </div>
            <div class="form-group row text-left text-warning">
                <div class="col-sm-3" style="padding-top: 5px;">
                    Type Client:
                </div>
                <div class="col-sm-9">
                    <select class="form-control" name="id_type" id="id_type" required>
                        <option value="">Choisir un Type</option><!-- cette option permette de ne pas afficher une type par defaut dans le inpute-->
                        <?php
                        // Requête SQL pour récupérer les types depuis la base de données
                        $sql_type = "SELECT id, nom_type FROM type";
                        $req_type = $connection->prepare($sql_type);
                        $req_type->execute();

                        // Affichage des options du menu déroulant
                        while ($row_type = $req_type->fetch(PDO::FETCH_ASSOC)) {
                            $selected = ($row_type['id'] == $row['id_type']) ? 'selected' : '';
                            echo '<option value="' . $row_type['id'] . '" ' . $selected . '>' . $row_type['nom_type'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group row text-left text-warning">
                <div class="col-sm-3" style="padding-top: 5px;">
                    Nom Entrprise:
                </div>
                <div class="col-sm-9">
                    <input class="form-control" placeholder="Nom Entrprise" name="nom_societe" value="<?php echo $soct; ?>" required>
                </div>
            </div>
            <div class="form-group row text-left text-warning">
                <div class="col-sm-3" style="padding-top: 5px;">
                    Email:
                </div>
                <div class="col-sm-9">
                    <input class="form-control" placeholder="Email" name="adresse" value="<?php echo $F; ?>" required>
                </div>
            </div>
            <div class="form-group row text-left text-warning">
                <div class="col-sm-3" style="padding-top: 5px;">
                    Telephone:
                </div>
                <div class="col-sm-9">
                    <input class="form-control" placeholder="Téléphone" name="contact" value="<?php echo $E; ?>" required>
                </div>
            </div>
           <!-- <div class="form-group row text-left text-warning">
                <div class="col-sm-3" style="padding-top: 5px;">
                    Date Modification:
                </div>
                <div class="col-sm-9">
                    <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" class="form-control" placeholder=" Date Modification" name="date_modif" required>
                </div>
            </div> -->
           
            <hr>
            <button type="submit" class="btn btn-warning btn-block"><i class="fa fa-edit fa-fw"></i>Modifier</button>    
        </form>  
    </div>
</div></center>

<?php include '../../includes/footer.php'; ?>
