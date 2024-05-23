<?php
session_start();
/*
Récupérer les fonctions communes à toutes les pages
*/

require_once ("../models/functions.php");
require_once ("../models/admin.php");



checkConnection();
checkPermissions($_SESSION["user"]);
