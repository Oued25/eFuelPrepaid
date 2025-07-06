<!-- Enveloppeur de contenu -->
<div id="content-wrapper" class="d-flex flex-column">

  <!-- Contenu principal -->
  <div id="content"> 

    <!-- Barre supérieure -->
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

      <!-- Bouton de bascule de la barre latérale (Topbar) -->
      <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
      </button>

      <!-- Barre de navigation supérieure -->

      <center><p><h2>Tableau De Bord <?php echo isset($_SESSION['nom_compagnie']) ? $_SESSION['nom_compagnie'] : ''; ?> Compagnie</h2></p></center>

      <ul class="navbar-nav ml-auto">
        <!-- Élément de menu - POS -->
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link" href="pos.php" role="button">
            <span class="mr-2 d-none d-lg-inline text-gray-600 small"></span> 
          </a>
        </li>

        <!-- Diviseur supérieur -->
        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Élément de menu - Informations utilisateur -->
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="mr-2 d-none d-lg-inline text-gray-600 small"> <?php echo isset($_SESSION['nom']) ? $_SESSION['nom'] : ''; ?> <?php echo isset($_SESSION['prenom']) ? $_SESSION['prenom'] : ''; ?></span>
            <img class="img-profile rounded-circle" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTS0rikanm-OEchWDtCAWQ_s1hQq1nOlQUeJr242AdtgqcdEgm0Dg">
          </a>

          <!--?php
                require_once('connection.php');

                $query = 'SELECT ID, FIRST_NAME, LAST_NAME, USERNAME, PASSWORD
                          FROM users u
                          JOIN employee e ON e.EMPLOYEE_ID = u.EMPLOYEE_ID';
                $result = $connexion->query($query);
                if (!$result) {
                    die("Erreur lors de l'exécution de la requête : " . $connexion->errorInfo()[2]);
                }

                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $a = $_SESSION['MEMBER_ID'];
                }
            ?-->

          <!-- Menu déroulant - Informations utilisateur -->
          <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
            <button class="dropdown-item" onclick="on()">
              <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
              Profile
            </button>
            <a class="dropdown-item" href="settings.php?action=edit & id='<?php echo $a; ?>'">
              <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
              Réglage
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
              <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
              Déconnexion
            </a>
          </div>
        </li>

      </ul>

    </nav>
    <!-- Fin de la barre supérieure -->

    <!-- Début du contenu de la page -->
    <div class="container-fluid">


    <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Se déconnecter?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body"><?php echo  $_SESSION['FIRST_NAME']; ?> Etes vous sure de vouloir quitter?</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
          <a class="btn btn-primary" href="../logout.php">Déconnecter</a>
        </div>
      </div>
    </div>
  </div>