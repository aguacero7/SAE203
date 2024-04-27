<?php
session_start();

require_once("functions.php");

checkConnection();
checkPermissions($_SESSION["user"]);

$title = "Annuaire";

require_once("../templates/vue_chart.php");
require_once("../templates/layout.php");