<?php  
include '../../includesSociete/connection.php'; 
include '../../includesSociete/sidebar.php'; 

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) { 
  header('Location: login.php');
  exit();
}

$user = $_SESSION; 

// Récupérer l'id du client à partir de la session
$id_client_connectee = $user['id_client'];

// Requête pour obtenir les informations du client
$sql_client = "SELECT cl.id AS id_client, cl.nom_societe 
                FROM client AS cl
                WHERE cl.id = :id_client_connectee";
$req_client = $connection->prepare($sql_client);
$req_client->bindParam(':id_client_connectee', $id_client_connectee, PDO::PARAM_INT);
$req_client->execute();
$client_user = $req_client->fetch(PDO::FETCH_ASSOC);

// Vérification des erreurs de requête
if ($client_user) {
    $id_client =  $client_user['id_client'];
    $nom_client = $client_user['nom_societe'];
} else {
    die("Erreur : client non trouvée pour cet utilisateur.");
}

// Requête SQL pour récupérer les données les utilisateur Clients
$sql = "SELECT u.id AS id, email, mot_de_passe, u.nom, u.prenom, p.nom_profil
        FROM utilisateur AS u
        JOIN profil AS p ON u.id_profil = p.id
        WHERE u.id_client = :id_client
        AND p.nom_profil = 'Utilisateur Client Entreprise'
        ORDER BY u.id ASC"; // Ajout de l'ordre par ID // Utilisation du paramètre de liaison :id
        
// Préparation de la requête
$req = $connection->prepare($sql);
$req->bindParam(':id_client', $user['id_client']);
$req->execute(); // Exécution de la requête

// Vérification des erreurs de requête
if (!$req) {
    die("Erreur dans la requête SQL: " . $connection->error);
}

?>

<!-- Tableau pour les comptes d'utilisateurs -->
<div class="card shadow mb-4">
<div class="card-header py-3">
    <h4 class="m-2 font-weight-bold text-primary">Comptes Utilisateurs&nbsp;<a href="#" data-toggle="modal" data-target="#uModal" type="button" class="btn btn-primary bg-gradient-primary" style="border-radius: 0px;"><i class="fas fa-fw fa-plus"></i></a></h4>
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
                                    <a type="button" class="btn btn-primary bg-gradient-primary"  href="us_searchfrm.php?action=edit&id='.$row['id'] . '"><i class="fas fa-fw fa-list-alt"></i> Details</a>
                                    <div class="btn-group">
                                    <a type="button" class="btn btn-primary bg-gradient-primary dropdown no-arrow" data-toggle="dropdown" style="color:white;">... <span class="caret"></span></a>
                                    <ul class="dropdown-menu text-center" role="menu">
                                        <li>
                                        <a type="button" class="btn btn-warning bg-gradient-warning btn-block" style="border-radius: 0px;" href="us_edit.php?action=edit&id='.$row['id']. '"><i class="fas fa-fw fa-edit"></i> Modifier</a>
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

 <!-- utilisateurs Modal-->
 <div class="modal fade" id="uModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ajoter utilisateurs</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
        <form role="form" method="post" action="us_transac.php?action=add">
            <div class="form-group">
              <input class="form-control" placeholder="Nom" name="nom" required>
            </div> 
            <div class="form-group">
              <input class="form-control" placeholder="prénom" name="prenom" required>
            </div>
            <div class="form-group">
                        <select class='form-control' name='genre' required>
                            <option value="" disabled selected hidden>Choisir Genre</option>
                            <option value="Homme">Homme</option>
                            <option value="Femme">Femme</option>
                            <option value="Femme">Perssone Morale</option>
                        </select>
             </div>

             <div class="form-group">
                        <input class="form-control" name="nom_client" value="<?php echo $nom_client; ?>" readonly>
                        <input type="hidden" name="id_client" value="<?php echo $id_client; ?>">
               </div>

             <div class="form-group">
                  <input class="form-control" placeholder="Email" name="email" required>
              </div>
            <div class="form-group">
              <select class="form-control" name="id_profil" id="id_profil">
                        <option value="">--Choisir un Profil--</option><!-- cette option permette de ne pas afficher une profils par defaut dans le inpute-->
                        <?php
                            // Requête SQL pour récupérer les profils depuis la base de données
                            $sql = "SELECT id, nom_profil FROM profil WHERE id IN (7)";
                            $req = $connection->prepare($sql); 
                            $req->execute();

                            // Affichage des options du menu déroulant
                            while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="' . $row['id'] . '">' . $row['nom_profil'] . '</option>';
                            }
                        ?>
                    </select>
              </div>
              <div class="form-group">
                <input type="password" class="form-control" placeholder="Mot de passe" name="mot_de_passe" required>
              </div>
            <hr>
            <button type="submit" class="btn btn-success"><i class="fa fa-check fa-fw"></i>Enregistrer</button>
            <button type="reset" class="btn btn-danger"><i class="fa fa-times fa-fw"></i>Réinitialiser</button>
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>    
          </form>  
        </div>
      </div>
    </div>
  </div>