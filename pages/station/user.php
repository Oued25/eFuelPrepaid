<?php 
include '../../includesStation/connection.php'; 
include '../../includesStation/sidebar.php'; 

// Récupération des informations de l'utilisateur connecté
$user = $_SESSION; 

// Récupérer l'id de la station à partir de la session
$id_station_connectee = $user['id_station'];

// Requête pour obtenir les informations de la station et de la compagnie associée
$sql_station = "SELECT s.id AS id_station, s.nom_station, s.id_compagnie, c.nom_compagnie 
                FROM station AS s
                LEFT JOIN compagnie AS c ON s.id_compagnie = c.id
                WHERE s.id = :id_station_connectee";
$req_station = $connection->prepare($sql_station);
$req_station->bindParam(':id_station_connectee', $id_station_connectee, PDO::PARAM_INT);
$req_station->execute();
$station_user = $req_station->fetch(PDO::FETCH_ASSOC);

// Vérification des erreurs de requête
if ($station_user) {
    $id_station =  $station_user['id_station'];
    $nom_station = $station_user['nom_station'];
    $id_compagnie = $station_user['id_compagnie'];
    $nom_compagnie = $station_user['nom_compagnie'];
} else {
    die("Erreur : Station non trouvée pour cet utilisateur.");
}

// Requête SQL pour récupérer les données des utilisateurs associés à la station
$sql = "SELECT u.id AS id, email, mot_de_passe, u.nom, u.prenom, p.nom_profil, s.nom_station, c.nom_compagnie, u.id_station, u.id_compagnie
        FROM utilisateur AS u
        JOIN profil AS p ON u.id_profil = p.id
        LEFT JOIN station AS s ON u.id_station = s.id
        LEFT JOIN compagnie AS c ON u.id_compagnie = c.id
        WHERE u.id_station = :id_station
        AND p.nom_profil = 'Utilisateur Station' 
        ORDER BY u.id ASC"; 

$req = $connection->prepare($sql); 
$req->bindParam(':id_station', $id_station_connectee);
$req->execute(); 

// Vérification des erreurs de requête
if (!$req) {
    die("Erreur dans la requête SQL: " . $connection->error);
}
?>

<!-- Tableau pour les comptes d'utilisateurs -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h4 class="m-2 font-weight-bold text-primary">Comptes Utilisateurs&nbsp;
            <a href="#" data-toggle="modal" data-target="#uModal" type="button" class="btn btn-primary bg-gradient-primary" style="border-radius: 0px;">
                <i class="fas fa-fw fa-plus"></i>
            </a>
        </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Profils</th>
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
                        echo "<td>".$row['email']."</td>";
                        echo "<td>".$row['nom_profil']."</td>";
                        echo '<td align="right">
                                <div class="btn-group">
                                    <a type="button" class="btn btn-primary bg-gradient-primary"  href="us_searchfrm.php?action=edit&id='.$row['id'] . '">
                                        <i class="fas fa-fw fa-list-alt"></i> Details
                                    </a>
                                    <div class="btn-group">
                                        <a type="button" class="btn btn-primary bg-gradient-primary dropdown no-arrow" data-toggle="dropdown" style="color:white;">
                                            ... <span class="caret"></span>
                                        </a>
                                        <ul class="dropdown-menu text-center" role="menu">
                                            <li>
                                                <a type="button" class="btn btn-warning bg-gradient-warning btn-block" style="border-radius: 0px;" href="us_edit.php?action=edit&id='.$row['id']. '">
                                                    <i class="fas fa-fw fa-edit"></i> Modifier
                                                </a>
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

<?php include '../../includesStation/footer.php'; ?>

<!-- Modal pour ajouter des utilisateurs -->
<div class="modal fade" id="uModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajouter utilisateur</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" method="post" action="us_transac.php?action=add">
                    <!-- Nom et Prénom -->
                    <div class="form-group">
                        <input class="form-control" placeholder="Nom" name="nom" required>
                    </div> 
                    <div class="form-group">
                        <input class="form-control" placeholder="Prénom" name="prenom" required>
                    </div>
                    
                    <!-- Genre -->
                    <div class="form-group">
                        <select class="form-control" name="genre" required>
                            <option value="" disabled selected hidden>Choisir Genre</option>
                            <option value="Homme">Homme</option>
                            <option value="Femme">Femme</option>
                            <option value="Personne Morale">Personne Morale</option>
                        </select>
                    </div>

                    <!-- Station (Pré-remplie et non modifiable) -->
                    <div class="form-group">
                        <input class="form-control" name="nom_station" value="<?php echo $nom_station; ?>" readonly>
                        <input type="hidden" name="id_station" value="<?php echo $id_station; ?>">
                    </div>

                    <!-- Compagnie (Pré-remplie et non modifiable) -->
                    <div class="form-group">
                        <input class="form-control" name="nom_compagnie" value="<?php echo $nom_compagnie; ?>" readonly>
                        <input type="hidden" name="id_compagnie" value="<?php echo $id_compagnie; ?>">
                    </div>

                    <!-- Email et Mot de passe -->
                    <div class="form-group">
                        <input class="form-control" placeholder="Email" name="email" required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Mot de passe" name="mot_de_passe" required>
                    </div>

                    <!-- Profil -->
                    <div class="form-group">
                        <select class="form-control" name="id_profil" required>
                            <option value="">--Choisir un Profil--</option>
                            <?php
                                $sql = "SELECT id, nom_profil FROM profil WHERE id IN (6)";
                                $req = $connection->prepare($sql); 
                                $req->execute();

                                while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                                    echo '<option value="' . $row['id'] . '">' . $row['nom_profil'] . '</option>';
                                }
                            ?>
                        </select>
                    </div>

                    <!-- Boutons d'action -->
                    <hr>
                    <button type="submit" class="btn btn-success"><i class="fa fa-check fa-fw"></i>Enregistrer</button>
                    <button type="reset" class="btn btn-danger"><i class="fa fa-times fa-fw"></i>Réinitialiser</button>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>    
                </form>
            </div>
        </div>
    </div>
</div>
