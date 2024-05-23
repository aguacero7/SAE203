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

        $response = array("success" => true, "message" => "L'utilisateur a été supprimé avec succès");
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
    if($user=User::get_user($_GET["username"],true)){
        $response = array("success" => true,"user"=> $user);
        echo json_encode($response);
        exit();}
}


if (isset($_POST["action"])) {
    $action = $_POST["action"];
    $errors = []; 

    // Vérifier si l'action est "create" ou "edit"
    if ($action === "create" || $action === "edit") {

        $requiredFields = ["username", "fullname", "email", "contact", "birthday"];
        foreach ($requiredFields as $field) {
            if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
                $errors[$field] = "Le champ $field est requis.";
            }
        }

        if ($action === "create" && isset($_POST["username"])) {
            $existingUser = User::get_user($_POST["username"],true);
            if ($existingUser) {
                $errors["username"] = "L'utilisateur existe déjà.";
            }
        }

        if ($action === "edit" && isset($_POST["username"])) {
            $existingUser = User::get_user($_POST["username"],true);
            if (!$existingUser) {
                $errors["username"] = "L'utilisateur n'existe pas.";
            }
        }
        $profilePicturePath="../assets/pfp/default.png";
        // Gestion de l'image de profil
        $profilePicturePath = "default.png";
        if (isset($_FILES["profilePicture"]) && $_FILES["profilePicture"]["error"] === UPLOAD_ERR_OK) {
            $fileType = exif_imagetype($_FILES["profilePicture"]["tmp_name"]);
            if ($fileType !== false) {
                $targetDir = "../assets/pfp/";
                $profilePicturePath = $_POST["username"] . ".jpg"; // Nom du fichier
                $targetFile = $targetDir . $profilePicturePath;
                if (!move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $targetFile)) {
                    $errors["profilePicture"] = "Une erreur s'est produite lors du téléchargement du fichier.";
                }
            } else {
                $errors["profilePicture"] = "Le fichier n'est pas une image.";
            }
        }
        

        // Si des erreurs existent, retourner les erreurs
        if (!empty($errors)) {
            echo json_encode(["success" => false, "errors" => $errors]);
            exit;
        }

        // Charger les utilisateurs existants
        $users = json_decode(file_get_contents("../assets/tempusers.json"), true);

        // Préparer les données de l'utilisateur
        if(isset($_POST["password"]))
            $pass= password_hash($_POST["password"], PASSWORD_DEFAULT);
        else
            $pass=$existingUser["password"];
            $user = [
                "password" => $pass,
                "email" => $_POST["email"],
                "groupes" => $_POST["groupes"],
                "username" => $_POST["username"],
                "fullname" => $_POST["fullname"],
                "pfp" => $profilePicturePath,
                "contact" => $_POST["contact"],
                "birthday" => $_POST["birthday"]
            ];
        

        if ($action === "create") {
            // Ajouter un nouvel utilisateur
            array_push($users,$user);
        } elseif ($action === "edit") {
            // Mettre à jour l'utilisateur existant
            foreach ($users as &$existingUser) {
                if ($existingUser["username"] == $_POST["username"]) {
                    $existingUser = $user;
                    break;
                }
            }
        }

        file_put_contents("../assets/tempusers.json", json_encode($users, JSON_PRETTY_PRINT));

        echo json_encode(["success" => true]);
    } else {
        // L'action n'est ni "create" ni "edit"
        $errors["action"] = "Action non valide.";
        echo json_encode(["success" => false, "errors" => $errors]);
    }
    exit();
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
