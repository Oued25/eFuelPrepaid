<?php 
include '../../includes/connection.php';
include '../../includes/sidebar.php';  

// Assurez-vous que vous recevez l'ID de produit à rechercher
//$id_produit = $_GET['id']; // Assurez-vous que $_GET['id'] contient l'ID du produit 

$id_compagnie_connectee = $_SESSION['id_compagnie'];
// Requête SQL pour récupérer les données de la table "produit"
$sql = " SELECT p.id AS id, code_produit, nom_produit, p.id_compagnie, cpa.nom_compagnie, p.description, p.date_creation, prix_unitaire, nom_categorie 
        FROM produit AS p
        JOIN categorie AS c ON p.id_categorie = c.id
        JOIN compagnie AS cpa ON p.id_compagnie = cpa.id"; 
$req = $connection->prepare($sql);
$req->execute(); // Exécuter directement sans bindParam
$compagnies = $req->fetch(PDO::FETCH_ASSOC);
// Vérification des erreurs de requête
if (!$req) {
    die("Erreur dans la requête SQL: " . $connection->error);
}
//$id_compagnie = $compagnies['id_compagnie'];
//$nom_compagnie = $compagnies['nom_compagnie'];
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
                                    <a type="button" class="btn btn-primary bg-gradient-primary"  href="pro_searchfrm.php?action=edit & id='.$row['id'] . '"><i class="fas fa-fw fa-list-alt"></i> Details</a>
                                    <div class="btn-group">
                                    <a type="button" class="btn btn-primary bg-gradient-primary dropdown no-arrow" data-toggle="dropdown" style="color:white;">... <span class="caret"></span></a>
                                    <ul class="dropdown-menu text-center" role="menu">
                                        <li>
                                        <a type="button" class="btn btn-warning bg-gradient-warning btn-block" style="border-radius: 0px;" href="pro_edit.php?action=edit&id='.$row['id']. '"><i class="fas fa-fw fa-edit"></i> Modifier</a>
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


<!-- Product Modal-->
<div class="modal fade" id="aModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajouter Produit</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span> 
                </button>
            </div>
            <div class="modal-body">
                <form role="form" method="post" action="pro_transac.php?action=add">
                    <div class="form-group">
                        <input class="form-control" placeholder="Code Produit" name="code_produit" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Nom Produit" name=" nom_produit" required>
                    </div>
                    <div class="form-group">
                        <input type="number"  min="1" max="9999999999" class="form-control" placeholder="Prix Unitaire" name="prix_unitaire" required>
                    </div>
                    <div class="form-group">
                        <textarea rows="5" cols="50" class="form-control" placeholder="Description" name="description" required></textarea>
                    </div>
                    <div class="form-group">
                    <select class="form-control" name="id_categorie" id="id_categorie">
                        <option value="">--Choisir une catégorie--</option><!-- cette option permette de ne pas afficher une Categorie par defaut dans le inpute-->
                        <?php
                            // Requête SQL pour récupérer les catégories depuis la base de données
                            $sql = "SELECT id, nom_categorie FROM categorie";
                            $req = $connection->prepare($sql); 
                            $req->execute();

                            // Affichage des options du menu déroulant
                            while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="' . $row['id'] . '">' . $row['nom_categorie'] . '</option>';
                            }
                        ?>
                    </select>
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
                    <hr>
                    <button type="submit" class="btn btn-success"><i class="fa fa-check fa-fw"></i>Enregistrer</button>
                    <button type="reset" class="btn btn-danger"><i class="fa fa-times fa-fw"></i>Regnitiliser</button>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>      
                </form>  
            </div>
        </div>
    </div>
</div>
