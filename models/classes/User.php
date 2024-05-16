<?php
class User
{

    public $username;
    public $pfp;
    public $email;
    public $fullname;
    public $groupes = [];
    public $forbiddenPages;
    private $groupForbiddenPages = [
        "admin" => ["salaries.php"],
        "salarie" => ["administration.php", "imports.php", "compta.php", 'salaries.php'],
        "manager" => ["administration.php"],
        "direction" => ["administration.php"]
    ];
    static function supOne($val)
    {
        return ($val >= 1 ? true : false);
    }

    public function __construct($username)
    {
        $this->username = $username;
        //gestion des infos du profils
        $users = json_decode(file_get_contents("../assets/utilisateurs.json"), true);
        foreach ($users as $user) {
            if ($user["username"] == $username) {
                $this->pfp = $user["pfp"];
                $this->fullname = $user["fullname"];
                $this->groupes = $user["groupes"];
                $this->email = $user["email"];
            }
        }
        // Gestion des permissions
        if (count($this->groupes) >= 2) {
            $forbidden = [];
            foreach ($this->groupes as $groupe) {
                // Vérifier si la clé existe dans $groupForbiddenPages avant de l'utiliser
                if (array_key_exists($groupe, $this->groupForbiddenPages)) {
                    // Ajouter les pages interdites en fonction du groupe
                    $forbidden = array_merge($forbidden, $this->groupForbiddenPages[$groupe]);
                }
            }
            $this->forbiddenPages = array_unique(array_filter($forbidden, "User::supOne"));
            $this->forbiddenPages = $this->forbiddenPages[0];
            
        } else {
            $this->forbiddenPages = $this->groupForbiddenPages[$this->groupes[0]];
        }
    }
}