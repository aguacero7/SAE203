<?php

//class for every activity
class Activity
{
    public $id;
    public $creator;
    public $title;
    public $invited = [];
    public $invited_groups = [];
    public $date = [];
    public $start_time;
    public $end_time;

    //contructor
    public function __construct($activity)
    {
        $this->id = $activity['id'];
        $this->creator = $activity['creator'];
        $this->date = $activity['date'];
        $this->invited = $activity['invited'];
        $this->invited_groups = $activity['invited_grp'];
        $this->start_time = $activity['start_time'];
        $this->end_time = $activity['end_time'];
        $this->title = $activity["title"];
    }

}

//Day class, stores activities
class Day
{
    public $activites_par_heure = [];
    public $nom;
    // constructeur
    public function __construct($date)
    {
        $jours = [
            1 => 'Lundi',
            2 => 'Mardi',
            3 => 'Mercredi',
            4 => 'Jeudi',
            5 => 'Vendredi',
            6 => 'Samedi',
            7 => 'Dimanche'
        ];
        $numeroJour = date('N', strtotime($date));
        $this->nom = $jours[$numeroJour];
        for ($i = 0; $i < 24; $i++) {
            $this->activites_par_heure[$i] = [];
        }
    }

    public function ajouterActivite($heure, $activite)
    {
        $this->activites_par_heure[$heure][] = $activite;
    }
}

// Timetable main class, stores days
class Timetable
{
    public $html_content;
    public $days = [];
    private $user;
    public $scale;
    public $first_date;
    public $date;
    private function isUserInvited($activity)
    {
        if (in_array($this->user->username, $activity['invited'])) {
            return true;
        }
        foreach ($this->user->groupes as $group) {
            if (in_array($group, $activity['invited_grp'])) {
                return true;
            }
        }
        return false;
    }

    private function getUserActivities()
    {
        $usr_activ = [];
        $data = json_decode(file_get_contents("../assets/timetable/timetables.json"), true);
        foreach ($data["activities"] as $activite) {
            if ($this->isUserInvited($activite)) {
                array_push($usr_activ, new Activity($activite));
            }
        }
        return ($usr_activ);
    }
    // Constructor
    public function __construct(string $date, int $scale, User $user)
    {
        $this->user = $user;
        $activites = $this->getUserActivities();
        $this->days = [];
        $this->scale = $scale;
        $this->date=$date;
        $this->first_date = $date;
        
        if ($scale == 0) {
            // Pour 1 jour
            $this->days[$date] = new Day($date);
        } elseif ($scale == 1) { 
            // Pour 1 semaine
            $this->first_date = date("Y-m-d", strtotime('monday this week', strtotime($date)));
            for ($i = 0; $i < 7; $i++) {
                $date = date("Y-m-d", strtotime("+$i day", strtotime($this->first_date)));
                $this->days[$date] = new Day($date);
            }
        } elseif ($scale == 2) { 
            // Pour 1 mois
            $this->first_date = date("Y-m-01", strtotime($date));
            $endOfMonth = date("Y-m-t", strtotime($date));
            
            $start_date = new DateTime($this->first_date);
            $end_date = new DateTime($endOfMonth);
    
            $interval = new DateInterval('P1D');
            $period = new DatePeriod($start_date, $interval, $end_date);
            foreach ($period as $date) {
                $this->days[$date->format('Y-m-d')] = new Day($date);
            }
        }
    
        foreach ($activites as $activity) {
            if (isset($this->days[$activity->date])) {
                $heure_debut = (int) substr($activity->start_time, 0, 2);
                $heure_fin = (int) substr($activity->end_time, 0, 2);
                for ($i = $heure_debut; $i < $heure_fin; $i++) {
                    $this->days[$activity->date]->ajouterActivite($i, $activity);
                }
            }
        }
        $this->html_content = TimetableView::renderPage($this, $this->user);
    }
    
}

//end Code