<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Réinitialiser le mot de passe | eFuelPrepaid</title>

  <link rel="icon" href="https://www.freeiconspng.com/uploads/sales-icon-7.pn">
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Nunito:400,700" rel="stylesheet">
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
                    <h1 class="h4 text-gray-900 mb-4">Mot de passe oublié ?</h1>
                    <p class="mb-4">Entrez votre numéro de téléphone pour recevoir un lien de réinitialisation.</p>
                  </div>
                  <form class="user" action="send_reset_link.php" method="post">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" name="contact" placeholder="Numéro de téléphone" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                      Envoyer le lien
                    </button>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="login2.php">Retour à la connexion</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="register.php">Créer un compte !</a>
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
