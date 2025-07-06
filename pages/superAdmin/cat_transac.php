<?php
include '../../includes/connection.php';

// Vérification de l'existence des données soumises
if(isset($_POST['nom_categorie'],
         $_POST['descrip_categorie'])) {
    // Récupération des valeurs du formulaire
    $cat = $_POST['nom_categorie'];
    $desc = $_POST['descrip_categorie'];

    switch ($_GET['action']) {
        case 'add':
            // Préparation de la requête
            $sql = "INSERT INTO categorie (id, nom_categorie, descrip_categorie, estActif) 
                    VALUES (NULL, ?, ?, 1);"; // Utilisation de marqueurs de paramètres anonymes
            $req = $connection->prepare($sql);
            
            // Liaison des paramètres
            $req->bindParam(1, $cat); // 1 correspond au premier marqueur de paramètre dans la requête
            $req->bindParam(2, $desc); // 2 correspond au deuxième marqueur de paramètre dans la requête

            // Exécution de la requête
            $req->execute();
            
            break;
    }
}

// Redirection vers la page des catégories
header("Location: categorie.php");
exit();

?>
