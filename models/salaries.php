<?php
session_start();

require_once("functions.php");

checkConnection();
checkPermissions($_SESSION["user"]);

$title = "Salaires";

//require_once("");
require_once("../templates/layout.php");