<?php
class User
{

    public $username;
    public $pfp;
    public $email;
    public $fullname;
    public $groupes = [];
    public $forbiddenPages=[];
    public $contact;
    public $age;
    public $naissance;
    private static $groupForbiddenPages = [
    ];
    public static $pagesAlias = [
        "Administration" => ["c_admin.php","c_admin_group.php"],
        "Emploi du temps" => ["timetable_controller.php"],
        "Annuaire" => ["organization_chart.php"],
        "Commandes" => ["commandes.php"],
        "Salaires"=>["salaries.php"],
        "Stocks"=>["stocks.php"],
        "Comptabilité"=>["compta.php"]
    ];
    static public function get_user($username,$tmp=false)
    {
        $list = [];
        if($tmp)
            $users = json_decode(file_get_contents("../assets/tempusers.json"), true);
        else
            $users = json_decode(file_get_contents("../assets/utilisateurs.json"), true);

        foreach ($users as $user) {
            if($user["username"]==$username)
                return new User($username,true);
        }
        return null;

    }
    
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
            array_push($list, new User($user['username'],true));
        }
        return $list;
    }
    static public function tmp_load_by_grp($grp)
    {
        $list = [];
        $users = json_decode(file_get_contents("../assets/tempusers.json"), true);
        foreach ($users as $user) {
            if(in_array($grp,$user["groupes"]))
                array_push($list, new User($user['username'],true));
        }
        return $list;
    }
    static public function load_all_grp()
    {
        $list = [];
        $groups = json_decode(file_get_contents("../assets/groups.json"), true);
        foreach ($groups as $group => $details) {
            $list[] = $group;
        }
        return $list;
    }
    
    static public function tmp_load_all_grp()
    {
        $list = [];
        $groups = json_decode(file_get_contents("../assets/tempgroups.json"), true);
        foreach ($groups as $group => $details) {
            $list[] = $group;
        }
        return $list;
    }
    
    static public function checkNumber($number){
        $users = json_decode(file_get_contents("../assets/tempusers.json"), true);
        foreach ($users as $user) {
            if($user["contact"]==$number)
                return false;
        }
        return true;
    }
    static public function checkUser($user){

    }
    public static function updateForbiddenGroups() {
        $groups = json_decode(file_get_contents("../assets/groups.json"), true);
        User::$groupForbiddenPages = [];
        
        foreach ($groups as $key => $grp) {
            User::$groupForbiddenPages[$key] = $grp["categories_interdites"];
        }
    }
    
    public function __construct($username, $tmp = false) {
        $this->username = $username;
        // gestion des infos du profil
        if ($tmp) {
            $users = json_decode(file_get_contents("../assets/tempusers.json"), true);
        } else {
            $users = json_decode(file_get_contents("../assets/utilisateurs.json"), true);
        }
        foreach ($users as $user) {
            if ($user["username"] == $username) {
                $this->pfp = $user["pfp"];
                $this->fullname = $user["fullname"];
                $this->groupes = $user["groupes"];
                $this->email = $user["email"];
                $this->naissance = $user["birthday"];
                $this->contact = $user["contact"];
                $this->age = User::calculateAge($this->naissance);
            }
        }
        User::updateForbiddenGroups();
        // Gestion des permissions  
        if (count($this->groupes) >= 2) {
            $forbidden = [];
            foreach ($this->groupes as $groupe) {
                if (array_key_exists($groupe, User::$groupForbiddenPages)) {
                    // Ajouter les pages interdites en fonction du groupe
                    $forbidden = array_merge($forbidden, User::$groupForbiddenPages[$groupe]);
                }
            }
    
            // Supprimer les doublons et ne conserver que les pages interdites dans tous les groupes
            $forbidden = array_unique($forbidden);
            $this->forbiddenPages = [];
            foreach ($forbidden as $page) {
                $count = 0;
                foreach ($this->groupes as $groupe) {
                    if (in_array($page, User::$groupForbiddenPages[$groupe])) {
                        $count++;
                    }
                }
                if ($count == count($this->groupes)) {
                    $this->forbiddenPages[] = $page;
                }
            }
        } else {
            if (count($this->groupes) != 0) {
                $this->forbiddenPages = User::$groupForbiddenPages[$this->groupes[0]];
                $this->forbiddenPages = (array)$this->forbiddenPages;

            } else {
                $this->forbiddenPages = [""];
            }
        }
    }
    
}