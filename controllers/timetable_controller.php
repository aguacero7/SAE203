<?php
session_start();

/*
Récupérer les fonctions communes à toutes les pages
*/
require_once ("../models/functions.php");
require_once ("../models/Timetable.php");

checkConnection();
checkPermissions($_SESSION["user"]);

$title = "Emploi du temps";
$script = "../js/timetable.js";



if (isset($_REQUEST["username"])) {
    $target = new User($_REQUEST["username"]);
} else {
    $target = new User(json_decode($_SESSION["user"], true)["username"]);
}
if (isset($_REQUEST["scale"]) && $_REQUEST["scale"] < 3 && $_REQUEST["scale"] >= 0) {
    $scale = $_REQUEST["scale"];
} else {
    $scale = 1;
}

/*
Gestion de la modification d'une activité

*/
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["edit"])) {
        $errors = [];

        // Vérification des champs requis
        if (empty($_POST["title"])) {
            $errors[] = "Le titre est requis.";
        }
        if (empty($_POST["date"])) {
            $errors[] = "La date est requise.";
        }
        if (empty($_POST["start_time"])) {
            $errors[] = "L'heure de début est requise.";
        }
        if (empty($_POST["end_time"])) {
            $errors[] = "L'heure de fin est requise.";
        }
        if (empty($_POST["color"]) || !in_array($_POST["color"], Activity::$authorized_colors)) {
            $errors[] = "La couleur est invalide.";
        }


        $startTime = strtotime($_POST["start_time"]);
        $endTime = strtotime($_POST["end_time"]);
        if ($endTime <= $startTime) {
            $errors[] = "L'heure de fin doit être après l'heure de début.";
        }
        // Vérification des utilisateurs invités
        $all_users = User::load_all();
        $selected_users = json_decode($_POST['invited'], true);
        $invalid_users = [];
        foreach ($selected_users as $selected_user) {
            $user_exists = false;
            foreach ($all_users as $user) {
                if ($user->username == $selected_user) {
                    $user_exists = true;
                    break;
                }
            }
            if (!$user_exists) {
                $invalid_users[] = $selected_user;
            }
        }

        if (!empty($invalid_users)) {
            $errors[] = "Vous avez entré des utilisateurs inexistants.";
        }

        $all_groups = User::load_all_grp();
        $selected_groups = json_decode($_POST['invited_grp'], true);

        if (!empty($errors)) {
            echo json_encode(["error" => implode(", ", $errors)]);
            exit();
        } else {
            $id = $_POST["id"];
            $title = htmlspecialchars($_POST["title"]);
            $date = $_POST["date"];
            $start_time = $_POST["start_time"];
            $end_time = $_POST["end_time"];
            $color = $_POST["color"];
            $activities = json_decode(file_get_contents("../assets/timetable/timetables.json"), true);

            foreach ($activities as &$activity) {
                if ($activity["id"] == $id) {
                    if ($activity["creator"] != json_decode($_SESSION["user"])->username && !in_array("admin", json_decode($_SESSION["user"])->groupes)) {
                        echo json_encode(["error" => "Vous n'avez pas les droits pour modifier cette activité."]);
                        exit();
                    } else {
                        $activity["title"] = $title;
                        $activity["date"] = $date;
                        $activity["start_time"] = $start_time;
                        $activity["end_time"] = $end_time;
                        $activity["color"] = $color;
                        if (isset($selected_users))
                            $activity["invited"] = $selected_users;
                        if (isset($selected_groups))
                            $activity["invited_grp"] = $selected_groups;
                    }
                }
            }

            file_put_contents("../assets/timetable/timetables.json", json_encode($activities, JSON_PRETTY_PRINT));

            echo json_encode(["success" => "Activité mise à jour avec succès."]);
            exit();
        }
    } else {
        /*
        Gestion de l'ajout d'une activité

        */
        if (isset($_POST["create"])) {
            // Vérification des champs requis
            if (empty($_POST["title"])) {
                $errors[] = "Le titre est requis.";
            }
            if (empty($_POST["date"])) {
                $errors[] = "La date est requise.";
            }
            if (empty($_POST["start_time"])) {
                $errors[] = "L'heure de début est requise.";
            }
            if (empty($_POST["end_time"])) {
                $errors[] = "L'heure de fin est requise.";
            }
            if (empty($_POST["color"]) || !in_array($_POST["color"], Activity::$authorized_colors)) {
                $errors[] = "La couleur est invalide.";
            }
            $startTime = strtotime($_POST["start_time"]);
            $endTime = strtotime($_POST["end_time"]);
            if ($endTime <= $startTime) {
                $errors[] = "L'heure de fin doit être après l'heure de début.";
            }
            // Vérification des utilisateurs invités
            $all_users = User::load_all();
            $selected_users = json_decode($_POST['invited'], true);
            $invalid_users = [];
            foreach ($selected_users as $selected_user) {
                $user_exists = false;
                foreach ($all_users as $user) {
                    if ($user->username == $selected_user) {
                        $user_exists = true;
                        break;
                    }
                }
                if (!$user_exists) {
                    $invalid_users[] = $selected_user;
                }
            }

            if (!empty($invalid_users)) {
                $errors[] = "Vous avez entré des utilisateurs inexistants.";
            }

            $all_groups = User::load_all_grp();
            $selected_groups = json_decode($_POST['invited_grp'], true);

            if (!empty($errors)) {
                echo json_encode(["error" => implode(", ", $errors)]);
                exit();
            } else {
                $title = htmlspecialchars($_POST["title"]);
                $date = $_POST["date"];
                $start_time = $_POST["start_time"];
                $end_time = $_POST["end_time"];
                $color = $_POST["color"];
                $activities = json_decode(file_get_contents("../assets/timetable/timetables.json"), true);
                $activity = [];
                $activity["id"] = array_key_last($activities) + 2;
                $activity["creator"] = json_decode($_SESSION["user"])->username;
                $activity["title"] = $title;
                $activity["date"] = $date;
                $activity["start_time"] = $start_time;
                $activity["end_time"] = $end_time;
                $activity["color"] = $color;
                $activity["invited"] = $selected_users;
                $activity["invited_grp"] = $selected_groups;
                array_push($activities, $activity);
                file_put_contents("../assets/timetable/timetables.json", json_encode($activities, JSON_PRETTY_PRINT));

                echo json_encode(["success" => "Activité Crée"]);
                exit();
            }
        }
    }
}






/*
 Les pages contenant la logique et l'affichage des emploisdu temps
*/

require_once ("../templates/vue_timetable.php");
if (isset($_REQUEST["date"])) {
    $timetable = new Timetable($_REQUEST["date"], $scale, $target);
} else {
    $timetable = new Timetable(date("Y-m-d"), $scale, $target);
}

$content = $timetable->html_content;


/*
 La page qui contient le layout c'est à dire la navbar et la sidebar
*/
require_once ("../templates/layout.php");


