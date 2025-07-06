<?php  
include '../../includesSociete/connection.php';

// Récupération des données POST
$code_trans = $_POST['code_trans'] ?? null;
$date_creation = $_POST['date_creation'] ?? null;
$prix_achat = $_POST['prix_achat'] ?? null;
$tel_benefic = $_POST['tel_benefic'] ?? null;
$num_imatric = $_POST['num_imatric'] ?? null;
$net_tva = $_POST['net_tva'] ?? null;
$addtva = $_POST['addtva'] ?? null;
$grand_total = $_POST['grand_total'] ?? null;
$payment_method = $_POST['payment_method'] ?? null;
$id_produit = $_POST['id'] ?? [];
$nom_produit = $_POST['nom_produit'] ?? [];
$num_paiment = $_POST['num_paiment'] ?? null;
$otp = $_POST['otp'] ?? null;

// Vérification que les variables sont valides
if (!is_array($id_produit)) {
    $id_produit = [$id_produit]; // Transforme en tableau si ce n'en est pas un
}

//var_dump( $date_creation, $otp, $net_tva, $addtva, $grand_total,$num_paiment, $id_produit, $payment_method, $num_imatric, $tel_benefic,$prix_achat,);
var_dump($id_produit, $nom_produit);
exit();  // Arrêter le script pour vérifier les valeurs affichées


// Vérification des données nécessaires
if (empty($net_tva) || empty($addtva) || empty($grand_total)) {
    die("Erreur : certaines informations requises sont manquantes.");
}

try {  
    // Démarre une transaction
    $connection->beginTransaction();

    // Insertion des informations principales
    $query = "INSERT INTO transaction (
                code_trans, date_creation, otp, prix_achat, num_imatric, tel_benefic, payment_method, 
                num_paiment, net_tva, add_tva, grand_total, id_statut
              ) 
              VALUES (
                :code_trans, :date_creation, :otp, :prix_achat, :num_imatric, :tel_benefic, :payment_method, 
                :num_paiment, :net_tva, :add_tva, :grand_total, :id_statut)";
    $stmt = $connection->prepare($query);
    $stmt->execute([
        ':code_trans' => $code_trans,
        ':date_creation' => $date_creation,
        ':otp' => $otp,
        ':prix_achat' => $prix_achat,
        ':num_imatric' => $num_imatric,
        ':tel_benefic' => $tel_benefic,
        ':payment_method' => $payment_method,
        ':num_paiment' => $num_paiment,
        ':net_tva' => $net_tva,
        ':add_tva' => $addtva,
        ':grand_total' => $grand_total,
        ':id_statut' => 1, // Statut par défaut
    ]);

    // Insertion des produits associés
    for ($i = 0; $i < count($id_produit); $i++) {
        $product_query = "INSERT INTO transaction_produits (code_trans, id_produit, nom_produit) 
                          VALUES (:code_trans, :id_produit, :nom_produit)";
        $product_stmt = $connection->prepare($product_query);
        $product_stmt->execute([
            ':code_trans' => $code_trans,
            ':id_produit' => $id_produit[$i],
            ':nom_produit' => $nom_produit[$i], // Corrigé pour insérer chaque nom de produit
        ]);
    }

    // Validation de la transaction
    $connection->commit();
    echo "<script>alert('Transaction réussie'); window.location.href = 'pos.php';</script>";

} catch (Exception $e) {
    // Annule la transaction en cas d'erreur
    $connection->rollBack();
    die("Erreur : " . $e->getMessage());
}
?>
