<?php
// =====================================================================
// pos.php — Page principale du Point de Vente (POS)
// Correction : le <form> du tableau est fermé AVANT include posside.php
//              pour éviter l'imbrication de formulaires
// =====================================================================

include '../../includesSociete/connection.php';
include '../../includesSociete/sidebar.php';

// Sécurité : s'assurer que la session est démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Initialiser le panier s'il n'existe pas
if (!isset($_SESSION['pointofsale']) || !is_array($_SESSION['pointofsale'])) {
    $_SESSION['pointofsale'] = [];
}

// Définir les constantes des catégories
if (!defined('CATEGORIE_PETROLIER')) define('CATEGORIE_PETROLIER', 1);
if (!defined('CATEGORIE_DERIVE'))    define('CATEGORIE_DERIVE',    2);

// Variable pour stocker les messages d'alerte
$alert_message = '';

// =====================================================================
// GESTION DE LA SÉLECTION DE COMPAGNIE
// =====================================================================
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_compagnie'])) {
    $id_compagnie = $_POST['id_compagnie'];

    // Vider le panier si on change de compagnie
    if (isset($_SESSION['id_compagnie']) && $_SESSION['id_compagnie'] != $id_compagnie) {
        unset($_SESSION['pointofsale']);
        $alert_message = "Changement de compagnie — le panier a été vidé.";
    }

    $_SESSION['id_compagnie'] = $id_compagnie;

    $stmt = $connection->prepare("SELECT id, nom_compagnie FROM compagnie WHERE id = :id");
    $stmt->execute(['id' => $id_compagnie]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $_SESSION['nom_compagnie'] = $result['nom_compagnie'] ?? 'Compagnie inconnue';
}

// Vérifier si une compagnie est sélectionnée
$id_compagnie  = $_SESSION['id_compagnie']  ?? 'Aucune compagnie sélectionnée';
$nom_compagnie = $_SESSION['nom_compagnie'] ?? 'Aucune compagnie sélectionnée';

// =====================================================================
// GESTION DU PANIER — AJOUT DE PRODUITS
// =====================================================================
$produit_ids = [];

if (filter_input(INPUT_POST, 'addpos')) {

    if (isset($_SESSION['pointofsale'])) {
        $count             = count($_SESSION['pointofsale']);
        $produit_ids       = array_column($_SESSION['pointofsale'], 'id');
        $nouveau_id        = filter_input(INPUT_GET,  'id');
        $nouvelle_categorie= filter_input(INPUT_POST, 'id_categorie');
        $nouvelle_compagnie= filter_input(INPUT_POST, 'id_compagnie');
        $nouveau_prix      = filter_input(INPUT_POST, 'prix_achat');
        $nouvelle_quantite = filter_input(INPUT_POST, 'quantite');
        $compagnie_panier  = $_SESSION['pointofsale'][0]['id_compagnie'] ?? null;

        // === RÈGLE 1 : Compagnie différente ===
        if ($compagnie_panier && $compagnie_panier != $nouvelle_compagnie) {
            $alert_message = "Impossible d'ajouter un produit d'une compagnie différente!";
        }
        // === RÈGLE 2 : Produit pétrolier ===
        elseif ($nouvelle_categorie == CATEGORIE_PETROLIER) {
            $produit_petrolier_existe = false;
            $key_petrolier = null;

            foreach ($_SESSION['pointofsale'] as $key => $produit) {
                if ($produit['id_categorie'] == CATEGORIE_PETROLIER) {
                    $produit_petrolier_existe = true;
                    $key_petrolier = $key;
                    break;
                }
            }

            if ($produit_petrolier_existe) {
                $_SESSION['pointofsale'][$key_petrolier]['prix_achat'] += $nouveau_prix;
                $alert_message = "Prix additionné au produit pétrolier existant.";
            } elseif ($count > 0) {
                $alert_message = "Impossible d'ajouter un produit pétrolier à un panier contenant d'autres catégories!";
            } else {
                $_SESSION['pointofsale'][0] = [
                    'id'           => $nouveau_id,
                    'nom_produit'  => filter_input(INPUT_POST, 'nom_produit'),
                    'prix_achat'   => $nouveau_prix,
                    'quantite'     => 1,
                    'id_compagnie' => $nouvelle_compagnie,
                    'nom_compagnie'=> filter_input(INPUT_POST, 'nom_compagnie'),
                    'id_categorie' => $nouvelle_categorie,
                    'nom_categorie'=> filter_input(INPUT_POST, 'nom_categorie'),
                ];
                $alert_message = "Produit pétrolier ajouté au panier.";
            }
        }
        // === RÈGLE 3 : Produit dérivé pétrolier ===
        elseif ($nouvelle_categorie == CATEGORIE_DERIVE) {
            $categorie_identique = true;
            foreach ($_SESSION['pointofsale'] as $produit) {
                if ($produit['id_categorie'] != CATEGORIE_DERIVE) {
                    $categorie_identique = false;
                    break;
                }
            }

            if (!$categorie_identique) {
                $alert_message = "Les produits dérivés pétroliers doivent être de la même catégorie!";
            } else {
                if (in_array($nouveau_id, $produit_ids)) {
                    for ($i = 0; $i < count($produit_ids); $i++) {
                        if ($produit_ids[$i] == $nouveau_id) {
                            $_SESSION['pointofsale'][$i]['prix_achat'] += $nouveau_prix;
                            $_SESSION['pointofsale'][$i]['quantite']   += $nouvelle_quantite;
                            $alert_message = "Produit dérivé mis à jour (prix et quantité additionnés).";
                            break;
                        }
                    }
                } else {
                    $_SESSION['pointofsale'][$count] = [
                        'id'           => $nouveau_id,
                        'nom_produit'  => filter_input(INPUT_POST, 'nom_produit'),
                        'prix_achat'   => $nouveau_prix,
                        'quantite'     => $nouvelle_quantite,
                        'id_compagnie' => $nouvelle_compagnie,
                        'nom_compagnie'=> filter_input(INPUT_POST, 'nom_compagnie'),
                        'id_categorie' => $nouvelle_categorie,
                        'nom_categorie'=> filter_input(INPUT_POST, 'nom_categorie'),
                    ];
                    $alert_message = "Produit dérivé ajouté au panier.";
                }
            }
        }
        // === RÈGLE 4 : Autres catégories ===
        else {
            if (!in_array($nouveau_id, $produit_ids)) {
                $_SESSION['pointofsale'][$count] = [
                    'id'           => $nouveau_id,
                    'nom_produit'  => filter_input(INPUT_POST, 'nom_produit'),
                    'prix_achat'   => $nouveau_prix,
                    'quantite'     => $nouvelle_quantite,
                    'id_compagnie' => $nouvelle_compagnie,
                    'nom_compagnie'=> filter_input(INPUT_POST, 'nom_compagnie'),
                    'id_categorie' => $nouvelle_categorie,
                    'nom_categorie'=> filter_input(INPUT_POST, 'nom_categorie'),
                ];
                $alert_message = "Produit ajouté au panier.";
            } else {
                for ($i = 0; $i < count($produit_ids); $i++) {
                    if ($produit_ids[$i] == $nouveau_id) {
                        $_SESSION['pointofsale'][$i]['quantite'] += $nouvelle_quantite;
                        $alert_message = "Quantité mise à jour pour le produit existant.";
                    }
                }
            }
        }

    } else {
        // Panier vide — premier produit
        $_SESSION['pointofsale'][0] = [
            'id'           => filter_input(INPUT_GET,  'id'),
            'nom_produit'  => filter_input(INPUT_POST, 'nom_produit'),
            'prix_achat'   => filter_input(INPUT_POST, 'prix_achat'),
            'quantite'     => filter_input(INPUT_POST, 'quantite'),
            'id_compagnie' => filter_input(INPUT_POST, 'id_compagnie'),
            'nom_compagnie'=> filter_input(INPUT_POST, 'nom_compagnie'),
            'id_categorie' => filter_input(INPUT_POST, 'id_categorie'),
            'nom_categorie'=> filter_input(INPUT_POST, 'nom_categorie'),
        ];
        $alert_message = "Produit ajouté au panier.";
    }
}

// =====================================================================
// SUPPRESSION D'UN PRODUIT DU PANIER
// =====================================================================
if (filter_input(INPUT_GET, 'action') == 'delete') {
    $produit_supprime = false;

    foreach ($_SESSION['pointofsale'] as $key => $produit) {
        if ($produit['id'] == filter_input(INPUT_GET, 'id')) {
            unset($_SESSION['pointofsale'][$key]);
            $produit_supprime = true;
            $alert_message = "Produit supprimé du panier.";
            break;
        }
    }

    if ($produit_supprime) {
        $_SESSION['pointofsale'] = array_values($_SESSION['pointofsale']);
        if (empty($_SESSION['pointofsale'])) {
            unset($_SESSION['pointofsale']);
        }
    }
}

// =====================================================================
// VIDER TOUT LE PANIER
// =====================================================================
if (filter_input(INPUT_GET, 'action') == 'clear_cart') {
    unset($_SESSION['pointofsale']);
    $alert_message = "Panier vidé avec succès.";
}

// Fonction utilitaire de debug
function pre_r($array) {
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}
?>

<!-- Alertes JavaScript -->
<?php if (!empty($alert_message)): ?>
<script type="text/javascript">
    alert("<?php echo addslashes($alert_message); ?>");
    <?php if (strpos($alert_message, 'Impossible') !== false): ?>
        window.location.href = window.location.href.split('?')[0];
    <?php endif; ?>
</script>
<?php endif; ?>

<!-- ================================================================
     CONTENU PRINCIPAL DE LA PAGE
================================================================ -->
<div class="row">
    <div class="col-lg-12">

        <!-- Sélection de compagnie -->
        <div class="card shadow mb-0">
            <div class="card-header py-2">
                <h4 class="m-1 text-lg text-primary">Sélectionner une Compagnie</h4>
                <div class="form-group mb-0">
                    <form method="post">
                        <select class="form-control" name="id_compagnie"
                                onchange="this.form.submit()" required>
                            <option value="">--Choisir une compagnie--</option>
                            <?php
                            $sql    = "SELECT id, nom_compagnie FROM compagnie ORDER BY nom_compagnie";
                            $result = $connection->query($sql);
                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                $selected = (isset($_SESSION['id_compagnie']) && $_SESSION['id_compagnie'] == $row['id'])
                                    ? 'selected' : '';
                                echo '<option value="' . htmlspecialchars($row['id']) . '" ' . $selected . '>'
                                    . htmlspecialchars($row['nom_compagnie']) . '</option>';
                            }
                            ?>
                        </select>
                    </form>
                </div>
            </div>
        </div>

        <!-- Catalogue produits -->
        <div class="card-body">
            <div class="card-header py-2">
                <h4 class="m-1 text-lg text-primary">
                    Catégories de produits — <?php echo htmlspecialchars($nom_compagnie); ?>
                </h4>
            </div>

            <!-- Navigation par onglets -->
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link" href="#keyboard" data-toggle="tab">Produits Pétroliers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#mouse" data-toggle="tab">Produits Dérivés</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#headset" data-toggle="tab">Produits du Shop</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#others" data-toggle="tab">Autres</a>
                </li>
            </ul>

            <!-- Contenu des onglets produits -->
            <?php include 'postabpane.php'; ?>

            <div style="clear:both"></div>
            <br/>

            <!-- Zone : tableau du panier + résumé latéral -->
            <div class="card shadow mb-4 col-md-12">
                <div class="card-header py-3 bg-white">
                    <h4 class="m-2 font-weight-bold text-primary">
                        <i class="fas fa-shopping-cart"></i> Achats en cours
                    </h4>
                </div>

                <div class="row">

                    <!-- ============================================
                         COLONNE GAUCHE : tableau du panier (9/12)
                         IMPORTANT : ce <form> se ferme ici-même,
                         AVANT l'include de posside.php
                    ============================================ -->
                    <div class="card-body col-md-9">
                        <div class="table-responsive">

                            <!-- Formulaire du tableau panier — indépendant du modal -->
                            <form role="form" method="post" action="pos.php">
                                <input type="hidden" name="employee"
                                       value="<?php echo htmlspecialchars($_SESSION['nom'] ?? ''); ?>">

                                <table class="table table-bordered table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th width="55%">Nom produit</th>
                                            <th width="15%">Prix d'Achat</th>
                                            <th width="15%">Total</th>
                                            <th width="5%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if (!empty($_SESSION['pointofsale'])):
                                        $total_panier = 0;
                                        foreach ($_SESSION['pointofsale'] as $key => $produit):
                                            $id_produit    = $produit['id'];
                                            $nom_produit   = $produit['nom_produit'];
                                            $prix_achat    = $produit['prix_achat'];
                                            $total_produit = $prix_achat;
                                    ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($nom_produit); ?></td>
                                            <td>F CFA <?php echo number_format($prix_achat); ?></td>
                                            <td>F CFA <?php echo number_format($total_produit, 2); ?></td>
                                            <td>
                                                <a href="pos.php?action=delete&id=<?php echo urlencode($id_produit); ?>"
                                                   class="btn btn-danger btn-sm"
                                                   onclick="return confirm('Supprimer ce produit ?')">
                                                    <i class="fas fa-fw fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php
                                            $total_panier += $total_produit;
                                        endforeach;
                                    else:
                                    ?>
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-3">
                                                <i class="fas fa-inbox"></i> Aucun produit dans le panier
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                    </tbody>
                                </table>

                                <!-- Bouton vider le panier -->
                                <?php if (!empty($_SESSION['pointofsale'])): ?>
                                <a href="pos.php?action=clear_cart"
                                   class="btn btn-outline-danger btn-sm"
                                   onclick="return confirm('Vider tout le panier ?')">
                                    <i class="fas fa-trash-alt"></i> Vider le panier
                                </a>
                                <?php endif; ?>

                            </form>
                            <!-- FIN du formulaire tableau — fermé ici, AVANT posside.php -->

                        </div>
                    </div>
                    <!-- FIN col-md-9 -->

                    <!-- ============================================
                         COLONNE DROITE : résumé + modal paiement
                         posside.php gère son propre <form> modal
                    ============================================ -->
                    <?php include 'posside.php'; ?>

                </div><!-- fin .row -->
            </div><!-- fin .card -->

        </div><!-- fin .card-body catalogue -->
    </div><!-- fin .col-lg-12 -->
</div><!-- fin .row principal -->

<?php include '../../includesSociete/footer.php'; ?>
