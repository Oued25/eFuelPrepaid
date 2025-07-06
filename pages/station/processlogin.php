<?php
require('../includes/connection.php');
require('session.php');

if (isset($_POST['btnlogin'])) {
    $users = trim($_POST['user']);
    $upass = trim($_POST['password']);
    $h_upass = sha1($upass);

    if ($upass == '') {
        ?>
        <script type="text/javascript">
            alert("Password is missing!");
            window.location = "login.php";
        </script>
        <?php
    } else {
        // Préparer la requête SQL avec des paramètres
        $sql = "SELECT ID, e.FIRST_NAME, e.LAST_NAME, e.GENDER, e.EMAIL, e.PHONE_NUMBER, j.JOB_TITLE, l.PROVINCE, l.CITY, t.TYPE
        FROM `users` u
        JOIN `employee` e ON e.EMPLOYEE_ID = u.EMPLOYEE_ID
        JOIN `location` l ON e.LOCATION_ID = l.LOCATION_ID
        JOIN `job` j ON e.JOB_ID = j.JOB_ID
        JOIN `type` t ON t.TYPE_ID = u.TYPE_ID
        WHERE `USERNAME` = :username AND `PASSWORD` = :password";

        // Préparation de la requête
        $stmt = $connexion->prepare($sql);

        // Liaison des paramètres
        $stmt->bindParam(':username', $users);
        $stmt->bindParam(':password', $h_upass);

        // Exécution de la requête
        $stmt->execute();

        // Récupération des résultats
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            // Si un utilisateur est trouvé
            $_SESSION['MEMBER_ID'] = $result['ID'];
            $_SESSION['FIRST_NAME'] = $result['FIRST_NAME'];
            $_SESSION['LAST_NAME'] = $result['LAST_NAME'];
            $_SESSION['GENDER'] = $result['GENDER'];
            $_SESSION['EMAIL'] = $result['EMAIL'];
            $_SESSION['PHONE_NUMBER'] = $result['PHONE_NUMBER'];
            $_SESSION['JOB_TITLE'] = $result['JOB_TITLE'];
            $_SESSION['PROVINCE'] = $result['PROVINCE'];
            $_SESSION['CITY'] = $result['CITY'];
            $_SESSION['TYPE'] = $result['TYPE'];
            $AAA = $_SESSION['MEMBER_ID'];

            // Redirection en fonction du type d'utilisateur
            if ($_SESSION['TYPE'] == 'Admin') {
                ?>
                <script type="text/javascript">
                    alert("<?php echo $_SESSION['FIRST_NAME']; ?> Welcome!");
                    window.location = "index.php";
                </script>
                <?php
            } elseif ($_SESSION['TYPE'] == 'User') {
                ?>
                <script type="text/javascript">
                    alert("<?php echo $_SESSION['FIRST_NAME']; ?> Welcome!");
                    window.location = "pos.php";
                </script>
                <?php
            }
        } else {
            // Si aucun utilisateur n'est trouvé
            ?>
            <script type="text/javascript">
                alert("Username or Password Not Registered! Contact Your administrator.");
                window.location = "index.php";
            </script>
            <?php
        }
    }
}

// Fermeture de la connexion PDO
$connexion = null;
?>
