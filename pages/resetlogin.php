<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Réinitialiser le mot de passe - eFuelPrepaid</title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-primary">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Mot de passe oublié ?</h1>
                    <p class="mb-4">Entrez votre numéro de téléphone et suivez les instructions.</p>
                  </div>
                  <form class="user" method="POST" action="resetprocess.php">
                    <div class="form-group">
                      <input type="text" name="contact" class="form-control form-control-user" placeholder="Numéro de téléphone" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">Réinitialiser le mot de passe</button>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="login2.php">Retour à la connexion</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> 
    </div>
  </div>
</body>
</html>
