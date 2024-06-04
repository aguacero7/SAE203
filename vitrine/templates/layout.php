<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <!-- Bootstrap CSS -->
    <link href="..\style\bootstrap\css\bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../style/bootstrap/css/layout.css">
    <link href="../style/bootstrap/js/bootstrap.min.js" rel="stylesheet">
    <script> <?=$script?> </script>
</head>

<div class="bg-success text-white">
    <nav class="navbar navbar-expand-lg navbar-light bg-dark">
        <a class="navbar-brand text-white">Big K</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link text-white " href="vitrine.php?menu=menu">Menu <span class="sr-only"></span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="vitrine.php?localisation=localisation">Localisation</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="vitrine.php?panier=panier">Panier</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h1 class="text-center my-5">Le Big K</h1>
        <p class="text-center mb-5">Notre numéro de téléphone : 01 23 45 67 89</p>
</div>