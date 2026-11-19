<?php
//Inclure  les fichiers de connexion et les éléments supérieurs de la page
include '../../includesSociete/connection.php';  
include '../../includesSociete/sidebar.php';

//initialiser le panier pour eviter les warnig
if (session_status() === PHP_SESSION_NONE) {
    // session_start();
}

// Initialiser le panier s'il n'existe pas
if (!isset($_SESSION['pointofsale']) || !is_array($_SESSION['pointofsale'])) {
    $_SESSION['pointofsale'] = [];
}

// Définir les constantes des catégories
define('CATEGORIE_PETROLIER', 1);    // Produit pétrolier
define('CATEGORIE_DERIVE', 2);       // Produit dérivé pétrolier

// Variable pour stocker les messages d'alerte
$alert_message = '';

// Gérer la sélection de la compagnie
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_compagnie'])) {
    $id_compagnie = $_POST['id_compagnie'];
    
    // Vider le panier si on change de compagnie
    if (isset($_SESSION['id_compagnie']) && $_SESSION['id_compagnie'] != $id_compagnie) {
        unset($_SESSION['pointofsale']);
        $alert_message = "Changement de compagnie - le panier sera vider.";
    }
    
    $_SESSION['id_compagnie'] = $id_compagnie;

    // Récupérer le nom de la compagnie sélectionnée depuis la base de données
    $stmt = $connection->prepare("SELECT id, nom_compagnie FROM compagnie WHERE id = :id");
    $stmt->execute(['id' => $id_compagnie]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $_SESSION['nom_compagnie'] = $result['nom_compagnie'] ?? 'Compagnie inconnue';
}

// Vérifier si une compagnie est déjà sélectionnée
$id_compagnie = isset($_SESSION['id_compagnie']) ? $_SESSION['id_compagnie'] : 'Aucune compagnie sélectionnée';
$nom_compagnie = isset($_SESSION['nom_compagnie']) ? $_SESSION['nom_compagnie'] : 'Aucune compagnie sélectionnée';

//Initialiser un tableau pour stocker les identifiants de produits déjà dans le panier
$produit_ids = array(); 

// Vérifier si le formulaire "Add to Cart" a été soumis via la méthode POST
if (filter_input(INPUT_POST, 'addpos')) {
    // Vérifier si une session "pointofsale" existe déjà
    if (isset($_SESSION['pointofsale'])) {
        $count = count($_SESSION['pointofsale']);
        $produit_ids = array_column($_SESSION['pointofsale'], 'id');
        
        // Récupérer les informations du nouveau produit à ajouter
        $nouveau_id = filter_input(INPUT_GET, 'id');
        $nouvelle_categorie = filter_input(INPUT_POST, 'id_categorie');
        $nouvelle_compagnie = filter_input(INPUT_POST, 'id_compagnie');
        $nouveau_prix = filter_input(INPUT_POST, 'prix_achat');
        $nouvelle_quantite = filter_input(INPUT_POST, 'quantite');
        
        // Récupérer la compagnie du panier actuel
        $compagnie_panier = $_SESSION['pointofsale'][0]['id_compagnie'] ?? null;
        
        // === RÈGLE 1 : Vérification compagnie différente ===
        if ($compagnie_panier && $compagnie_panier != $nouvelle_compagnie) {
            $alert_message = "Impossible d'ajouter un produit d'une compagnie différente!";
        }
        // === RÈGLE 2 : Produit pétrolier ===
        elseif ($nouvelle_categorie == CATEGORIE_PETROLIER) {
            // Vérifier si un produit pétrolier existe déjà
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
                // Produit pétrolier existe déjà → additionner seulement le prix
                $_SESSION['pointofsale'][$key_petrolier]['prix_achat'] += $nouveau_prix;
                $alert_message = "Prix additionné au produit pétrolier existant.";
            }
            // Vérifier si le panier contient d'autres catégories
            elseif ($count > 0) {
                $alert_message = "Impossible d'ajouter un produit pétrolier à un panier contenant d'autres catégories!";
            }
            else {
                // Ajouter le produit pétrolier (premier et seul produit)
                $_SESSION['pointofsale'][0] = array(
                    'id' => $nouveau_id,
                    'nom_produit' => filter_input(INPUT_POST, 'nom_produit'),
                    'prix_achat' => $nouveau_prix,
                    'quantite' => 1, // Quantité fixe à 1 pour pétrolier
                    'id_compagnie' => $nouvelle_compagnie,
                    'nom_compagnie' => filter_input(INPUT_POST, 'nom_compagnie'),
                    'id_categorie' => $nouvelle_categorie,
                    'nom_categorie' => filter_input(INPUT_POST, 'nom_categorie'),
                );
                $alert_message = "Produit pétrolier ajouté au panier.";
            }
        }
        // === RÈGLE 3 : Produit dérivé pétrolier ===
        elseif ($nouvelle_categorie == CATEGORIE_DERIVE) {
            // Vérifier que tous les produits du panier sont de la catégorie dérivée
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
                // Vérifier si le produit existe déjà dans le panier
                if (in_array($nouveau_id, $produit_ids)) {
                    // Produit existe déjà → additionner prix et quantité
                    for ($i = 0; $i < count($produit_ids); $i++) {
                        if ($produit_ids[$i] == $nouveau_id) {
                            $_SESSION['pointofsale'][$i]['prix_achat'] += $nouveau_prix;
                            $_SESSION['pointofsale'][$i]['quantite'] += $nouvelle_quantite;
                            $alert_message = "Produit dérivé mis à jour (prix et quantité additionnés).";
                            break;
                        }
                    }
                } else {
                    // Ajouter le nouveau produit dérivé
                    $_SESSION['pointofsale'][$count] = array(
                        'id' => $nouveau_id,
                        'nom_produit' => filter_input(INPUT_POST, 'nom_produit'),
                        'prix_achat' => $nouveau_prix,
                        'quantite' => $nouvelle_quantite,
                        'id_compagnie' => $nouvelle_compagnie,
                        'nom_compagnie' => filter_input(INPUT_POST, 'nom_compagnie'),
                        'id_categorie' => $nouvelle_categorie,
                        'nom_categorie' => filter_input(INPUT_POST, 'nom_categorie'),
                    );
                    $alert_message = "Produit dérivé ajouté au panier.";
                }
            }
        }
        // === RÈGLE 4 : Autres catégories (si existantes) ===
        else {
            // Logique par défaut pour autres catégories
            if (!in_array($nouveau_id, $produit_ids)) {
                $_SESSION['pointofsale'][$count] = array(
                    'id' => $nouveau_id,
                    'nom_produit' => filter_input(INPUT_POST, 'nom_produit'),
                    'prix_achat' => $nouveau_prix,
                    'quantite' => $nouvelle_quantite,
                    'id_compagnie' => $nouvelle_compagnie,
                    'nom_compagnie' => filter_input(INPUT_POST, 'nom_compagnie'),
                    'id_categorie' => $nouvelle_categorie,
                    'nom_categorie' => filter_input(INPUT_POST, 'nom_categorie'),
                );
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
        // Panier vide - premier produit
        $_SESSION['pointofsale'][0] = array(
            'id' => filter_input(INPUT_GET, 'id'),
            'nom_produit' => filter_input(INPUT_POST, 'nom_produit'),
            'prix_achat' => filter_input(INPUT_POST, 'prix_achat'),
            'quantite' => filter_input(INPUT_POST, 'quantite'),
            'id_compagnie' => filter_input(INPUT_POST, 'id_compagnie'),
            'nom_compagnie' => filter_input(INPUT_POST, 'nom_compagnie'),
            'id_categorie' => filter_input(INPUT_POST, 'id_categorie'),
            'nom_categorie' => filter_input(INPUT_POST, 'nom_categorie'),
        );
        $alert_message = "Produit ajouté au panier.";
    }
}

// Supprimer un produit du panier
if(filter_input(INPUT_GET, 'action') == 'delete'){
    $produit_supprime = false;
    
    foreach($_SESSION['pointofsale'] as $key => $produit){
        if ($produit['id'] == filter_input(INPUT_GET, 'id')){
            unset($_SESSION['pointofsale'][$key]);
            $produit_supprime = true;
            $alert_message = "Produit supprimé du panier.";
            break;
        }
    }
    
    // Réindexer le tableau après suppression
    if ($produit_supprime) {
        $_SESSION['pointofsale'] = array_values($_SESSION['pointofsale']);
        
        // Si le panier est vide après suppression, on peut reset certaines variables
        if (empty($_SESSION['pointofsale'])) {
            unset($_SESSION['pointofsale']);
        }
    }
}

// Vider tout le panier
if(filter_input(INPUT_GET, 'action') == 'clear_cart'){
    unset($_SESSION['pointofsale']);
    $alert_message = "Panier vidé avec succès.";
}

// Fonction pour afficher un tableau de manière lisible
function pre_r($array){
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}
?>

<!-- Afficher l'alerte JavaScript si un message existe -->
<?php if (!empty($alert_message)): ?>
<script type="text/javascript">
    alert("<?php echo addslashes($alert_message); ?>");
    <?php if (strpos($alert_message, 'Impossible') !== false): ?>
        // Recharger la page pour les erreurs bloquantes
        window.location.href = window.location.href.split('?')[0];
    <?php endif; ?>
</script>
<?php endif; ?>



<!-- Contenu de la page -->
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-0">
            <div class="card-header py-2">
                <h4 class="m-1 text-lg text-primary">Sélectionner une Compagnie</h4>
                <div class="form-group">
                    <form method="post">
                        <select class="form-control" name="id_compagnie" onchange="this.form.submit()" required>
                            <option value="">--Choisir une compagnie--</option>
                            <?php 
                            $sql = "SELECT id, nom_compagnie FROM compagnie";
                            $result = $connection->query($sql);
                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                $selected = (isset($_SESSION['id_compagnie']) && $_SESSION['id_compagnie'] == $row['id']) ? 'selected' : '';
                                echo '<option value="'.$row['id'].'" '.$selected.'>'.$row['nom_compagnie'].'</option>';
                            }
                            ?>
                        </select>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="card-header py-2">
                <h4 class="m-1 text-lg text-primary">Catégories de produits - <?php echo $nom_compagnie; ?></h4>
            </div>
                <!-- Navigation par onglets -->
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-target="#keyboard" data-toggle="tab">Produits Pétroliers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-target="#mouse" data-toggle="tab">Produits Dérivés</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#headset" data-toggle="tab">Produits du Shops</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#others" data-toggle="tab">Autres</a>
                    </li>      
                </ul>
            <!-- Contenu des onglets -->
            <?php include 'postabpane.php'; ?>
            <div style="clear:both"></div>
            <br/>
            <div class="card shadow mb-4 col-md-12">
                <div class="card-header py-3 bg-white">
                    <h4 class="m-2 font-weight-bold text-primary">Achats</h4>
                </div>
                <div class="row">    
                    <div class="card-body col-md-9">
                        <div class="table-responsive">
                            <!-- Formulaire pour traiter les transactions de point de vente -->
                            <form role="form" method="post" action="pos_transac.php?action=add">
                                <input type="hidden" name="employee" value="<?php echo $_SESSION['nom']; ?>">
                                <table class="table">    
                                    <tr>  
                                         <!--<th width="55%">id_produit</th> -->
                                        <th width="55%">Nom produit</th>  
                                        <!-- <th width="10%">id_compagnie</th>  
                                        <th width="10%">Nom compagnie</th> -->
                                        <th width="15%">Prix d'Achat</th>  
                                        <th width="15%">Total</th>  
                                        <th width="5%">Action</th>  
                                    </tr>  
                                    <?php  
                                    if(!empty($_SESSION['pointofsale'])):  
                                        $total = 0;  
                                        foreach($_SESSION['pointofsale'] as $key => $produit): 
                                            $id_produit = $produit['id'];
                                            $nom_produit = $produit['nom_produit'];
                                           // $id_compagnie = $produit['id_compagnie'];
                                           // $nom_compagnie = $produit['nom_compagnie'];
                                            $prix_achat = $produit['prix_achat'];
                                            $total_produit = $prix_achat;
                                    ?>  
                                    <tr>  
                                        
                                        
                                        <td><?php echo $nom_produit; ?></td> 
                                        <!-- <td><?php echo $id_compagnie; ?></td>
                                        <td><?php echo $nom_compagnie; ?></td>-->
                                        <td>F CFA <?php echo number_format($prix_achat); ?></td>  
                                        <td>F CFA <?php echo number_format($total_produit, 2); ?></td>  
                                        <td>
                                            <a href="pos.php?action=delete&id=<?php echo $id_produit; ?>" class="btn bg-gradient-danger btn-danger">
                                                <i class="fas fa-fw fa-trash"></i>
                                            </a>
                                        </td>  
                                    </tr>
                                    <?php  
                                        $total += $total_produit;
                                        endforeach;  
                                    endif;
                                    ?>  
                                </table>  
                        </div>
                    </div>

<?php
include 'posside.php';
include '../../includesSociete/footer.php';
?>
