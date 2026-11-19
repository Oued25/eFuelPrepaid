<?php
//session_start();
include '../../includesSociete/connection.php';
require_once 'orange_api.php'; // fichier contenant sendOrangePayment()

// =====================
// RÉCUPÉRATION DES DONNÉES
// =====================

$id_user        = $_SESSION['id'];
$id_compagnie   = $_POST['id_compagnie'] ?? null;
$code_trans     = $_POST['code_trans'] ?? null;
$date_creation  = $_POST['date_creation'] ?? null;
$prix_achat     = str_replace(',', '', $_POST['prix_achat'] ?? 0);
$tel_benefic    = $_POST['tel_benefic'] ?? null;
$num_imatric    = $_POST['num_imatric'] ?? null;
$net_tva        = $_POST['net_tva'] ?? null;
$addtva         = $_POST['addtva'] ?? null;
$grand_total    = str_replace(',', '', $_POST['grand_total'] ?? 0);
$payment_method = $_POST['payment_method'] ?? null;
$num_paiment    = $_POST['num_paiment'] ?? null;
$otp            = $_POST['otp'] ?? null;

$produits = $_POST['produit'] ?? [];

// =====================
// VALIDATIONS BASIQUES
// =====================

if (empty($net_tva) || empty($addtva) || empty($grand_total)) {
    die("Erreur : informations manquantes.");
}

if ($payment_method !== "orange_money") {
    die("Seul Orange Money est autorisé pour l'instant.");
}

if (empty($otp)) {
    die("OTP manquant.");
}

// =====================
// APPEL API ORANGE
// =====================

$orangeData = [
    'customer_msisdn' => $num_paiment,
    'merchant_msisdn' => getenv('ORANGE_MERCHANT_MSISDN') ?: '',
    'api_username'    => getenv('ORANGE_API_USERNAME') ?: '',
    'api_password'    => getenv('ORANGE_API_PASSWORD') ?: '',
    'amount'          => $grand_total,
    'otp'             => $otp,
    'reference'       => $code_trans,
    'txn_id'          => uniqid("TXN_")
];

$result = sendOrangePayment($orangeData);

if (!$result['success']) {
    die("Erreur connexion Orange : " . $result['error']);
}

$responseXml = simplexml_load_string($result['response']);

$status  = (string) $responseXml->status;
$message = (string) $responseXml->message;

// ⚠️ Vérifier avec Orange le code succès exact (souvent 00)
if ($status !== "00") {
    die("Paiement refusé : " . $message);
}

// =====================
// SI ON ARRIVE ICI → PAIEMENT VALIDÉ
// =====================

try {

    $connection->beginTransaction();

    $query = "INSERT INTO transaction (
        code_trans, date_creation, otp, prix_achat, num_imatric,
        tel_benefic, payment_method, num_paiment,
        net_tva, add_tva, grand_total,
        id_statut, id_user, id_compagnie
    ) VALUES (
        :code_trans, :date_creation, :otp, :prix_achat, :num_imatric,
        :tel_benefic, :payment_method, :num_paiment,
        :net_tva, :add_tva, :grand_total,
        :id_statut, :id_user, :id_compagnie
    )";

    $stmt = $connection->prepare($query);
    $stmt->execute([
        ':code_trans'   => $code_trans,
        ':date_creation'=> $date_creation,
        ':otp'          => $otp,
        ':prix_achat'   => $prix_achat,
        ':num_imatric'  => $num_imatric,
        ':tel_benefic'  => $tel_benefic,
        ':payment_method'=> $payment_method,
        ':num_paiment'  => $num_paiment,
        ':net_tva'      => $net_tva,
        ':add_tva'      => $addtva,
        ':grand_total'  => $grand_total,
        ':id_statut'    => 1,
        ':id_user'      => $id_user,
        ':id_compagnie' => $id_compagnie,
    ]);

    // INSERT PRODUITS
    foreach ($produits as $produit) {

        $product_query = "INSERT INTO transaction_produits 
            (code_trans, id_produit, nom_produit, nom_compagnie)
            VALUES (:code_trans, :id_produit, :nom_produit, :nom_compagnie)";

        $product_stmt = $connection->prepare($product_query);
        $product_stmt->execute([
            ':code_trans'   => $code_trans,
            ':id_produit'   => $produit['id'],
            ':nom_produit'  => $produit['nom_produit'],
            ':nom_compagnie'=> $produit['nom_compagnie'],
        ]);
    }

    $connection->commit();

    unset($_SESSION['pointofsale']);

    echo "<script>alert('Paiement validé et transaction enregistrée ✅'); 
          window.location.href = 'pos.php';</script>";

} catch (Exception $e) {

    $connection->rollBack();
    die("Erreur base de données : " . $e->getMessage());
}
?>