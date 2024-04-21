<?php
session_start();

$post = json_decode(file_get_contents('php://input'), true);

require_once('../controllers/User.php');
require_once("../models/functions.php"); //recup la fonction checkOverload
checkOverload(); //Empecher trop de requêtes


if (isset($post["loginId"]) && isset($post["loginPass"])) { // Connexion
    $usersList = json_decode(file_get_contents("../assets/utilisateurs.json"), true);
    foreach ($usersList as $user) {

        if ($user["username"] === $post["loginId"]) {
            if (password_verify($post["loginPass"], $user["password"])) { // Vérification du mot de passe hashé
                $_SESSION["auth"] = true;
                $connectedUser=new User($user["username"]);
                $_SESSION["user"] = json_encode($connectedUser);
                echo json_encode(["success" => true]);
                exit; // Arrête l'exécution après avoir envoyé la réponse
            } else {
                $_SESSION['derniere_requete'][$_SERVER['REMOTE_ADDR']] = time();
                echo json_encode(["error" => "Mot de passe incorrect"]);
                exit;
            }
        }
    }
    $_SESSION['derniere_requete'][$_SERVER['REMOTE_ADDR']] = time();
    echo json_encode(["error" => "Identifiant ou mot de passe incorrect"]);
    exit;
}

echo json_encode(["error" => "Requête invalide"]); // Si aucun cas n'est traité
