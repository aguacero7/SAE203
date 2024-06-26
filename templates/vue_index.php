<?php ob_start();?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="jumbotron text-center">
                <h1 class="display-4">Bienvenue sur l'intranet de Big K</h1>
                <p class="lead">Vous êtes connecté à notre plateforme intranet sécurisée.</p>
                <hr class="my-4">
                <p>Explorez les fonctionnalités et les ressources disponibles pour votre travail quotidien.</p>
                <a class="btn btn-primary btn-lg" href="../controllers/timetable_controller.php" role="button">Votre emploi du temps de la semaine</a>
            </div>
        </div>
    </div>
</div>

<?php $content = ob_get_clean(); ?>
