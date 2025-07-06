<?php
include '../../includesStation/connection.php'; 
include '../../includesStation/sidebar.php';  
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
              <h4 class="m-2 font-weight-bold text-primary"> Detaile Produit </h4>
            </div>
            <a href="product.php?action=add" type="button" class="btn btn-primary bg-gradient-primary btn-block"> <i class="fas fa-flip-horizontal fa-fw fa-share"></i> Retour</a>
            <div class="card-body">
            <?php

              $id_produit = $_GET['id'];

              // Requête SQL avec PDO
              $sql = "SELECT p.id AS id, code_produit, nom_produit, description, date_creation, date_modif, prix_unitaire, nom_categorie 
                      FROM produit AS p, categorie AS c
                      WHERE c.id=p.id_categorie
                      AND   p.code_produit = :id";

              // Préparation de la requête
              $req = $connection->prepare($sql);

              // Liaison des paramètres
              $req->bindParam(':id', $id_produit);

              // Exécution de la requête
              $req->execute();

              // Vérification des erreurs de requête
              if (!$req) {
                  die("Erreur dans la requête SQL: " . $connection->error);
              }

              // Récupération des résultats
              while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                  //$zz = $row['id_produit'];
                  $zzz = $row['code_produit'];
                  $i = $row['nom_produit'];
                  $a = $row['description'];
                  $b = $row['prix_unitaire'];
                  $c = $row['date_creation'];
                  $e = $row['date_modif'];
                  $d = $row['nom_categorie'];
                 
              }

              ?>

                  <div class="form-group row text-left">
                      <div class="col-sm-3 text-primary">
                        <h5>
                        Code Produit:<br>
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
                          Nom Produit :<br>
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
                          Description :<br>
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
                          Prix :<br>
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

                    <div class="form-group row text-left">
                      <div class="col-sm-3 text-primary">
                        <h5>
                          Categorie:<br>
                        </h5>
                      </div>
                      <div class="col-sm-9">
                        <h5>
                          <?php echo $d; ?><br>
                        </h5>
                      </div>
                    </div>
                </div>
          </div></center>



          <?php include '../../includesStation/footer.php'; ?>