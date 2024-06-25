<?php
session_start();

require_once("../models/functions.php");

checkConnection();
checkPermissions($_SESSION["user"]);

$title = "Stocks";

require_once("../models/stocks.php");
require_once("../templates/vue_stocks.php");
$content = renderPage();
require_once("../templates/layout.php");