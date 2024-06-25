<?php

session_start();
require_once ("../models/functions.php");

checkConnection();
checkPermissions($_SESSION["user"]);

require_once ("../models/Timetable.php");
if (isset($_GET["id"])) {
    $activityId = $_GET["id"];
    $activity = Activity::get_activity_by_id($activityId);
    if ($activity != null) {
        if($activity->creator ==json_decode($_SESSION["user"])->username || in_array("admin",json_decode($_SESSION["user"])->groupes))
            echo json_encode($activity);
        else
            echo json_encode(["error" => "Vous n'êtes pas autorisé à modifier cette activité"]);
    } else {
        echo json_encode(["error" => "Activité inexistante"]);
    }
}
