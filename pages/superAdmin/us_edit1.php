<?php
include '../../includes/connection.php'; 

// Récupération des valeurs des champs du formulaire 
$zz = $_POST['id'];
$nom = $_POST['nom'];
$pnom = $_POST['prenom'];
$gen = $_POST['genre']; 
$em = $_POST['email'];
$pass = $_POST['mot_de_passe'];
$pro = $_POST['id_profil'];
//$dmo = date('Y-m-d H:i:s'); // Date de modification actuelle

// Requête SQL corrigée
$sql = 'UPDATE utilisateur AS u
        SET 
            u.nom = :nom,
            u.prenom = :pnom,
            u.genre = :gen,
            u.email = :em,
            u.mot_de_passe = :pass,
            u.id_profil = :pro, 
            u.date_modif = :dmo 
        WHERE u.id = :id';

// Préparation de la requête
$req = $connection->prepare($sql);

// Liaison des paramètres
$req->bindParam(':id', $zz);
$req->bindParam(':nom', $nom);
$req->bindParam(':pnom', $pnom);
$req->bindParam(':gen', $gen);
$req->bindParam(':em', $em);
$req->bindParam(':pass', $pass);
$req->bindParam(':pro', $pro);
$req->bindParam(':dmo', $dmo);

// Exécution de la requête
try {
    $result = $req->execute();

    // Vérification de l'exécution de la requête
    if ($result) {
        ?>
        <script type="text/javascript">
            alert("Utilisateur modifié avec succès.");
            window.location = "user.php";
        </script>
        <?php
    } else {
        echo "Erreur lors de la modification de l'utilisateur.";
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
