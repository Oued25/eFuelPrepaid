<!-- Employee select and script -->
<?php
    // Préparation de la requête SQL avec PDO
    $sqlforjob = "SELECT DISTINCT JOB_TITLE, JOB_ID FROM job ORDER BY JOB_ID ASC";

    // Préparation de la requête avec PDO
    $stmt = $connexion->prepare($sqlforjob);

    // Exécution de la requête
    $stmt->execute();

    // Récupération des résultats
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Initialisation de la variable contenant les options du select
    $job = "<select class='form-control' name='jobs' required>
                <option value='' disabled selected hidden>Select Job</option>";

    // Parcours des résultats et ajout des options au select
    foreach ($result as $row) {
        $job .= "<option value='".$row['JOB_ID']."'>".$row['JOB_TITLE']."</option>";
    }

    $job .= "</select>";
?>

<script>  
window.onload = function() {  
  // ---------------
  // basic usage
  // ---------------
  var $ = new City();
  $.showProvinces("#province");
  $.showCities("#city");

  // ------------------
  // additional methods 
  // -------------------

  // will return all provinces 
  console.log($.getProvinces());
  
  // will return all cities 
  console.log($.getAllCities());
  
  // will return all cities under specific province (e.g Batangas)
  console.log($.getCities("Batangas")); 
  
}
</script>
<!-- end of Employee select and script -->

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Se déconnecter?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body"><?php echo  $_SESSION['FIRST_NAME']; ?> Etes vous sure de vouloir quitter?</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
          <a class="btn btn-primary" href="logout.php">Déconnecter</a>
        </div>
      </div>
    </div>
  </div>
  <!-- Maude de station -->
  <div class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ajouter Station</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form role="form" method="post" action="cust_transac.php?action=add">
            <div class="form-group">
              <input class="form-control" placeholder="Nom Station" name="firstname" required>
            </div>
            <div class="form-group">
              <input class="form-control" placeholder="Adresse" name="lastname" required>
            </div>
            <div class="form-group">
              <input class="form-control" placeholder="Compte Paiement" name="lastname" required>
            </div>
            <div class="form-group">
              <input class="form-control" placeholder="Localisation" name="lastname" required>
            </div>
            <div class="form-group">
              <input class="form-control" placeholder="Téléphone" name="phonenumber" required>
            </div>
            <hr>
            <button type="submit" class="btn btn-success"><i class="fa fa-check fa-fw"></i>Validez</button>
            <button type="reset" class="btn btn-danger"><i class="fa fa-times fa-fw"></i>Réinitialiser</button>
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>      
          </form>  
        </div>
      </div>
    </div>
  </div>
  <!-- Mode client-->
  <div class="modal fade" id="poscustomerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ajouter Client</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form role="form" method="post" action="cust_pos_trans.php?action=add">
            <div class="form-group">
              <input class="form-control" placeholder="Nom" name="firstname" required>
            </div>
            <div class="form-group">
              <input class="form-control" placeholder="Prénom" name="lastname" required>
            </div>
            <div class="form-group">
              <input class="form-control" placeholder="Téléphone" name="phonenumber" required>
            </div>
            <hr>
            <button type="submit" class="btn btn-success"><i class="fa fa-check fa-fw"></i>Valider</button>
            <button type="reset" class="btn btn-danger"><i class="fa fa-times fa-fw"></i>Réinitialiser</button>
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>      
          </form>  
        </div>
      </div>
    </div>
  </div>
  <!--  Maude Mananger-->
  <div class="modal fade" id="employeeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ajouter Mananger</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form role="form" method="post" action="emp_transac.php?action=add">          
              <div class="form-group">
                <input class="form-control" placeholder="Nom" name="firstname" required>
              </div>
              <div class="form-group">
                <input class="form-control" placeholder="Prénom" name="lastname" required>
              </div>
              <div class="form-group">
                  <select class='form-control' name='gender' required>
                    <option value="" disabled selected hidden>Select Genre</option>
                    <option value="Male">Homme</option>
                    <option value="Female">Femme</option>
                  </select>
              </div>
              <div class="form-group">
                <input class="form-control" placeholder="Email" name="email" required>
              </div>
              <div class="form-group">
                <input class="form-control" placeholder="Téléphone" name="phonenumber" required>
              </div>
              <div class="form-group">
                <?php
                  echo $job;
                ?>
              </div>
              <hr>
            <button type="submit" class="btn btn-success"><i class="fa fa-check fa-fw"></i>Valider</button>
            <button type="reset" class="btn btn-danger"><i class="fa fa-times fa-fw"></i>Réinitialiser</button>
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>      
          </form>  
        </div>
      </div>
    </div>
  </div>



  <!--  Mode de suppression-->
  <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="DeleteModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Confirmer</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Etes vous sure de vouloir supprimer?</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
          <a class="btn btn-danger btn-ok">Supprimer</a>
        </div>
      </div>
    </div>
  </div>
    <script>
        $('#confirm-delete').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
            
            $('.debug-url').html('Delete URL: <strong>' + $(this).find('.btn-ok').attr('href') + '</strong>');
        });
    </script>


<!-- Sélection et script pour les employés --
?php
// Requête pour sélectionner les emplois distincts dans la base de données
$sqlforjob = "SELECT DISTINCT JOB_TITLE, JOB_ID FROM job ORDER BY JOB_ID ASC";
$result = mysqli_query($db, $sqlforjob) or die ("Mauvaise requête SQL : $sqlforjob");

// Construction du menu déroulant pour les emplois
$job = "<select class='form-control' name='jobs' required>
        <option value='' disabled selected hidden>Sélectionnez un emploi</option>";
while ($row = mysqli_fetch_assoc($result)) {
  $job .= "<option value='".$row['JOB_ID']."'>".$row['JOB_TITLE']."</option>";
}
$job .= "</select>";
?>
<script>  
window.onload = function() {  
  // ---------------
  // Utilisation de base
  // ---------------
  var $ = new City();
  $.showProvinces("#province"); // Affiche les provinces dans le sélecteur avec l'ID 'province'
  $.showCities("#city"); // Affiche les villes dans le sélecteur avec l'ID 'city'

  // ------------------
  // Méthodes supplémentaires
  // -------------------

  // Retourne toutes les provinces 
  console.log($.getProvinces());
  
  // Retourne toutes les villes 
  console.log($.getAllCities());
  
  // Retourne toutes les villes sous une province spécifique (par exemple Batangas)
  console.log($.getCities("Batangas")); 
}
</script>
-- Fin du script pour les employés --

!-- Modal de déconnexion --
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    
</div>

-- Modal pour ajouter un client --
<div class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   
</div>

-- Modal pour ajouter un client dans le POS (point de vente) --
<div class="modal fade" id="poscustomerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    
</div>

-- Modal pour ajouter un employé --
<div class="modal fade" id="employeeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    -- ... --
</div>

<-- Modal de confirmation de suppression --
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="DeleteModal" aria-hidden="true">
    <-- ... --
</div>

<script>
    // Script pour mettre à jour le lien de suppression dans la boîte de dialogue de confirmation de suppression
    $('#confirm-delete').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        
        $('.debug-url').html('Delete URL: <strong>' + $(this).find('.btn-ok').attr('href') + '</strong>');
    });
</script>
  -->