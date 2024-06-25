<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erreur</title>
    <link href="..\style\bootstrap\css\bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-center">
                    <div class="card-header bg-danger text-white">
                        <h4>Erreur <?php echo $this->code; ?></h4>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Oups ! Une erreur est survenue.</h5>
                        <p class="card-text"><?php echo htmlspecialchars($this->texte); ?></p>
                        <a href="../models/login.php" class="btn btn-primary">Retour à l'accueil</a>
                    </div>
                    <div class="card-footer text-muted">
                        <?php echo date('Y-m-d H:i:s'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
