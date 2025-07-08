<?php  
session_start();// une fonction qui permet d'afficher les messages d'erreur de connexion en utilisant une varible  $_SESSION
                // il a ete placer à ce niveau parce tout comme le ficher connexion.php, il sera appler dans tous les qutre ficher du code
    $nom_serveur = "62.171.183.84";
    $db = "eFuelPrepaid_DEV2";
    $utilisateur = "ubuntu";  
    $motpass = "bUDhKxE4$)oSQ";

try {
    $connection = new PDO("mysql:host=$nom_serveur;dbname=$db", $utilisateur, $motpass);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $connection; 
} catch (Exception $e) {
    die("Erreur de connexion : " . $e->getMessage());
}