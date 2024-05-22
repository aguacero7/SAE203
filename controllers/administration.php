<?php
// Contrôleur administration.php

session_start();
/*
Récupérer les fonctions communes à toutes les pages
*/

require_once ("../models/functions.php");
require_once ("../models/admin.php");
require_once ("../templates/vue_admin.php");

checkConnection();
checkPermissions($_SESSION["user"]);

$title = "Interface Administrateur";
$script = "../js/admin.js";

// Vérifier l'action à exécuter
if(isset($_GET["action"])) {
    $action = $_GET["action"];
    switch($action) {
        case "users":
            $content = VueAdmin::renderPage("users");
            break;
        case "logs":
            $content = VueAdmin::renderPage("logs");
            break;
        case "groups":
            $content = VueAdmin::renderPage("groups");
            break;
        case "files":
            $content = VueAdmin::renderPage("files");
            break;
        default:
            // Action par défaut ou action non reconnue
            $content = "Action non reconnue.";
            //new Error
            break;
    }
} else {
    // Action par défaut si aucune action n'est spécifiée
    $content = VueAdmin::renderPage("users");
}


/*
 La page qui contient le layout c'est à dire la navbar et la sidebar
*/
require_once ("../templates/layout.php");
