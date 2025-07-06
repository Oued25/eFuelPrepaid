</div>
        <!-- /.container-fluid -->

      </div>
      <!-- Fin du contenu principal -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
              <span>Droits d'auteur © 2024. Tous droits réservés.</span>
          </div>
        </div>
      </footer>
      <!-- Fin du pied de page -->

    </div>
    <!-- Fin du conteneur de contenu -->

  </div>
  <!-- Fin de la page -->

  <!-- Bouton de retour en haut -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Modal de déconnexion -->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Prêt à partir ?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body"><?php  ?> êtes-vous sûr de vouloir vous déconnecter ?</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
          <a class="btn btn-primary" href="../logout.php">Déconnexion</a>
        </div>
      </div>
    </div>
  </div>

 <!-- JavaScript de base de Bootstrap -->
 <script src="../../vendor/jquery/jquery.min.js"></script>
  <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Plugin principal JavaScript -->
  <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Scripts personnalisés pour toutes les pages -->
  <script src="../../js/sb-admin-2.min.js"></script>

  <!-- Plugins au niveau de la page -->
  <script src="../../vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../../vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Scripts client au niveau de la page -->
  <script src="../../js/demo/datatables-demo.js"></script>
  <script src="../../js/city.js"></script> 
  

<!-- SUPERPOSITION DE PROFIL Nom MODE -->
<div id="overlay" onclick="off()">
  <div id="text">Je suis <?php echo  $_SESSION['FIRST_NAME']. ' '.$_SESSION['LAST_NAME'] ;?><BR>
    De <?php echo  $_SESSION['PROVINCE']. ' '.$_SESSION['CITY'] ;?></div>
</div>
<script>
// Fonction pour afficher l'overlay
function on() {
  document.getElementById("overlay").style.display = "block";
}

// Fonction pour masquer l'overlay
function off() {
  document.getElementById("overlay").style.display = "none";
}

// Fonction utilisée dans les champs de texte pour n'accepter que des chiffres
function isNumberKey(evt) {
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
    return false;
  return true;
}
// Fin de la fonction utilisée dans les champs de texte pour n'accepter que des chiffres
</script>

</body>

</html>

<?php
          /*// Inclusion du fichier modal.php (s'il est nécessaire)
          include 'modal.php';

          // Requête SQL pour obtenir les options du select
          $sql = "SELECT DISTINCT TYPE, TYPE_ID FROM type";

          // Préparation de la requête avec PDO
          $stmt = $connection->prepare($sql);

          // Exécution de la requête
          $stmt->execute();

          // Récupération des résultats
          $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

          // Initialisation de la variable contenant les options du select
          $opt = "<select class='form-control' name='type'>";
          foreach ($result as $row) {
              $opt .= "<option value='".$row['TYPE_ID']."'>".$row['TYPE']."</option>";
          }
          $opt .= "</select>";

          // Requête SQL pour obtenir les informations de l'employé
          $query = "SELECT ID, e.FIRST_NAME, e.LAST_NAME, e.GENDER, USERNAME, PASSWORD, e.EMAIL, PHONE_NUMBER, j.JOB_TITLE, e.HIRED_DATE, t.TYPE, l.PROVINCE, l.CITY
                      FROM users u
                      JOIN employee e ON u.EMPLOYEE_ID = e.EMPLOYEE_ID
                      JOIN job j ON e.JOB_ID = j.JOB_ID
                      JOIN location l ON e.LOCATION_ID = l.LOCATION_ID
                      JOIN type t ON u.TYPE_ID = t.TYPE_ID
                      WHERE ID = :member_id";

          // Préparation de la requête avec PDO
          $stmt = $connexion->prepare($query);

          // Liaison des paramètres
          $stmt->bindParam(':member_id', $_SESSION['MEMBER_ID'], PDO::PARAM_INT);

          // Exécution de la requête
          $stmt->execute();

          // Récupération du résultat
          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          // Affectation des valeurs aux variables
          $zz = $row['ID'];
          $a = $row['FIRST_NAME'];
          $b = $row['LAST_NAME'];
          $c = $row['GENDER'];
          $d = $row['USERNAME'];
          $e = $row['PASSWORD'];
          $f = $row['EMAIL'];
          $g = $row['PHONE_NUMBER'];
          $h = $row['JOB_TITLE'];
          $i = $row['HIRED_DATE'];
          $j = $row['PROVINCE'];
          $k = $row['CITY'];
          $l = $row['TYPE'];
          */
?>

  <!-- Mode de modification des informations utilisateur -->

  <div class="modal fade" id="settingsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <!-- Titre du mode -->
          <h5 class="modal-title" id="exampleModalLabel">Modifier les informations de l'utilisateur</h5>
          <!-- Bouton de fermeture -->
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form role="form" method="post" action="settings_edit.php">
              <input type="hidden" name="id" value="<?php echo $zz; ?>" />

              <div class="form-group row text-left text-primary">
                <div class="col-sm-3" style="padding-top: 5px;">
                 Prénom :
                </div>
                <div class="col-sm-9">
                  <input class="form-control" placeholder="Prénom" name="firstname" value="<?php echo $a; ?>" required>
                </div>
              </div>
              <div class="form-group row text-left text-primary">
                <div class="col-sm-3" style="padding-top: 5px;">
                 Nom de famille :
                </div>
                <div class="col-sm-9">
                  <input class="form-control" placeholder="Nom de famille" name="lastname" value="<?php echo $b; ?>" required>
                </div>
              </div>
              <div class="form-group row text-left text-primary">
                <div class="col-sm-3" style="padding-top: 5px;">
                 Genre :
                </div>
                <div class="col-sm-9">
                  <select class='form-control' name='gender' required>
                    <option value="" disabled selected hidden>Sélectionnez le genre</option>
                    <option value="Homme">Homme</option>
                    <option value="Femme">Femme</option>
                  </select>
                </div>
              </div>
              <div class="form-group row text-left text-primary">
                <div class="col-sm-3" style="padding-top: 5px;">
                 Nom d'utilisateur :
                </div>
                <div class="col-sm-9">
                  <input class="form-control" placeholder="Nom d'utilisateur" name="username" value="<?php echo $d; ?>" required>
                </div>
              </div>
              <div class="form-group row text-left text-primary">
                <div class="col-sm-3" style="padding-top: 5px;">
                 Mot de passe :
                </div>
                <div class="col-sm-9">
                  <input type="password" class="form-control" placeholder="Mot de passe" name="password" value="" required>
                </div>
              </div>
              <div class="form-group row text-left text-primary">
                <div class="col-sm-3" style="padding-top: 5px;">
                 Email :
                </div>
                <div class="col-sm-9">
                  <input class="form-control" placeholder="Email" name="email" value="<?php echo $f; ?>" required>
                </div>
              </div>
              <div class="form-group row text-left text-primary">
                <div class="col-sm-3" style="padding-top: 5px;">
                 Contact :
                </div>
                <div class="col-sm-9">
                   <input class="form-control" placeholder="Contact" name="phone" value="<?php echo $g; ?>" required>
                </div>
              </div>
              <div class="form-group row text-left text-primary">
                <div class="col-sm-3" style="padding-top: 5px;">
                 Rôle :
                </div>
                <div class="col-sm-9">
                  <input class="form-control" placeholder="Rôle" name="role" value="<?php echo $h; ?>" readonly>
                </div>
              </div>
              <div class="form-group row text-left text-primary">
                <div class="col-sm-3" style="padding-top: 5px;">
                 Date d'embauche :
                </div>
                <div class="col-sm-9">
                  <input class="form-control" placeholder="Date d'embauche" name="hireddate" value="<?php echo $i; ?>" required>
                </div>
              </div>
              <div class="form-group row text-left text-primary">
                <div class="col-sm-3" style="padding-top: 5px;">
                 Province :
                </div>
                <div class="col-sm-9">
                  <input class="form-control" placeholder="Province" name="province" value="<?php echo $j; ?>" required>
                </div>
              </div>
              <div class="form-group row text-left text-primary">
                <div class="col-sm-3" style="padding-top: 5px;">
                 Ville / Municipalité :
                </div>
                <div class="col-sm-9">
                  <input class="form-control" placeholder="Ville / Municipalité" name="city" value="<?php echo $k; ?>" required>
                </div>
              </div>
              <div class="form-group row text-left text-primary">
                <div class="col-sm-3" style="padding-top: 5px;">
                  Type de compte :
                </div>
                <div class="col-sm-9">
                  <input class="form-control" placeholder="Type de compte" name="type" value="<?php echo $l; ?>" readonly>
                </div>
              </div>
              <!-- Bouton de sauvegarde -->
              <hr>
            <button type="submit" class="btn btn-success"><i class="fa fa-check fa-fw"></i>Enregistrer</button>
            <!-- Bouton de fermeture -->
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Fermer</button>      
          </form>  
        </div>
      </div>
    </div>
  </div>
