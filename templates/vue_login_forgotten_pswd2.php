<?php ob_start(); ?>
<section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-dark text-white" style="border-radius: 1rem; position: relative;">
                    <div class="card-body p-5 text-center">

                        <div class="mb-md-5 mt-md-4">
                            <form method="POST">
                            <h2 class="fw-bold mb-2 text-uppercase">RÉINITIALISER VOTRE MOT DE PASSE</h2>
                            <p class="text-white-50 mb-4">Votre nouveau mot de passe doit contenir un minimum de 8 caractères dont au moins
                                1 caractère numérique, 1 lettre majuscule et 1 lettre minuscule.
                            </p>

                            <div class="form-outline form-white mb-4">
                                <input type="password" id="loginPassword" name="loginPass" class="form-control form-control-lg" required/>
                                <label class="form-label" for="loginPassword">Votre nouveau mot de passe </label>
                            </div>

                            <div class="form-outline form-white mb-4">
                                <input type="password" id="loginPassword" name="loginPass" class="form-control form-control-lg" required/>
                                <label class="form-label" for="loginPassword">Confirmer votre nouveau mot de passe</label>
                            </div>

                            <p class="small mb-2 pb-lg-2"><a class="text-white-50" href="../models/login.php">Retour à la page d'accueil</a>
                            </p>

                            <button class="btn btn-outline-light btn-lg px-5" type="submit" id="save" name="save">ENREGISTRER</button>
                            </form>
                        </div>
                        <div class="alert alert-danger text-center mt-5" hidden role="alert">
                            <h2 id="loginFeedback"> </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $content = ob_get_clean(); ?>