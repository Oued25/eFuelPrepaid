<?php
include '../../includes/connection.php'; // Inclusion du fichier de connexion à la base de données
include '../../includes/sidebar.php'; // Inclusion de la barre latérale
?>

<div class="container mt-4">
    <!-- Onglets pour basculer entre les comptes Admin, clients, sation et compagnies -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="admin-tab" data-toggle="tab" href="#admin" role="tab" aria-controls="admin" aria-selected="true">Compte Admin</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " id="client-tab" data-toggle="tab" href="#client" role="tab" aria-controls="client" aria-selected="true">Compte Client</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="compagnie-tab" data-toggle="tab" href="#compagnie" role="tab" aria-controls="compagnie" aria-selected="false">Compte Compagnie</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="station-tab" data-toggle="tab" href="#station" role="tab" aria-controls="station" aria-selected="false">Compte Station</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">

        <!-- Début Onglet Comptes Admin -->
        <div class="tab-pane fade show active" id="admin" role="tabpanel" aria-labelledby="admin-tab">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4 class="m-2 font-weight-bold text-primary">
                        Compte Admin
                        <a href="#" data-toggle="modal" data-target="#aModal" type="button" class="btn btn-primary bg-gradient-primary" style="border-radius: 0px;">
                            <i class="fas fa-fw fa-plus"></i>
                        </a>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTableAdmin" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Genre</th>
                                    <th>Email</th>
                                    <th>Profil</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                // Requête SQL pour récupérer les données des utilisateurs admins
                                $sql = "SELECT u.id, u.nom, u.prenom, u.genre, u.email, p.nom_profil
                                        FROM utilisateur u
                                        JOIN profil p ON u.id_profil = p.id
                                        WHERE u.id_profil IN (1)
                                        ORDER BY u.id ASC"; 

                                $req = $connection->prepare($sql); // Préparation de la requête
                                $req->execute(); // Exécution de la requête

                                // Vérification des erreurs dans la requête
                                if (!$req) {
                                    die("Erreur dans la requête SQL: " . $connection->error);
                                }

                                // Boucle pour afficher les résultats de la requête
                                while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr>";
                                   //echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['nom'] . "</td>"; 
                                    echo "<td>" . $row['prenom'] . "</td>";
                                    echo "<td>" . $row['genre'] . "</td>";
                                    echo "<td>" . $row['email'] . "</td>";
                                    echo "<td>" . $row['nom_profil'] . "</td>";
                                    echo '<td align="right">
                                            <div class="btn-group">
                                                <a type="button" class="btn btn-primary bg-gradient-primary" href="us_searchfrm.php?action=edit&id=' . $row['id'] . '"><i class="fas fa-fw fa-list-alt"></i> Details</a>
                                                <div class="btn-group">
                                                    <a type="button" class="btn btn-primary bg-gradient-primary dropdown no-arrow" data-toggle="dropdown" style="color:white;">... <span class="caret"></span></a>
                                                    <ul class="dropdown-menu text-center" role="menu">
                                                        <li>
                                                            <a type="button" class="btn btn-warning bg-gradient-warning btn-block" style="border-radius: 0px;" href="us_edit.php?action=edit&id=' . $row['id'] . '"><i class="fas fa-fw fa-edit"></i> Modifier</a>
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
        </div>
        <!-- Fin Onglet Comptes Admin -->

        <!-- Début Onglet Comptes Client -->
        <div class="tab-pane fade " id="client" role="tabpanel" aria-labelledby="client-tab">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4 class="m-2 font-weight-bold text-primary">
                        Compte Client
                        <a href="#" data-toggle="modal" data-target="#cModal" type="button" class="btn btn-primary bg-gradient-primary" style="border-radius: 0px;">
                            <i class="fas fa-fw fa-plus"></i>
                        </a>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTableClient" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Genre</th>
                                    <th>Email</th>
                                    <th>Profil</th>
                                    <th>Nom clients</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                // Requête SQL pour récupérer les données des utilisateurs clients
                                $sql = "SELECT u.id, u.nom, u.prenom, u.genre, u.email, p.nom_profil, cl.nom_societe AS nom_structure
                                        FROM utilisateur u
                                        JOIN profil p ON u.id_profil = p.id
                                        LEFT JOIN client cl ON u.id_client = cl.id
                                        WHERE u.id_client IS NOT NULL
                                        ORDER BY u.id ASC"; 

                                $req = $connection->prepare($sql); // Préparation de la requête
                                $req->execute(); // Exécution de la requête

                                // Vérification des erreurs dans la requête
                                if (!$req) {
                                    die("Erreur dans la requête SQL: " . $connection->error);
                                }

                                // Boucle pour afficher les résultats de la requête
                                while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr>";
                                   //echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['nom'] . "</td>"; 
                                    echo "<td>" . $row['prenom'] . "</td>";
                                    echo "<td>" . $row['genre'] . "</td>";
                                    echo "<td>" . $row['email'] . "</td>";
                                    echo "<td>" . $row['nom_profil'] . "</td>";
                                    echo "<td>" . $row['nom_structure'] . "</td>";
                                    echo '<td align="right">
                                            <div class="btn-group">
                                                <a type="button" class="btn btn-primary bg-gradient-primary" href="us_searchfrm.php?action=edit&id=' . $row['id'] . '"><i class="fas fa-fw fa-list-alt"></i> Details</a>
                                                <div class="btn-group">
                                                    <a type="button" class="btn btn-primary bg-gradient-primary dropdown no-arrow" data-toggle="dropdown" style="color:white;">... <span class="caret"></span></a>
                                                    <ul class="dropdown-menu text-center" role="menu">
                                                        <li>
                                                            <a type="button" class="btn btn-warning bg-gradient-warning btn-block" style="border-radius: 0px;" href="us_edit.php?action=edit&id=' . $row['id'] . '"><i class="fas fa-fw fa-edit"></i> Modifier</a>
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
        </div>
        <!-- Fin Onglet Comptes Client -->

        <!-- Début Onglet Comptes Compagnie -->
        <div class="tab-pane fade" id="compagnie" role="tabpanel" aria-labelledby="compagnie-tab">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4 class="m-2 font-weight-bold text-primary">
                        Compte Compagnie
                        <a href="#" data-toggle="modal" data-target="#uModal" type="button" class="btn btn-primary bg-gradient-primary" style="border-radius: 0px;">
                            <i class="fas fa-fw fa-plus"></i>
                        </a>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTableCompagnie" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Genre</th>
                                    <th>Email</th>
                                    <th>Profil</th>
                                    <th>Compagnies</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                // Requête SQL pour récupérer les données des utilisateurs compagnies
                                $sql = "SELECT u.id, u.nom, u.prenom, u.genre, u.email, p.nom_profil, c.nom_compagnie AS nom_structure
                                        FROM utilisateur u
                                        JOIN profil p ON u.id_profil = p.id
                                        LEFT JOIN compagnie c ON u.id_compagnie = c.id
                                        WHERE u.id_compagnie IS NOT NULL
                                        ORDER BY u.id ASC"; 

                                $req = $connection->prepare($sql); // Préparation de la requête
                                $req->execute(); // Exécution de la requête

                                // Vérification des erreurs dans la requête
                                if (!$req) {
                                    die("Erreur dans la requête SQL: " . $connection->error);
                                }

                                // Boucle pour afficher les résultats de la requête
                                while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr>";
                                    //echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['nom'] . "</td>"; 
                                    echo "<td>" . $row['prenom'] . "</td>";
                                    echo "<td>" . $row['genre'] . "</td>";
                                    echo "<td>" . $row['email'] . "</td>";
                                    echo "<td>" . $row['nom_profil'] . "</td>";
                                    echo "<td>" . $row['nom_structure'] . "</td>";
                                    echo '<td align="right">
                                            <div class="btn-group">
                                                <a type="button" class="btn btn-primary bg-gradient-primary" href="us_searchfrm.php?action=edit&id=' . $row['id'] . '"><i class="fas fa-fw fa-list-alt"></i> Details</a>
                                                <div class="btn-group">
                                                    <a type="button" class="btn btn-primary bg-gradient-primary dropdown no-arrow" data-toggle="dropdown" style="color:white;">... <span class="caret"></span></a>
                                                    <ul class="dropdown-menu text-center" role="menu">
                                                        <li>
                                                            <a type="button" class="btn btn-warning bg-gradient-warning btn-block" style="border-radius: 0px;" href="us_edit.php?action=edit&id=' . $row['id'] . '"><i class="fas fa-fw fa-edit"></i> Modifier</a>
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
        </div>
        <!-- Fin Onglet Comptes Compagnie -->

 <!-- Debut Onglet Comptes Station -->
 <div class="tab-pane fade" id="station" role="tabpanel" aria-labelledby="station-tab">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4 class="m-2 font-weight-bold text-primary">
                        Compte Station
                        <a href="#" data-toggle="modal" data-target="#sModal" type="button" class="btn btn-primary bg-gradient-primary" style="border-radius: 0px;">
                            <i class="fas fa-fw fa-plus"></i>
                        </a>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTableStation" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Genre</th>
                                    <th>Email</th>
                                    <th>Profil</th>
                                    <th>Stations</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                // Requête SQL pour récupérer les données des utilisateurs stations
                                $sql = "SELECT u.id, u.nom, u.prenom, u.genre, u.email, p.nom_profil, c.nom_station AS nom_structure
                                        FROM utilisateur u
                                        JOIN profil p ON u.id_profil = p.id
                                        LEFT JOIN station c ON u.id_station = c.id
                                        WHERE u.id_station IS NOT NULL
                                        ORDER BY u.id ASC"; 

                                $req = $connection->prepare($sql); // Préparation de la requête
                                $req->execute(); // Exécution de la requête

                                // Vérification des erreurs dans la requête
                                if (!$req) {
                                    die("Erreur dans la requête SQL: " . $connection->error);
                                }

                                // Boucle pour afficher les résultats de la requête
                                while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['nom'] . "</td>"; 
                                    echo "<td>" . $row['prenom'] . "</td>";
                                    echo "<td>" . $row['genre'] . "</td>";
                                    echo "<td>" . $row['email'] . "</td>";
                                    echo "<td>" . $row['nom_profil'] . "</td>";
                                    echo "<td>" . $row['nom_structure'] . "</td>";
                                    echo '<td align="right">
                                            <div class="btn-group">
                                                <a type="button" class="btn btn-primary bg-gradient-primary" href="us_searchfrm.php?action=edit&id=' . $row['id'] . '"><i class="fas fa-fw fa-list-alt"></i> Details</a>
                                                <div class="btn-group">
                                                <a type="button" class="btn btn-primary bg-gradient-primary dropdown no-arrow" data-toggle="dropdown" style="color:white;">... <span class="caret"></span></a>
                                                <ul class="dropdown-menu text-center" role="menu">
                                                    <li>
                                                        <a type="button" class="btn btn-warning bg-gradient-warning btn-block" style="border-radius: 0px;" href="us_edit.php?action=edit&id=' . $row['id'] . '"><i class="fas fa-fw fa-edit"></i> Modifier</a>
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
        </div>
        <!-- Fin Onglet Comptes Staion -->
    </div>
</div>

<?php
include '../../includes/footer.php'; // Inclusion du pied de page
?>

<!-- Modal pour ajouter un utilisateur admin -->
<div class="modal fade" id="aModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ajoter un utilisateur Admin</h5>
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
                        </select>
            </div>
            <div class="form-group">
                <input class="form-control" placeholder="Numéro de Téléphone" name="telephone" required>
            </div>
                   
            <div class="form-group">
              <select class="form-control" name="id_profil" id="id_profil">
                        <option value="">--Choisir un Profil--</option><!-- cette option permette de ne pas afficher une profils par defaut dans le inpute-->
                        <?php
                            // Requête SQL pour récupérer les profils depuis la base de données
                            $sql = "SELECT id, nom_profil FROM profil WHERE id IN (1)";
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
                  <input class="form-control" placeholder="Email" name="email" required>
              </div>
              <div class="form-group">
                <input type="password" class="form-control" placeholder="Mot de passe" name="mot_de_passe" required>
              </div>
            <hr>
            <button type="submit" class="btn btn-success"><i class="fa fa-check fa-fw"></i>Validez</button>
            <button type="reset" class="btn btn-danger"><i class="fa fa-times fa-fw"></i>Réinitialiser</button>
            <button type="button" class="btn btn-secondary"data-dismiss="modal">Annuler</button>    
          </form>  
        </div>
      </div>
    </div>
  </div>

<!-- Modal pour ajouter un utilisateur station -->
<div class="modal fade" id="sModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ajoter un utilisateur Station</h5>
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
                <input class="form-control" placeholder="Numéro de Téléphone" name="telephone" required>
            </div>
            <div class="form-group">
                <select class="form-control" name="id_compagnie" required>
                <option value="">--Choisir une Compagnie--</option><!-- cette option permette de ne pas afficher une profils par defaut dans le inpute-->
                    <?php 
                    $sql = "SELECT id, nom_compagnie FROM compagnie";
                    $result = $connection->query($sql);

                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo '<option value="'.$row['id'].'">'.$row['nom_compagnie'].'</option>';
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
              <select class="form-control" name="id_profil" id="id_profil">
                        <option value="">--Choisir un Profil--</option><!-- cette option permette de ne pas afficher une profils par defaut dans le inpute-->
                        <?php
                            // Requête SQL pour récupérer les profils depuis la base de données
                            $sql = "SELECT id, nom_profil FROM profil WHERE id IN (3,6)";
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
                  <input class="form-control" placeholder="Email" name="email" required>
              </div>
              <div class="form-group">
                <input type="password" class="form-control" placeholder="Mot de passe" name="mot_de_passe" required>
              </div>
            <hr>
            <button type="submit" class="btn btn-success"><i class="fa fa-check fa-fw"></i>Validez</button>
            <button type="reset" class="btn btn-danger"><i class="fa fa-times fa-fw"></i>Réinitialiser</button>
            <button type="button" class="btn btn-secondary"data-dismiss="modal">Annuler</button>    
          </form>  
        </div>
      </div>
    </div>
  </div>

  
<!-- Modal pour ajouter un utilisateur compagnie -->
<div class="modal fade" id="uModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajouter un utilisateur Compagnie</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="us_transac.php?action=ajouter" method="post">
                    <!-- Champs pour ajouter un utilisateur compagnie -->
                    <div class="form-group">
                        <input class="form-control" placeholder="Nom" name="nom" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Prénom" name="prenom" required>
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
                        <input class="form-control" placeholder="Numéro de Téléphone" name="telephone" required>
                    </div>
                    
                    <div class="form-group">
                        <select class="form-control" name="id_compagnie" required>
                        <option value="">--Choisir une compagnie--</option><!-- cette option permette de ne pas afficher une profils par defaut dans le inpute-->
                            <?php 
                            $sql = "SELECT id, nom_compagnie FROM compagnie";
                            $result = $connection->query($sql);

                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="'.$row['id'].'">'.$row['nom_compagnie'].'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="id_profil" id="id_profil">
                                    <option value="">--Choisir un Profil--</option><!-- cette option permette de ne pas afficher une profils par defaut dans le inpute-->
                                    <?php
                                        // Requête SQL pour récupérer les profils depuis la base de données
                                        $sql = "SELECT id, nom_profil FROM profil WHERE id IN (2,5)";
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
                        <input class="form-control" placeholder="Email" name="email" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Mot de Passe" name="mot_de_passe" required>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-success"><i class="fa fa-check fa-fw"></i>Validez</button>
                    <button type="reset" class="btn btn-danger"><i class="fa fa-times fa-fw"></i>Réinitialiser</button>
                    <button type="button" class="btn btn-secondary"data-dismiss="modal">Annuler</button> 
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour ajouter un utilisateur client -->
<div class="modal fade" id="cModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajouter un utilisateur Client</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="us_transac.php?action=ajouter" method="post">
                    <!-- Champs pour ajouter un utilisateur client -->
                    <div class="form-group">
                        <input class="form-control" placeholder="Nom" name="nom" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Prénom" name="prenom" required>
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
                        <input class="form-control" placeholder="Numéro de Téléphone" name="telephone" required>
                    </div>
                    
                    <div class="form-group">
                        <select class="form-control" name="id_client" required>
                        <option value="">--Choisir un Client--</option><!-- cette option permette de ne pas afficher une profils par defaut dans le inpute-->
                            <?php 
                            $sql = "SELECT id, nom_societe FROM client";
                            $result = $connection->query($sql);

                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="'.$row['id'].'">'.$row['nom_societe'].'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                           <select class="form-control" name="id_profil" id="id_profil">
                                <option value="">--Choisir un Profil--</option><!-- cette option permette de ne pas afficher une profils par defaut dans le inpute-->
                                <?php
                                    // Requête SQL pour récupérer les profils depuis la base de données
                                    $sql = "SELECT id, nom_profil FROM profil WHERE id IN (4,7)";
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
                        <input class="form-control" placeholder="Email" name="email" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Mot de Passe" name="mot_de_passe" required>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-success"><i class="fa fa-check fa-fw"></i>Validez</button>
                    <button type="reset" class="btn btn-danger"><i class="fa fa-times fa-fw"></i>Réinitialiser</button>
                    <button type="button" class="btn btn-secondary"data-dismiss="modal">Annuler</button>  
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Inclusion des scripts JavaScript ->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>-->

<!-- Initialisation des tableaux DataTables -->
<script>
$(document).ready(function() {
    $('#dataTableClient').DataTable();
    $('#dataTableCompagnie').DataTable();
    $('#dataTableStation').DataTable();
});
</script>
