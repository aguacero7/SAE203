<?php
function checkConnection()
{
    if (!isset($_SESSION["auth"])) {
        http_response_code(401);
        header("Location: login.php");
        exit();
    }
    else{

    }
}
function checkOverload()
{
    session_start();

    $delaiMinimum = 1; // seconde

    // Récupérer l'adresse IP de l'utilisateur
    $ip = $_SERVER['REMOTE_ADDR'];

    if (isset($_SESSION['derniere_requete'][$ip])) {
        // Calculer le temps écoulé depuis la dernière requête
        $tempsEcoule = time() - $_SESSION['derniere_requete'][$ip];

        if ($tempsEcoule < $delaiMinimum) {
            echo json_encode(["error" => "Trop de requêtes !!!!"]);
            sleep(2);
            exit();
        }
    }

}

function checkPermissions($userOBJ){     
    $user=json_decode($userOBJ);
    $pages= $user->forbiddenPages[0];
    $path=explode("/",$_SERVER["SCRIPT_NAME"]);         //chemin du fichier

    if(in_array($path[array_key_last($path)],$pages))     // si la page fait partie des interdites de l'utilisateur
    {
        http_response_code(403);
        require_once("../templates/vue_forbidden.php");
        require_once("../templates/login_layout.php");
        exit();
    }
}