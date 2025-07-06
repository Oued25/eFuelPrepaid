<?php
   include '../../includesStation/connection.php'; 
   include '../../includesStation/sidebar.php'; 
            

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) { 
  header('Location: login.php');
  exit();
}
 
$user = $_SESSION;

// Requête SQL pour récupérer les données des utilisateurs de la même compagnie
$sql = "SELECT t.id, t.code_trans, t.date_creation, cl.contact, p.nom_produit, t.Prix_achat,t.quantite, cat.nom_categorie,
              cl.nom_societe, s.nom_station, st.nom_statut, c.nom_compagnie AS StationCompanyName  
        FROM  transaction t
        LEFT JOIN  produit p ON t.id_produit = p.id
        LEFT JOIN categorie cat ON p.id_categorie = cat.id
        LEFT JOIN  station s ON t.id_station = s.id
         LEFT JOIN  statut st ON t.id_statut = st.id
        LEFT JOIN compagnie c ON s.id_compagnie = c.id
        LEFT JOIN utilisateur u ON t.id_user = u.id
        LEFT JOIN client cl ON u.id_client = cl.id OR t.id_client = cl.id
        WHERE t.id_station = :id_station
        ORDER BY  t.date_creation DESC";

$req = $connection->prepare($sql);
$req->bindParam(':id_station', $user['id_station']);
$req->execute();

?>           
  <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h4 class="m-2 font-weight-bold text-primary">Transaction</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"> 
                <thead>
                    <tr>
                      <th>Numéro Transaction</th> 
                      <th>Produit</th>
                      <th>Prix Total</th>
                      <th>Nom Station</th>
                      <th>Statut</th>
                      <th width="11%">Action</th>
                    </tr>
                </thead>
                <tbody> 
                <?php 
                    // Affichage des données récupérées
                    while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>".$row['code_trans']."</td>"; 
                        echo "<td>".$row['nom_produit']."</td>";
                        echo "<td>".$row['Prix_achat']."</td>"; 
                        echo "<td>".$row['nom_station']."</td>";
                        echo "<td>".$row['nom_statut']."</td>";
                        echo '<td align="right">
                                <div class="btn-group">
                                  <a type="button" class="btn btn-success bg-gradient-success" 
                                    href="trans_update.php?code_trans='.$row['code_trans'].'&id_statut=3">
                                    Valider
                                  </a>
                                  <a type="button" class="btn btn-danger bg-gradient-danger" 
                                    href="trans_update.php?code_trans='.$row['code_trans'].'&id_statut=2">
                                    Bloquer
                                  </a>
                                  <a type="button" class="btn btn-warning bg-gradient-warning" 
                                    href="trans_update.php?code_trans='.$row['code_trans'].'&id_statut=4">
                                    Annuler
                                  </a>
                                  <a type="button" class="btn btn-primary bg-gradient-primary" 
                                    href="trans_view.php"> <!-- <i class="fas fa-fw fa-th-list"></i>-->
                                    Détail
                                  </a> 

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

    <?php include '../../includesStation/footer.php'; ?>
