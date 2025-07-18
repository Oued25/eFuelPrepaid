<?php
  // Inclusion du fichier de session et vérification de la connexion
  require_once('session.php');
  confirm_logged_in();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Styles pour l'overlay -->
  <style type="text/css">
    #overlay {
      position: fixed;
      display: none;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: rgba(0,0,0,0.5);
      z-index: 2;
      cursor: pointer;
    }
    #text{
      position: absolute;
      top: 50%;
      left: 50%;
      font-size: 50px;
      color: white;
      transform: translate(-50%,-50%);
      -ms-transform: translate(-50%,-50%);
    }
  </style>
  
  <!-- Métadonnées et liens vers les styles -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>eFuel_Prepaid</title>
  <link rel="icon" href="https://www.freeiconspng.com/uploads/sales-icon-7.png">

  <!-- Styles personnalisés pour ce modèle -->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="../css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Styles personnalisés pour cette page -->
  <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link rel="stylesheet" href="cart.css" />
</head>

<body id="page-top">
  
  <!-- Enveloppeur de la page -->
  <div id="wrapper">

    <!-- Enveloppeur de contenu -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Contenu principal -->
      <div id="content">

        <!-- Barre supérieure -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Marque de la barre latérale -->
          <a class="sidebar-brand d-flex align-items-center justify-content-center"  style="text-decoration: none; font-size: 18px; font-weight: bold;" href="index.php">
            <div class="sidebar-brand-icon rotate-n-15">
              <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">eFuel_Prepaid</div>
          </a>

          <!-- Barre de navigation supérieure -->
          <ul class="navbar-nav ml-auto">

            <!-- Élément de menu - POS -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link" href="pos.php" role="button">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Achat</span>
              </a>
            </li>

            <!-- Diviseur supérieur -->
            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Élément de menu - Informations utilisateur -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo  $_SESSION['FIRST_NAME']. ' '.$_SESSION['LAST_NAME'] ;?></span>
                <img class="img-profile rounded-circle"
                <?php
                  // Affichage de l'image de profil en fonction du genre de l'utilisateur
                  if($_SESSION['GENDER']=='Male'){
                    echo 'src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTS0rikanm-OEchWDtCAWQ_s1hQq1nOlQUeJr242AdtgqcdEgm0Dg"';
                  }else{
                    echo 'src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSNngF0RFPjyGl4ybo78-XYxxeap88Nvsyj1_txm6L4eheH8ZBu"';
                  }
                ?>>

              </a>

              <?php
                // Requête pour récupérer les informations de l'utilisateur
                $query = 'SELECT ID, FIRST_NAME, LAST_NAME, USERNAME, PASSWORD, t.TYPE
                          FROM users u
                          JOIN employee e ON e.EMPLOYEE_ID = u.EMPLOYEE_ID
                          JOIN type t ON t.TYPE_ID = u.TYPE_ID';
                $stmt = $connexion->query($query);
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($rows as $row) {
                    $a = $_SESSION['MEMBER_ID'];
                    $bbb = $_SESSION['TYPE'];
                }
                ?>


              <!-- Menu déroulant - Informations utilisateur -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <button class="dropdown-item" onclick="on()">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </button>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#settingsModal" data-href="settings.php?action=edit & id='<?php echo $a; ?>'">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Règlage
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
