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

    if (!empty($_POST['email']) && !empty($_POST['mot_de_passe'])) {
        $email = $_POST['email'];
        $mot_de_passe = $_POST['mot_de_passe'];

        // Requête SQL pour récupérer l'utilisateur en fonction du nom d'utilisateur
        $sql = 'SELECT u.id, u.nom, u.prenom, u.email, u.mot_de_passe, p.nom_profil, u.id_compagnie, c.nom_compagnie, 
                       u.id_station, s.nom_station, u.id_client, cl.nom_societe, cl.id_type, t.nom_type
                FROM utilisateur u
                JOIN profil p ON u.id_profil = p.id
                LEFT JOIN compagnie c ON u.id_compagnie = c.id
                LEFT JOIN station AS s ON u.id_station = s.id 
                LEFT JOIN client AS cl ON u.id_client = cl.id
                LEFT JOIN type AS t ON cl.id_type = t.id
                WHERE u.email = ?';

        $recpUser = $connection->prepare($sql);
        $recpUser->execute([$email]);
        $user = $recpUser->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Vérification du mot de passe
            if ($mot_de_passe == $user['mot_de_passe']) {
                // Stockage des données dans des variables de session
                session_start();
                $_SESSION['id'] = $user['id'];
                $_SESSION['nom'] = $user['nom'];
                $_SESSION['prenom'] = $user['prenom'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['nom_profil'] = $user['nom_profil'];
                $_SESSION['id_compagnie'] = $user['id_compagnie'];
                $_SESSION['nom_compagnie'] = $user['nom_compagnie'];
                $_SESSION['id_station'] = $user['id_station'];
                $_SESSION['nom_station'] = $user['nom_station'];
                $_SESSION['id_client'] = $user['id_client'];
                $_SESSION['nom_societe'] = $user['nom_societe'];

                // Redirection en fonction du type d'utilisateur
                switch ($_SESSION['nom_profil']) {
                    case "Super Admin":
                        header('Location: superAdmin/index.php');
                        exit();
                    case "Gestionnaire Compagnie":
                    case "Utilisateur Compagnie":
                        header('Location: compagnie/index.php');
                        exit();
                    case "Gestionnaire Station":
                    case "Utilisateur Station":
                        header('Location: station/index.php');
                        exit();
                    case "Gestionnaire Client":
                    case "Utilisateur Client Entreprise":
                        header('Location: clientSociete/index.php');
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
