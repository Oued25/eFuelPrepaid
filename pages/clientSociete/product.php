<?php 
include '../../includesSociete/connection.php'; 
include '../../includesSociete/sidebar.php';

$id_compagnie_connectee = $_SESSION['id_compagnie'];

// Requête SQL pour récupérer les données de la table "produit"
$sql = "SELECT p.id AS id, code_produit, nom_produit, p.id_compagnie, description, p.date_creation, prix_unitaire, nom_categorie, nom_compagnie
        FROM produit AS P
        JOIN categorie AS c ON p.id_categorie = c.id
        JOIN compagnie AS cpa ON p.id_compagnie = cpa.id"; // Utilisation du paramètre de liaison :id
        
$req = $connection->prepare($sql);
//$req->bindParam(':id_compagnie_connectee', $id_compagnie_connectee, PDO::PARAM_INT); // Liaison du paramètre de :id avec la valeur $id_produit
$req->execute(); // Exécutez la requête avec le paramètre de liaison

// Vérification des erreurs de requête
if (!$req) {
    die("Erreur dans la requête SQL: " . $connection->error);
}

?>

<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h4 class="m-2 font-weight-bold text-primary">Produits&nbsp;<a href="#" data-toggle="modal" data-target="#aModal" type="button" class="btn btn-primary bg-gradient-primary" style="border-radius: 0px;"><i class="fas fa-fw fa-plus"></i></a></h4>
  </div>
            
  <div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">        
            <thead>
                <tr>
                    <th>Code Produit</th> 
                    <th>Nom Produit</th>
                    <th>Description</th>
                    <th>Prix Unitaire</th>
                    <th>Catégorie</th>
                    <th>Nom Compagnie</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            
            <?php 
                    // Affichage des données récupérées
                    while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>".$row['code_produit']."</td>"; 
                        echo "<td>".$row['nom_produit']."</td>";
                        echo "<td>".$row['description']."</td>";
                        echo "<td>".$row['prix_unitaire']."</td>";
                        echo "<td>".$row['nom_categorie']."</td>";
                        echo "<td>".$row['nom_compagnie']."</td>";
                        echo '<td align="right">
                                <div class="btn-group">
                                    <a type="button" class="btn btn-primary bg-gradient-primary"  href="pro_searchfrm.php?action=edit & id='.$row['code_produit'] . '"><i class="fas fa-fw fa-list-alt"></i> Details</a>
                                    <div class="btn-group">
                                    <a type="button" class="btn btn-primary bg-gradient-primary dropdown no-arrow" data-toggle="dropdown" style="color:white;">... <span class="caret"></span></a>
                                    <ul class="dropdown-menu text-center" role="menu">
                                        <li>
                                        <a type="button" class="btn btn-warning bg-gradient-warning btn-block" style="border-radius: 0px;" href="pro_edit.php?action=edit&id='.$row['code_produit']. '"><i class="fas fa-fw fa-edit"></i> Modifier</a>
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

