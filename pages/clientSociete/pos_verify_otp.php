<?php
/**
 * ==========================================================
 *  post_verify_otp.php
 *  Envoi d’une requête de validation OTP à Orange Money
 *  via authentification SSL mutuelle (certificat + clé privée)
 * ==========================================================
 */

/**
 * URL de l’API Orange Money (environnement de test)
 * ⚠️ À remplacer par l’URL PROD en production
 */
$url = "https://testom.orange.bf/";

/**
 * ==========================================================
 * Construction du XML attendu par Orange Money
 * ==========================================================
 *
 * Tous les champs doivent STRICTEMENT respecter
 * la documentation Orange Money
 */
$xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<COMMAND>
    <!-- Type de commande Orange Money -->
    <TYPE>OMPREQ</TYPE>

    <!-- Numéro du client qui paye -->
    <customer_msisdn>55758225</customer_msisdn>

    <!-- Numéro marchand Orange Money -->
    <merchant_msisdn><?= htmlspecialchars(getenv('ORANGE_MERCHANT_MSISDN') ?: '') ?></merchant_msisdn>

    <!-- Identifiants API fournis par Orange -->
    <api_username><?= htmlspecialchars(getenv('ORANGE_API_USERNAME') ?: '') ?></api_username>
    <api_password><?= htmlspecialchars(getenv('ORANGE_API_PASSWORD') ?: '') ?></api_password>

    <!-- Montant du paiement -->
    <amount>5000</amount>

    <!-- Code opérateur (Orange BF = 101) -->
    <PROVIDER>101</PROVIDER>
    <PROVIDER2>101</PROVIDER2>

    <!-- Type de paiement (selon contrat Orange) -->
    <PAYID>12</PAYID>
    <PAYID2>12</PAYID2>

    <!-- Code OTP reçu par SMS -->
    <otp>541847</otp>

    <!-- Référence interne (visible côté Orange) -->
    <reference_number>789233</reference_number>

    <!-- Identifiant unique côté eFuelPrepaid (TRÈS IMPORTANT) -->
    <ext_txn_id>201500068544</ext_txn_id>
</COMMAND>
XML;

/**
 * ==========================================================
 * Initialisation de cURL
 * ==========================================================
 */
$ch = curl_init($url);

/**
 * Configuration complète de la requête cURL
 */
curl_setopt_array($ch, [

    /**
     * Indique que la requête est un POST
     */
    CURLOPT_POST => true,

    /**
     * Contenu envoyé dans le corps HTTP (le XML)
     */
    CURLOPT_POSTFIELDS => $xml,

    /**
     * Retourner la réponse sous forme de string
     * (sinon elle est affichée directement)
     */
    CURLOPT_RETURNTRANSFER => true,

    /**
     * En-têtes HTTP requis par Orange Money
     */
    CURLOPT_HTTPHEADER => [
        "Content-Type: text/xml",
        "Content-Length: " . strlen($xml)
    ],

    /**
     * ======================================================
     * AUTHENTIFICATION SSL MUTUELLE
     * ======================================================
     */

    // Certificat client (.pem)
    CURLOPT_SSLCERT => "/etc/ssl/certs/certificat_efuel.pem",

    // Clé privée associée au certificat
    CURLOPT_SSLKEY  => "/etc/ssl/private/cle_privee_efuel.pem",

    /**
     * ======================================================
     * SÉCURITÉ SSL
     * ======================================================
     */

    // Vérifie le certificat du serveur Orange
    CURLOPT_SSL_VERIFYPEER => true,

    // Vérifie que le nom de domaine correspond au certificat
    CURLOPT_SSL_VERIFYHOST => 2,

    /**
     * ======================================================
     * DEBUG & TIMEOUT
     * ======================================================
     */

    // Affiche les détails SSL et HTTP (À DÉSACTIVER EN PROD)
    CURLOPT_VERBOSE => true,

    // Timeout maximum (en secondes)
    CURLOPT_TIMEOUT => 30
]);

/**
 * ==========================================================
 * Exécution de la requête
 * ==========================================================
 */
$response = curl_exec($ch);

/**
 * Gestion des erreurs cURL
 */
if ($response === false) {

    // Erreur réseau / SSL / certificat / timeout
    echo "Erreur cURL : " . curl_error($ch);

} else {

    // Réponse XML retournée par Orange Money
    echo "Réponse API Orange Money :\n";
    echo $response;
}

/**
 * Fermeture de la session cURL
 */
curl_close($ch);
