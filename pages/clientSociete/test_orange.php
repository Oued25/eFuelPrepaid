<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
// ... reste du code
// =====================================================================
// test_orange.php — Script de test autonome Orange Money BF
// À déposer dans le même dossier que orange_api.php
// SUPPRIMER ce fichier après les tests !
// =====================================================================

// Sécurité basique : protéger le script de test
define('TEST_MODE', true);

// Inclure votre fichier API
require_once 'orange_api.php';

$result_brut  = null;
$result_parse = null;
$erreur       = null;
$xml_envoye   = null;

// =====================================================================
// TRAITEMENT DU FORMULAIRE
// =====================================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = [
        'customer_msisdn' => trim($_POST['customer_msisdn'] ?? ''),
        'merchant_msisdn' => trim($_POST['merchant_msisdn'] ?? ''),
        'api_username'    => trim($_POST['api_username']    ?? ''),
        'api_password'    => trim($_POST['api_password']    ?? ''),
        'amount'          => intval($_POST['amount']        ?? 0),
        'otp'             => trim($_POST['otp']             ?? ''),
        'reference'       => 'TEST_' . date('YmdHis'),
        'txn_id'          => uniqid('TXN_TEST_'),
    ];

    // Générer le XML tel qu'il sera envoyé
    $xml_envoye = '<?xml version="1.0" encoding="UTF-8"?>
<COMMAND>
    <TYPE>OMPREQ</TYPE>
    <customer_msisdn>' . htmlspecialchars($data['customer_msisdn']) . '</customer_msisdn>
    <merchant_msisdn>' . htmlspecialchars($data['merchant_msisdn']) . '</merchant_msisdn>
    <api_username>'    . htmlspecialchars($data['api_username'])    . '</api_username>
    <api_password>'    . htmlspecialchars($data['api_password'])    . '</api_password>
    <amount>'          . $data['amount']                            . '</amount>
    <PROVIDER>101</PROVIDER>
    <PROVIDER2>101</PROVIDER2>
    <PAYID></PAYID>
    <PAYID2>12</PAYID2>
    <otp>'             . htmlspecialchars($data['otp'])             . '</otp>
    <reference_number>'. htmlspecialchars($data['reference'])       . '</reference_number>
    <ext_txn_id>'      . htmlspecialchars($data['txn_id'])          . '</ext_txn_id>
</COMMAND>';

    // Appel API
    $result_brut = sendOrangePayment($data);

    // Parser la réponse XML si succès
    if ($result_brut['success']) {
        $xml_obj = simplexml_load_string($result_brut['response']);
        if ($xml_obj !== false) {
            $result_parse = [
                'status'  => (string)($xml_obj->status  ?? $xml_obj->STATUS  ?? '?'),
                'message' => (string)($xml_obj->message ?? $xml_obj->MESSAGE ?? '?'),
                'txn_id'  => (string)($xml_obj->txnid   ?? $xml_obj->TXNID   ?? '?'),
            ];
        } else {
            $erreur = "Réponse reçue mais XML invalide. Voir réponse brute ci-dessous.";
        }
    } else {
        $erreur = $result_brut['error'];
    }
}

// Valeurs par défaut (documentation Orange)
$default = [
    'customer_msisdn' => '54168140',
    'merchant_msisdn' => getenv('ORANGE_MERCHANT_MSISDN') ?: '',
    'api_username'    => getenv('ORANGE_API_USERNAME') ?: '',
    'api_password'    => getenv('ORANGE_API_PASSWORD') ?: '',
    'amount'          => '100',
    'otp'             => '',
];

// Fusionner avec les valeurs POST si soumis
$vals = array_merge($default, array_intersect_key($_POST, $default));
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Test Orange Money API — eFuelPrepaid</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 30px; color: #333; }
        .container { max-width: 750px; margin: 0 auto; }

        h1 { font-size: 20px; margin-bottom: 4px; color: #222; }
        .badge-test { display:inline-block; background:#FF6600; color:#fff;
                      font-size:11px; padding:2px 10px; border-radius:20px; margin-bottom:20px; }

        .card { background:#fff; border:1px solid #ddd; border-radius:8px;
                padding:20px; margin-bottom:20px; }
        .card h2 { font-size:15px; color:#555; margin-bottom:15px;
                   padding-bottom:8px; border-bottom:1px solid #eee; }

        .grid2 { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
        label { display:block; font-size:13px; color:#666; margin-bottom:4px; }
        input { width:100%; padding:9px 12px; border:1px solid #ccc;
                border-radius:5px; font-size:14px; }
        input:focus { outline:none; border-color:#FF6600; }
        input[readonly] { background:#f9f9f9; color:#888; }

        .ussd-hint { font-size:12px; color:#888; margin-top:5px; }
        .ussd-hint strong { color:#FF6600; }

        .btn { width:100%; padding:12px; background:#FF6600; color:#fff;
               border:none; border-radius:5px; font-size:16px; font-weight:bold;
               cursor:pointer; margin-top:5px; }
        .btn:hover { background:#e55a00; }

        /* Résultats */
        .result-ok  { border-left:4px solid #28a745; }
        .result-err { border-left:4px solid #dc3545; }
        .result-warn{ border-left:4px solid #ffc107; }

        .status-ok  { color:#28a745; font-size:22px; font-weight:bold; }
        .status-err { color:#dc3545; font-size:22px; font-weight:bold; }

        .field-row { display:flex; justify-content:space-between;
                     padding:8px 0; border-bottom:1px solid #f0f0f0; font-size:14px; }
        .field-row:last-child { border-bottom:none; }
        .field-label { color:#888; }
        .field-value { font-weight:bold; }

        pre { background:#1e1e1e; color:#d4d4d4; padding:15px; border-radius:5px;
              font-size:12px; overflow-x:auto; white-space:pre-wrap; word-break:break-all; }

        .warning-box { background:#fff3cd; border:1px solid #ffc107;
                       border-radius:5px; padding:12px; font-size:13px; margin-bottom:20px; }
        .warning-box strong { color:#856404; }

        .step { display:flex; align-items:flex-start; gap:10px; margin-bottom:12px; }
        .step-num { background:#FF6600; color:#fff; border-radius:50%;
                    width:24px; height:24px; display:flex; align-items:center;
                    justify-content:center; font-size:12px; font-weight:bold; flex-shrink:0; }
        .step-text { font-size:13px; color:#555; line-height:1.5; }
    </style>
</head>
<body>
<div class="container">

    <h1>🔶 Test Orange Money API</h1>
    <span class="badge-test">PLATEFORME TEST — testom.orange.bf</span>

    <!-- Avertissement
    <div class="warning-box">
        <strong>⚠️ Fichier de test uniquement.</strong>
        Supprimez <code>test_orange.php</code> de votre serveur après validation.
        Ne jamais laisser ce fichier en production.
    </div> -->

    <!-- Instructions -->
    <div class="card">
        <h2>📋 Comment tester</h2>
        <div class="step">
            <div class="step-num">1</div>
            <div class="step-text">
                Notez le montant que vous allez entrer ci-dessous (ex: <strong>100</strong>)
            </div>
        </div>
        <div class="step">
            <div class="step-num">2</div>
            <div class="step-text">
                Depuis votre téléphone Orange de test, composez :
                <strong style="color:#FF6600">*865*3*4*100#</strong>
                (remplacez 100 par votre montant)
            </div>
        </div>
        <div class="step">
            <div class="step-num">3</div>
            <div class="step-text">
                Entrez le code OTP reçu par SMS dans le champ ci-dessous
            </div>
        </div>
        <div class="step">
            <div class="step-num">4</div>
            <div class="step-text">
                Cliquez sur <strong>Envoyer la requête</strong> et observez la réponse
            </div>
        </div>
    </div>

    <!-- Formulaire de test -->
    <div class="card">
        <h2>⚙️ Paramètres de la requête</h2>
        <form method="post">

            <p style="font-size:13px;color:#888;margin-bottom:15px;">
                Identifiants ci-dessous = valeurs de test fournies par Orange.<br>
                Remplacez par vos vrais identifiants marchand si vous les avez.
            </p>

            <div class="grid2">
                <div>
                    <label>customer_msisdn (téléphone client)</label>
                    <input type="tel" name="customer_msisdn"
                           value="<?= htmlspecialchars($vals['customer_msisdn']) ?>"
                           maxlength="8" required>
                </div>
                <div>
                    <label>merchant_msisdn (votre numéro marchand)</label>
                    <input type="tel" name="merchant_msisdn"
                           value="<?= htmlspecialchars($vals['merchant_msisdn']) ?>"
                           maxlength="8" required>
                </div>
                <div>
                    <label>api_username</label>
                    <input type="text" name="api_username"
                           value="<?= htmlspecialchars($vals['api_username']) ?>" required>
                </div>
                <div>
                    <label>api_password</label>
                    <input type="password" name="api_password"
                           value="<?= htmlspecialchars($vals['api_password']) ?>" required>
                </div>
            </div>

            <br>
            <div class="grid2">
                <div>
                    <label>Montant (FCFA)</label>
                    <input type="number" name="amount" id="amount"
                           value="<?= htmlspecialchars($vals['amount']) ?>"
                           min="1" required oninput="updateUssd(this.value)">
                    <p class="ussd-hint">
                        👉 Composez : <strong id="ussd_code">*865*3*4*100#</strong>
                    </p>
                </div>
                <div>
                    <label>Code OTP reçu</label>
                    <input type="tel" name="otp" id="otp"
                           value="<?= htmlspecialchars($vals['otp'] ?? '') ?>"
                           placeholder="6 chiffres" maxlength="6"
                           pattern="[0-9]{6}" required>
                </div>
            </div>

            <br>
            <button type="submit" class="btn">🚀 Envoyer la requête OMPREQ</button>
        </form>
    </div>

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>

    <!-- ========================
         RÉSULTATS
    ======================== -->

    <?php if ($erreur): ?>
    <!-- Erreur de connexion -->
    <div class="card result-err">
        <h2>❌ Erreur de connexion</h2>
        <p style="font-size:14px;color:#dc3545;margin-bottom:15px;"><?= htmlspecialchars($erreur) ?></p>
        <p style="font-size:13px;color:#888;">
            Causes possibles : cURL non activé, SSL bloqué, serveur Orange inaccessible depuis votre hébergement,
            ou pare-feu. Vérifiez que votre hébergeur autorise les connexions sortantes HTTPS.
        </p>
    </div>

    <?php elseif ($result_parse): ?>
    <!-- Réponse parsée -->
    <?php
        $is_success = ($result_parse['status'] === '00');
        $card_class = $is_success ? 'result-ok' : 'result-err';
    ?>
    <div class="card <?= $card_class ?>">
        <h2>📨 Réponse d'Orange Money</h2>

        <div class="field-row">
            <span class="field-label">Statut</span>
            <span class="field-value <?= $is_success ? 'status-ok' : 'status-err' ?>">
                <?= $is_success ? '✅ ' : '❌ ' ?><?= htmlspecialchars($result_parse['status']) ?>
            </span>
        </div>
        <div class="field-row">
            <span class="field-label">Message</span>
            <span class="field-value"><?= htmlspecialchars($result_parse['message']) ?></span>
        </div>
        <div class="field-row">
            <span class="field-label">ID Transaction Orange</span>
            <span class="field-value"><?= htmlspecialchars($result_parse['txn_id']) ?></span>
        </div>

        <?php if ($is_success): ?>
        <br>
        <p style="font-size:13px;color:#28a745;font-weight:bold;">
            ✅ Paiement accepté ! Le code de succès est bien <strong>"00"</strong>.
            Votre pos_transac.php est configuré correctement.
        </p>
        <?php else: ?>
        <br>
        <p style="font-size:13px;color:#dc3545;">
            ❌ Paiement refusé par Orange. Vérifiez l'OTP (expiré ?), le montant,
            ou les credentials. Notez le code <strong>"<?= htmlspecialchars($result_parse['status']) ?>"</strong>
            et consultez la documentation Orange pour sa signification exacte.
        </p>
        <?php endif; ?>
    </div>

    <?php else: ?>
    <!-- Réponse reçue mais XML non parsable -->
    <div class="card result-warn">
        <h2>⚠️ Réponse reçue mais non parsable</h2>
        <p style="font-size:13px;color:#856404;"><?= htmlspecialchars($erreur ?? 'Erreur inconnue') ?></p>
    </div>
    <?php endif; ?>

    <!-- XML envoyé -->
    <div class="card">
        <h2>📤 XML envoyé à Orange</h2>
        <pre><?= htmlspecialchars($xml_envoye) ?></pre>
    </div>

    <!-- Réponse brute -->
    <?php if ($result_brut && $result_brut['success']): ?>
    <div class="card">
        <h2>📥 Réponse brute reçue</h2>
        <pre><?= htmlspecialchars($result_brut['response']) ?></pre>
    </div>
    <?php endif; ?>

    <?php endif; ?>

</div>

<script>
function updateUssd(montant) {
    document.getElementById('ussd_code').textContent = '*865*3*4*' + (montant || '?') + '#';
}
// Init au chargement
updateUssd(document.getElementById('amount').value);
</script>
</body>
</html>
