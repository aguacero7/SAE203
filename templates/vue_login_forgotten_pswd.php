<?php ob_start(); ?>
<section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-dark text-white" style="border-radius: 1rem; position: relative;">
                    <div class="card-body p-5 text-center">

                            <form method="POST" name="authentification" action="login.php">
                            <div class="mb-md-5 mt-md-4">
                                <h2 class="fw-bold mb-2 text-uppercase">Mon identifiant</h2>
                                <p class="text-white-50 mb-4">Veuillez saisir votre identifiant et réponde à la question choisi lors de votre inscription pour changer de mot de passe.</p>

                                <div class="form-outline form-white mb-4">
                                    <input type="text" id="loginId2" name="loginId2" class="form-control form-control-lg" required/>
                                    <label class="form-label" for="loginId2">Identifiant</label>
                                </div>

                                <div class="form-outline form-white mb-4">
                                    <select class="form-select" aria-label="Default select example" name="question" required>
                                        <option selected>Choisir parmis ces questions</option>
                                        <option value="mere">Quel est le nom de jeune fille de votre mère ?</option>
                                        <option value="plat">Quel est votre plat préféré ?</option>
                                        <option value="voiture">Quel est le modèle de votre première voiture ?</option>
                                    </select>
                                    <label class="form-label" for="question">Questions</label>
                                </div>

                                <div class="form-outline form-white mb-4">
                                    <input type="text" id="answer" name="answer" class="form-control form-control-lg" required/>
                                    <label class="form-label" for="answer">Réponse</label>
                                </div>

                                <p class="small mb-2 pb-lg-2">
                                    <a class="text-white-50" href="login.php?retour='retour'">Retour à la page d'accueil</a>
                                </p>

                                <button class="btn btn-outline-light btn-lg px-5" type="submit" name="submit">RÉINITIALISER MON MOT DE PASSE</button>
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