<?php
class TimetableView
{
    public static function renderPage($timetable, $user)
    {
        ob_start(); // Début de la mise en tampon de la sortie
        ?>
        <div class="row d-flex">
            <h1>Emploi de temps de <?= $user->fullname ?></h1>

            <div class="form-group ml-auto">
                <label for="scale">Choisir l'échelle :</label>
                <select id="scale" class="form-control">
                    <option value=0>Jour</option>
                    <option value=1>Semaine</option>
                    <option value=2>Mois</option>
                </select>
            </div>
        </div>
        <div class="table-responsive">
            <?= self::renderBootstrapTable($timetable) ?>
        </div>

        <hr>

        <h2>Créer une activité</h2>
        <form action="create_activity.php" method="post">
            <!-- Champs du formulaire pour créer une activité -->
            <div class="form-group">
                <label for="activity_title">Titre :</label>
                <input type="text" id="activity_title" name="activity_title" class="form-control">
            </div>
            <!-- Autres champs du formulaire -->
            <button type="submit" class="btn btn-primary">Créer</button>
        </form>
        <?php
        $content = ob_get_clean(); // Récupération et nettoyage de la sortie en tampon

        return $content;
    }

    public static function renderBootstrapTable($timetable)
    {
        ob_start(); // Début de la mise en tampon de la sortie


        switch ($timetable->scale) {
            case 0:
                self::generateDayTable($timetable);
                break;
            case 1:
                self::generateWeekTable($timetable);
                break;
            case 2:
                self::generateMonthTable($timetable);
                break;
            default:
                echo '<p>Période non valide</p>';
                break;
        }



        $content = ob_get_clean(); // Récupération et nettoyage de la sortie en tampon

        return $content;
    }

    private static function generateDayTable(Timetable $timetable)
    {
        // Générer le contenu HTML pour afficher un jour
        ob_start(); // Début de la mise en tampon de la sortie
        ?>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th style="width: 20%;">Heure</th>
                    <th style="width: 80%;">Activités <?= array_key_first($timetable->days) ?></th>

                </tr>
            </thead>
            <tbody>
                <?php
                // Parcours de chaque heure de la journée
                for ($hour = 0; $hour < 24; $hour++) {
                    ?>
                    <tr>
                        <td><?= str_pad($hour, 2, "0", STR_PAD_LEFT) . ":00" ?></td>
                        <?
                        $day=$timetable->days[array_key_first($timetable->days)]
                            ?>
                            <td>
                                <?php foreach ($day->activites_par_heure[$hour] ?? [] as $activity): ?>
                                    <div><?= $activity->title ?></div>
                                <?php endforeach; ?>
                            </td>
                        </tr>
                        <?php
                        
                }
                ?>
            </tbody>
        </table>
        <?php
        $content = ob_get_clean(); // Récupération et nettoyage de la sortie en tampon

        echo $content;
    }

    private static function generateWeekTable(Timetable $timetable)
    {
        ob_start(); // Début de la mise en tampon de la sortie
        ?>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Heure</th>
                    <?php
                    foreach ($timetable->days as $date => $day) {
                        echo "<th>$date</th>";
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($hour = 0; $hour < 24; $hour++) {
                    ?>
                    <tr>
                        <td><?= str_pad($hour, 2, "0", STR_PAD_LEFT) . ":00" ?></td>
                        <?php
                        foreach ($timetable->days as $day) {
                            ?>
                            <td>
                                <?php foreach ($day->activites_par_heure[$hour] ?? [] as $activity): ?>
                                    <div><?= $activity->title ?></div>
                                <?php endforeach; ?>
                            </td>
                            <?php
                        }
                        ?>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <?php
        $content = ob_get_clean(); // Récupération et nettoyage de la sortie en tampon

        echo $content;
    }

    private static function generateMonthTable(Timetable $timetable)
{
    ob_start(); // Début de la mise en tampon de la sortie
    ?>
    <div class="container">
        <h2 class="mb-4"><?= date('F Y', strtotime(key($timetable->days))) ?></h2>
        <div class="row">
            <?php
            foreach ($timetable->days as $date => $day) {
                ?>
                <div class="col border">
                    <h5 class="mb-3"><?= date('l', strtotime($date)) ?></h5>
                    <div class="activities">
                        <?php foreach ($day->activites_par_heure as $activities) : ?>
                            <?php foreach ($activities as $activity) : ?>
                                <span class="badge badge-primary mb-2"><?= $activity->title ?></span>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
    $content = ob_get_clean(); // Récupération et nettoyage de la sortie en tampon

    echo $content;
}


}

