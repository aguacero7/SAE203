<?php ob_start(); ?>
<section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-dark text-white" style="border-radius: 1rem; position: relative;">
                    <div class="card-body p-5 text-center">

                    <form method="POST" name="connexion" action="../controllers/login_treatment.php">
                        <div class="mb-md-5 mt-md-4">

                            <h2 class="fw-bold mb-2 text-uppercase">BIG K </h2>
                            <p class="text-white-50 mb-5">Entrez vos identifiants de connexion</p>

                            <div class="form-outline form-white mb-4">
                                <input type="text" id="loginID" name="loginID" class="form-control form-control-lg" />
                                <label class="form-label" for="loginID">Identifiant</label>
                            </div>

                            <div class="form-outline form-white mb-4">
                                <input type="password" id="loginPassword" name="loginPassword"
                                    class="form-control form-control-lg" />
                                <label class="form-label" for="loginPassword">Mot de passe</label>
                            </div>
                            <p class="small mb-2 pb-lg-2">
                                <a class="text-white-50" href="login.php?forgotten_pswd=ok">Mot de passe oublié?</a>

                            </p>

                            <button class="btn btn-outline-light btn-lg px-5" type="submit" id="loginButton">Se
                                connecter</button>
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