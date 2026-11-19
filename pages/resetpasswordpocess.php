<?php
session_start(); // indispensable si tu utilises $_SESSION
require('../includes/connection.php');

if (isset($_POST['btn_reset'])) {
    $contact = $_POST['contact'];
    $nouveau_mdp = $_POST['nouveau_mdp'];
    $confirm_mdp = $_POST['confirm_mdp'];

    // Vérifie que les deux mots de passe sont identiques
    if ($nouveau_mdp !== $confirm_mdp) {
        $_SESSION['reset_error'] = "Les mots de passe ne correspondent pas.";
        header("Location: resetpassword.php");
        exit();
    }

    try {
        // Vérifie que l'utilisateur existe bien avec ce contact
        $stmt = $connection->prepare("SELECT id FROM utilisateur WHERE contact = :contact");
        $stmt->bindParam(":contact", $contact);
        $stmt->execute();

        if ($stmt->rowCount() === 1) {
            // Enregistre le mot de passe en clair (ATTENTION : temporaire pour tests uniquement)
            //$mot_de_passe_en_clair = $nouveau_mdp;

            // Mise à jour dans la base
            $update = $connection->prepare("UPDATE utilisateur SET mot_de_passe = :mdp WHERE contact = :contact");
            $update->bindParam(":mdp", $nouveau_mdp);
            $update->bindParam(":contact", $contact);
            $update->execute();

            $_SESSION['reset_success'] = "Mot de passe mis à jour. Veuillez vous connecter.";
            header("Location: login2.php");
            exit();

        } else {
            $_SESSION['reset_error'] = "Aucun utilisateur trouvé avec ce contact.";
            header("Location: resetlogin.php");
            exit();
        }
    } catch (Exception $e) {
        $_SESSION['reset_error'] = "Erreur serveur : " . $e->getMessage();
        header("Location: resetlogin.php");
        exit();
    }
}
