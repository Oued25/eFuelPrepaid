<?php 
require('../includes/connection.php');
require('session.php'); // Assurez-vous que ce fichier contient la connexion PDO à la base de données

if (isset($_POST['submit'])) {
    $nom = htmlspecialchars(trim($_POST['nom']));
    $prenom = htmlspecialchars(trim($_POST['prenom']));
    $genre = $_POST['genre'];
    $contact = htmlspecialchars(trim($_POST['contact']));
    $mot_de_passe = $_POST['mot_de_passe'];
    $mot_de_passe_conf = $_POST['mot_de_passe_conf']; // Correction ici

    // Vérification des champs vides
    if (empty($nom) || empty($prenom) || empty($genre) || empty($contact) || empty($mot_de_passe) || empty($mot_de_passe_conf)) {
        $error = "Tous les champs sont obligatoires !";
    } elseif ($mot_de_passe !== $mot_de_passe_conf) {
        $error = "Les mots de passe ne correspondent pas !";
    } else {
        // Vérification si le numéro existe déjà
        $stmt = $connection->prepare("SELECT * FROM utilisateur WHERE contact = ?");
        $stmt->execute([$contact]);
        if ($stmt->rowCount() > 0) {
            $error = "Ce numéro de téléphone est déjà utilisé !";
        } else {
            // Hash du mot de passe
            $hashed_password = $mot_de_passe;

            // Insertion des données dans la table utilisateur
            $stmt = $connection->prepare("INSERT INTO utilisateur (nom, prenom, genre, contact, mot_de_passe, id_profil) VALUES (?, ?, ?, ?, ?, ?)");
            if ($stmt->execute([$nom, $prenom, $genre, $contact, $hashed_password, 8])) {
                $success = "Inscription réussie ! <br> Vous pouvez maintenant vous connecter.";
            } else {
                $error = "Une erreur est survenue lors de l'inscription.";
            }
        }
    }
}
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

            <?php if(isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
            <?php if(isset($success)) { echo "<p style='color:green;'>$success</p>"; } ?>

            <div class="input-group">
                <input type="text" placeholder="Nom" name="nom" value="<?= htmlspecialchars($nom ?? '') ?>" required>
            </div>

            <div class="input-group">
                <input type="text" placeholder="Prénom" name="prenom" value="<?= htmlspecialchars($prenom ?? '') ?>" required>
            </div>

            <div class="input-group">
                <select class="input-group" name='genre' required>
                    <option value="" disabled selected hidden>Choisir Genre</option>
                    <option value="Homme" <?= (isset($genre) && $genre == "Homme") ? "selected" : "" ?>>Homme</option>
                    <option value="Femme" <?= (isset($genre) && $genre == "Femme") ? "selected" : "" ?>>Femme</option>
                </select>
            </div>

            <div class="input-group">
                <input type="text" placeholder="Numéro de Téléphone" name="contact" value="<?= htmlspecialchars($contact ?? '') ?>" required>
            </div>

            <div class="input-group">
                <input type="password" placeholder="Mot de passe" name="mot_de_passe" required>
            </div>
            <div class="input-group">
                <input type="password" placeholder="Confirmer le mot de passe" name="mot_de_passe_conf" required>
            </div>

            <div class="input-group">
                <button name="submit" class="btn">S'inscrire</button>
            </div>
            <p class="login-register-text">Vous avez déjà un compte? <a href="login2.php">Cliquez ici !</a></p>
        </form>
    </div>
</body>
</html>
