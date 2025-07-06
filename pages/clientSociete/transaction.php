<?php
include '../../includesSociete/connection.php';
include '../../includesSociete/sidebar.php';

// Activer les erreurs PDO
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

// Récupérer l'ID de l'utilisateur depuis la session 
$id_user = $_SESSION['id'];

try {
    // Préparation de la requête
    $sql = "SELECT t.id, t.id_user, t.code_trans, t.date_creation, p.nom_produit, cat.nom_categorie, 
                   cl.nom_societe, st.nom_statut, c.nom_compagnie, t.prix_achat
            FROM transaction t 
            LEFT JOIN transaction_produits tp ON t.code_trans = tp.code_trans 
            LEFT JOIN produit p ON tp.id_produit = p.id 
            LEFT JOIN categorie cat ON p.id_categorie = cat.id 
            LEFT JOIN utilisateur u ON t.id_user = u.id 
            LEFT JOIN client cl ON u.id_client = cl.id 
            /*LEFT JOIN station s ON u.id_station = s.id */
            LEFT JOIN compagnie c ON p.id_compagnie = c.id 
            LEFT JOIN statut st ON t.id_statut = st.id 
            WHERE t.id_user = :id_user
            ORDER BY t.date_creation DESC";

    $req = $connection->prepare($sql);
    $req->bindValue(':id_user', $id_user, PDO::PARAM_INT);
    $req->execute();

    // Récupération des résultats
    $transactions = $req->fetchAll(PDO::FETCH_ASSOC);

    // Déboguer les résultats
    //var_dump($transactions);
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
    exit();
}
?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h4 class="m-2 font-weight-bold text-primary">Transaction</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Numéro Transaction</th>
                        <th>Catégorie Produit</th>
                        <th>Nom Produit</th>
                        <th>Prix d'Achat</th>
                        <th>Nom Structure</th>
                        <th>Nom Compagnie</th>
                        <th>Statut</th>
                        <th>Date</th>
                        <th width="11%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($transactions)): ?>
                        <tr>
                            <td colspan="10" class="text-center">Aucune transaction trouvée.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($transactions as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['code_trans']); ?></td>
                                <td><?= htmlspecialchars($row['nom_categorie']); ?></td>
                                <td><?= htmlspecialchars($row['nom_produit']); ?></td>
                                <td><?= htmlspecialchars(number_format($row['prix_achat'], 2)); ?></td>
                                <td><?= htmlspecialchars($row['nom_societe'] ?? 'N/A'); ?></td>
                                <td><?= htmlspecialchars($row['nom_compagnie'] ?? 'N/A'); ?></td>
                                <td><?= htmlspecialchars($row['nom_statut'] ?? 'N/A'); ?></td>
                                <td><?= htmlspecialchars($row['date_creation']); ?></td>
                                <td align="right">
                                    <div class="btn-group">
                                        <a class="btn btn-primary bg-gradient-primary" href="trans_view.php"><i class="fas fa-fw fa-th-list"></i> Voir</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../../includesSociete/footer.php'; ?>