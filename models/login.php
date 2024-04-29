<?php 
session_start();

require_once("functions.php");

checkID();

$title="Connexion";

if(isset($_SESSION["auth"]) && $_SESSION["auth"]==true){
    header("Location: index.php");
    exit();
}

//conditions qui permettent d'afficher les pages selon l'action faites par l'user' :

if (isset($_GET["forgotten_pswd"]) && $_GET['forgotten_pswd'] = 'ok'){
    unset($_GET["forgotten_pswd"]);
    $_GET['forgotten_pswd'] = '';
    require_once('../templates/vue_login_forgotten_pswd.php'); //stocke affichage la page login du mdp oublié
}
elseif (isset($error)){//affiche message erreur si utilisateur tapé mauvais ID
    echo $error; 
    unset($error);
    require_once('../templates/vue_login_forgotten_pswd.php'); //stocke affichage la page login du mdp oublié
}
elseif (empty($error) && empty($_GET["retour"])){//affiche message erreur si utilisateur tapé mauvais ID
    require_once('../templates/vue_login_forgotten_pswd2.php'); //stocke affichage la page login du mdp oublié
}
elseif (isset($_GET["retour"]) && $_GET['retour'] = 'retour'){
    unset($_GET["retour"]);
    $_GET['retour'] = '';
    require_once('../templates/vue_login.php'); //stocke affichage de la page connexion
}
else{
    require_once('../templates/vue_login.php'); //stocke affichage de la page connexion
}

require_once('../templates/login_layout.php'); // present sur toutes les pages
