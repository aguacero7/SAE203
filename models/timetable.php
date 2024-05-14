<?php
session_start();

require_once("functions.php");

checkConnection();
checkPermissions($_SESSION["user"]);

$title = "Accueil";
$target =$_POST["username"];
$timetable = getTimetable($target);
require_once("../templates/vue_timetable.php");
require_once("../templates/layout.php");