<?php

$server = "localhost";
$user = "root";
$pass = "";
$database = "scms";

try {
    // Créer une instance de PDO
    $conn = new PDO("mysql:host=$server;dbname=$database", $user, $pass);

    // Configurer PDO pour afficher les erreurs
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Si la connexion réussit, afficher un message (optionnel)
    // echo "<script>alert('Connexion réussie.')</script>";

} catch (PDOException $e) {
    // Si la connexion échoue, afficher l'erreur
    die("<script>alert('Erreur de connexion : " . $e->getMessage() . "')</script>");
}

?>
