<?php
function checkConnection(){
    if(!isset($_SESSION["auth"])){
        header("Location: login.php");
        exit();
    }
}