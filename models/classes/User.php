<?php
class User
{

    public $username;
    public $pfp;
    public $email;
    public $fullname;
    public $groupes = [];
    public $forbiddenPages=[];

    public $age;
    public $naissance;
    private static $groupForbiddenPages = [
        "admin" => ["salaries.php"],
        "salarie" => ["administration.php", "imports.php", "compta.php"],
        "manager" => ["administration.php"],
        "direction" => ["administration.php"],
        "comptable" => ["administration.php"]
    ];

    public static function calculateAge($birthday) {
        $birthdate = new DateTime($birthday);
        $today = new DateTime('today');
        $age = $birthdate->diff($today)->y;
        return $age;
    }
    static public function load_all()
    {
        $list = [];
        $users = json_decode(file_get_contents("../assets/utilisateurs.json"), true);
        foreach ($users as $user) {
            array_push($list, new User($user['username']));
        }
        return $list;
    }
    static public function tmp_load_all()
    {
        $list = [];
        $users = json_decode(file_get_contents("../assets/tempusers.json"), true);
        foreach ($users as $user) {
            array_push($list, new User($user['username']));
        }
        return $list;
    }
    static public function tmp_load_by_grp($grp)
    {
        $list = [];
        $users = json_decode(file_get_contents("../assets/tempusers.json"), true);
        foreach ($users as $user) {
            if(in_array($grp,$user["groupes"]))
                array_push($list, new User($user['username']));
        }
        return $list;
    }
    static public function load_all_grp()
    {
        $list = [];
        $users = json_decode(file_get_contents("../assets/utilisateurs.json"), true);
        foreach ($users as $user) {
            foreach ($user["groupes"] as $grp) {
                if (!in_array($grp, $list)) {
                    array_push($list, $grp);
                }
            }
        }
        return $list;
    }
    static public function tmp_load_all_grp()
    {
        $list = [];
        $users = json_decode(file_get_contents("../assets/tempusers.json"), true);
        foreach ($users as $user) {
            foreach ($user["groupes"] as $grp) {
                if (!in_array($grp, $list)) {
                    array_push($list, $grp);
                }
            }
        }
        return $list;
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
                $this->naissance=$user["birthday"];
                $this->age =User::calculateAge($this->naissance);
            }
        }
        // Gestion des permissions
        if (count($this->groupes) >= 2) {
            $forbidden = [];
            foreach ($this->groupes as $groupe) {
                // Vérifier si la clé existe dans $groupForbiddenPages avant de l'utiliser
                if (array_key_exists($groupe, User::$groupForbiddenPages)) {
                    // Ajouter les pages interdites en fonction du groupe
                    $forbidden = array_merge($forbidden, User::$groupForbiddenPages[$groupe]);
                }
            }
            $this->forbiddenPages = array_count_values($forbidden);
            foreach($this->forbiddenPages as $key =>$page){
                if($page!=count($this->groupes))
                    unset($this->forbiddenPages[$key]);
            }
            $this->forbiddenPages=array_keys($this->forbiddenPages);
        } else {
            $this->forbiddenPages = User::$groupForbiddenPages[$this->groupes[0]];
        }
    }
}