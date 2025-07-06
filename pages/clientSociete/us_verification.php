<?php
//include '../../includesSociete/connection.php'; 
// include '../../includesSociete/sidebar.php';

ob_start(); // Tamponner la sortie


 function verifierConnexion() {
    //session_start();

    // Délai d'expiration en secondes
    $timeout = 120; // 30 minutes

    if (!isset($_SESSION['id'])) {
        header('Location: ../login.php');
        exit();
    }

    // Vérifiez l'activité récente
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout) {
        session_unset();
        session_destroy();
        header('Location: ../login.php');
        exit("Erreur : Session expirée.");
    }
    $_SESSION['last_activity'] = time(); // Réinitialise l'horodatage de l'activité
}
  ?>