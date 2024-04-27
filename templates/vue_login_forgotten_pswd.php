<?php ob_start(); ?>
<section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-dark text-white" style="border-radius: 1rem; position: relative;">
                    <div class="card-body p-5 text-center">

                        <div class="mb-md-5 mt-md-4">
                            <h2 class="fw-bold mb-2 text-uppercase">Mon identifiant</h2>
                            <p class="text-white-50 mb-4">Veuillez saisir votre identifiant pour changer de mot de passe.</p>

                            <div class="form-outline form-white mb-4">
                                <input type="text" id="loginID" name="loginId" class="form-control form-control-lg" required/>
                                <label class="form-label" for="loginID">Identifiant</label>
                            </div>

                            <p class="small mb-2 pb-lg-2"><a class="text-white-50" href="../models/login.php">Retour à la page d'accueil</a>
                            </p>

                            <a href="login.php?loginButton2=ok">
                                <button class="btn btn-outline-light btn-lg px-5" type="submit">RÉINITIALISER MON MOT DE PASSE</button>
                            </a>

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