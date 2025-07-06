<?php 
 include '../../includesParticulier/connection.php'; 
 include '../../includesParticulier/sidebar.php';

  ?>

<!-- En-tête de la page -->
<div class="row show-grid">
    <!-- Nombre de stations -->
    <div class="col-md-3">
        <div class="col-md-12 mb-3">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-0">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Liste des Stations</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">10 Enregistrer(s)</div>
                            <br>
                            <div class="button">
                                    <a href="customer.php" class="btn btn-default btn-block">Voir Tous</a>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div> 
            </div>
        </div> 
    </div> 

    <!-- Nombre de managers -->
    <div class="col-md-3">
        <div class="col-md-12 mb-3">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-0">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Utilisateurs</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">5 Enregistrer(s)</div>
                            <br>
                            <div class="button">
                                    <a href="user.php" class="btn btn-default btn-block">Voir Tous</a>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Nombre de produits -->
    <div class="col-md-3">
        <div class="col-md-12 mb-3">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-0">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Liste des Produits</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">15 Enregistrer(s)</div>
                            <br>
                            <div class="button">
                                    <a href="product.php" class="btn btn-default btn-block">Voir Tous</a>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- voir liste transaction -->
    <div class="col-md-3">
        <div class="col-md-12 mb-3">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-0">
                           <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Transactions Rencentes</div>
                           <div class="h6 mb-0 font-weight-bold text-gray-800">15 Enregistrer(s)</div>
                           <br>
                           <div class="button">
                                <a href="transaction.php" class="btn btn-default btn-block">Voir Tous</a>
                           </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>

<?php include '../../includesParticulier/footer.php'; ?>
