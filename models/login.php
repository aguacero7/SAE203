<?php 
//session_start();

require_once("functions.php");

checkLOGIN();
checkID();
new_pswd();

$title="Connexion";

if(isset($_SESSION["auth"])){
    header("Location: index.php");
    exit();
}


//var_dump($GLOBALS);
//conditions qui permettent d'afficher les pages selon l'action faites par l'user' :

if (isset($_GET["forgotten_pswd"]) && $_GET['forgotten_pswd'] = 'ok'){
    echo '1';
    unset($_GET["forgotten_pswd"]);
    $_GET['forgotten_pswd'] = '';
    require_once('../templates/vue_login_forgotten_pswd.php'); //stocke affichage la page login du mdp oublié
}
elseif (isset($GLOBALS['Connexion'])){
    echo '2';
    echo $GLOBALS['Connexion'];
    require_once('../vitrine/vitrine.php'); //stocke affichage de la page vitrine
}
elseif (isset($GLOBALS['error_connexion'])){
    echo '3';
    echo $GLOBALS['error_connexion'];
    require_once('../templates/vue_login.php'); //stocke affichage de la page connexion
}
elseif (isset($GLOBALS['bad_id'])){//affiche message erreur si utilisateur tapé mauvais ID
    echo '4';
    echo $GLOBALS['bad_id'];
    require_once('../templates/vue_login_forgotten_pswd.php'); //stocke affichage de la page login du mdp oublié
}
elseif (isset($GLOBALS['last_page'])){
    echo '5';
    require_once('../templates/vue_login_forgotten_pswd2.php');
}
elseif (isset($GLOBALS['error_pswd'])){//affiche message erreur si les mdp ne correspondent pas
    echo '6';
    echo $GLOBALS['error_pswd'];
    require_once('../templates/vue_login_forgotten_pswd2.php');
}
elseif (isset($GLOBALS['pswd_changed'])){
    echo '7';
    echo $GLOBALS['pswd_changed'];
    require_once('../templates/vue_login.php'); //stocke affichage de la page connexion
}
elseif (isset($_GET["retour"]) && $_GET['retour'] = 'retour'){
    echo '8';
    unset($_GET["retour"]);
    $_GET['retour'] = '';
    require_once('../templates/vue_login.php'); 
}
else{
    echo '9';
    require_once('../templates/vue_login.php');
}

require_once('../templates/login_layout.php'); // present sur toutes les pages
