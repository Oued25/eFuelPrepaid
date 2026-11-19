<!-- Partie latérale avec le résumé -->
<div class="card-body col-md-3">
    <!--<form method="post" action="pos_transac.php?action=add">  Ajout de l'ouverture du formulaire -->
          <?php   
          // Vérifie si la session 'pointofsale' contient des produits
          if(!empty($_SESSION['pointofsale'])):  
              
              $total = 0;  // Initialisation du total
              
              // Boucle sur chaque produit dans la session 'pointofsale' 
              foreach($_SESSION['pointofsale'] as $key => $produit):  
                    // Calcule le total, la TVA réduite, nette et ajoutée
                    $total += ($produit['prix_achat']);
              endforeach;

              $net_tva = ($total / 1.18);
              $addtva = ($total / 1.18) * 0.18;  

              // Menu déroulant pour le client 
   
              // Fin du menu déroulant
          ?> 

          <?php
            // Fonction pour générer un code unique basé sur la date et l'heure actuelle
            function genererCodeTrans() {
                $prefix = 'T'; // Préfixe
                $date = date('YmdHis'); // Format: AnnéeMoisJourHeureMinuteSeconde
                return $prefix . $date;
            }

            // Générer le code
            $code_trans = genererCodeTrans();
         ?> 

          <!-- Affiche la date d'aujourd'hui -->
          <?php 
                echo "Date et Heure : "; 
                $today = date("Y-m-d H:i "); 
                echo $today; 
          ?> 
          <!-- Champ caché pour la date -->
          <input type="hidden" name="date_creation" value="<?php echo $today; ?>">
          
          <!-- Affichage du sous-total -->
          <div class="form-group row text-left mb-3">
            <div class="col-sm-12 text-primary btn-group"> 
            <input type="hidden" name="id" value="<?php echo isset($_SESSION['id']) ? $_SESSION['id'] : ''; ?>" />    
            <?php echo isset($_SESSION['nom']) ? $_SESSION['nom'] : ''; ?> <?php echo isset($_SESSION['prenom']) ? $_SESSION['prenom'] : ''; ?>        
            </div>
          </div>
          
          <!-- Affichage du montant net de TVA -->
          <div class="form-group row mb-2">
            <div class="col-sm-5 text-left text-primary py-2">
              <h6>Prix HT</h6>
            </div>
            <div class="col-sm-7">
              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <span class="input-group-text">F CFA</span>
                </div>
                <input type="text" class="form-control text-right" value="<?php echo number_format($net_tva, 2); ?>" readonly name="net_tva">
              </div>
            </div>
          </div>
          
          <!-- Affichage de l'ajout de TVA -->
          <div class="form-group row mb-2">
            <div class="col-sm-5 text-left text-primary py-2">
              <h6>TVA</h6>
            </div>
            <div class="col-sm-7">
              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <span class="input-group-text">F CFA</span>
                </div>
                <input type="text" class="form-control text-right" value="<?php echo number_format($addtva, 2); ?>" readonly name="addtva">
              </div>
            </div>
          </div>
          
          <!-- Affichage du total -->
          <div class="form-group row text-left mb-2">
            <div class="col-sm-5 text-primary">
              <h6 class="font-weight-bold py-2">Grand Total</h6>
            </div>
            <div class="col-sm-7">
              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <span class="input-group-text">F CFA</span>
                </div>
                <input type="text" class="form-control text-right" value="<?php echo number_format($total, 2); ?>" readonly name="grand_total">
              </div>
            </div>
          </div>
          
          <?php endif; ?>       
          <!-- Bouton pour soumettre la commande -->
          <button type="button" class="btn btn-block btn-success" data-toggle="modal" data-target="#paymentModal">VALIDEZ</button>


          <!-- Modal pour le paiement -->
             <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="paymentModalLabel">Formulaire de Paiement</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <!--<form method="post" action="process_payment.php">-->
                        <div class="modal-body">

                            <!-- Champs cachés pour les produits -->
                            <?php foreach ($_SESSION['pointofsale'] as $key => $produit): ?>
                                <input type="hidden" name="produit[<?php echo $key; ?>][id]" value="<?php echo $produit['id']; ?>">
                                <input type="hidden" name="produit[<?php echo $key; ?>][nom_produit]" value="<?php echo $produit['nom_produit']; ?>">
                                <input type="hidden" name="produit[<?php echo $key; ?>][prix_achat]" value="<?php echo $produit['prix_achat']; ?>">
                                <input type="hidden" name="produit[<?php echo $key; ?>][id_compagnie]" value="<?php echo $produit['id_compagnie']; ?>">
                                <input type="hidden" name="produit[<?php echo $key; ?>][nom_compagnie]" value="<?php echo $produit['nom_compagnie']; ?>">

                                <!--<input type="hidden" name="produit[<?php echo $key; ?>][id_categorie]" value="<?php echo $produit['id_categorie']; ?>">
                                <input type="hidden" name="produit[<?php echo $key; ?>][quantite]" value="<?php echo $produit['quantite']; ?>">
                                <input type="hidden" name="produit[<?php echo $key; ?>][id_compagnie]" value="<?php echo $produit['id_compagnie']; ?>">
                                <input type="hidden" name="produit[<?php echo $key; ?>][nom_categorie]" value="<?php echo $produit['nom_categorie']; ?>">-->
                            <?php endforeach; ?>

                            <!-- Champ caché pour le code de transaction -->
                            <input type="hidden" name="code_trans" value="<?php echo $code_trans; ?>">

                            <!-- Téléphone du bénéficiaire -->
                            <div class="form-group">
                                <label for="tel_benefic">Téléphone du Bénéficiaire</label>
                                <input type="number" class="form-control" id="tel_benefic" name="tel_benefic" placeholder="Entrez le numéro" required>
                            </div>

                            <!-- Numero Immatriculation -->
                            <div class="form-group">
                                <label for="num_imatric">Numéro Immatriculation</label>
                                <input type="text" class="form-control" id="num_imatric" name="num_imatric" placeholder="Entrez le numéro" required>
                            </div>

                            <!-- Nom Produit -->
                            <div class="form-group">
                                <label for="nom_produit">Nom Produit</label>
                                <input type="text" class="form-control" id="nom_produit" name="nom_produit" placeholder="Nom Produit" readonly value="<?php echo $produit['nom_produit']; ?>">
                            </div>

                            <!-- Montant -->
                            <div class="form-group">
                                <label for="prix_achat">Montant</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text">F CFA</span>
                                  </div>
                                  <input 
                                    type="text" 
                                    class="form-control text-right" 
                                    id="prix_achat" 
                                    name="prix_achat" 
                                    placeholder="Montant à payer" 
                                    readonly 
                                    value="<?php echo number_format($total, 2); ?>">
                                </div>
                              </div>


                            <!-- Moyen de paiement -->
                            <div class="form-group">
                                <label for="payment_method">Moyen de Paiement</label>
                                <select class="form-control" id="payment_method" name="payment_method" required>
                                    <option value="" disabled selected>Choisir un moyen de paiement</option>
                                    <option value="orange_money">Orange Money</option>
                                    <option value="moov_money">Moov Money</option>
                                </select>
                            </div>

                             <!-- Numéro de paiement -->
                            <div class="form-group">
                              <label for="num_paiment">Numéro Paiement</label>
                              <input type="number"
                                    class="form-control"
                                    id="num_paiment"
                                    name="num_paiment"
                                    placeholder="Entrez numéro paiement"
                                    required
                                    maxlength="8"
                                    pattern="[0-9]{8}"
                                    title="Numéro invalide ou non supporté.">
                              <small id="operateur_message" style="display: block; font-weight: bold; margin-top: 5px;"></small>
                            </div>

                            <!-- OTP -->
                            <div class="form-group">
                                <label for="otp">Code OTP</label>
                                <input 
                                  type="number"
                                  class="form-control" 
                                  id="otp" 
                                  name="otp" 
                                  placeholder="Entrez le code OTP" 
                                  required
                                  pattern="[0-9]{6}"
                                  maxlength="6"
                                  minlength="6"
                                  inputmode="numeric"
                                  title="Le code OTP doit comporter exactement 6 chiffres.">
                              </div>


                            <!-- Compagnie  -->                            
                                <input type="hidden" class="form-control" id="id_compagnie" name="id_compagnie" placeholder="id_compagnie" readonly value="<?php echo $produit['id_compagnie']; ?>">
                          

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-primary">Confirmer le Paiement</button>
                            </div>
                            <!--</form>-->
                        </div>
                    </div>
              </div>

    </form> <!-- Fermeture du formulaire -->
  </div> <!-- Fin du corps de la carte -->
</div>
   
<script>
document.getElementById('num_paiment').addEventListener('input', function () {
    // Nettoyer les caractères non numériques et limiter à 8 chiffres
    this.value = this.value.replace(/\D/g, '').substring(0, 8);

    const numero = this.value;
    const prefix = numero.substring(0, 2);
    const message = document.getElementById('operateur_message');

    const orange = ['05','06','07','54','55','56','57','64','65','66','67','74','75','76','77'];
    const moov   = ['01','02','03','50','51','52','53','60','61','62','63','70','71','72','73'];
    const telecel= ['58','59','68','69','78','79'];

    if (numero.length === 8) {
        if (orange.includes(prefix)) {
            message.textContent = "code OTP Orange: *144*4*6*montant#";
            message.style.color = "green";
        } else if (moov.includes(prefix)) {
            message.textContent = "code OTP Moov: *555*4*6*montant#";
            message.style.color = "blue";
        } else if (telecel.includes(prefix)) {
            message.textContent = "code OTP Télécel: *808*4*6*montant#";
            message.style.color = "purple";
        } else {
            message.textContent = "Numéro invalide.";
            message.style.color = "red";
        }
    } else {
        message.textContent = "Numéro invalide.";
        message.style.color = "red";
    }
});
</script>