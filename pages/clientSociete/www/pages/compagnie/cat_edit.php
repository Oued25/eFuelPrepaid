<?php
include($_SERVER['DOCUMENT_ROOT'] . '/Projet_eFuelPrepaid/includesCompag/connection.php');
include($_SERVER['DOCUMENT_ROOT'] . '/Projet_eFuelPrepaid/includesCompag/sidebar.php');

// Vérifiez si 'id' est défini dans $_GET
$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id === null) {
    // Gérer le cas où 'id' n'est pas défini dans l'URL
    die('ID non spécifié');
}

// Requête SQL pour récupérer les données de la catégorie avec l'ID spécifié
$sql = "SELECT id, nom_categorie, descrip_categorie FROM categorie WHERE id = ?";
$req = $connection->prepare($sql);

// Exécutez la requête avec l'ID comme paramètre
$result = $req->execute([$id]);

if ($result === false) {
    // Gérer le cas où la requête SQL a échoué
    die('Erreur lors de l\'exécution de la requête SQL');
}

// Récupération des données de la catégorie
$row = $req->fetch(PDO::FETCH_ASSOC);

// Vérifiez si des données ont été récupérées
if (!$row) {
    // Gérer le cas où aucune donnée n'a été trouvée pour l'ID donné
    die('Aucune catégorie trouvée pour cet ID');
}

// Récupération des valeurs de la catégorie
$zz = $row['id'];
$A = $row['nom_categorie'];
$B = $row['descrip_categorie'];
?>

<!-- Votre HTML et formulaire ici avec les valeurs $A et $B -->


<center>
    <div class="card shadow mb-4 col-xs-12 col-md-8 border-bottom-primary">
        <div class="card-header py-3">
            <h4 class="m-2 font-weight-bold text-primary">Modifier Catégorie</h4>
        </div>
        <a href="categorie.php?action=add" type="button" class="btn btn-primary bg-gradient-primary"><i class="fas fa-flip-horizontal fa-fw fa-share"></i> Retour</a>
        <div class="card-body">
            <form role="form" method="post" action="cat_edit1.php">
                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                        Nom Categorie:
                    </div>
                    <div class="col-sm-9">
                        <input type="hidden" name="id" value="<?php echo $zz; ?>" />
                        <input class="form-control" placeholder="Nom Catégorie" name="nom_categorie" value="<?php echo $A; ?>" required>
                    </div>
                </div>
                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                        Description:
                    </div>
                    <div class="col-sm-9">
                        <textarea class="form-control" placeholder="Description" name="descrip_categorie"><?php echo $B; ?></textarea>
                    </div>
                </div>
                <hr>

                <button type="submit" class="btn btn-warning btn-block"><i class="fa fa-edit fa-fw"></i>Modifier</button>    
            </form>  
        </div>
    </div>
</center>