<?php 
require_once("../models/classes/Error.php");
new DebugError($texte="test");
$erreur2= new ErrorPage(200,"mama");