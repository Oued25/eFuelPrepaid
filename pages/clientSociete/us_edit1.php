<?php
//var_dump($_POST);
include '../../includesSociete/connection.php';  

// Récupération des valeurs des champs du formulaire
$nom = $_POST['nom'];
$pnom = $_POST['prenom'];
$em = $_POST['email'];
$pass = $_POST['mot_de_passe'];
$pro = $_POST['id_profil'];

// Requête SQL avec PDO
$sql = 'UPDATE utilisateur AS u, profil AS p
        SET u.nom = :nom,
            u.prenom = :pnom,
            u.mot_de_passe = :pass,
            u.id_profil = :pro, 
            u.date_modif = :dmo  
        WHERE u.email = :em
        AND p.id = u.id_profil';

// Préparation de la requête
$req = $connection->prepare($sql);

// Liaison des paramètres
$req->bindParam(':nom', $nom);
$req->bindParam(':pnom', $pnom);
$req->bindParam(':em', $em);
$req->bindParam(':pass', $pass);
$req->bindParam(':pro', $pro);
$req->bindParam(':dmo', $dmo);

// Exécution de la requête
$result = $req->execute();

// Vérification de l'exécution de la requête
if ($result) {
    ?>
    <script type="text/javascript">
        alert("Utilisateur modifier avec succès.");
        window.location = "user.php";
    </script>
    <?php
} else {
    echo "Erreur de la Modification du Utilisateur";
    
}

?>
