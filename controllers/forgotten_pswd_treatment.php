<?php
session_start();

$post = json_decode(file_get_contents('php://input'), true);

require_once('../controllers/User.php');
require_once("../models/functions.php"); //recup la fonction checkID
checkID(); //Empêche trop de requêtes