<?php
require('connexion.php');
session_start();

if (isset($_POST['btn_reset'])) {
    $contact = $_POST['contact'];
    $nouveau_mdp = $_POST['nouveau_mdp'];
    $confirm_mdp = $_POST['confirm_mdp'];

    if ($nouveau_mdp !== $confirm_mdp) {
        $_SESSION['reset_error'] = "Les mots de passe ne correspondent pas.";
        header("Location: reset_password.php");
        exit();
    }

    try {
        $stmt = $connection->prepare("SELECT id FROM utilisateur WHERE contact = :contact");
        $stmt->bindParam(":contact", $contact);
        $stmt->execute();

        if ($stmt->rowCount() === 1) {
            $mdp_hash = password_hash($nouveau_mdp, PASSWORD_DEFAULT);

            $update = $connection->prepare("UPDATE utilisateur SET mot_de_passe = :mdp WHERE contact = :contact");
            $update->bindParam(":mdp", $mdp_hash);
            $update->bindParam(":contact", $contact);
            $update->execute();

            $_SESSION['reset_success'] = "Mot de passe mis à jour. Veuillez vous connecter.";
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['reset_error'] = "Aucun utilisateur trouvé avec ce contact.";
            header("Location: reset_password.php");
            exit();
        }
    } catch (Exception $e) {
        $_SESSION['reset_error'] = "Erreur serveur : " . $e->getMessage();
        header("Location: reset_password.php");
        exit();
    }
}
