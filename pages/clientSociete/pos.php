<?php
//Inclure  les fichiers de connexion et les éléments supérieurs de la page
include '../../includesSociete/connection.php';  
include '../../includesSociete/sidebar.php';


// Gérer la sélection de la compagnie
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_compagnie'])) {
    $id_compagnie = $_POST['id_compagnie'];
    $_SESSION['id_compagnie'] = $id_compagnie;

    // Récupérer le nom de la compagnie sélectionnée depuis la base de données
    $stmt = $connection->prepare("SELECT id, nom_compagnie FROM compagnie WHERE id = :id");
    $stmt->execute(['id' => $id_compagnie]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    //$_SESSION['id'] = $result['id'] ?? 'Compagnie inconnue';
    $_SESSION['nom_compagnie'] = $result['nom_compagnie'] ?? 'Compagnie inconnue';
}

// Vérifier si une compagnie est déjà sélectionnée
$id_compagnie = isset($_SESSION['id_compagnie']) ? $_SESSION['id_compagnie'] : 'Aucune compagnie sélectionnée';
$nom_compagnie = isset($_SESSION['nom_compagnie']) ? $_SESSION['nom_compagnie'] : 'Aucune compagnie sélectionnée';

//Initialiser un tableau pour stocker les identifiants de produits déjà dans le panier
$produit_ids = array(); 

// Vérifier si le formulaire "Add to Cart" a été soumis via la méthode POST
if (filter_input(INPUT_POST, 'addpos')) {
    // Vérifier si une session "pointofsale" existe déjà (indiquant que le panier n'est pas vide)
    if (isset($_SESSION['pointofsale'])) {
        // Compter le nombre de produits actuellement dans le panier
        $count = count($_SESSION['pointofsale']);
        
        // Extraire tous les identifiants des produits actuellement dans le panier
        $produit_ids = array_column($_SESSION['pointofsale'], 'id');

        // Vérifier si le produit actuel (identifié par `id` via GET) est déjà dans le panier
        if (!in_array(filter_input(INPUT_GET, 'id'), $produit_ids)) {
            // Si le produit n'est pas dans le panier, ajouter un nouvel élément au tableau de session
            $_SESSION['pointofsale'][$count] = array(
                'id' => filter_input(INPUT_GET, 'id'),
                'nom_produit' => filter_input(INPUT_POST, 'nom_produit'),
                'prix_achat' => filter_input(INPUT_POST, 'prix_achat'),
                'quantite' => filter_input(INPUT_POST, 'quantite'),
                'id_compagnie' => filter_input(INPUT_POST, 'id_compagnie'),
                'nom_compagnie' => filter_input(INPUT_POST, 'nom_compagnie', FILTER_SANITIZE_STRING) ?? 'Non défini', // Défaut si absent
                'id_categorie' => filter_input(INPUT_POST, 'id_categorie', FILTER_SANITIZE_NUMBER_INT) ?? 'Non défini', // Défaut si absent
                'nom_categorie' => filter_input(INPUT_POST, 'nom_categorie', FILTER_SANITIZE_STRING) ?? 'Non défini',  // Défaut si absent
            );
            
        } else {
            // Si le produit est déjà dans le panier, parcourir les produits existants
            for ($i = 0; $i < count($produit_ids); $i++) {
                // Rechercher le produit correspondant dans le tableau de session
                if ($produit_ids[$i] == filter_input(INPUT_GET, 'id')) {
                    // Ajouter la quantité soumise à la quantité existante du produit dans le panier
                    $_SESSION['pointofsale'][$i]['quantite'] += filter_input(INPUT_POST, 'quantite');
                }
            }
        }
    } else {
        // Si le panier est vide (session "pointofsale" non définie), initialiser le panier avec le premier produit
        $_SESSION['pointofsale'][0] = array(
                'id' => filter_input(INPUT_GET, 'id'),
                'nom_produit' => filter_input(INPUT_POST, 'nom_produit'),
                'prix_achat' => filter_input(INPUT_POST, 'prix_achat'),
                'quantite' => filter_input(INPUT_POST, 'quantite'),
                'id_compagnie' => filter_input(INPUT_POST, 'id_compagnie'),
                'nom_compagnie' => filter_input(INPUT_POST, 'nom_compagnie', FILTER_SANITIZE_STRING) ?? 'Non défini', // Défaut si absent
                'id_categorie' => filter_input(INPUT_POST, 'id_categorie', FILTER_SANITIZE_NUMBER_INT) ?? 'Non défini', // Défaut si absent
                'nom_categorie' => filter_input(INPUT_POST, 'nom_categorie', FILTER_SANITIZE_STRING) ?? 'Non défini',  // Défaut si absent
            );
    }
}

// Supprimer un produit du panier
if(filter_input(INPUT_GET, 'action') == 'delete'){
    foreach($_SESSION['pointofsale'] as $key => $produit){
        if ($produit['id'] == filter_input(INPUT_GET, 'id')){
            unset($_SESSION['pointofsale'][$key]);
        }
    }
    $_SESSION['pointofsale'] = array_values($_SESSION['pointofsale']);
}

// Fonction pour afficher un tableau de manière lisible
function pre_r($array){
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}
?>

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
                                        <th width="55%">id_produit</th> 
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
                                        
                                        <td><?php echo $id_produit; ?></td> 
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
