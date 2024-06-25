<?php


$usersData = file_get_contents('../assets/utilisateurs.json');
$users = json_decode($usersData, true);

