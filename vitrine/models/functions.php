<?php

// fct verification mdp et id :
function verif($mdp , $id) {
    // Lecture dans le json :
        $path = 'assets/utilisateurs.json';
        $jsonString = file_get_contents($path);
        $jsonData = json_decode($jsonString, true);
    
        foreach ($jsonData as $tableaux){
            $mdp = $tableaux['password'];
            $id = $tableaux['username'];
            if (isset($_POST["idf"]) and password_verify($_POST['pswd'], $mdp) == $mdp and $_POST['idf'] == $id){ 
                return true;
            }
        }
        return false;
    }

?>