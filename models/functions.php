<?php
require_once('../models/classes/Error.php'); 
require_once("../models/classes/User.php");
User::updateForbiddenGroups();


function checkConnection()
{
    if (!isset($_SESSION["auth"])) {
        //http_response_code(401);
        //header("Location: ../models/login.php");
        new RedirectedError("../models/login.php");
        exit();
    }
    else{

    }
}
function checkOverload()
{
    $delaiMinimum = 1; // seconde

    $ip = $_SERVER['REMOTE_ADDR'];

    if (isset($_SESSION['derniere_requete'][$ip])) {
        $tempsEcoule = time() - $_SESSION['derniere_requete'][$ip];

        if ($tempsEcoule < $delaiMinimum) {
            echo json_encode(["error" => "Trop de requêtes !!!!"]);
            sleep(1);

            exit();
        }
    }

}

function checkPermissions($userOBJ) {
    User::updateForbiddenGroups();
    $user = json_decode($userOBJ);

    // Convertir les forbiddenPages en tableau
    $pages = (array)$user->forbiddenPages;

    // Tableau des alias de pages
    $pagesAlias = [
        "Administration" => ["c_admin.php", "c_admin_group.php"],
        "Emploi du temps" => ["timetable_controller.php"],
        "Annuaire" => ["organization_chart.php"],
        "Commandes" => ["commandes.php"],
        "Salaires" => ["salaries.php"],
        "Stocks" => ["stocks.php"],
        "Comptabilité" => ["compta.php"]
    ];

    // Créer une liste de fichiers interdits
    $forbiddenFiles = [];
    foreach ($pages as $forbiddenPage) {
        if (array_key_exists($forbiddenPage, $pagesAlias)) {
            $forbiddenFiles = array_merge($forbiddenFiles, $pagesAlias[$forbiddenPage]);
        }
    }

    $path = explode("/", $_SERVER["SCRIPT_NAME"]); // chemin du fichier
    $currentPage = end($path); // obtenir la page actuelle


    if (in_array($currentPage, $forbiddenFiles)) { // si la page fait partie des interdites de l'utilisateur
        http_response_code(403);
        require_once("../templates/vue_forbidden.php");
        require_once("../templates/login_layout.php");
        exit();
    }
}

function checkLOGIN(){
    
    $GLOBALS['Connexion'] = null;
    $GLOBALS['error_connexion'] = null;

    $GLOBALS['last_page'] = null;
    $GLOBALS['bad_id'] = null;

    $GLOBALS['error_pswd'] = null;
    $GLOBALS['pswd_changed'] = null;
    
    $usersList = json_decode(file_get_contents("../assets/utilisateurs.json"), true);

    //if (is_array($usersList) || is_object($usersList)){ // cette ligne permet de ne pas afficher d'erreur
        foreach ($usersList as $key => $value){
            if(isset($_POST["loginButton"])){
                echo 'ok';
                if($_POST["loginID"] == $value["username"] && password_hash($_POST["loginPassword"], PASSWORD_DEFAULT) == $value["password"]){
                    $GLOBALS['Connexion'] = '<div class="alert-1"><div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <strong>Tout est bon !</strong> Vous êtes connecté en tant que '.$_SESSION["user"].'.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div></div>';
                $GLOBALS['error_connexion'] = null;
                $_SESSION["user"] = $value["username"];

                }
                else{
                    $GLOBALS['error_connexion'] = '<div class="alert-1"><div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Attention !</strong> Mauvais identifiant.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div></div>';
                $GLOBALS['Connexion'] = null;
                }
            }
        }
    //}
}

function checkID(){

    $usersList = json_decode(file_get_contents("../assets/utilisateurs.json"), true);

    //if (is_array($usersList) || is_object($usersList)){ // cette ligne permet de ne pas afficher d'erreur
        foreach ($usersList as $key => $value){
            //echo $_POST["answer"];
            //echo ' ';
            if(isset($_POST["submit"])){
                if ($value["username"] == $_POST["loginId2"]){
                
                    if($value["question"] == $_POST["question"] && $value["answer"] == $_POST["answer"]){
                        $GLOBALS['bad_id'] = null;
                        $GLOBALS['last_page'] = 'ok';

                        $_SESSION["user"] = $value["username"];
                        return;
                    }
                    else{
                        $GLOBALS['last_page'] = null;
                        $GLOBALS['bad_id'] = '<div class="alert-1"><div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Attention !</strong> Mauvais identifiant.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div></div>';
                    }
                    return;
                }
                else{
                    $GLOBALS['last_page'] = null;
                    $GLOBALS['bad_id'] = '<div class="alert-1"><div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Attention !</strong> Mauvais identifiant.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div></div>'; 
                }
            }
        }
    //}
}

function new_pswd(){
    
    $usersList = json_decode(file_get_contents("../assets/utilisateurs.json"), true);
    //if (is_array($usersList) || is_object($usersList)){ // cette ligne permet de ne pas afficher d'erreur
        
        if (isset($_SESSION["user"])){
            foreach ($usersList as $key => $value){
                if (isset($_POST["save"])){
                    if ($value["username"] == $_SESSION["user"]){
                        var_dump($value["username"]);
                        if ($_POST['pswd'] != $_POST['confirm']){
                            $GLOBALS['error_pswd'] = '<div class="alert-1"><div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Attention!</strong> Mauvais mot de passe.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div></div>';
                            $GLOBALS['pswd_changed'] = null;
                        }
                        else{
                            $GLOBALS['pswd_changed'] = '<div class="alert-1"><div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <strong>Tout est bon!</strong> Le nouveau mot de passe a bien été pris en compte.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div></div>';
                            $GLOBALS['error_pswd'] = null;
                            $usersList[$key]['password'] = password_hash($_POST["confirm"], PASSWORD_DEFAULT);
                        }
                    }
                }
            }
        }
    //}
    $data = json_encode($usersList, JSON_PRETTY_PRINT);
    file_put_contents("../assets/utilisateurs.json", $data);

}
