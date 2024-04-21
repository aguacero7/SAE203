<?php 
require_once("functions.php");
session_start();

$title = "Accueil";

checkConnection();

require_once("../templates/vue_index.php");
require_once("../templates/layout.php");