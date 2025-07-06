<?php
include '../../includesSociete/connection.php'; 
include '../../includesSociete/sidebar.php';
  /*$query = 'SELECT ID, t.TYPE 
            FROM users u
            JOIN type t ON t.TYPE_ID=u.TYPE_ID WHERE ID = '.$_SESSION['MEMBER_ID'].'';
  $result = mysqli_query($db, $query) or die (mysqli_error($db));
  
  while ($row = mysqli_fetch_assoc($result)) {
            $Aa = $row['TYPE'];
                   
  if ($Aa=='User'){
?>
  <script type="text/javascript">
    //then it will be redirected
    alert("Restricted Page! You will be redirected to POS"); 
    window.location = "pos.php"; 
  </script>
<?php
  }           
} 
         */   ?> 
          <center><div class="card shadow mb-4 col-xs-12 col-md-8 border-bottom-primary">
            <div class="card-header py-3">
              <h4 class="m-2 font-weight-bold text-primary"> Detaile Utilisateurs </h4>
            </div>
            <a href="user.php?action=add" type="button" class="btn btn-primary bg-gradient-primary btn-block"> <i class="fas fa-flip-horizontal fa-fw fa-share"></i> Retour</a>
            <div class="card-body">
            <?php

              $id_user = $_GET['id'];

              // Requête SQL avec PDO
              $sql = "SELECT u.id AS id, email, mot_de_passe, nom, prenom, genre,  nom_profil, u.date_creation, u.date_modif 
                      FROM utilisateur AS u 
                      JOIN profil AS p ON p.id = u.id_profil 
                      WHERE u.id = :id";  // Utilisation du paramètre de liaison :id



              // Préparation de la requête
              $req = $connection->prepare($sql);

              // Liaison des paramètres
              $req->bindParam(':id', $id_user);

              // Exécution de la requête
              $req->execute();

              // Vérification des erreurs de requête
              if (!$req) {
                  die("Erreur dans la requête SQL: " . $connection->error);
              }

              // Récupération des résultats
              while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                $zzz = $row['nom'];
                $i = $row['prenom'];
                $ii = $row['genre'];
                $a = $row['email'];
                $b = $row['nom_profil'];
                $c = $row['date_creation'];
                $e = $row['date_modif'];
          }
          ?>
      
           <div class="form-group row text-left">
                      <div class="col-sm-3 text-primary">
                        <h5>
                        Nom:<br>
                        </h5>
                      </div>
                      <div class="col-sm-9">
                        <h5>
                            <?php echo $zzz; ?><br>
                        </h5>
                      </div>
                    </div>
                    <div class="form-group row text-left">
                      <div class="col-sm-3 text-primary">
                        <h5>
                          Prénom :<br>
                        </h5>
                      </div>
                      <div class="col-sm-9">
                        <h5>
                          <?php echo $i; ?> <br>
                        </h5>
                      </div>
                    </div>
                    <div class="form-group row text-left">
                      <div class="col-sm-3 text-primary">
                        <h5>
                          Genre :<br>
                        </h5>
                      </div>
                      <div class="col-sm-9">
                        <h5>
                          <?php echo $ii; ?> <br>
                        </h5>
                      </div>
                    </div>
                  <div class="form-group row text-left">
                      <div class="col-sm-3 text-primary">
                        <h5>
                          Email :<br>
                        </h5>
                      </div>
                      <div class="col-sm-9">
                        <h5>
                          <?php echo $a; ?><br>
                        </h5>
                      </div>
                    </div>
                  <div class="form-group row text-left">
                      <div class="col-sm-3 text-primary">
                        <h5>
                          Profil :<br>
                        </h5>
                      </div>
                      <div class="col-sm-9">
                        <h5>
                          <?php echo $b; ?><br>
                        </h5>
                      </div>
                    </div>
                  <div class="form-group row text-left">
                      <div class="col-sm-3 text-primary">
                        <h5>
                          Date Creation:<br>
                        </h5>
                      </div>
                      <div class="col-sm-9">
                        <h5>
                            <?php echo $c; ?><br>
                        </h5>
                      </div>
                    </div>

                    <div class="form-group row text-left">
                      <div class="col-sm-3 text-primary">
                          <h5>
                              Date Modification:<br>
                          </h5>
                      </div>
                      <div class="col-sm-9">
                          <h5>
                          <?php echo $e; ?> <br>
                          </h5>
                      </div>
                    </div>
                </div>
          </div></center>


          <?php include '../../includesSociete/footer.php'; ?>