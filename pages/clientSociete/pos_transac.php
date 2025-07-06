<?php  
include '../../includesSociete/connection.php'; 
// Récupération des données POST
$id_user = $_SESSION['id'];
$id_compagnie = $_POST['id_compagnie'];
$code_trans = $_POST['code_trans'] ?? null;
$date_creation = $_POST['date_creation'] ?? null;
$prix_achat = $_POST['prix_achat'] ?? null;
$tel_benefic = $_POST['tel_benefic'] ?? null;
$num_imatric = $_POST['num_imatric'] ?? null;
$net_tva = $_POST['net_tva'] ?? null;
$addtva = $_POST['addtva'] ?? null;
$grand_total = $_POST['grand_total'] ?? null;
$payment_method = $_POST['payment_method'] ?? null;
$num_paiment = $_POST['num_paiment'] ?? null;
$otp = $_POST['otp'] ?? null;

$produits = $_POST['produit'] ?? [];// ici est recuperé toutes valeurs venant du formualaire caché du ficher pos.php

//var_dump( $date_creation, $otp, $net_tva, $addtva, $grand_total,$num_paiment, $id_produit, $payment_method, $num_imatric, $tel_benefic,$prix_achat,);
//var_dump($_POST['produit']);
//exit();  // Arrêter le script pour vérifier les valeurs affichées

// Vérification des données nécessaires
if (empty($net_tva) || empty($addtva) || empty($grand_total)) {
    die("Erreur : certaines informations requises sont manquantes.");
}



try {  
    // Démarrer une transaction
    $connection->beginTransaction();

    // Insertion des informations principales
    $query = "INSERT INTO transaction (
                code_trans, date_creation, otp, prix_achat, num_imatric, tel_benefic, payment_method, 
                num_paiment, net_tva, add_tva, grand_total, id_statut, id_user, id_compagnie
              ) 
              VALUES (
                :code_trans, :date_creation, :otp, :prix_achat, :num_imatric, :tel_benefic, :payment_method, 
                :num_paiment, :net_tva, :add_tva, :grand_total, :id_statut, :id_user, :id_compagnie)";
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
        ':id_user' => $id_user, // ID utilisateur
        ':id_compagnie' => $id_compagnie, // ID compagnie
        
    ]);

    // Insertion des produits associés
    foreach ($produits as $produit) {
        $id_produit = $produit['id'];
        $nom_produit = $produit['nom_produit'];
        $nom_compagnie = $produit['nom_compagnie'];
    
        $product_query = "INSERT INTO transaction_produits (code_trans, id_produit, nom_produit, nom_compagnie) 
                          VALUES (:code_trans, :id_produit, :nom_produit, :nom_compagnie)";
        $product_stmt = $connection->prepare($product_query);
        $product_stmt->execute([
            ':code_trans' => $code_trans,
            ':id_produit' => $id_produit,
            ':nom_produit' => $nom_produit,
            ':nom_compagnie' => $nom_compagnie, // ID compagnie
        ]);
    }

    // Valider la transaction
    $connection->commit();
    echo "<script>alert('Transaction réussie'); window.location.href = 'pos.php';</script>";

} catch (Exception $e) {
    // Annuler la transaction en cas d'erreur
    $connection->rollBack();
    die("Erreur : " . $e->getMessage());
}
?>
