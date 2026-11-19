<?php
/**
 * orange_api.php
 * Gère l'appel XML-RPC vers l'API Orange Money BF
 * Plateforme TEST : https://testom.orange.bf/
 * Plateforme PROD : https://apiom.orange.bf/
 */

function sendOrangePayment(array $data): array {

    // 🔧 Passer à https://apiom.orange.bf/ en production
    $url = 'https://testom.orange.bf/';

    // Chemins des certificats SSL fournis par Orange
    $cert_client  = '/etc/ssl/certs/certificat_efuel.pem';   // Certificat client
    $cle_privee   = '/etc/ssl/private/cle_privee_efuel.pem'; // Clé privée

    $xml = '<?xml version="1.0" encoding="UTF-8"?>
<COMMAND>
    <TYPE>OMPREQ</TYPE>
    <customer_msisdn>' . htmlspecialchars($data['customer_msisdn']) . '</customer_msisdn>
    <merchant_msisdn>' . htmlspecialchars($data['merchant_msisdn']) . '</merchant_msisdn>
    <api_username>'    . htmlspecialchars($data['api_username'])    . '</api_username>
    <api_password>'    . htmlspecialchars($data['api_password'])    . '</api_password>
    <amount>'          . intval($data['amount'])                    . '</amount>
    <PROVIDER>101</PROVIDER>
    <PROVIDER2>101</PROVIDER2>
    <PAYID></PAYID>
    <PAYID2>12</PAYID2>
    <otp>'             . htmlspecialchars($data['otp'])             . '</otp>
    <reference_number>'. htmlspecialchars($data['reference'])       . '</reference_number>
    <ext_txn_id>'      . htmlspecialchars($data['txn_id'])          . '</ext_txn_id>
</COMMAND>';

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_POST            => true,
        CURLOPT_POSTFIELDS      => $xml,
        CURLOPT_HTTPHEADER      => ['Content-Type: text/xml; charset=UTF-8'],
        CURLOPT_RETURNTRANSFER  => true,
        CURLOPT_TIMEOUT         => 30,

        // Certificats SSL Orange
        CURLOPT_SSLCERT         => $cert_client,  // Certificat client .pem
        CURLOPT_SSLKEY          => $cle_privee,   // Clé privée .pem
        CURLOPT_SSLCERTTYPE     => 'PEM',
        CURLOPT_SSLKEYTYPE      => 'PEM',

        // Vérification SSL activée (sécurité)
        CURLOPT_SSL_VERIFYPEER  => true,
        CURLOPT_SSL_VERIFYHOST  => 2,
    ]);

    $response   = curl_exec($ch);
    $curl_error = curl_error($ch);
    $http_code  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($curl_error) {
        return ['success' => false, 'error' => $curl_error];
    }

    if ($http_code !== 200) {
        return ['success' => false, 'error' => "HTTP $http_code reçu de Orange"];
    }

    if (empty($response)) {
        return ['success' => false, 'error' => 'Réponse vide de Orange'];
    }

    return ['success' => true, 'response' => $response];
}