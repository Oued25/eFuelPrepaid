<!-- Page des comptes d'utilisateurs pour les superUser -->

<?php 

include '../../includes/connection.php';
include '../../includes/sidebar.php'; 

?>

<!-- Tableau pour les comptes d'utilisateurs Compagnie -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
    <h4 class="m-2 font-weight-bold text-primary">Comptes Compagnie&nbsp;<a href="#" data-toggle="modal" data-target="#uModal" type="button" class="btn btn-primary bg-gradient-primary" style="border-radius: 0px;"><i class="fas fa-fw fa-plus"></i></a></h4>
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
                        <th>Nom Compagnie</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php 

                    // Requête SQL pour récupérer les données des gestionnaires
                    $sql = "SELECT u.id AS id, email, mot_de_passe, u.nom, u.prenom, p.nom_profil, c.nom_compagnie
                            FROM utilisateur AS u
                            JOIN profil AS p ON u.id_profil = p.id
                            JOIN compagnie AS c ON u.id_compagnie = c.id"; // Utilisation du paramètre de liaison :id

                    // Préparation de la requête
                    $req = $connection->prepare($sql);
                    $req->execute(); // Exécution de la requête

                    // Vérification des erreurs de requête
                    if (!$req) {
                        die("Erreur dans la requête SQL: " . $connection->error);
                    }

                    // Affichage des données récupérées
                    while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>".$row['nom']."</td>"; 
                        echo "<td>".$row['prenom']."</td>";
                        echo "<td>".$row['email']."</td>";
                        echo "<td>".$row['nom_profil']."</td>";
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

<!-- Tableau pour les comptes d'utilisateurs Client -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
    <h4 class="m-2 font-weight-bold text-primary">Comptes Client&nbsp;<a href="#" data-toggle="modal" data-target="#uModal" type="button" class="btn btn-primary bg-gradient-primary" style="border-radius: 0px;"><i class="fas fa-fw fa-plus"></i></a></h4>
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
                        <th>Nom Compagnie</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php 

                  // Requête SQL pour récupérer les données des
                  $sql = "SELECT u.id AS id, email, mot_de_passe, u.nom, u.prenom, p.nom_profil, t.nom_type
                  FROM utilisateur AS u
                  JOIN profil AS p ON u.id_profil = p.id
                  JOIN client AS cl ON u.id_client = cl.id
                  JOIN type AS t ON cl.id_type = t.id";
           // Utilisation du paramètre de liaison :id

                    // Préparation de la requête
                    $req = $connection->prepare($sql);
                    $req->execute(); // Exécution de la requête

                    // Vérification des erreurs de requête
                    if (!$req) {
                    die("Erreur dans la requête SQL: " . $connection->error);
                    }

                    // Affichage des données récupérées
                    while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>".$row['nom']."</td>"; 
                        echo "<td>".$row['prenom']."</td>";
                        echo "<td>".$row['email']."</td>";
                        echo "<td>".$row['nom_profil']."</td>";
                        echo "<td>".$row['nom_type']."</td>";
                        echo '<td align="right">
                                <div class="btn-group">
                                    <a type="button" class="btn btn-primary bg-gradient-primary"  href="us_searchfrm.php?action = edit&id='.$row['id'] . '"><i class="fas fa-fw fa-list-alt"></i> Details</a>
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

<?php
// Affichage de la table pour les comptes d'utilisateurs
include '../../includes/footer.php';
?>

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
                     <select class="form-control" name="id_compagnie" id="id_compagnie">
                            <option value="">Choisir un Compagnie</option><!-- cette option permette de ne pas afficher une compagnies par defaut dans le inpute-->
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
                     <select class="form-control" name="id_profil" id="id_profil">
                            <option value="">Choisir un Profil</option><!-- cette option permette de ne pas afficher une profils par defaut dans le inpute-->
                            <?php
                                // Requête SQL pour récupérer les profils depuis la base de données
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
              <div class="form-group">
                <input type="password" class="form-control" placeholder="Mot de passe" name="mot_de_passe" required>
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






  <!--     ----------------------test 1  du ficer utilisateur de supert Admin---------------->

  <?php
include '../../includes/connection.php';
include '../../includes/sidebar.php'; 
?>

<!-- Tableau pour les comptes d'utilisateurs -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h4 class="m-2 font-weight-bold text-primary">
            Comptes Compagnie
            <a href="#" data-toggle="modal" data-target="#uModal" type="button" class="btn btn-primary bg-gradient-primary" style="border-radius: 0px;">
                <i class="fas fa-fw fa-plus"></i>
            </a>
        </h4>
        <h4 class="m-2 font-weight-bold text-primary">
            Comptes Client
            <a href="#" data-toggle="modal" data-target="#cModal" type="button" class="btn btn-primary bg-gradient-primary" style="border-radius: 0px;">
                <i class="fas fa-fw fa-plus"></i>
            </a>
        </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Genre</th>
                        <th>Email</th>
                        <th>Profil</th>
                        <th>Nom de la structure</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    // Requête SQL pour récupérer les données des utilisateurs
                    $sql = "SELECT u.id, u.nom, u.prenom, u.genre, u.email, p.nom_profil,
                                    CASE
                                        WHEN u.id_compagnie IS NOT NULL THEN c.nom_compagnie
                                        WHEN u.id_client IS NOT NULL THEN cl.nom_societe
                                        ELSE 'N/A'
                                    END AS nom_structure
                            FROM utilisateur u
                            JOIN profil p ON u.id_profil = p.id
                            LEFT JOIN compagnie c ON u.id_compagnie = c.id
                            LEFT JOIN client cl ON u.id_client = cl.id
                            ORDER BY u.id ASC"; // Ajout de l'ordre par ID

                    // Préparation et exécution de la requête
                    $req = $connection->prepare($sql);
                    $req->execute();

                    // Vérification des erreurs de requête
                    if (!$req) {
                        die("Erreur dans la requête SQL: " . $connection->error);
                    }

                    // Affichage des données récupérées
                    while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
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

<?php
include '../../includes/footer.php';
?>

<!-- utilisateurs compagnie Modal-->
<div class="modal fade" id="uModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajouter utilisateur Compagnie</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" method="post" action="us_transac.php?action=add&type=compagnie">
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
                        <input class="form-control" placeholder="Email" name="email" required>
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
                    <div class="form-group">
                        <select class="form-control" name="id_profil" id="id_profil">
                            <option value="">Choisir un Profil</option>
                            <?php
                                // Requête SQL pour récupérer les profils depuis la base de données
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

<!-- utilisateurs client Modal-->
<div class="modal fade" id="cModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajouter utilisateur Client</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" method="post" action="us_transac.php?action=add&type=client">
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
                        <input class="form-control" placeholder="Email" name="email" required>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="id_client" id="id_client">
                            <option value="">Choisir un Client</option>
                            <?php
                                // Requête SQL pour récupérer les clients depuis la base de données
                                $sql = "SELECT id, nom_societe FROM client";
                                $req = $connection->prepare($sql); 
                                $req->execute();

                                // Affichage des options du menu déroulant
                                while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                                    echo '<option value="' . $row['id'] . '">' . $row['nom_societe'] . '</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="id_profil" id="id_profil">
                            <option value="">Choisir un Profil</option>
                            <?php
                                // Requête SQL pour récupérer les profils depuis la base de données
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






 <!--     ----------------------Nouneau test2 du ficer utilisateur de supert Admin---------------->
                            <?php
include '../../includes/connection.php'; // Inclusion du fichier de connexion à la base de données
include '../../includes/sidebar.php'; // Inclusion de la barre latérale
?>

<!-- Inclusion de la feuille de style Bootstrap -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<!-- Inclusion de la feuille de style DataTables -->
<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">

<div class="container mt-4">
    <!-- Onglets pour basculer entre les comptes clients et compagnies -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="client-tab" data-toggle="tab" href="#client" role="tab" aria-controls="client" aria-selected="true">Comptes Client</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="compagnie-tab" data-toggle="tab" href="#compagnie" role="tab" aria-controls="compagnie" aria-selected="false">Comptes Compagnie</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <!-- Onglet Comptes Client -->
        <div class="tab-pane fade show active" id="client" role="tabpanel" aria-labelledby="client-tab">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4 class="m-2 font-weight-bold text-primary">
                        Comptes Client
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
                                    <th>ID</th>
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
                                    echo "<td>" . $row['id'] . "</td>";
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
        <!-- Onglet Comptes Compagnie -->
        <div class="tab-pane fade" id="compagnie" role="tabpanel" aria-labelledby="compagnie-tab">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4 class="m-2 font-weight-bold text-primary">
                        Comptes Compagnie
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
                                    <th>ID</th>
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
                                    echo "<td>" . $row['id'] . "</td>";
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
    </div>
</div>

<?php
include '../../includes/footer.php'; // Inclusion du pied de page
?>

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
                <form action="u_transac.php?action=ajouter" method="post">
                    <!-- Champs pour ajouter un utilisateur compagnie -->
                    <div class="form-group">
                        <input class="form-control" placeholder="Nom" name="nom" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Prénom" name="prenom" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Adresse Email" name="email" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Numéro de Téléphone" name="telephone" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Adresse" name="adresse" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Mot de Passe" name="mot_de_passe" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Profil" name="profil" required>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="id_compagnie" required>
                            <?php 
                            $sql = "SELECT id, nom_compagnie FROM compagnie";
                            $result = $connection->query($sql);

                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="'.$row['id'].'">'.$row['nom_compagnie'].'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-success">Enregistrer</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
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
                <form action="u_transac.php?action=ajouter" method="post">
                    <!-- Champs pour ajouter un utilisateur client -->
                    <div class="form-group">
                        <input class="form-control" placeholder="Nom" name="nom" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Prénom" name="prenom" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Adresse Email" name="email" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Numéro de Téléphone" name="telephone" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Adresse" name="adresse" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Mot de Passe" name="mot_de_passe" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Profil" name="profil" required>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="id_client" required>
                            <?php 
                            $sql = "SELECT id, nom_societe FROM client";
                            $result = $connection->query($sql);

                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="'.$row['id'].'">'.$row['nom_societe'].'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-success">Enregistrer</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Inclusion des scripts JavaScript -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<!-- Initialisation des tableaux DataTables -->
<script>
$(document).ready(function() {
    $('#dataTableClient').DataTable();
    $('#dataTableCompagnie').DataTable();
});
</script>


