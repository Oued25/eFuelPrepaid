<?php

include '../../includesCompag/connection.php';
include '../../includesCompag/sidebar.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) { 
    header('Location: login.php');
    exit();
} 

$user = $_SESSION; 

// Requête SQL pour récupérer les données des utilisateurs de la même compagnie
$sql = "SELECT u.id AS id, email, mot_de_passe, u.nom, u.prenom, p.nom_profil, s.nom_station, c.nom_compagnie
        FROM utilisateur AS u
        JOIN profil AS p ON u.id_profil = p.id
        LEFT JOIN station AS s ON u.id_station = s.id
        LEFT JOIN compagnie AS c ON u.id_compagnie = c.id
        WHERE u.id_compagnie = :id_compagnie
        AND p.nom_profil IN ('Gestionnaire Station', 'Utilisateur Compagnie')
        ORDER BY u.id ASC";

$stmt = $connection->prepare($sql);
$stmt->bindParam(':id_compagnie', $user['id_compagnie']);
$stmt->execute();

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
                        <th>Station</th>
                        <th>Compagnie</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    // Affichage des données récupérées
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>".$row['nom']."</td>"; 
                        echo "<td>".$row['prenom']."</td>";
                        echo "<td>".$row['email']."</td>";
                        echo "<td>".$row['nom_profil']."</td>";
                        echo "<td>".$row['nom_station']."</td>";
                        echo "<td>".$row['nom_compagnie']."</td>";
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

<?php include '../../includesCompag/footer.php'; ?>

 <!-- utilisateurs Modal-->
 <div class="modal fade" id="uModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ajouter utilisateurs</h5>
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
                        <select class="form-control" name="id_compagnie" id="id_compagnie">
                            <option value="">--Choisir une Compagnie--</option>
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
             <div class="form-group">
              <select class="form-control" name="id_station" id="id_station">
                        <option value="">--Choisir un station--</option><!-- cette option permette de ne pas afficher une stations par defaut dans le inpute-->
                        <?php
                            // Requête SQL pour récupérer les stations depuis la base de données
                            $sql = "SELECT id, nom_station FROM station ";
                            $req = $connection->prepare($sql); 
                            $req->execute();

                            // Affichage des options du menu déroulant
                            while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="' . $row['id'] . '">' . $row['nom_station'] . '</option>';
                            }
                        ?>
                    </select>
              </div>
             <div class="form-group">
                  <input class="form-control" placeholder="Email" name="email" required>
              </div>
            <div class="form-group">
              <select class="form-control" name="id_profil" id="id_profil">
                        <option value="">--Choisir un Profil--</option><!-- cette option permette de ne pas afficher une profils par defaut dans le inpute-->
                        <?php
                            // Requête SQL pour récupérer les profils depuis la base de données
                            $sql = "SELECT id, nom_profil FROM profil WHERE id IN (3, 5)";
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
