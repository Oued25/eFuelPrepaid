<?php  
include($_SERVER['DOCUMENT_ROOT'] . '/Projet_eFuelPrepaid_fin/includesCompag/connection.php');
include($_SERVER['DOCUMENT_ROOT'] . '/Projet_eFuelPrepaid_fin/includesCompag/sidebar.php');

// Démarrer la session et récupérer l'ID de la compagnie connectée
$id_compagnie_connectee = $_SESSION['id_compagnie'];

// Requête SQL pour récupérer les données des stations appartenant à la compagnie connectée
$sql = "SELECT S.id AS id, s.code_station, s.nom_station, s.id_compagnie, cpa.nom_compagnie, s.contact, s.adresse, s.localisation, s.compte_paiementStation, s.date_creation
        FROM station AS s
        JOIN compagnie AS cpa ON s.id_compagnie = cpa.id
        WHERE s.id_compagnie = :id_compagnie_connectee
        ORDER BY s.id ASC";

$req = $connection->prepare($sql);
$req->bindParam(':id_compagnie_connectee', $id_compagnie_connectee, PDO::PARAM_INT);
$req->execute(); // Exécuter la requête avec le paramètre de liaison
$compagnies = $req->fetch(PDO::FETCH_ASSOC);
// Vérification des erreurs de requête
if (!$req) {
    die("Erreur dans la requête SQL: " . $connection->error);
}


// Requête SQL pour récupérer le nom de la compagnie de la station connectée
$sql_compagnie = "SELECT nom_compagnie FROM compagnie WHERE id = :id_compagnie_connectee ";
$req_compagnie = $connection->prepare($sql_compagnie);
$req_compagnie->bindParam(':id_compagnie_connectee', $id_compagnie_connectee, PDO::PARAM_INT);
$req_compagnie->execute();
$compagnie = $req_compagnie->fetch(PDO::FETCH_ASSOC);

// Vérification des erreurs de requête
if (!$req_compagnie) {
    die("Erreur dans la requête SQL: " . $connection->error);
}

$nom_compagnie = $compagnie['nom_compagnie'];
$id_compagnie = $compagnies['id_compagnie'];
?>

<div class="card shadow mb-4">
 <div class="card-header py-3">
    <h4 class="m-2 font-weight-bold text-primary">Station&nbsp;<a href="#" data-toggle="modal" data-target="#sModal" type="button" class="btn btn-primary bg-gradient-primary" style="border-radius: 0px;"><i class="fas fa-fw fa-plus"></i></a></h4>
  </div> 
            
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">        
        <thead>
          <tr>
            <th>Code Station</th>
            <th>Nom Station</th>
            <!-- <th>Nom Compagnie</th>   -->
            <th>Téléphone</th>
            <th>Adresse</th>
            <th>Localisation</th>
            <th>Compte Paiement</th> 
            <th>Date Création</th>
            <th>Action</th>
          </tr>
        </thead> 
        <tbody>
          <?php 
            // Affichage des données récupérées
            while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>".$row['code_station']."</td>"; 
                echo "<td>".$row['nom_station']."</td>";
                //echo "<td>".$row['nom_compagnie']."</td>";
                echo "<td>".$row['contact']."</td>";
                echo "<td>".$row['adresse']."</td>";
                echo "<td>".$row['localisation']."</td>";
                echo "<td>".$row['compte_paiementStation']."</td>";
                echo "<td>".$row['date_creation']."</td>";
                echo '<td align="right">
                        <div class="btn-group">
                            <a type="button" class="btn btn-primary bg-gradient-primary"  href="cust_searchfrm.php?action=edit&id='.$row['code_station'] . '"><i class="fas fa-fw fa-list-alt"></i> Details</a>
                            <div class="btn-group">
                            <a type="button" class="btn btn-primary bg-gradient-primary dropdown no-arrow" data-toggle="dropdown" style="color:white;">... <span class="caret"></span></a>
                            <ul class="dropdown-menu text-center" role="menu">
                                <li>
                                <a type="button" class="btn btn-warning bg-gradient-warning btn-block" style="border-radius: 0px;" href="cust_edit.php?action=edit&id='.$row['id']. '"><i class="fas fa-fw fa-edit"></i> Modifier</a>
                                </li>
                            </ul>
                            </div>
                        </div>
                    </td>';
                echo "</tr>";
            }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/Projet_eFuelPrepaid_fin/includesCompag/footer.php'); ?>

<!-- Modal pour ajouter une station -->
<div class="modal fade" id="sModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ajouter Station</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form role="form" method="post" action="cust_transac.php?action=add">
            <div class="form-group">
              <input class="form-control" placeholder="Code Station" name="code_station" required>
            </div> 
            <div class="form-group">
              <input class="form-control" placeholder="Nom Station" name="nom_station" required>
            </div>
            <div class="form-group">
                <input class="form-control" name="nom_compagnie" value="<?php echo $nom_compagnie; ?>" readonly>
                <input type="hidden" name="id_compagnie" value="<?php echo $id_compagnie; ?>">
            </div>

            <div class="form-group">
              <input class="form-control" placeholder="Téléphone" name="contact" required>
            </div>
            <div class="form-group">
              <input class="form-control" placeholder="Adresse Mail" name="adresse" required>
            </div>
            
            <div class="form-group">
              <input class="form-control" placeholder="Localisation" name="localisation" required>
            </div>
            <div class="form-group">
              <input class="form-control" placeholder="Compte Paiement" name="compte_paiementStation" required>
            </div>
            <hr>
            <button type="submit" class="btn btn-success"><i class="fa fa-check fa-fw"></i>Validez</button>
            <button type="reset" class="btn btn-danger"><i class="fa fa-times fa-fw"></i>Réinitialiser</button>
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>      
          </form>  
        </div>
      </div>
    </div>
</div>
