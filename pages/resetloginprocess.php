<?php
session_start(); // Assure l'utilisation des variables de session

require('../includes/connection.php');

// Vérifie que la requête est bien de type POST (soumise par un formulaire)
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Récupère et nettoie le numéro de téléphone soumis par le formulaire
    $contact = trim($_POST['contact']);

    // Prépare une requête SQL pour vérifier si ce contact existe dans la table 'utilisateur'
    $stmt = $connection->prepare("SELECT * FROM utilisateur WHERE contact = :contact");
    $stmt->bindParam(':contact', $contact);
    $stmt->execute();

    // Vérifie si une ligne a été trouvée (le contact existe dans la base)
    if ($stmt->rowCount() > 0) {

        // Génère un code OTP aléatoire à 6 chiffres
        $otp = random_int(100000, 999999);

        // Enregistre le contact et l'OTP dans la session
        $_SESSION['reset_contact'] = $contact;
        $_SESSION['otp_code'] = $otp;
        $_SESSION['otp_expires_at'] = time() + 300; // valable 5 minutes

        // Met à jour l'utilisateur avec l'OTP (assure-toi que la colonne `otp_code` existe dans la table `utilisateur`)
        $update = $connection->prepare("UPDATE utilisateur SET otp_code = :otp WHERE contact = :contact");
        $update->execute([
            'otp' => $otp,
            'contact' => $contact
        ]);

        // (Optionnel) — Affiche l’OTP à l’écran pour test
         //echo "Votre code OTP est : " . $otp;

        // Redirige vers la page de saisie du code OTP
        header("Location: otpform.php");
        exit();

    } else {
        // Si le contact n’existe pas dans la base
        $_SESSION['reset_error'] = "Ce numéro n'existe pas dans notre base.";
        header("Location: resetlogin.php");
        exit();
    }

} else {
    // Redirige vers la page de connexion si accès non autorisé
    header("Location: login2.php");
    exit();
}
