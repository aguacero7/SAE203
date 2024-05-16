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

    // constructeur
    public function __construct()
    {
        // Initialisation de toutes les heures avec une activité vide
        for ($i = 0; $i < 24; $i++) {
            $this->activites_par_heure[$i] = [];
        }
    }

    // Méthode pour ajouter une activité à une heure spécifique
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
    // Method to check if user is invited to an activity
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
    public function __construct(string $firstday, int $scale, User $user)
    {
        $this->user = $user;
        $split_date = explode("-", $firstday);
        $activites = $this->getUserActivities();
        $this->days = [];
        $this->scale=$scale;
        if ($scale == 0) {
             // Pour 1 jour
            $this->days[$firstday] = new Day();

        } elseif ($scale == 1) { 
            // Pour 1 semaine

            for ($i = 0; $i < 7; $i++) {
                $date = date("Y-m-d", strtotime("+$i day", strtotime($firstday)));
                $this->days[$date] = new Day();

            }
        } elseif ($scale == 2) { 
            // Pour 1 mois

            $start_date = new DateTime($firstday);
            $end_date = (clone $start_date)->modify('last day of this month');

            $interval = new DateInterval('P1D');
            $period = new DatePeriod($start_date, $interval, $end_date);
            foreach ($period as $date) {
                $this->days[$date->format('Y-m-d')] = new Day();
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
        $this->html_content=TimetableView::renderPage($this,$this->user);

    }
    public function updateWeek(string $firstday)
    {
        // Mise à jour des jours pour une semaine
        $this->days = [];
        for ($i = 0; $i < 7; $i++) {
            $date = date("Y-m-d", strtotime("+$i day", strtotime($firstday)));
            $this->days[$date] = new Day();
        }
    }

    public function updateMonth(string $firstday)
    {
        // Mise à jour des jours pour un mois
        $start_date = new DateTime($firstday);
        $end_date = $start_date->modify('last day of this month');
        $interval = new DateInterval('P1D');
        $period = new DatePeriod($start_date, $interval, $end_date);
        foreach ($period as $date) {
            $this->days[$date->format('Y-m-d')] = new Day();
        }
    }
    public function updateDay(string $date)
    {
        // Mise à jour des jours pour une seule journée
        $this->days = [];
        $this->days[$date] = new Day();
    }

    public function updateDays(string $firstday, string $scale)
    {
        switch ($scale) {
            case 1:
                $this->updateWeek($firstday);
                break;
            case 2:
                $this->updateMonth($firstday);
                break;
            default:
                $this->updateDay($firstday);
                break;
        }
    }
}

//end Code