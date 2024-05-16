<?php
session_start();

/*
Récupérer les fonctions communes à toutes les pages
*/
require_once("../models/functions.php");

checkConnection();
checkPermissions($_SESSION["user"]);

$title = "Emploi du temps";
$script="../js/timetable.js";
if(isset($_GET["username"])){
    $target =new User($_GET["username"]);
}
else{
    $target = new User(json_decode($_SESSION["user"],true)["username"]);
}


/*
 Les pages contenant la logique et l'affichage des emploisdu temps
*/
require_once("../models/Timetable.php");
require_once("../templates/vue_timetable.php");
$timetable= new Timetable("2024-05-13",2,$target);
$content=$timetable->html_content;
/*
 La page qui contient le layout c'est à dire la navbar et la sidebar
*/
require_once("../templates/layout.php");


