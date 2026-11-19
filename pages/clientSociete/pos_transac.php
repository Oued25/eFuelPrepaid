<?php
//session_start();
include '../../includesSociete/connection.php';
require_once 'orange_api.php';

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

// =====================
// PARSING + LOGGING ← NOUVEAU
// =====================

$responseXml = simplexml_load_string($result['response']);

$status   = (string) ($responseXml->status  ?? $responseXml->STATUS  ?? '');
$message  = (string) ($responseXml->message ?? $responseXml->MESSAGE ?? '');
$txn_id   = (string) ($responseXml->txnid   ?? $responseXml->TXNID   ?? '');

// 📋 LOG TEMPORAIRE — à supprimer après validation du code de succès
$log  = "==============================\n";
$log .= "Date       : " . date('Y-m-d H:i:s') . "\n";
$log .= "code_trans : " . $code_trans . "\n";
$log .= "Montant    : " . $grand_total . " FCFA\n";
$log .= "Status     : " . $status . "\n";
$log .= "Message    : " . $message . "\n";
$log .= "TxnID      : " . $txn_id . "\n";
$log .= "XML brut   :\n" . $result['response'] . "\n";
$log .= "==============================\n\n";

file_put_contents('/tmp/orange_response.txt', $log, FILE_APPEND);

// =====================
// VÉRIFICATION DU STATUT
// ⚠️ Le code "00" sera confirmé après le premier vrai test
// =====================

if ($status !== "00") {
    die("
        <div style='font-family:Arial; max-width:500px; margin:50px auto; 
                    padding:20px; border:2px solid #dc3545; border-radius:8px;'>
            <h3 style='color:#dc3545;'>❌ Paiement refusé</h3>
            <p><strong>Code retourné :</strong> $status</p>
            <p><strong>Message Orange :</strong> $message</p>
            <p><strong>ID Transaction :</strong> $txn_id</p>
            <hr>
            <p style='font-size:12px; color:#888;'>
                Si vous pensez que c'est une erreur, vérifiez le log :<br>
                <code>cat /tmp/orange_response.txt</code>
            </p>
            <a href='pos.php' style='display:inline-block; margin-top:10px; 
               padding:8px 16px; background:#FF6600; color:#fff; 
               border-radius:5px; text-decoration:none;'>
                ← Retour au POS
            </a>
        </div>
    ");
}

// =====================
// PAIEMENT VALIDÉ → INSERTION EN BASE
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
        ':code_trans'    => $code_trans,
        ':date_creation' => $date_creation,
        ':otp'           => $otp,
        ':prix_achat'    => $prix_achat,
        ':num_imatric'   => $num_imatric,
        ':tel_benefic'   => $tel_benefic,
        ':payment_method'=> $payment_method,
        ':num_paiment'   => $num_paiment,
        ':net_tva'       => $net_tva,
        ':add_tva'       => $addtva,
        ':grand_total'   => $grand_total,
        ':id_statut'     => 1,
        ':id_user'       => $id_user,
        ':id_compagnie'  => $id_compagnie,
    ]);

    // INSERT PRODUITS
    foreach ($produits as $produit) {
        $product_query = "INSERT INTO transaction_produits 
            (code_trans, id_produit, nom_produit, nom_compagnie)
            VALUES (:code_trans, :id_produit, :nom_produit, :nom_compagnie)";

        $product_stmt = $connection->prepare($product_query);
        $product_stmt->execute([
            ':code_trans'    => $code_trans,
            ':id_produit'    => $produit['id'],
            ':nom_produit'   => $produit['nom_produit'],
            ':nom_compagnie' => $produit['nom_compagnie'],
        ]);
    }

    $connection->commit();

    unset($_SESSION['pointofsale']);

    // Redirection vers pos_recu.php avec le code de transaction
    header("Location: pos_recu.php?code_trans=" . urlencode($code_trans));
    exit();

} catch (Exception $e) {
    $connection->rollBack();
    die("Erreur base de données : " . $e->getMessage());
}
?>
