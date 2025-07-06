<!-- Tab panes -->
<div class="tab-content"> 
  <?php
  // Vérifie si une compagnie est sélectionnée
  if (isset($_SESSION['id_compagnie'])) {
      $id_compagnie = $_SESSION['id_compagnie'];
  } else {
      $id_compagnie = null;
  }

  // Afficher un message si aucune compagnie n'est sélectionnée
  if (!$id_compagnie) {
      echo "<p class='text-danger'>Veuillez sélectionner une compagnie pour afficher les produits.</p>";
  }
  ?>

  <!-- 1ST TAB -->
  <div class="tab-pane fade in mt-2" id="keyboard">
    <div class="row">
        <?php
          if ($id_compagnie){  

              $sql ='SELECT p.id AS id, code_produit, nom_produit, p.id_compagnie,cpa.nom_compagnie, nom_categorie 
                      FROM produit AS p
                      LEFT JOIN categorie AS c ON p.id_categorie = c.id
                      LEFT JOIN compagnie AS cpa ON p.id_compagnie = cpa.id
                      WHERE id_categorie = 1 
                      AND id_compagnie = :id_compagnie
                      GROUP BY code_produit 
                      ORDER BY code_produit ASC';
              $req = $connection->prepare($sql); 
              $req->execute(['id_compagnie' => $id_compagnie]);

              if ($req->rowCount() > 0):
                  while ($produit = $req->fetch(PDO::FETCH_ASSOC)):
          ?>
      <div class="col-sm-4 col-md-2">
          <form method="post" action="pos.php?action=add&id=<?php echo $produit['id']; ?>">
            <div class="products">
              <!-- Nom du produit -->
              <h6 class="text-info"><?php echo $produit['nom_produit']; ?></h6>
              
              <!-- Champ pour le prix d'achat -->
              <input type="number" name="prix_achat" class="form-control" value="" placeholder="Prix d'Achat" required />

              <!-- Champ caché pour le nom du produit -->
              <input type="hidden" name="nom_produit" value="<?php echo $produit['nom_produit']; ?>" />

              <!-- Champ caché pour l'ID du produit -->
              <input type="hidden" name="id_produit" value="<?php echo $produit['id']; ?>" />

              <!-- Champs cachés pour la compagnie -->
              <input type="hidden" name="id_compagnie" value="<?php echo $id_compagnie; ?>" />
              <input type="hidden" name="nom_compagnie" value="<?php echo isset($_SESSION['nom_compagnie']) ? $_SESSION['nom_compagnie'] : ''; ?>" />

              <!-- Bouton de soumission -->
              <input type="submit" name="addpos" style="margin-top:5px;" class="btn btn-info" value="Ajoutez" />
            </div>
          </form>
        </div>
      <?php
              endwhile;
          else:
              echo "<p class='text-warning'>Aucun produit trouvé pour cette catégorie.</p>";
          endif;
      }
      ?>
    </div>
  </div>

  <!-- 2ND TAB -->
  <div class="tab-pane fade in mt-2" id="mouse">
    <div class="row">
      <?php
      if ($id_compagnie) {
          $sql = 'SELECT * FROM produit
                  WHERE id_categorie = 2 AND id_compagnie = :id_compagnie
                  GROUP BY code_produit 
                  ORDER BY code_produit ASC';
          $req = $connection->prepare($sql);
          $req->execute(['id_compagnie' => $id_compagnie]);

          if ($req->rowCount() > 0):
              while ($produit = $req->fetch(PDO::FETCH_ASSOC)):
      ?>
      <div class="col-sm-4 col-md-2">
        <form method="post" action="pos.php?action=add&id=<?php echo $produit['id']; ?>">
          <div class="products">
            <h6 class="text-info"><?php echo $produit['nom_produit']; ?></h6>
            <h6>F CFA <?php echo $produit['prix_unitaire']; ?></h6>
            <input type="text" name="quantite" class="form-control" value="1" />
            <input type="hidden" name="nom_produit" value="<?php echo $produit['nom_produit']; ?>" />
            <input type="hidden" name="prix_unitaire" value="<?php echo $produit['prix_unitaire']; ?>" />
            <input type="submit" name="addpos" style="margin-top:5px;" class="btn btn-info" value="Ajoutez" />
          </div>
        </form>
      </div>
      <?php
              endwhile;
          else:
              echo "<p class='text-warning'>Aucun produit trouvé pour cette catégorie.</p>";
          endif;
      }
      ?>
    </div>
  </div>

  <!-- 3RD TAB -->
  <div class="tab-pane fade in mt-2" id="headset">
    <div class="row">
      <?php
      if ($id_compagnie) {
          $sql = 'SELECT * FROM produit
                  WHERE id_categorie = 3 AND id_compagnie = :id_compagnie
                  GROUP BY code_produit 
                  ORDER BY code_produit ASC';
          $req = $connection->prepare($sql);
          $req->execute(['id_compagnie' => $id_compagnie]);

          if ($req->rowCount() > 0):
              while ($produit = $req->fetch(PDO::FETCH_ASSOC)):
      ?>
      <div class="col-sm-4 col-md-2">
        <form method="post" action="pos.php?action=add&id=<?php echo $produit['id']; ?>">
          <div class="products">
            <h6 class="text-info"><?php echo $produit['nom_produit']; ?></h6>
            <h6>F CFA <?php echo $produit['prix_unitaire']; ?></h6>
            <input type="text" name="quantite" class="form-control" value="1" />
            <input type="hidden" name="nom_produit" value="<?php echo $produit['nom_produit']; ?>" />
            <input type="hidden" name="prix_unitaire" value="<?php echo $produit['prix_unitaire']; ?>" />
            <input type="submit" name="addpos" style="margin-top:5px;" class="btn btn-info" value="Ajoutez" />
          </div>
        </form>
      </div>
      <?php
              endwhile;
          else:
              echo "<p class='text-warning'>Aucun produit trouvé pour cette catégorie.</p>";
          endif;
      }
      ?>
    </div>
  </div>

  <!-- 4TH TAB -->
  <div class="tab-pane fade in mt-2" id="others">
    <div class="row">
      <?php
      if ($id_compagnie) {
          $sql = 'SELECT * FROM produit
                  WHERE id_categorie = 4 AND id_compagnie = :id_compagnie
                  GROUP BY code_produit 
                  ORDER BY code_produit ASC';
          $req = $connection->prepare($sql);
          $req->execute(['id_compagnie' => $id_compagnie]);

          if ($req->rowCount() > 0):
              while ($produit = $req->fetch(PDO::FETCH_ASSOC)):
      ?>
      <div class="col-sm-4 col-md-2">
        <form method="post" action="pos.php?action=add&id=<?php echo $produit['id']; ?>">
          <div class="products">
            <h6 class="text-info"><?php echo $produit['nom_produit']; ?></h6>
            <h6>F CFA <?php echo $produit['prix_unitaire']; ?></h6>
            <input type="text" name="quantite" class="form-control" value="1" />
            <input type="hidden" name="nom_produit" value="<?php echo $produit['nom_produit']; ?>" />
            <input type="hidden" name="prix_unitaire" value="<?php echo $produit['prix_unitaire']; ?>" />
            <input type="submit" name="addpos" style="margin-top:5px;" class="btn btn-info" value="Ajoutez" />
          </div>
        </form>
      </div>
      <?php
              endwhile;
          else:
              echo "<p class='text-warning'>Aucun produit trouvé pour cette catégorie.</p>";
          endif;
      }
      ?>
    </div>
  </div>
</div>
