<?php
session_start();

require_once("functions.php");

checkConnection();
checkPermissions($_SESSION["user"]);

$title = "Accueil";

require_once("../templates/vue_index.php");
require_once("../templates/layout.php");