<?php
// Inclusion du fichier de connexion PDO
include '../includes/connection.php';
include '../includes/sidebar.php';

// Requête pour récupérer le type de l'utilisateur
$query = 'SELECT ID, t.TYPE
          FROM users u
          JOIN type t ON t.TYPE_ID = u.TYPE_ID
          WHERE ID = :member_id';
$stmt = $connexion->prepare($query);
$stmt->bindParam(':member_id', $_SESSION['MEMBER_ID']);
$stmt->execute();

// Boucle pour vérifier le type de l'utilisateur
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $Aa = $row['TYPE'];

    // Vérification si l'utilisateur est de type "User"
    if ($Aa == 'User') {
?>
        <script type="text/javascript">
            // Redirection vers POS en cas de type "User"
            alert("Page restreinte ! Vous serez redirigé vers POS");
            window.location = "pos.php";
        </script>
<?php
    }
}
?>
<!-- Contenu de la page -->
<div class="col-lg-12">
    <?php
    // Récupération des données du formulaire
    $fname = $_POST['firstname'];
    $lname = $_POST['lastname'];
    $pn = $_POST['phonenumber'];

    // Switch pour gérer l'action
    switch ($_GET['action']) {
        case 'add':
            // Requête d'insertion dans la table "customer"
            $query = "INSERT INTO customer
                    (CUST_ID, FIRST_NAME, LAST_NAME, PHONE_NUMBER)
                    VALUES (Null,'{$fname}','{$lname}','{$pn}')";
            // Exécution de la requête
            $stmt = $connexion->query($query);
            break;
    }
    ?>
    <script type="text/javascript">
        // Redirection vers POS après l'ajout du client
        window.location = "pos.php";
    </script>
</div>

<?php
include '../includes/footer.php';
?>
