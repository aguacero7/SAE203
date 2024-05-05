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

function checkID(){
    $GLOBALS['last_page'] = null;
    $GLOBALS['bad_id'] = null;
    $GLOBALS['error_pswd'] = null;
    $GLOBALS['pswd_changed'] = null;

    $usersList = json_decode(file_get_contents("../assets/utilisateurs.json"), true);

    //if (is_array($usersList) || is_object($usersList)){ // cette ligne permet de ne pas afficher d'erreur
        foreach ($usersList as $key => $value){
            if(isset($_POST["submit"])){
                if($value["username"] == $_POST["loginId2"] and $value["question"] == $_POST["question"] and $value["answer"] == $_POST["answer"]){
                    $GLOBALS['last_page'] = "ok";
                    $GLOBALS['bad_id'] = null;
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
        foreach ($usersList as $key => $value){
            if (isset($_SESSION["user"])){
                if ($_SESSION["user"] == $usersList[$key]['username'] && isset($_POST["save"])){
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
    //}
    $data = json_encode($usersList, JSON_PRETTY_PRINT);
    file_put_contents("../assets/utilisateurs.json", $data);
}