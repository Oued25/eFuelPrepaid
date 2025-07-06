<?php 
include '../../includes/connection.php';  
include '../../includes/sidebar.php'; 

$id_user = $_GET['id'];

// Requête SQL avec PDO
$sql = "SELECT u.id, u.nom, u.prenom, u.genre, u.email, mot_de_passe, p.nom_profil, u.date_creation, u.date_modif, 
        CASE
            WHEN u.id_compagnie IS NOT NULL THEN c.nom_compagnie
            WHEN u.id_client IS NOT NULL THEN cl.nom_societe
            ELSE 'N/A'
        END AS nom_structure,
        CASE
            WHEN u.id_compagnie IS NOT NULL THEN 'Compagnie'
            WHEN u.id_client IS NOT NULL THEN 'Client'
            ELSE 'N/A'
        END AS type_utilisateur
        FROM utilisateur u
        JOIN profil p ON u.id_profil = p.id
        LEFT JOIN compagnie c ON u.id_compagnie = c.id
        LEFT JOIN client cl ON u.id_client = cl.id
        WHERE u.id = :id"; // Ajout de la condition WHERE


// Préparation de la requête
$req = $connection->prepare($sql);

// Liaison des paramètres
$req->bindParam(':id', $id_user, PDO::PARAM_INT);

// Exécution de la requête
$req->execute();

// Vérification des erreurs de requête
if (!$req) {
    die("Erreur dans la requête SQL: " . $connection->error);
}

// Récupération des résultats
while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
    $zz = $row['id'];
    $zzz = $row['email'];
    $A = $row['mot_de_passe'];
    $B = $row['nom'];
    $C = $row['prenom'];
    $D = $row['genre'];
    $E = $row['nom_profil'];
    //$F = $row['nom_type'];
    //$G = $row['date_creation'];
    //$H = $row['date_modif'];
}

?>

<center>
    <div class="card shadow mb-4 col-xs-12 col-md-8 border-bottom-primary">
        <div class="card-header py-3">
            <h4 class="m-2 font-weight-bold text-primary">Modifier Utilisateur</h4>
        </div>
        <a href="user.php?action=add" type="button" class="btn btn-primary bg-gradient-primary"><i class="fas fa-flip-horizontal fa-fw fa-share"></i>Retour</a>
        <div class="card-body">
            <form role="form" method="post" action="us_edit1.php">
                <input type="hidden" name="id" value="<?php echo $zz; ?>" />
                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                      Nom:
                    </div>
                    <div class="col-sm-9">
                        <input class="form-control" placeholder="nom" name="nom" value="<?php echo $B; ?>" required>
                    </div>
                </div>
                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                      Prénom:
                    </div>
                    <div class="col-sm-9">
                        <input class="form-control" placeholder="Prénom" name="prenom" value="<?php echo $C; ?>" required>
                    </div>
                </div>
                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                      Genre:
                    </div>
                    <div class="col-sm-9">
                        <select class='form-control' name='genre' required>
                            <option value="" disabled selected hidden>Choisir Genre</option>
                            <option value="Homme">Homme</option>
                            <option value="Femme">Femme</option>
                            <option value="Femme">Perssone Morale</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                       Email:
                    </div>
                    <div class="col-sm-9">
                        <input class="form-control" placeholder="Email" name="email" value="<?php echo $zzz; ?>" required>
                    </div>
                </div>
                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                        Mot de Passe:
                    </div>
                    <div class="col-sm-9">
                        <input class="form-control" placeholder="mot_de_passe" name="mot_de_passe" value="<?php echo $A; ?>" required>
                    </div>
                </div>
                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                      Profil:
                    </div>
                    <div class="col-sm-9">
                        <select class="form-control" name="id_profil" id="id_profil">
                            <option value="">--Choisir un Profil--</option><!-- cette option permette de ne pas afficher une profil par defaut dans le inpute-->
                            <?php
                            // Requête SQL pour récupérer les profil depuis la base de données
                            $sql = "SELECT id, nom_profil FROM profil";
                            $req = $connection->prepare($sql);
                            $req->execute();

                            // Affichage des options du menu déroulant
                            while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="' . $row['id'] . '">' . $row['nom_profil'] . '</option>';
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

<?php include '../../includes/footer.php'; ?>
