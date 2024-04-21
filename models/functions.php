<?php
function checkConnection()
{
    if (!isset($_SESSION["auth"])) {
        header("Location: login.php");
        exit();
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
            sleep($delaiMinimum - $tempsEcoule);
            exit();
        }
    }

}