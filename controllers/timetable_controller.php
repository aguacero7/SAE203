<?php
session_start();

/*
Récupérer les fonctions communes à toutes les pages
*/
require_once ("../models/functions.php");

checkConnection();
checkPermissions($_SESSION["user"]);

$title = "Emploi du temps";
$script = "../js/timetable.js";



if (isset($_REQUEST["username"])) {
    $target = new User($_REQUEST["username"]);
} else {
    $target = new User(json_decode($_SESSION["user"], true)["username"]);
}
if (isset($_REQUEST["scale"]) && $_REQUEST["scale"] < 3 && $_REQUEST["scale"] >= 0) {
    $scale = $_REQUEST["scale"];
} else {
    $scale = 1;
}




/*
 Les pages contenant la logique et l'affichage des emploisdu temps
*/
require_once ("../models/Timetable.php");
require_once ("../templates/vue_timetable.php");
if (isset($_REQUEST["date"])) {
    $timetable = new Timetable($_REQUEST["date"], $scale, $target);
}else{
    $timetable = new Timetable(date("Y-m-d"), $scale, $target);
}

$content = $timetable->html_content;


/*
 La page qui contient le layout c'est à dire la navbar et la sidebar
*/
require_once ("../templates/layout.php");


