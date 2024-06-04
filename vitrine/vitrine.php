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
else{
    echo '3';
    require_once("models/home.php");
}