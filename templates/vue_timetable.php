<?php
class TimetableView
{
    public static function renderPage($timetable, $user)
    {
        ob_start(); // Début de la mise en tampon de la sortie
        ?>
        <div class="container">
            <div class="alert alert-secondary text-center fs-2" role="alert">
                Emploi du temps de <?= $user->fullname ?>
            </div>
        </div>

        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <!-- Boutons "Jour" -->
                    <button type="button" onclick="updatePageWithNewDate('prev')" id="prevButton"
                        class="btn btn-outline-primary mr-2">&larr; </button>
                    <button type="button" onclick="updatePageWithNewDate('next')" id="nextButton"
                        class="btn btn-outline-primary">&rarr;</button>

                </div>
                <div class="col-md-6">
                    <!-- Select et bouton "Changer" -->
                    <form action="../controllers/timetable_controller.php" method="post" id="changeTableForm"
                        class="d-flex justify-content-end">
                        <div class="form-group">
                            <select id="scale" class="form-control" name="scale">
                                <option value=0 <?php echo ($timetable->scale == 0) ? 'selected' : ''; ?>>Jour</option>
                                <option value=1 <?php echo ($timetable->scale == 1) ? 'selected' : ''; ?>>Semaine</option>
                                <!-- TODO  <option value=2 <?php echo ($timetable->scale == 2) ? 'selected' : ''; ?>>Mois</option> !-->
                            </select>
                        </div>
                        <input type="hidden" id="username" name="username" value="<?= $user->username ?>">
                        <input type="hidden" id="date" name="date" value="<?= $timetable->date ?>">
                        <button type="submit" class="btn btn-primary">Changer</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="table-responsive mt-4">
            <?= self::renderBootstrapTable($timetable) ?>
        </div>

        <!-- Modal pour créer un nouvel évènement -->
        <div class="modal fade" id="createEventModal" tabindex="-1" role="dialog" aria-labelledby="createEventModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createEventModalLabel">Créer un nouvel évènement</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="createEventForm">
                            <!-- Champs du formulaire pour créer un événement -->
                            <div class="form-group">
                                <label for="eventTitle">Titre :</label>
                                <input type="text" id="eventTitle" name="eventTitle" class="form-control">
                            </div>
                            <!-- Autres champs du formulaire (date, heure de début, heure de fin, etc.) -->
                            <button type="submit" class="btn btn-primary">Créer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $content = ob_get_clean();

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
        ob_start(); // Début de la mise en tampon de la sortie
        ?>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th style="width: 20%;">Heure</th>
                    <th style="width: 80%;">Activités <?= $timetable->days[array_key_first($timetable->days)]->nom ?> <?= array_key_first($timetable->days) ?></th>

                </tr>
            </thead>
            <tbody>
                <?php
                // Parcours de chaque heure de la journée
                for ($hour = 7; $hour < 19; $hour++) {
                    ?>
                    <tr>
                        <td><?= str_pad($hour, 2, "0", STR_PAD_LEFT) . ":00" ?></td>
                        <?
                        $day = $timetable->days[array_key_first($timetable->days)]
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
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Heure</th>
                    <?php
                    foreach ($timetable->days as $date => $day) {
                        echo "<th>$day->nom</th>";
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($hour = 7; $hour < 20; $hour++) {
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
                            <?php foreach ($day->activites_par_heure as $activities): ?>
                                <?php foreach ($activities as $activity): ?>
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

