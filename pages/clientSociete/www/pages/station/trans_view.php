<?php
 include '../../includesStation/connection.php'; 
 include '../../includesStation/sidebar.php'; 

/*  $query = 'SELECT ID, t.TYPE
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
 $query = 'SELECT *, FIRST_NAME, LAST_NAME, PHONE_NUMBER, EMPLOYEE, ROLE
              FROM transaction T
              JOIN customer C ON T.`CUST_ID`=C.`CUST_ID`
              JOIN transaction_details tt ON tt.`TRANS_D_ID`=T.`TRANS_D_ID`
              WHERE TRANS_ID ='.$_GET['id'];
        $result = mysqli_query($db, $query) or die (mysqli_error($db));
        while ($row = mysqli_fetch_assoc($result)) {
          $fname = $row['FIRST_NAME'];
          $lname = $row['LAST_NAME'];
          $pn = $row['PHONE_NUMBER'];
          $date = $row['DATE'];
          $tid = $row['TRANS_D_ID'];
          $cash = $row['CASH'];
          $sub = $row['SUBTOTAL'];
          $less = $row['LESSVAT'];
          $net = $row['NETVAT'];
          $add = $row['ADDVAT'];
          $grand = $row['GRANDTOTAL'];
          $role = $row['EMPLOYEE'];
          $roles = $row['ROLE'];
        }
        */
?>
            
          <div class="card shadow mb-4">
            <div class="card-body">
              <div class="form-group row text-left mb-0">
                <div class="col-sm-9">
                  <h5 class="font-weight-bold">
                    Reçu:
                  </h5>
                </div>
                <div class="col-sm-3 py-1">
                  <h6>
                    Date: 2024-02-19 09:25 
                  </h6>
                </div>
              </div>
<hr>
              <div class="form-group row text-left mb-0 py-2">
                <div class="col-sm-4 py-1">
                  <h6 class="font-weight-bold">
                   ouedraogo Issouf
                  </h6>
                  <h6>
                    Téléphone: 77856412
                  </h6>
                </div>
                <div class="col-sm-4 py-1"></div>
                <div class="col-sm-4 py-1">
                  <h6>
                    Transaction #021992615
                  </h6>
                  <h6 class="font-weight-bold">
                    Manager: Traoré Check
                  </h6>
                  <h6 class="font-weight-bold">
                    Tél  Bénéficière: 54213698
                  </h6>
                </div>
              </div>
          <table class="table table-bordered" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Produits</th>
                <th width="8%">Quantité</th>
                <th width="20%">Prix</th>
                <th width="20%">Prix Total</th>
              </tr>
            </thead>
            <tbody>
                <?php  
                          /*$query = 'SELECT *
                                    FROM transaction_details
                                    WHERE TRANS_D_ID ='.$tid;
                            $result = mysqli_query($db, $query) or die (mysqli_error($db));
                            while ($row = mysqli_fetch_assoc($result)) {
                              $Sub =  $row['QTY'] * $row['PRICE'];
                                echo '<tr>';
                                echo '<td>'. $row['PRODUCTS'].'</td>';
                                echo '<td>'. $row['QTY'].'</td>';
                                echo '<td>'. $row['PRICE'].'</td>';
                                echo '<td>'. $Sub.'</td>';
                                echo '</tr> ';
                                        }*/
                ?>

                <tr>
                        <td>Essence super 91</td>
                        <td>5 L</td>
                        <td>5000 f</td>
                        <td>25000 f</td>
                </tr>
            </tbody>
          </table>
            <div class="form-group row text-left mb-0 py-2">
                <div class="col-sm-4 py-1"></div>
                <div class="col-sm-3 py-1"></div>
                <div class="col-sm-4 py-1">
                  <h4>
                  Montant en Espèces: 25000 f
                  </h4>
                  <table width="100%">
                    <tr>
                      <td class="font-weight-bold">Prix Total</td>
                      <td class="text-right">5000 f</td>
                    </tr>
                    <tr>
                      <td class="font-weight-bold">Quantité</td>
                      <td class="text-right">5 L</td>
                    </tr>
                    <tr>
                      <td class="font-weight-bold">Total</td>
                      <td class="font-weight-bold text-right text-primary">25000 f</td>
                    </tr>
                  </table>
                </div>
                <div class="col-sm-1 py-1"></div>
              </div>
            </div>
          </div>


<?php include '../../includesStation/footer.php'; ?>
