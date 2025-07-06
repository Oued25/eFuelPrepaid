<!DOCTYPE html>  
<html lang="fr">

<head>
  <!-- Styles CSS -->
  <style type="text/css">
    /* Styles pour l'overlay */  
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
    /* Styles pour le texte au centre de l'overlay */
    #text {
      position: absolute;
      top: 50%;
      left: 50%;
      font-size: 50px;
      color: white;
      transform: translate(-50%,-50%);
      -ms-transform: translate(-50%,-50%);
    }
  </style>
  <!-- Méta-informations -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Titre de la page -->
  <title>eFuelPrepaid</title>
  <!-- Icône de la page -->
  <link rel="icon" href="https://www.freeiconspng.com/uploads/sales-icon-7.png">

  <!-- Feuilles de style personnalisées -->
  <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="../../css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Styles personnalisés pour cette page -->
  <link href="../../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body id="page-top">
          
  <!-- Conteneur de la page -->
  <div id="wrapper">

    <!-- Barre latérale -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Marque de la barre latérale -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">e.Fuel_Prepaid</div>
      </a>

      <!-- Séparateur -->
      <hr class="sidebar-divider my-0">

      <!-- Élément de navigation - Dashboard -->
      <li class="nav-item">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-home"></i>
          <span>Accueil</span></a>
      </li>

      <!-- Séparateur -->
      <hr class="sidebar-divider">

      <!-- En-tête -->
      <div class="sidebar-heading">
        Gestion Client
      </div>

      <!-- Boutons des tables -->
      
      <li class="nav-item">
        <a class="nav-link" href="POS.php">
        <i class="fas fa-fw fa-retweet"></i>
          <span>Faire Un Achat</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="transaction.php">
        <i class="fas fa-fw fa-table"></i>
          <span>Liste Transaction</span></a>
      </li>
      <!-- Séparateur -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Basculer la barre latérale (Sidebar Toggler) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- Fin de la barre latérale -->

    <!-- Inclusion de la barre supérieure -->
    <?php include_once 'topbar.php'; ?> 
