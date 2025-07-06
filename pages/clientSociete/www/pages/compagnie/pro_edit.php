<?php
include '../../includesCompag/connection.php';  
include '../../includesCompag/sidebar.php'; 

    $id_produit = $_GET['id'];

    // Requête SQL avec PDO
    $sql = "SELECT p.id AS id, code_produit, nom_produit, description, prix_unitaire, nom_categorie 
            FROM produit AS p, categorie AS c
            WHERE c.id=p.id_categorie
            AND   p.code_produit = :id"; 

    // Préparation de la requête
    $req = $connection->prepare($sql); 

    // Liaison des paramètres
    $req->bindParam(':id', $id_produit);

    // Exécution de la requête
    $req->execute();

    // Vérification des erreurs de requête
    if (!$req) {
        die("Erreur dans la requête SQL: " . $connection->error);
    }

    // Récupération des résultats
    while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
        //$zz = $row['p.id'];
        $zzz = $row['code_produit'];
        $A = $row['nom_produit'];
        $B = $row['description'];
        $C = $row['prix_unitaire'];
        
    }
 
?>

<center>
    <div class="card shadow mb-4 col-xs-12 col-md-8 border-bottom-primary">
        <div class="card-header py-3">
            <h4 class="m-2 font-weight-bold text-primary">Modifier Produit</h4>
        </div>
        <a href="product.php?action=add" type="button" class="btn btn-primary bg-gradient-primary"><i class="fas fa-flip-horizontal fa-fw fa-share"></i>Retour</a>
        <div class="card-body">
            <form role="form" method="post" action="pro_edit1.php">
                <input type="hidden" name="id" value="<?php echo $zz; ?>" />
                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                       Code Produit:
                    </div>
                    <div class="col-sm-9">
                        <input class="form-control" placeholder=" Code Produit" name="code_produit" value="<?php echo $zzz; ?>" required>
                    </div>
                </div>
                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                        Nom Produit:
                    </div>
                    <div class="col-sm-9">
                        <input class="form-control" placeholder="Nom Produit" name="nom_produit" value="<?php echo $A; ?>" required>
                    </div>
                </div>
                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                        Description:
                    </div>
                    <div class="col-sm-9">
                        <textarea class="form-control" placeholder="Description" name="description" required><?php echo $B; ?></textarea>
                    </div>
                </div>
                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                        Prix Unitaire:
                    </div>
                    <div class="col-sm-9">
                        <input class="form-control" placeholder="Prix Unitaire" name="prix_unitaire" value="<?php echo $C; ?>" required>
                    </div>
                </div>
                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                        Catégorie:
                    </div>
                    <div class="col-sm-9">
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
                </div>
                <hr>
                <button type="submit" class="btn btn-warning btn-block"><i class="fa fa-edit fa-fw"></i>Modifier</button>
            </form>
        </div>
    </div>
</center>

<?php include '../../includesCompag/footer.php'; ?>
