<?php 
require('session.php');

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" type="text/css" href="style.css">

    <link rel="icon" href="https://www.freeiconspng.com/uploads/sales-icon-7.png">

	<title>eFuelPrepaid</title>
</head>
<body>
	<div class="container">
		<form action="" method="POST" class="login-email">
            <p class="login-text" style="font-size: 2rem; font-weight: 800;">Inscription</p>
			<div class="input-group">
				<input type="text" placeholder="Email" name="email" value="" required>
			</div>
	
			<div class="input-group">
				<input type="password" placeholder="Mot de passe" name="mot_de_passe" value="" required>
            </div>
            <div class="input-group">
				<input type="password" placeholder="Confirmer le mot de passe" name="mot_de_passe" value="" required>
			</div>
			<div class="input-group">
				<button name="submit" class="btn">S'inscrire</button>
			</div>
			<p class="login-register-text">Vous avez déjà un compte? <a href="login.php">Clicquez ici !</a></p>
		</form>
	</div>
</body>
</html>
