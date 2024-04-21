<?php 
$title="Connexion";


session_start();

if(isset($_SESSION["auth"])){
    header("Location: index.php");
    exit();
}

require_once("functions.php");

require_once('../templates/vue_login.php'); //stocke affichage la page connexion

require_once('../templates/login_layout.php'); // present sur toutes les pages