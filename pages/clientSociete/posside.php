<?php
// =====================================================================
// posside.php — Partie latérale : résumé panier + modal de paiement
// Améliorations : form modal correctement lié à pos_transac.php,
//                 indicateur OTP dynamique selon opérateur,
//                 champs cachés complets, sécurité htmlspecialchars
// =====================================================================
?>

<!-- Partie latérale avec le résumé du panier -->
<div class="card-body col-md-3">

    <?php
    // =====================
    // CALCULS DU PANIER
    // =====================
    $total    = 0;
    $net_tva  = 0;
    $addtva   = 0;
    $panier_vide = empty($_SESSION['pointofsale']);

    // Fonction pour générer un code de transaction unique
    if (!function_exists('genererCodeTrans')) {
        function genererCodeTrans() {
            return 'T' . date('YmdHis');
        }
    }
    $code_trans = genererCodeTrans();
    $today      = date("Y-m-d H:i");

    if (!$panier_vide):
        foreach ($_SESSION['pointofsale'] as $produit) {
            $total += $produit['prix_achat'];
        }
        $net_tva = $total / 1.18;
        $addtva  = $net_tva * 0.18;

        // Récupérer le dernier produit pour les champs d'affichage
        $dernier_produit = end($_SESSION['pointofsale']);
    endif;
    ?>

    <!-- Date et heure -->
    <div class="form-group row text-left mb-1">
        <div class="col-sm-12 text-muted" style="font-size:13px;">
            <i class="fas fa-clock"></i> <?php echo $today; ?>
        </div>
    </div>

    <!-- Nom de l'utilisateur connecté -->
    <div class="form-group row text-left mb-3">
        <div class="col-sm-12 text-primary btn-group font-weight-bold">
            <i class="fas fa-user mr-1"></i>
            <?php echo htmlspecialchars(($_SESSION['nom'] ?? '') . ' ' . ($_SESSION['prenom'] ?? '')); ?>
        </div>
    </div>

    <?php if (!$panier_vide): ?>

        <!-- Prix HT -->
        <div class="form-group row mb-2">
            <div class="col-sm-5 text-left text-primary py-2">
                <h6>Prix HT</h6>
            </div>
            <div class="col-sm-7">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">F CFA</span>
                    </div>
                    <input type="text" class="form-control text-right"
                           value="<?php echo number_format($net_tva, 2); ?>"
                           readonly name="net_tva">
                </div>
            </div>
        </div>

        <!-- TVA -->
        <div class="form-group row mb-2">
            <div class="col-sm-5 text-left text-primary py-2">
                <h6>TVA (18%)</h6>
            </div>
            <div class="col-sm-7">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">F CFA</span>
                    </div>
                    <input type="text" class="form-control text-right"
                           value="<?php echo number_format($addtva, 2); ?>"
                           readonly name="addtva">
                </div>
            </div>
        </div>

        <!-- Grand Total -->
        <div class="form-group row text-left mb-3">
            <div class="col-sm-5 text-primary">
                <h6 class="font-weight-bold py-2">Grand Total</h6>
            </div>
            <div class="col-sm-7">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">F CFA</span>
                    </div>
                    <input type="text" class="form-control text-right font-weight-bold"
                           value="<?php echo number_format($total, 2); ?>"
                           readonly name="grand_total">
                </div>
            </div>
        </div>

    <?php else: ?>
        <div class="alert alert-warning text-center" style="font-size:13px;">
            <i class="fas fa-shopping-cart"></i> Panier vide
        </div>
    <?php endif; ?>

    <!-- Bouton VALIDER (désactivé si panier vide) -->
    <button type="button"
            class="btn btn-block btn-success <?php echo $panier_vide ? 'disabled' : ''; ?>"
            <?php echo $panier_vide ? 'disabled' : 'data-toggle="modal" data-target="#paymentModal"'; ?>>
        <i class="fas fa-check-circle"></i> VALIDEZ
    </button>

</div><!-- Fin col-md-3 -->


<!-- ================================================================
     MODAL DE PAIEMENT
     Le <form> englobe correctement modal-body ET modal-footer
     pour que le submit fonctionne depuis le bouton "Confirmer"
================================================================ -->
<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog"
     aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="paymentModalLabel">
                    <i class="fas fa-mobile-alt"></i> Paiement Mobile Money
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fermer">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- FORMULAIRE — englobe body + footer -->
            <form method="post" action="pos_transac.php">

                <div class="modal-body">

                    <!-- == Champs cachés : produits du panier == -->
                    <?php if (!$panier_vide): ?>
                        <?php foreach ($_SESSION['pointofsale'] as $key => $produit): ?>
                            <input type="hidden" name="produit[<?php echo $key; ?>][id]"
                                   value="<?php echo htmlspecialchars($produit['id']); ?>">
                            <input type="hidden" name="produit[<?php echo $key; ?>][nom_produit]"
                                   value="<?php echo htmlspecialchars($produit['nom_produit']); ?>">
                            <input type="hidden" name="produit[<?php echo $key; ?>][prix_achat]"
                                   value="<?php echo htmlspecialchars($produit['prix_achat']); ?>">
                            <input type="hidden" name="produit[<?php echo $key; ?>][id_compagnie]"
                                   value="<?php echo htmlspecialchars($produit['id_compagnie']); ?>">
                            <input type="hidden" name="produit[<?php echo $key; ?>][nom_compagnie]"
                                   value="<?php echo htmlspecialchars($produit['nom_compagnie']); ?>">
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <!-- Champs cachés : transaction -->
                    <input type="hidden" name="code_trans"    value="<?php echo htmlspecialchars($code_trans); ?>">
                    <input type="hidden" name="date_creation" value="<?php echo htmlspecialchars($today); ?>">
                    <input type="hidden" name="id_user"       value="<?php echo htmlspecialchars($_SESSION['id'] ?? ''); ?>">
                    <input type="hidden" name="id_compagnie"  value="<?php echo htmlspecialchars($dernier_produit['id_compagnie'] ?? ''); ?>">
                    <input type="hidden" name="net_tva"       value="<?php echo $net_tva; ?>">
                    <input type="hidden" name="addtva"        value="<?php echo $addtva; ?>">
                    <input type="hidden" name="grand_total"   value="<?php echo $total; ?>">

                    <!-- == Résumé visuel de la commande == -->
                    <div class="alert alert-info py-2 mb-3" style="font-size:13px;">
                        <strong>Produit :</strong>
                        <?php echo htmlspecialchars($dernier_produit['nom_produit'] ?? '—'); ?><br>
                        <strong>Montant TTC :</strong>
                        <span class="font-weight-bold">
                            <?php echo number_format($total, 2); ?> F CFA
                        </span>
                    </div>

                    <!-- Téléphone du bénéficiaire -->
                    <div class="form-group">
                        <label for="tel_benefic">
                            <i class="fas fa-phone"></i> Téléphone du Bénéficiaire
                        </label>
                        <input type="tel" class="form-control" id="tel_benefic"
                               name="tel_benefic" placeholder="Ex: 70000000" required
                               pattern="[0-9]{8}" maxlength="8" inputmode="numeric">
                    </div>

                    <!-- Numéro d'immatriculation -->
                    <div class="form-group">
                        <label for="num_imatric">
                            <i class="fas fa-id-card"></i> Numéro d'Immatriculation
                        </label>
                        <input type="text" class="form-control" id="num_imatric"
                               name="num_imatric" placeholder="Ex: AA-1234-BF" required>
                    </div>

                    <!-- Moyen de paiement -->
                    <div class="form-group">
                        <label for="payment_method">
                            <i class="fas fa-wallet"></i> Moyen de Paiement
                        </label>
                        <select class="form-control" id="payment_method"
                                name="payment_method" required>
                            <option value="" disabled selected>Choisir un moyen de paiement</option>
                            <option value="orange_money">Orange Money</option>
                            <option value="moov_money">Moov Money</option>
                        </select>
                    </div>

                    <!-- Numéro de paiement -->
                    <div class="form-group">
                        <label for="num_paiment">
                            <i class="fas fa-sim-card"></i> Numéro de Paiement
                        </label>
                        <input type="tel" class="form-control" id="num_paiment"
                               name="num_paiment" placeholder="Entrez le numéro (8 chiffres)"
                               required maxlength="8" inputmode="numeric"
                               title="Numéro à 8 chiffres requis.">
                        <!-- Message opérateur + instruction OTP -->
                        <small id="operateur_message"
                               style="display:block; font-weight:bold; margin-top:5px;"></small>
                        <small id="otp_instruction"
                               style="display:block; margin-top:3px; color:#555;"></small>
                    </div>

                    <!-- Code OTP -->
                    <div class="form-group">
                        <label for="otp">
                            <i class="fas fa-key"></i> Code OTP
                        </label>
                        <input type="tel" class="form-control" id="otp"
                               name="otp" placeholder="Code OTP à 6 chiffres"
                               required pattern="[0-9]{6}" maxlength="6"
                               minlength="6" inputmode="numeric"
                               title="Le code OTP doit comporter exactement 6 chiffres.">
                        <small class="text-muted">
                            Composez le code USSD affiché ci-dessus pour recevoir votre OTP.
                        </small>
                    </div>

                    <!-- Montant affiché (lecture seule, pour confirmation visuelle) -->
                    <div class="form-group">
                        <label>Montant à débiter</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">F CFA</span>
                            </div>
                            <input type="text" class="form-control text-right font-weight-bold"
                                   value="<?php echo number_format($total, 2); ?>"
                                   name="prix_achat" readonly>
                        </div>
                    </div>

                </div><!-- fin modal-body -->

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Annuler
                    </button>
                    <button type="submit" class="btn btn-primary" id="btn_confirmer">
                        <i class="fas fa-paper-plane"></i> Confirmer le Paiement
                    </button>
                </div>

            </form><!-- fin form -->

        </div>
    </div>
</div><!-- fin modal -->


<script>
(function () {
    const montantTotal = <?php echo intval($total); ?>;

    const orange  = ['05','06','07','54','55','56','57','64','65','66','67','74','75','76','77'];
    const moov    = ['01','02','03','50','51','52','53','60','61','62','63','70','71','72','73'];
    const telecel = ['58','59','68','69','78','79'];

    const inputNum     = document.getElementById('num_paiment');
    const msgOperateur = document.getElementById('operateur_message');
    const msgOtp       = document.getElementById('otp_instruction');
    const selectMethod = document.getElementById('payment_method');

    function detecterOperateur(numero) {
        const prefix = numero.substring(0, 2);
        if (orange.includes(prefix))  return 'orange';
        if (moov.includes(prefix))    return 'moov';
        if (telecel.includes(prefix)) return 'telecel';
        return null;
    }

    function afficherInfoOperateur(numero) {
        if (numero.length !== 8) {
            msgOperateur.textContent = numero.length > 0 ? 'Numéro incomplet (8 chiffres requis).' : '';
            msgOperateur.style.color = 'red';
            msgOtp.textContent = '';
            return;
        }

        const op = detecterOperateur(numero);

        if (op === 'orange') {
            msgOperateur.textContent = '✔ Orange Money détecté';
            msgOperateur.style.color = 'orange';
            msgOtp.textContent       = '👉 Composez : *144*4*6*' + montantTotal + '# pour générer l\'OTP';
            selectMethod.value       = 'orange_money';
        } else if (op === 'moov') {
            msgOperateur.textContent = '✔ Moov Money détecté';
            msgOperateur.style.color = 'blue';
            msgOtp.textContent       = '👉 Composez : *555*4*6*' + montantTotal + '# pour générer l\'OTP';
            selectMethod.value       = 'moov_money';
        } else if (op === 'telecel') {
            msgOperateur.textContent = '✔ Télécel détecté';
            msgOperateur.style.color = 'purple';
            msgOtp.textContent       = '👉 Composez : *808*4*6*' + montantTotal + '# pour générer l\'OTP';
        } else {
            msgOperateur.textContent = '✘ Numéro non reconnu.';
            msgOperateur.style.color = 'red';
            msgOtp.textContent       = '';
        }
    }

    // Nettoyage + détection en temps réel
    inputNum.addEventListener('input', function () {
        this.value = this.value.replace(/\D/g, '').substring(0, 8);
        afficherInfoOperateur(this.value);
    });

    // Validation OTP avant soumission
    document.querySelector('#paymentModal form').addEventListener('submit', function (e) {
        const otp = document.getElementById('otp').value;
        const num = inputNum.value;

        if (num.length !== 8) {
            e.preventDefault();
            alert('Veuillez entrer un numéro de paiement valide à 8 chiffres.');
            return;
        }

        if (!/^\d{6}$/.test(otp)) {
            e.preventDefault();
            alert('Le code OTP doit comporter exactement 6 chiffres.');
            return;
        }

        // Désactiver le bouton pour éviter double soumission
        document.getElementById('btn_confirmer').disabled = true;
        document.getElementById('btn_confirmer').innerHTML =
            '<i class="fas fa-spinner fa-spin"></i> Traitement...';
    });
})();
</script>
