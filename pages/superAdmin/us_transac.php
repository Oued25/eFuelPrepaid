<?php

include '../../includes/connection.php'; 

if (isset($_POST['nom'], 
         $_POST['prenom'], 
         $_POST['genre'], 
         $_POST['email'], 
         $_POST['mot_de_passe'], 
         $_POST['id_profil'])) {

    $nom = $_POST['nom']; 
    $prenom = $_POST['prenom'];
    $genre = $_POST['genre'];
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];
    $id_profil = $_POST['id_profil'];
    $id_compagnie = isset($_POST['id_compagnie']) ? $_POST['id_compagnie'] : NULL;
    $id_station = isset($_POST['id_station']) ? $_POST['id_station'] : NULL;
    $id_client = isset($_POST['id_client']) ? $_POST['id_client'] : NULL;

    try {
        $sql = "INSERT INTO utilisateur (nom, prenom, genre, email, mot_de_passe, id_profil, id_compagnie, id_station, id_client, date_creation, estActif)
                VALUES (:nom, :prenom, :genre, :email, :mot_de_passe, :id_profil, :id_compagnie, :id_station, :id_client, NOW(), 1)";
        $req = $connection->prepare($sql);
        $req->bindParam(':nom', $nom);
        $req->bindParam(':prenom', $prenom);
        $req->bindParam(':genre', $genre);
        $req->bindParam(':email', $email);
        $req->bindParam(':mot_de_passe', $mot_de_passe);
        $req->bindParam(':id_profil', $id_profil);
        $req->bindParam(':id_compagnie', $id_compagnie);
        $req->bindParam(':id_station', $id_station);
        $req->bindParam(':id_client', $id_client);

        $req->execute();

        header("Location: user.php");
        exit();
    } catch (PDOException $e) {
        echo "Erreur lors de l'ajout de l'utilisateur : " . $e->getMessage();
    }
} else {
    echo "Erreur : Données manquantes dans la requête POST.";
}
?>