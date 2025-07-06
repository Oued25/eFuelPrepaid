<?php 
include '../../includesSociete/connection.php'; 
include '../../includesSociete/sidebar.php'; 

// Requête SQL pour récupérer les données des gestionnaires
$sql = "SELECT id, nom, prenom, genre, contact, adresse, date_creation 
        FROM gestionnaire";

// Préparation de la requête
$req = $connection->prepare($sql);
$req->execute(); // Exécution de la requête

// Vérification des erreurs de requête
if (!$req) {
    die("Erreur dans la requête SQL: " . $connection->error);
}

?>

<div class="card shadow mb-4" id="employee">
  <div class="card-header py-3">
    <h4 class="m-2 font-weight-bold text-primary">Manager&nbsp;<a href="#" data-toggle="modal" data-target="#eModal" type="button" class="btn btn-primary bg-gradient-primary" style="border-radius: 0px;"><i class="fas fa-fw fa-plus"></i></a></h4>
  </div>
            
  <div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">        
            <thead> 
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Genre</th>
                    <th>Téléphone</th>
                    <th>Adresse</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                    // Affichage des données récupérées
                    while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>".$row['nom']."</td>"; 
                        echo "<td>".$row['prenom']."</td>";
                        echo "<td>".$row['genre']."</td>";
                        echo "<td>".$row['contact']."</td>";
                        echo "<td>".$row['adresse']."</td>";
                        echo "<td>".$row['date_creation']."</td>";
                        echo '<td align="right">
                                <div class="btn-group">
                                    <a type="button" class="btn btn-primary bg-gradient-primary"  href="emp_searchfrm.php?action=edit & id='.$row['id'] . '"><i class="fas fa-fw fa-list-alt"></i> Details</a>
                                    <div class="btn-group">
                                    <a type="button" class="btn btn-primary bg-gradient-primary dropdown no-arrow" data-toggle="dropdown" style="color:white;">... <span class="caret"></span></a>
                                    <ul class="dropdown-menu text-center" role="menu">
                                        <li>
                                        <a type="button" class="btn btn-warning bg-gradient-warning btn-block" style="border-radius: 0px;" href="emp_edit.php?action=edit&id='.$row['id']. '"><i class="fas fa-fw fa-edit"></i> Modifier</a>
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

<?php include '../../includesSociete/footer.php'; ?>


<!--  Modal pour ajouter un Manager-->
<div class="modal fade" id="eModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ajouter Manager</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form role="form" method="post" action="emp_transac.php?action=add">          
              <div class="form-group">
                <input class="form-control" placeholder="Nom" name="nom" required>
              </div>
              <div class="form-group">
                <input class="form-control" placeholder="Prénom" name="prenom" required>
              </div>
              <div class="form-group">
                <input class="form-control" placeholder="Adresse" name="adresse" required>
              </div>
              <div class="form-group">
                <input class="form-control" placeholder="Téléphone" name="contact" required>
              </div>
              <div class="form-group">
                  <select class='form-control' name='genre' required>
                    <option value="" disabled selected hidden>Choisir Genre</option>
                    <option value="Homme">Homme</option>
                    <option value="Femme">Femme</option>
                  </select>
              </div>
              <div class="form-group ">
                <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" class="form-control" placeholder=" Date Création" name="date_creation" required>
               </div>
              <hr>
            <button type="submit" class="btn btn-success"><i class="fa fa-check fa-fw"></i>Valider</button>
            <button type="reset" class="btn btn-danger"><i class="fa fa-times fa-fw"></i>Réinitialiser</button>
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>      
          </form>  
        </div>
      </div>
    </div>
  </div>