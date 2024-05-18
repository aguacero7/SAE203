<?php ob_start(); ?>
<div class="bg-success text-white">
    <nav class="navbar navbar-expand-lg navbar-light bg-dark">
        <a class="navbar-brand text-white" href="#">Big K</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link text-white " href="#">Menu <span class="sr-only"></span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Localisation</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h1 class="text-center my-5">Le Big K</h1>
        <p class="text-center mb-5">Notre numéro de téléphone : 01 23 45 67 89</p>

        <h2 class="text-center my-5">Menu</h2>
        <div class="row">
            <div class="col-md-6">
                <div class="card bg-dark text-white">
                    <img src="tacos1.jpg" class="card-img-top" alt="Tacos 1">
                    <div class="card-body">
                        <h5 class="card-title">Formule Tacos 1</h5>
                        <p class="card-text">Description du tacos 1.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-dark text-white">
                    <img src="tacos2.jpg" class="card-img-top" alt="Tacos 2">
                    <div class="card-body">
                        <h5 class="card-title">Formule Tacos 2</h5>
                        <p class="card-text">Description du tacos 2.</p>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="text-center my-5">Localisation</h2>
        <div class="embed-responsive embed-responsive-16by9">
        <iframe class="embed-responsive-item" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1234.5678901234567!2d-1.987174!3d48.6582371!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x480e8349143218df:0xfb5a23e824f9e950!2sBig+K!5e0!3m2!1sfr!2sfr!4v1671234567890!5m2!1sfr!2sfr" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>