<?php ob_start(); ?>
<section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card-body p-6 text-center">
                    <div class="mb-md-5 mt-md-4">
                        <div class="alert alert-danger" role="alert">
                            <h2>Accès interdit</h2>
                            <p>Vous n'êtes pas autorisé à accéder à cette page.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $content = ob_get_clean(); ?>