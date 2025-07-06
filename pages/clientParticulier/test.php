<?php
// Inclure les fichiers de connexion et les éléments supérieurs de la page
include '../../includesParticulier/connection.php';  
//include '../../includesParticulier/sidebar.php';

// Vérifier si le panier est validé
if (isset($_SESSION['pointofsale']) && !empty($_SESSION['pointofsale'])): 
?>
<div class="container mt-4">
    <h2 class="text-center text-primary">Paiement</h2>
    <form method="post" action="process_payment.php">
        <!-- Téléphone du bénéficiaire -->
        <div class="form-group">
            <label for="tel_beneficiaire">Téléphone du Bénéficiaire</label>
            <input type="text" class="form-control" id="tel_beneficiaire" name="tel_beneficiaire" placeholder="Entrer le numéro" required>
        </div>
        
        <!-- Numéro ayant généré l'OTP -->
        <div class="form-group">
            <label for="tel_otp_generator">Téléphone ayant généré l'OTP</label>
            <input type="text" class="form-control" id="tel_otp_generator" name="tel_otp_generator" placeholder="Entrer le numéro ayant généré l'OTP" required>
        </div>
        
        <!-- Montant -->
        <div class="form-group">
            <label for="montant">Montant</label>
            <input type="text" class="form-control" id="montant" name="montant" value="<?php echo $total; ?>" readonly>
        </div>
        
        <!-- OTP -->
        <div class="form-group">
            <label for="otp">OTP (Code de validation)</label>
            <input type="text" class="form-control" id="otp" name="otp" placeholder="Entrer l'OTP" required>
        </div>
        
        <!-- Moyen de paiement -->
        <div class="form-group">
            <label for="moyen_paiement">Moyen de Paiement</label>
            <select class="form-control" id="moyen_paiement" name="moyen_paiement" required>
                <option value="">--Choisir un moyen de paiement--</option>
                <option value="Orange Money">Orange Money</option>
                <option value="Moov Money">Moov Money</option>
                <option value="Wave">Wave</option>
                <option value="Mtn Mobile Money">MTN Mobile Money</option>
            </select>
        </div>
        
        <!-- Produit acheté -->
        <div class="form-group">
            <label for="produit">Produit Acheté</label>
            <select class="form-control" id="produit" name="produit" required>
                <option value="">--Choisir un produit--</option>
                <option value="Essence">Essence</option>
                <option value="Gazoil">Gazoil</option>
                <option value="Produit du Shop">Produit du Shop</option>
            </select>
        </div>
        
        <!-- Stations -->
        <div class="form-group">
            <label for="station">Stations</label>
            <select class="form-control" id="station" name="station" required>
                <option value="">--Choisir une station--</option>
                <option value="Fixée">Fixée</option>
                <option value="Toutes Stations">Toutes Stations</option>
            </select>
        </div>
        
        <!-- Bouton de validation -->
        <button type="submit" class="btn btn-success btn-block">Confirmer le Paiement</button>
    </form>
</div>
<?php
else:
    echo '<p class="text-center text-danger">Votre panier est vide. Veuillez ajouter des produits avant de procéder au paiement.</p>';
endif;
?>

<?php
include '../../includesParticulier/footer.php';
?>




         <!-- Modal pour le récapitulatif de commande -->
         <div class="modal fade" id="posMODAL" tabindex="-1" role="dialog" aria-labelledby="POS" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">RÉSUMÉ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                  <!-- Affichage du grand total dans le modal -->
                  <div class="form-group row text-left mb-2">
                    <div class="col-sm-12 text-center">
                      <h3 class="py-0">TOTAL FINAL</h3>
                      <h3 class="font-weight-bold py-3 bg-light">F CFA <?php echo number_format($total, 2); ?></h3>
                    </div>
                  </div>

                  <!-- Champ pour entrer le montant en espèces -->
                  <div class="col-sm-12 mb-2">
                    <div class="input-group mb-2">
                      <div class="input-group-prepend">
                        <span class="input-group-text">F CFA</span>
                      </div>
                      <input class="form-control text-right" id="txtNumber" onkeypress="return isNumberKey(event)" type="text" name="cash" placeholder="ENTREZ CASH" required>
                    </div>
                  </div>
              </div>
              <div class="modal-footer">
                <!-- Bouton pour procéder au paiement -->
                <button type="submit" class="btn btn-primary btn-block">PROCEDURE DE PAIMENT</button>
              </div>
            </div>
          </div>
        </div>
        <!-- Fin du modal -->