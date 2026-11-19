<?php
// Inclusion de la connexion à la base de données et de la barre latérale
include '../../includesSociete/connection.php';
include '../../includesSociete/sidebar.php';

// Activer le mode d'affichage des erreurs PDO
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Vérifier que l'utilisateur est bien connecté
if (!isset($_SESSION['id'])) {
    header('Location: login.php'); // Redirection vers la page de login si non connecté
    exit();
}

// Récupérer l'identifiant de l'utilisateur connecté
$id_user = $_SESSION['id'];

try {
    // Requête pour récupérer les informations sur les transactions de l'utilisateur
    $sql = "SELECT t.id, t.id_user, t.code_trans, t.date_creation, p.nom_produit, cat.nom_categorie, 
                   cl.nom_societe, st.nom_statut, c.nom_compagnie, t.prix_achat
            FROM transaction t 
            LEFT JOIN transaction_produits tp ON t.code_trans = tp.code_trans 
            LEFT JOIN produit p ON tp.id_produit = p.id 
            LEFT JOIN categorie cat ON p.id_categorie = cat.id 
            LEFT JOIN utilisateur u ON t.id_user = u.id 
            LEFT JOIN client cl ON u.id_client = cl.id 
            LEFT JOIN compagnie c ON p.id_compagnie = c.id 
            LEFT JOIN statut st ON t.id_statut = st.id 
            WHERE t.id_user = :id_user
            ORDER BY t.date_creation DESC";

    // Préparation et exécution de la requête
    $req = $connection->prepare($sql);
    $req->bindValue(':id_user', $id_user, PDO::PARAM_INT);
    $req->execute();

    // Récupération des résultats
    $transactions = $req->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Affichage de l'erreur en cas d'échec
    echo "Erreur : " . $e->getMessage();
    exit();
}
?>

<!-- Contenu HTML de la page -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <!-- Titre de la section -->
        <h4 class="m-2 font-weight-bold text-primary">Transaction</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <!-- Tableau des transactions -->
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
                        <!-- Affichage si aucune transaction trouvée -->
                        <tr>
                            <td colspan="10" class="text-center">Aucune transaction trouvée.</td>
                        </tr>
                    <?php else: ?>
                        <!-- Boucle sur les transactions pour les afficher -->
                        <?php foreach ($transactions as $row): ?>
                            <tr>
                                <!-- Affichage sécurisé avec htmlspecialchars -->
                                <td><?= htmlspecialchars($row['code_trans']); ?></td>
                                <td><?= htmlspecialchars($row['nom_categorie']); ?></td>
                                <td><?= htmlspecialchars($row['nom_produit']); ?></td>
                                <td>
                                    <?php 
                                        $prix = str_replace(',', '', $row['prix_achat']); 
                                        echo htmlspecialchars(number_format((float)$prix, 2)) . ' FCFA';
                                    ?>
                                </td>

                                <td><?= htmlspecialchars($row['nom_societe'] ?? 'N/A'); ?></td>
                                <td><?= htmlspecialchars($row['nom_compagnie'] ?? 'N/A'); ?></td>
                                <td><?= htmlspecialchars($row['nom_statut'] ?? 'N/A'); ?></td>
                                <td><?= htmlspecialchars($row['date_creation']); ?></td>
                                <td align="right">
                                    <div class="btn-group">
                                        <!-- Bouton "Voir" avec passage de l'ID de la transaction -->
                                        <a class="btn btn-primary bg-gradient-primary" href="trans_view.php?action=edit&id=<?= $row['id'] ?>">
                                            <i class="fas fa-fw fa-th-list"></i> Voir
                                        </a>
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

<!-- Inclusion du pied de page -->
<?php include '../../includesSociete/footer.php'; ?>
