<?php
// Contrôleur administration.php

session_start();
/*
Récupérer les fonctions communes à toutes les pages
*/

require_once ("../models/functions.php");
require_once ("../models/admin.php");



checkConnection();
checkPermissions($_SESSION["user"]);

$title = "Interface Administrateur";
$script = "../js/admin.js";
require_once ("../templates/vue_admin.php");

//modification d'un groupe
if (isset($_POST["update"])) {
    try {
        $data = json_decode(file_get_contents("../assets/tempusers.json"), true);
        $group = $_POST["group"];
        $username = $_POST["username"];
        $update = $_POST["update"];
        $userFound = false;

        foreach ($data as $key => $user) {
            if ($user["username"] == $username) {
                $userFound = true;

                if ($update == "1") {
                    // Ajouter le groupe
                    if (!in_array($group, $data[$key]["groupes"])) {
                        array_push($data[$key]["groupes"], $group);
                        $response = array("success" => true, "message" => "Le groupe a été ajouté avec succès.");
                    } else {
                        $response = array("success" => false, "error" => "Le groupe est déjà attribué.");
                    }
                } elseif ($update == "0") {
                    // Supprimer le groupe
                    if (in_array($group, $data[$key]["groupes"])) {
                        $data[$key]["groupes"] = array_diff($data[$key]["groupes"], array($group));
                        $response = array("success" => true, "message" => "Le groupe a été supprimé avec succès.");
                    } else {
                        $response = array("success" => false, "error" => "Le groupe n'est pas attribué à cet utilisateur.");
                    }
                } else {
                    $response = array("success" => false, "error" => "Valeur d'update non valide.");
                }

                break;
            }
        }

        if (!$userFound) {
            $response = array("success" => false, "error" => "Utilisateur non trouvé.");
        }

        // Sauvegarder les modifications dans le fichier temporaire
        $path = "../assets/tempusers.json";
        file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT));
    } catch (Exception $e) {
        $response = array("success" => false, "error" => $e->getMessage());
    }

    echo json_encode($response);
    exit();
}


if (isset($_POST["save"])) {
    try {

        $data = json_decode(file_get_contents("../assets/tempusers.json"), true);
        $path = "../assets/utilisateurs.json";
        file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT));

        $response = array("success" => true, "message" => "La sauvegarde a été effectuée avec succès !");
        echo json_encode($response);
        exit();

    } catch (Exception $e) {
        $response = array("success" => false, "error" => $e->getMessage());
        echo json_encode($response);
        exit();
    }
}
if (isset($_POST["rollback"])) {
    try {

        $data = json_decode(file_get_contents("../assets/utilisateurs.json"), true);
        $path = "../assets/tempusers.json";
        file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT));

        $response = array("success" => true, "message" => "Le rollback a été effectué avec succès !");
        echo json_encode($response);
        exit();

    } catch (Exception $e) {
        $response = array("success" => false, "error" => $e->getMessage());
        echo json_encode($response);
        exit();
    }
}
if (isset($_POST["delete"])) {
    try {

        $data = json_decode(file_get_contents("../assets/tempusers.json"), true);
        foreach ($data as $key => $user) {
            if ($user["username"] == $_POST["delete"]) {
                unset($data[$key]);
            }
        }
        file_put_contents("../assets/tempusers.json", json_encode($data, JSON_PRETTY_PRINT));

        $response = array("success" => true, "message" => "Le rollback a été effectué avec succès !");
        echo json_encode($response);
        exit();

    } catch (Exception $e) {
        $response = array("success" => false, "error" => $e->getMessage());
        echo json_encode($response);
        exit();
    }
}
if(isset($_GET["number"])){
    if(User::checkNumber($_GET["number"]))
        $response = array("success" => true);
        echo json_encode($response);
        exit();
}
if(isset($_GET["username"])){
    if($user=User::get_user($_GET["username"])){
        $response = array("success" => true,"user"=> $user);
        echo json_encode($response);
        exit();}
}
if(isset($_POST["action"])){
    
}



// Vérifier l'action à exécuter
if (isset($_GET["action"])) {
    $action = $_GET["action"];
    switch ($action) {
        case "users":
            require_once ("../templates/admin_pages/users.php");
            if (isset($_GET["group"]))
                $vue = new VueAdminUsers($_GET["group"]);
            else
                $vue = new VueAdminUsers("all");
            $content = $vue->tabs_html;
            break;
        case "logs":
            require_once ("../templates/admin_pages/logs.php");
            break;
        case "groups":
            require_once ("../templates/admin_pages/groups.php");
            break;
        case "files":
            require_once ("../templates/admin_pages/files.php");
            break;
        default:
            $content = "Action non reconnue.";
            //new Error
            break;
    }
} else {
    // Action par défaut si aucune action n'est spécifiée
    require_once ("../templates/admin_pages/users.php");
    $vue = new VueAdminUsers("all");
    $content = $vue->tabs_html;
}


/*
 La page qui contient le layout c'est à dire la navbar et la sidebar
*/
require_once ("../templates/layout.php");
