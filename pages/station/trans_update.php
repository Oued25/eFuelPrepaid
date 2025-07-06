<?php
include '../../includesStation/connection.php';

if (isset($_GET['code_trans'], $_GET['id_statut'])) {
    $code_trans = $_GET['code_trans'];
    $id_statut = (int) $_GET['id_statut']; // Cast pour éviter les injections SQL

    try {
        // Vérifier si l'id_statut existe dans la table statut
        $checkStatut = $connection->prepare("SELECT id FROM statut WHERE id = :id_statut");
        $checkStatut->execute([':id_statut' => $id_statut]);
        
        if ($checkStatut->rowCount() === 0) {
            die("Statut invalide.");
        }

        // Mettre à jour le statut dans la table transaction
        $sql = "UPDATE transaction SET id_statut = :id_statut WHERE code_trans = :code_trans";
        $stmt = $connection->prepare($sql);
        $stmt->execute([
            ':id_statut' => $id_statut,
            ':code_trans' => $code_trans,
        ]);

        echo "<script>alert('Statut mis à jour avec succès.'); window.location.href = 'transaction.php';</script>";
    } catch (Exception $e) {
        die("Erreur : " . $e->getMessage());
    }
} else {
    die("Données manquantes.");
}
?>
