<?php 
      include  '../../includes/connection.php';
      include  '../../includes/sidebar.php';


      // Assurez-vous que vous recevez l'ID de produit à rechercher
      //$id_produit = $_GET['id']; // Assurez-vous que $_GET['id'] contient l'ID du produit

      // Requête SQL pour récupérer les données de la table "produit"

      $sql = "SELECT id, code_compagnie, nom_compagnie, contact, adresse, localisation, compte_paiement, date_creation
              FROM compagnie "; 


      $req = $connection->prepare($sql);
      //$req->bindParam(':id', $id_produit); // Liaison du paramètre de :id avec la valeur $id_produit
      $req->execute(); // Exécutez la requête avec le paramètre de liaison

      // Vérification des erreurs de requête
      if (!$req) {
          die("Erreur dans la requête SQL: " . $connection->error);
      }
?>

<div class="card shadow mb-4">
 <div class="card-header py-3">
    <h4 class="m-2 font-weight-bold text-primary">Compagnie&nbsp;<a href="#" data-toggle="modal" data-target="#sModal" type="button" class="btn btn-primary bg-gradient-primary" style="border-radius: 0px;"><i class="fas fa-fw fa-plus"></i></a></h4>
  </div> 
            
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">        
        <thead>
          <tr>
            <th>Code Compagnie</th>
            <th>Nom Compagnie</th>   
            <th>teléphone</th>
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
                        echo "<td>".$row['code_compagnie']."</td>"; 
                        echo "<td>".$row['nom_compagnie']."</td>";
                        echo "<td>".$row['contact']."</td>";
                        echo "<td>".$row['adresse']."</td>";
                        echo "<td>".$row['localisation']."</td>";
                        /*echo "<td>".$row['compte_paiement']."</td>";*/
                        echo "<td>".$row['date_creation']."</td>";
                      
                        echo '<td align="right">
                                <div class="btn-group">
                                    <a type="button" class="btn btn-primary bg-gradient-primary"  href="cust_searchfrm.php?action=edit & id='.$row['code_compagnie'] . '"><i class="fas fa-fw fa-list-alt"></i> Details</a>
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

<?php include '../../includes/footer.php'; ?>



 <!-- Maude de station --> 
 <div class="modal fade" id="sModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ajouter Compagnie</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form role="form" method="post" action="cust_transac.php?action=add">
          <div class="form-group">
              <input class="form-control" placeholder="Code Compagnie" name="code_compagnie" required>
            </div> 
            <div class="form-group">
              <input class="form-control" placeholder="Nom Compagnie" name="nom_compagnie" required>
            </div>
            <div class="form-group">
              <input class="form-control" placeholder="Téléphone" name="contact" required>
            </div>
            <div class="form-group">
              <input class="form-control" placeholder="Adresse" name="adresse" required>
            </div>
            <div class="form-group">
              <input class="form-control" placeholder="Compte Paiement" name="compte_paiement" required>
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
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>      
          </form>  
        </div>
      </div>
    </div>
  </div>