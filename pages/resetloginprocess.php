<?php
session_start();
require('connexion.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $contact = trim($_POST['contact']);

    // Vérifie si le numéro de téléphone existe
    $stmt = $connection->prepare("SELECT * FROM utilisateur WHERE contact = :contact");
    $stmt->bindParam(':contact', $contact);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Stocker le contact en session pour usage dans la prochaine étape
        $_SESSION['reset_contact'] = $contact;
        header("Location: new_password.php");
        exit();
    } else {
        $_SESSION['reset_error'] = "Ce numéro n'existe pas dans notre base.";
        header("Location: reset_password.php");
        exit();
    }
} else {
    header("Location: reset_password.php");
    exit();
}
