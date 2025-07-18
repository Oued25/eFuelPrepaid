<?php 
require('session.php');

?>

<!DOCTYPE html> 
<html lang="fr">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>eFuelPrepaid</title>
  
<!-- Icône de la page au niveau du navigateur-->
  <link rel="icon" href="https://www.freeiconspng.com/uploads/sales-icon-7.pn">

  <!-- Polices personnalisées pour ce modèle-->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Styles personnalisés pour ce modèle-->
  <link href="../css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container"> 

    <!-- Ligne extérieure -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Ligne imbriquée dans le corps de la carte -->
            <div class="row shadow">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Bienvenue à vous !</h1>
                  </div>
                  <form class="user" role="form" action="processlogin.php" method="post">
                    <div class="form-group">
                        <input class="form-control form-control-user" placeholder="Email" name="email" type="text" autofocus>
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-user" placeholder="Mot de passe" name="mot_de_passe" type="password" value="">
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="customCheck">
                        <label class="custom-control-label" for="customCheck">Se souvenir de moi</label>
                      </div>
                    </div>
                    <button class="btn btn-primary btn-user btn-block" type="submit" name="btnlogin">Connexion</button>
                    <hr>
                  <div class="text-center">
                    <a class="small" href="register.php">Créer un compte !</a>
                  </div>
                </form>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- JavaScript de base Bootstrap-->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Plugin JavaScript de base-->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Scripts personnalisés pour toutes les pages-->
  <script src="../js/sb-admin-2.min.js"></script>

</body>

</html>
