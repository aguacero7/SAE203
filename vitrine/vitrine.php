<?php
session_start();

//require_once("models/functions.php");

$title = "Vitrine";

require_once("templates/layout.php");

if (isset($_GET['menu']) && $_GET['menu']=='menu'){
    echo '1';
    require_once("models/menu.php");
}
elseif (isset($_GET['localisation']) && $_GET['localisation']=='localisation'){
    echo '2';
    require_once("models/localisation.php");
}
elseif (isset($_GET['panier']) && $_GET['panier']=='panier'){
    echo '3';
    require_once("models/panier.php");
}
elseif (isset($_GET['inscription']) && $_GET['inscription']=='inscription'){
    echo '4';
    require_once("models/inscription.php");
}
elseif (isset($_GET['profil']) && $_GET['profil']=='profil'){
    echo '5';
    require_once("models/profil.php");
}
else{
    echo '6';
    require_once("models/home.php");
}