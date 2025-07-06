<?php 
include '../../includes/connection.php'; 
include '../../includes/sidebar.php'; 

// Démarrer la session et récupérer l'ID de la compagnie connectée

//$id_compagnie_connectee = $_SESSION['id_compagnie'];

// Requête SQL pour récupérer les données des stations appartenant à la compagnie connectée
$sql = "SELECT s.id AS id, s.code_station, s.nom_station, s.id_compagnie, s.contact, s.adresse, s.localisation, s.compte_paiementStation, cpa.nom_compagnie, s.date_creation
        FROM station AS s
        JOIN compagnie AS cpa ON s.id_compagnie = cpa.id
       /* WHERE s.id_compagnie = :id_compagnie_connectee*/
        ORDER BY s.date_creation ASC";

$req = $connection->prepare($sql);
$req->execute(); // Exécuter directement sans bindParam

// Vérification des erreurs de requête
if (!$req) {
    die("Erreur dans la requête SQL: " . $connection->error);
}
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
            <th>Nom Compagnie</th>   
            <!--<th>Téléphone</th>-->
            <th>Adresse</th>
            <th>Localisation</th>
            <!--<th>Compte Paiement</th> -->
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
                echo "<td>".$row['nom_compagnie']."</td>";
                /*echo "<td>".$row['contact']."</td>";*/
                echo "<td>".$row['adresse']."</td>";
                echo "<td>".$row['localisation']."</td>";
                /*echo "<td>".$row['compte_paiementStation']."</td>";*/
                echo "<td>".$row['date_creation']."</td>";
                echo '<td align="right">
                        <div class="btn-group">
                            <a type="button" class="btn btn-primary bg-gradient-primary"  href="stat_searchfrm.php?action=edit&id='.$row['code_station'] . '"><i class="fas fa-fw fa-list-alt"></i> Details</a>
                            <div class="btn-group">
                            <a type="button" class="btn btn-primary bg-gradient-primary dropdown no-arrow" data-toggle="dropdown" style="color:white;">... <span class="caret"></span></a>
                            <ul class="dropdown-menu text-center" role="menu">
                                <li>
                                <a type="button" class="btn btn-warning bg-gradient-warning btn-block" style="border-radius: 0px;" href="stat_edit.php?action=edit&id='.$row['id']. '"><i class="fas fa-fw fa-edit"></i> Modifier</a>
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

<?php include '../../includes/footer.php'; ?>

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
          <form role="form" method="post" action="stat_transac.php?action=add">
            <div class="form-group">
              <input class="form-control" placeholder="Code Station" name="code_station" required>
            </div> 
            <div class="form-group">
              <input class="form-control" placeholder="Nom Station" name="nom_station" required>
            </div>
            <div class="form-group">
                        <select class="form-control" name="id_compagnie" id="id_compagnie">
                            <option value="">Choisir une Compagnie</option>
                            <?php
                                // Requête SQL pour récupérer les compagnies depuis la base de données
                                $sql = "SELECT id, nom_compagnie FROM compagnie";
                                $req = $connection->prepare($sql); 
                                $req->execute();

                                // Affichage des options du menu déroulant
                                while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                                    echo '<option value="' . $row['id'] . '">' . $row['nom_compagnie'] . '</option>';
                                }
                            ?>
                        </select>
                    </div>
            <div class="form-group">
              <input class="form-control" placeholder="Téléphone" name="contact" required>
            </div>
            <div class="form-group">
              <input class="form-control" placeholder="Adresse" name="adresse" required>
            </div>
            <div class="form-group">
              <input class="form-control" placeholder="Compte Paiement" name="compte_paiementStation" required>
            </div>
            <div class="form-group">
              <input class="form-control" placeholder="Localisation" name="localisation" required>
            </div>
            <!--<div class="form-group">
              <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" class="form-control" placeholder="Date " name="date_creation" required>
            </div>-->
            <hr>
            <button type="submit" class="btn btn-success"><i class="fa fa-check fa-fw"></i>Validez</button>
            <button type="reset" class="btn btn-danger"><i class="fa fa-times fa-fw"></i>Réinitialiser</button>
            <button type="button" class="btn btn-secondary"data-dismiss="modal">Annuler</button>      
          </form>  
        </div>
      </div>
    </div>
</div>
