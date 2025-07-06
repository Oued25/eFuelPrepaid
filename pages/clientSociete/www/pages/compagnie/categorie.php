<?php 
include '../../includesCompag/connection.php'; 
include '../../includesCompag/sidebar.php'; 

// Requête SQL pour récupérer les données de la table "categorie"
$sql = "SELECT id, nom_categorie FROM categorie";
$req = $connection->prepare($sql);
$req->execute();
            
// Vérification des erreurs de requête
if (!$req) {
    die("Erreur dans la requête SQL: " . $connection->error);
}

?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h4 class="m-2 font-weight-bold text-primary">Categories&nbsp;<a href="#" data-toggle="modal" data-target="#catModal" type="button" class="btn btn-primary bg-gradient-primary" style="border-radius: 0px;"><i class="fas fa-fw fa-plus"></i></a></h4>
    </div>
            
    <div class="card-body"> 
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">        
                <thead>
                    <tr>
                        <th>N° Categorie</th>
                        <th>Nom Categorie</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Affichage des données récupérées
                    while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>".$row['id']."</td>"; // Affichez l'ID de la catégorie
                        echo "<td>".$row['nom_categorie']."</td>";
                        echo '<td align="right">
                                <div class="btn-group">
                                    <a type="button" class="btn btn-primary bg-gradient-primary" href="cat_searchfrm.php?action =edit & id='.$row['id'].'""><i class="fas fa-fw fa-list-alt"></i> Details</a>
                                    <div class="btn-group">
                                    <a type="button" class="btn btn-primary bg-gradient-primary dropdown no-arrow" data-toggle="dropdown" style="color:white;">... <span class="caret"></span></a>
                                    <ul class="dropdown-menu text-center" role="menu">
                                        <li>
                                        <a type="button" class="btn btn-warning bg-gradient-warning btn-block" style="border-radius: 0px;" href="cat_edit.php?action = edit&id='.$row['id'].'"><i class="fas fa-fw fa-edit"></i> Modifier</a>
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

<?php include '../../includesCompag/footer.php'; ?>

<!-- Product Modal-->
<div class="modal fade" id="catModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajouter Categorie</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span> 
                </button>
            </div>
            <div class="modal-body">
                <form role="form" method="post" action="cat_transac.php?action=add">
                    <div class="form-group">
                        <input class="form-control" placeholder="Nom Categorie" name="nom_categorie" required>
                    </div>
                    <div class="form-group">
                        <textarea rows="5" cols="50" class="form-control" placeholder="Description" name="descrip_categorie" required></textarea>
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
