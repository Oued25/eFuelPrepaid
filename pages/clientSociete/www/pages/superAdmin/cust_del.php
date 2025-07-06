<?php
// Inclusion du fichier de connexion PDO
include '../includes/connection.php';
include '../includes/sidebar.php';

// Vérification du type d'utilisateur
$query = 'SELECT ID, t.TYPE FROM users u JOIN type t ON t.TYPE_ID=u.TYPE_ID WHERE ID = :member_id';
$stmt = $connexion->prepare($query);
$stmt->bindParam(':member_id', $_SESSION['MEMBER_ID']);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$Aa = $row['TYPE'];

if ($Aa == 'User') { 
?>
<script type="text/javascript">
    alert("Page restreinte ! Vous serez redirigé vers Achat");
    window.location = "pos.php";
</script>
<?php
}

// Vérification du type de requête
if (!isset($_GET['id']) || $_GET['id'] != 1) {
    switch ($_GET['id']) {
        case 'customer':
            // Suppression d'une station
            $query = 'DELETE FROM customer WHERE CUST_ID = :cust_id';
            $stmt = $connexion->prepare($query);
            $stmt->bindParam(':cust_id', $_GET['id']);
            $stmt->execute();
?>
<script type="text/javascript">
    alert("Station Service supprimé avec succès.");
    window.location = "customer.php";
</script>
<?php
            break;
    }
}
?>
