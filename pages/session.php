<?php
    // Avant de stocker les informations de notre membre, nous devons d'abord démarrer la session
    
    // session_start();
    
    // Créer une nouvelle fonction pour vérifier si la variable de session MEMBER_ID est définie
    function logged_in() {
        return isset($_SESSION['MEMBER_ID']);
    }
    
    // Cette fonction vérifie si la session MEMBER_ID n'est pas définie, alors l'utilisateur est redirigé vers index.php
    function confirm_logged_in() {
        if (!logged_in()) {
?>
            <script type="text/javascript"> 
                window.location = "login.php";
            </script>
<?php
        }
    }
?>
