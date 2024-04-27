<?php 
$title="Connexion";


session_start();

if(isset($_SESSION["auth"]) && $_SESSION["auth"]==true){
    header("Location: index.php");
    exit();
}

//conditions qui permettent d'afficher les pages selon le bouton cliqué :

if (isset($_GET["forgotten_pswd"]) && $_GET['forgotten_pswd'] != ''){
    require_once('../templates/vue_login_forgotten_pswd.php'); //stocke affichage la page login du mdp oublié
}
elseif (isset($_GET["loginButton2"]) && $_GET['loginButton2'] != ''){
    require_once('../templates/vue_login_forgotten_pswd2.php'); //stocke affichage de la page réinitialisation mdp
}
else{
    require_once('../templates/vue_login.php'); //stocke affichage de la page connexion
}

require_once('../templates/login_layout.php'); // present sur toutes les pages
