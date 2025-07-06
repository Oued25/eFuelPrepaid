<?php   
include '../../includesSociete/connection.php'; 
include '../../includesSociete/sidebar.php';  

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) { 
  header('Location: login.php');
  exit();
}

$user = $_SESSION; 

// Préparation de la requête
    $sql = "SELECT t.code_trans, t.date_creation, t.nom_produit, cl.nom_societe, s.nom_station, st.nom_statut, c.nom_compagnie, t.Prix_achat
            FROM  transaction t
           /* LEFT JOIN transaction_produits tp ON t.code_trans = tp.transaction_id
            LEFT JOIN produit p ON tp.id_produit = p.id
            LEFT JOIN categorie cat ON p.id_categorie = cat.id*/
            LEFT JOIN client cl ON t.id_client = cl.id
            LEFT JOIN station s ON t.id_station = s.id
            LEFT JOIN statut st ON t.id_statut = st.id
            LEFT JOIN compagnie c ON s.id_compagnie = c.id
            WHERE  t.id_client = :id_client
            ORDER BY t.date_creation DESC";

    $req = $connection->prepare($sql);
    $req->bindParam(':id_client', $user['id_client'], PDO::PARAM_INT);
    $req->execute();

// Récupération des résultats
$transactions = $req->fetchAll(PDO::FETCH_ASSOC);
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
                      <th>Nom Station</th>
                      <th>Statut</th>
                      <th>Date</th>
                      <th width="11%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transactions as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['code_trans']); ?></td>
                        <td><?= htmlspecialchars($row['nom_categorie']); ?></td>
                        <td><?= htmlspecialchars($row['nom_produit']); ?></td>
                        <td><?= htmlspecialchars(number_format($row['Prix_achat'], 2)); ?></td>
                        <td><?= htmlspecialchars($row['nom_societe']); ?></td>
                        <td><?= htmlspecialchars($row['nom_compagnie']); ?></td>
                        <td><?= htmlspecialchars($row['nom_station']); ?></td>
                        <td><?= htmlspecialchars($row['nom_statut']); ?></td>
                        <td><?= htmlspecialchars($row['date_creation']); ?></td>
                        <td align="right">
                            <div class="btn-group">
                                <a class="btn btn-primary bg-gradient-primary" href="trans_view.php"><i class="fas fa-fw fa-th-list"></i> Voir</a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>

      </div>
  </div>
</div>
    
    <?php include '../../includesSociete/footer.php'; ?>