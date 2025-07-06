<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Réinitialiser le mot de passe - eFuelPrepaid</title>
  <link rel="icon" href="https://www.freeiconspng.com/uploads/sales-icon-7.pn">
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="../css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-primary">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <div class="row shadow">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Réinitialiser votre mot de passe</h1>
                  </div>
                  <?php if (isset($_SESSION['reset_error'])): ?>
                    <div class="alert alert-danger"><?= $_SESSION['reset_error']; unset($_SESSION['reset_error']); ?></div>
                  <?php endif; ?>
                  <form class="user" action="process_reset.php" method="post">
                    <div class="form-group">
                      <input class="form-control form-control-user" placeholder="Téléphone enregistré" name="contact" type="text" required>
                    </div>
                    <div class="form-group">
                      <input class="form-control form-control-user" placeholder="Nouveau mot de passe" name="nouveau_mdp" type="password" required>
                    </div>
                    <div class="form-group">
                      <input class="form-control form-control-user" placeholder="Confirmer le mot de passe" name="confirm_mdp" type="password" required>
                    </div>
                    <button class="btn btn-primary btn-user btn-block" type="submit" name="btn_reset">Réinitialiser</button>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="index.php">Retour à la connexion</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> 
    </div>
  </div>

  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="../js/sb-admin-2.min.js"></script>
</body>
</html>
