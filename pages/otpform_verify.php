<?php
require('../includes/connection.php');

// Vérifie que la requête vient bien du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Récupération du code OTP saisi par l'utilisateur
    $otp_saisi = trim($_POST['otp']);

    // Vérifie que les infos nécessaires existent bien dans la session
    if (
        isset($_SESSION['otp_code']) &&
        isset($_SESSION['otp_expires_at']) &&
        isset($_SESSION['reset_contact'])
    ) {
        // Vérifie si l'OTP n'a pas expiré
        if (time() <= $_SESSION['otp_expires_at']) {

            // Comparaison du code saisi et de celui en session
            if ($otp_saisi == $_SESSION['otp_code']) {

                // L'OTP est correct → on autorise l'accès à la réinitialisation
                $_SESSION['otp_valid'] = true;

                // Redirection vers la page de réinitialisation du mot de passe
                header("Location: resetpassword.php");
                exit();

            } else {
                // Mauvais code
                $_SESSION['otp_error'] = "Le code OTP saisi est incorrect.";
                header("Location: otpform.php");
                exit();
            }

        } else {
            // OTP expiré
            $_SESSION['otp_expires_at'] = "Le code OTP a expiré. Veuillez recommencer.";
            header("Location: resetlogin.php"); // ou otpform.php pour renvoyer un nouveau OTP
            exit();
        }

    } else {
        // Session incomplète ou manipulation
        $_SESSION['otp_error'] = "Session expirée ou invalide. Veuillez recommencer.";
        header("Location: resetlogin.php");
        exit();
    }

} else {
    // Accès non autorisé
    header("Location: login2.php");
    exit();
}
