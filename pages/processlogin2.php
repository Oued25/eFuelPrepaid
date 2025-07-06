<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// processlogin.php
require('../includes/connection.php');
require('session.php');

if (isset($_POST['btnlogin'])) { // Vérifie si le bouton de soumission a été envoyé

    // Afficher les valeurs des variables POST pour le débogage
    echo '<pre>';
    var_dump($_POST['btnlogin']);
    echo '</pre>';

    if (!empty($_POST['contact']) && !empty($_POST['mot_de_passe'])) {
        $contact = $_POST['contact'];
        $mot_de_passe = $_POST['mot_de_passe'];

        // Requête SQL pour récupérer l'utilisateur en fonction du nom d'utilisateur
        $sql = 'SELECT u.id, u.nom, u.prenom, u.contact, u.mot_de_passe, p.nom_profil
                FROM utilisateur u
                JOIN profil p ON u.id_profil = p.id
                WHERE u.contact = ?';

        $recpUser = $connection->prepare($sql);
        $recpUser->execute([$contact]);
        $user = $recpUser->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Vérification du mot de passe
            if ($mot_de_passe == $user['mot_de_passe']) {
                // Stockage des données dans des variables de session
                session_start();
                $_SESSION['id'] = $user['id'];
                $_SESSION['nom'] = $user['nom'];
                $_SESSION['prenom'] = $user['prenom'];
                $_SESSION['contact'] = $user['contact'];
                $_SESSION['nom_profil'] = $user['nom_profil'];

                // Redirection en fonction du type d'utilisateur
                switch ($_SESSION['nom_profil']) {
                    
                    case "Utilisateur Client Particulier":
                        header('Location: clientParticulier/index.php');
                        exit();
                    default:
                        $_SESSION['message']['text'] = "Profil inconnu!";
                        $_SESSION['message']['type'] = "warning";
                        header('Location: login.php');
                        exit();
                }
            } else {
                // Mot de passe incorrect
                $_SESSION['message']['text'] = "Mot de passe incorrect !";
                $_SESSION['message']['type'] = "warning";
                header('Location: login.php');
                exit();
            }
        } else {
            // Nom d'utilisateur non trouvé
            $_SESSION['message']['text'] = "Utilisateur non enregistré ! <br> Contactez votre administrateur.";
            $_SESSION['message']['type'] = "error";
            header('Location: login.php');
            exit();
        }
    } else {
        // Champs vides
        $_SESSION['message']['text'] = "Veuillez remplir tous les champs!";
        $_SESSION['message']['type'] = "warning";
        header('Location: login.php');
        exit();
    }
}

// Fermeture de la connexion PDO
$connection = null;
?>
