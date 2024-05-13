<?php
session_start();

require_once("functions.php");

checkConnection();
checkPermissions($_SESSION["user"]);

$title = "Annuaire";
$script="../js/users.js";
$get=$_GET;

require_once("../controllers/controller_organization_chart.php");
require_once("../templates/vue_chart.php");
require_once("../templates/layout.php");