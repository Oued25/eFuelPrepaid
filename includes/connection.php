<?php  
session_start();

    $nom_serveur = getenv("DB_HOST") ?: "localhost";
    $db = getenv("DB_NAME") ?: "eFuelPrepaid_DEV";
    //$db = "BDTEST";
    $utilisateur = getenv("DB_USER") ?: "root";
    $motpass = getenv("DB_PASSWORD") ?: "";

try {
    $connection = new PDO("mysql:host=$nom_serveur;dbname=$db", $utilisateur, $motpass);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $connection; 
} catch (Exception $e) {
    die("Erreur de connexion : " . $e->getMessage());
}