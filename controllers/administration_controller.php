<?php
session_start();

require_once("../models/functions.php");

checkConnection();
checkPermissions($_SESSION["user"]);


require_once("../models/administration.php");
require_once("../templates/layout.php");