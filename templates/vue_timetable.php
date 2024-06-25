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
            <div class="col-md-6 text-align center">
                <button type="button" onclick="createActivity()" class="btn btn-outline-success mx-2">
                    Ajouter Activité
                </button>
            </div>
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

        <!-- Modal pour créer une activité -->
        <div class="modal fade" id="createActivityModal" tabindex="-1" role="dialog" aria-labelledby="createActivityModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createActivityModalLabel">Créer l'activité</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="createActivityForm" method="post">
                            <input type="hidden" name="create" value="1">
                            <div class="mb-3">
                                <label for="createActivityTitle" class="form-label">Titre</label>
                                <input type="text" class="form-control" id="createActivityTitle" name="title" required>
                            </div>
                            <div class="mb-3">
                                <label for="createActivityDate" class="form-label">Date</label>
                                <input type="date" class="form-control" id="createActivityDate" name="date"
                                    value="<?= $timetable->date ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="createActivityStartTime" class="form-label">Heure de début</label>
                                <input type="time" class="form-control" id="createActivityStartTime" name="start_time" required>
                            </div>
                            <div class="mb-3">
                                <label for="createActivityEndTime" class="form-label">Heure de fin</label>
                                <input type="time" class="form-control" id="createActivityEndTime" name="end_time" required>
                            </div>
                            <div class="mb-3">
                                <label for="createActivityColor" class="form-label">Couleur</label>
                                <select class="form-control" id="createActivityColor" name="color" required>
                                    <option value="primary">Bleu</option>
                                    <option value="secondary">Gris</option>
                                    <option value="success">Vert</option>
                                    <option value="danger">Rouge</option>
                                    <option value="warning">Jaune</option>
                                    <option value="info">Cyan</option>
                                    <option value="light">Blanc</option>
                                    <option value="dark">Noir</option>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <!-- Liste des utilisateurs -->
                                    <label for="allUsers">Utilisateurs</label>
                                    <select multiple id="allUsers" class="form-control">
                                        <?= TimetableView::load_users(false) ?>
                                    </select>
                                    <br>
                                    <!-- Liste des groupes -->
                                    <label for="allGroups">Groupes</label>
                                    <select multiple id="allGroups" class="form-control">
                                        <?= TimetableView::load_groups(false) ?>
                                    </select>
                                </div>

                                <div class="col">
                                    <label for="selectedUsers">Utilisateurs sélectionnés</label>
                                    <select multiple id="createActivityInvited" class="form-control">
                                    </select>
                                    <br>
                                    <!-- Groupes choisis -->
                                    <label for="selectedGroups">Groupes sélectionnés</label>
                                    <select multiple id="createActivityInvitedGrp" class="form-control">
                                    </select>
                                </div>
                            </div>
                            <div hidden class="alert alert-danger" id="errorResult"></div>
                            <br>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal pour editer un évènement -->
        <div class="modal fade" id="editActivityModal" tabindex="-1" role="dialog" aria-labelledby="editActivityModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editActivityModalLabel">Modifier l'activité</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editActivityForm" method="post">
                            <input type="hidden" id="editActivityId" name="id">
                            <input type="hidden" id="edit" name="edit" value="">

                            <div class="mb-3">
                                <label for="editActivityTitle" class="form-label">Titre</label>
                                <input type="text" class="form-control" id="editActivityTitle" name="title" required>
                            </div>
                            <div class="mb-3">
                                <label for="editActivityDate" class="form-label">Date</label>
                                <input type="date" class="form-control" id="editActivityDate" name="date" required>
                            </div>
                            <div class="mb-3">
                                <label for="editActivityStartTime" class="form-label">Heure de début</label>
                                <input type="time" class="form-control" id="editActivityStartTime" name="start_time" required>
                            </div>
                            <div class="mb-3">
                                <label for="editActivityEndTime" class="form-label">Heure de fin</label>
                                <input type="time" class="form-control" id="editActivityEndTime" name="end_time" required>
                            </div>
                            <div class="mb-3">
                                <label for="editActivityColor" class="form-label">Couleur</label>
                                <select class="form-control" id="editActivityColor" name="color" required>
                                    <option value="primary">Bleu</option>
                                    <option value="secondary">Gris</option>
                                    <option value="success">Vert</option>
                                    <option value="danger">Rouge</option>
                                    <option value="warning">Jaune</option>
                                    <option value="info">Cyan</option>
                                    <option value="light">Blanc</option>
                                    <option value="dark">Noir</option>
                                </select>

                            </div>

                            <div class="row">
                                <div class="col">
                                    <!-- Liste des utilisateurs -->
                                    <label for="allUsers">Utilisateurs</label>
                                    <select multiple id="allUsers" class="form-control">
                                        <?= TimetableView::load_users(true) ?>
                                    </select>
                                    <br>
                                    <!-- Liste des groupes -->
                                    <label for="allGroups">Groupes</label>
                                    <select multiple id="allGroups" class="form-control">
                                        <?= TimetableView::load_groups(true) ?>
                                    </select>
                                </div>

                                <div class="col">
                                    <label for="selectedUsers">Utilisateurs sélectionnés</label>
                                    <select multiple id="editActivityInvited" class="form-control">
                                    </select>
                                    <br>
                                    <!-- Groupes choisis -->
                                    <label for="selectedGroups">Groupes sélectionnés</label>
                                    <select multiple id="editActivityInvitedGrp" class="form-control">
                                    </select>
                                </div>
                            </div>
                            <div hidden class="alert alert-danger" id="errorResult"></div>
                            <BR>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
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
        <table class="table table-bordered table-striped table-hover">
            <thead class="">
                <tr>
                    <th style="width: 20%;">Heure</th>
                    <th style="width: 80%;">Activités <?= $timetable->days[array_key_first($timetable->days)]->nom ?>
                        <?= array_key_first($timetable->days) ?>
                    </th>

                </tr>
            </thead>
            <tbody class="table-primary">
                <?php
                // Parcours de chaque heure de la journée
                for ($hour = 7; $hour < 21; $hour++) {
                    ?>
                    <tr>
                        <td><?= str_pad($hour, 2, "0", STR_PAD_LEFT) . ":00" ?></td>
                        <?
                        $day = $timetable->days[array_key_first($timetable->days)]
                            ?>
                        <td>
                            <?php foreach ($day->activites_par_heure[$hour] ?? [] as $activity): ?>
                                <a href="javascript:void(0);" onclick="editActivity(<?= $activity->id ?>)">
                                        <span
                                            class="badge text-bg-<?= $activity->color ?> <?= $activity->id ?>"><?= $activity->title ?></span>
                                    </a>
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
        <table class="table table-bordered table-striped ">
            <thead class="thead thead-dark">
                <tr>
                    <th>Heure</th>
                    <?php
                    foreach ($timetable->days as $date => $day) {
                        echo "<th> <p class='text-secondary'>($day->date)</p>$day->nom</th>";
                    }
                    ?>
                </tr>
            </thead>
            <tbody class="table-primary">
                <?php
                for ($hour = 7; $hour < 21; $hour++) {
                    ?>
                    <tr>
                        <td><?= str_pad($hour, 2, "0", STR_PAD_LEFT) . ":00" ?></td>
                        <?php
                        foreach ($timetable->days as $day) {
                            ?>
                            <td>
                                <?php foreach ($day->activites_par_heure[$hour] ?? [] as $activity): ?>
                                    <a href="javascript:void(0);" onclick="editActivity(<?= $activity->id ?>)">
                                        <span
                                            class="badge text-bg-<?= $activity->color ?> <?= $activity->id ?>"><?= $activity->title ?></span>
                                    </a>
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
    private static function load_users($id)
    {
        $users = User::load_all();
        foreach ($users as $user) {
            if ($id) {
                echo "<option class='all user-option' id='" . $user->username . "' value='" . $user->username . "'>" . $user->username . "</option>";

            }
            else{
                echo "<option class='all user-option' value='" . $user->username . "'>" . $user->username . "</option>";

            }
        }
    }

    private static function load_groups($id)
    {
        $groupes = User::load_all_grp();
        foreach ($groupes as $groupe) {
            if ($id) {
                echo "<option class='all group-option' id='$groupe' value='$groupe'>$groupe</option>";
            }
            else{
                echo "<option class='all group-option' value='$groupe'>$groupe</option>";

            }
        }
    }
}

