<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h3>✅ PHP fonctionne</h3>";

// Test 1 : orange_api.php existe ?
if (file_exists('orange_api.php')) {
    echo "✅ orange_api.php trouvé<br>";
    require_once 'orange_api.php';
    echo "✅ orange_api.php chargé sans erreur<br>";
} else {
    echo "❌ orange_api.php INTROUVABLE dans ce dossier<br>";
}

// Test 2 : cURL disponible ?
if (function_exists('curl_init')) {
    echo "✅ cURL est activé<br>";
} else {
    echo "❌ cURL NON disponible — contacter votre hébergeur<br>";
}

// Test 3 : connexion sortante vers Orange ?
$ch = curl_init('https://testom.orange.bf/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$r = curl_exec($ch);
$err = curl_error($ch);
curl_close($ch);

if ($err) {
    echo "❌ Connexion Orange bloquée : " . $err . "<br>";
} else {
    echo "✅ Connexion vers testom.orange.bf OK<br>";
}
?>