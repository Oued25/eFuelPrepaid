<?php 
 include '../../includes/connection.php';
 include '../../includes/sidebar.php';
?>
<?php
                  // Requête pour récupérer le type de l'utilisateur 
                 /*$query = 'SELECT ID, t.TYPE
                            FROM users u
                            JOIN type t ON t.TYPE_ID = u.TYPE_ID
                            WHERE ID = :member_id';
                  $stmt = $connexion->prepare($query);
                  $stmt->bindParam(':member_id', $_SESSION['MEMBER_ID']);
                  $stmt->execute();
                  $row = $stmt->fetch(PDO::FETCH_ASSOC);

                  // Vérification du type de l'utilisateur
                  if ($row && $row['TYPE'] === 'User') {
                  ?>
                  <script type="text/javascript">
                      // Redirection vers POS
                      alert("Page restreinte ! Vous allez être redirigé vers POS");
                      window.location = "pos.php";
                  </script>
                  <?php
                  }

                  // Requête pour récupérer les informations du client
                  $query = 'SELECT * FROM customer WHERE CUST_ID = :cust_id';
                  $stmt = $connexion->prepare($query);
                  $stmt->bindParam(':cust_id', $_GET['id']);
                  $stmt->execute();
                  $row = $stmt->fetch(PDO::FETCH_ASSOC);

                  if ($row) {
                      $zz = $row['CUST_ID'];
                      $i = $row['FIRST_NAME'];
                      $a = $row['LAST_NAME'];
                      $b = $row['PHONE_NUMBER'];
                      $id = $_GET['id'];
                  }
                  */
?>

            
            <center><div class="card shadow mb-4 col-xs-12 col-md-8 border-bottom-primary">
            <div class="card-header py-3">
              <h4 class="m-2 font-weight-bold text-primary">Détail de la Compagnie</h4>
            </div>
            <a href="customer.php" type="button" class="btn btn-primary bg-gradient-primary btn-block"> <i class="fas fa-flip-horizontal fa-fw fa-share"></i>Retour</a>
            <div class="card-body">
              <?php

                $id_compagnie = $_GET['id'];

                // Requête SQL avec PDO
                $sql = "SELECT c.id AS id, c.code_compagnie, c.nom_compagnie,  c.contact, c.adresse, c.localisation, c.compte_paiement, c.date_creation, .c.date_modif
                        FROM compagnie AS c 
                        WHERE  c.code_compagnie= :id"; 

                // Préparation de la requête
                $req = $connection->prepare($sql);

                // Liaison des paramètres
                $req->bindParam(':id', $id_compagnie);

                // Exécution de la requête
                $req->execute(); 

                // Vérification des erreurs de requête
                if (!$req) {
                    die("Erreur dans la requête SQL: " . $connection->error);
                }

                // Récupération des résultats
                while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                    //$zz = $row['id_produit'];
                    $zzz = $row['code_compagnie'];
                    $a = $row['nom_compagnie'];
                    $b = $row['adresse'];
                    $c = $row['contact'];
                    $d = $row['localisation'];
                    $e = $row['compte_paiement'];
                    $f = $row['date_creation'];
                    $g = $row['date_modif'];
                  
                }

                ?>
                    
                    <div class="form-group row text-left">

                      <div class="col-sm-3 text-primary">
                        <h5>
                        Code Compagnie : <br>
                        </h5>
                      </div>

                      <div class="col-sm-9">
                        <h5>
                        <?php echo $zzz; ?> <br>
                        </h5>
                      </div>

                    </div>

                    <div class="form-group row text-left">

                      <div class="col-sm-3 text-primary">
                        <h5>
                        Nom Compagnie :<br>
                        </h5>
                      </div>

                      <div class="col-sm-9">
                        <h5>
                        <?php echo $a; ?> <br>
                        </h5>
                      </div>

                    </div>

                    <div class="form-group row text-left">

                      <div class="col-sm-3 text-primary">
                        <h5>
                        Adresse :<br>
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
                          Téléphone :<br>
                        </h5>
                      </div>

                      <div class="col-sm-9">
                        <h5>
                        <?php echo $c; ?> <br>
                        </h5>
                      </div>

                    </div>

                    <div class="form-group row text-left">

                      <div class="col-sm-3 text-primary">
                        <h5>
                        Localisation :<br>
                        </h5>
                      </div>

                      <div class="col-sm-9">
                        <h5>
                        <?php echo $d; ?> <br>
                        </h5>
                      </div>

                    </div>

                    <div class="form-group row text-left">

                    <div class="col-sm-3 text-primary">
                      <h5>
                      Compte Paiement :<br>
                      </h5>
                    </div>

                    <div class="col-sm-9">
                      <h5>
                      <?php echo $e; ?><br>
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
                        <?php echo $f; ?><br>
                        </h5>
                      </div> 
                    </div>

                    <div class="form-group row text-left">
                        <div class="col-sm-3 text-primary">
                            <h5>
                                Date Modification<br>
                            </h5>
                        </div>
                        <div class="col-sm-9">
                            <h5>
                            <?php echo $g; ?> <br>
                            </h5>
                        </div>
                    </div>
            </div>
          </div>
          <?php include '../../includes/footer.php'; ?>