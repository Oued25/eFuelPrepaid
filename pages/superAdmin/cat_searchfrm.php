<?php
include '../../includes/connection.php';  
include '../../includes/sidebar.php'; 
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
              <h4 class="m-2 font-weight-bold text-primary"> Detaile Categorie </h4>
            </div>
            <a href="categorie.php?action=add" type="button" class="btn btn-primary bg-gradient-primary btn-block"> <i class="fas fa-flip-horizontal fa-fw fa-share"></i> Retour</a>
            <div class="card-body">
            <?php

              $id_cat = $_GET['id'];

              // Requête SQL avec PDO
              $sql = "SELECT id, nom_categorie, descrip_categorie FROM categorie WHERE id= :id ";

              // Préparation de la requête
              $req = $connection->prepare($sql);

              // Liaison des paramètres
              $req->bindParam(':id', $id_cat);

              // Exécution de la requête
              $req->execute();

              // Vérification des erreurs de requête
              if (!$req) {
                  die("Erreur dans la requête SQL: " . $connection->error);
              }

              // Récupération des résultats
              while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                  //$zz = $row['id_produit'];
                  $a = $row['nom_categorie'];
                  $b = $row['descrip_categorie'];
                 
              }

              ?>
 
                  <div class="form-group row text-left">
                      <div class="col-sm-3 text-primary">
                        <h5>
                        Categorie :<br>
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
                        Description :<br>
                        </h5>
                      </div>
                      <div class="col-sm-9">
                        <h5>
                          <?php echo $b; ?><br>
                        </h5>
                      </div>
                    </div>
                </div>
          </div></center>


 <?php include '../../includes/footer.php'; ?>