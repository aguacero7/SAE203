<?php
session_start();

require_once("../models/functions.php");

checkConnection();
checkPermissions($_SESSION["user"]);


require_once("../models/commandes.php");

$content="";
require_once("../templates/layout.php");
new ErrorPage(501,"Cette fonctionnalité n'est pas encore implémentée");
