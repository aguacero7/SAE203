<?php

echo '<!DOCTYPE html>
    <html lang="fr">
    <head>
    <title>Big K</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>
    </head> 

    <body>
    <div class="jumbotron jumbotron-fluid bg-success p-5 py-3 text-white">
    <p>';


    // Set the new timezone
    date_default_timezone_set('Europe/Paris');
    $date = "Heure: ".date('h').'h'.date('i');

    echo $date;

    echo '</p>
    <div class="connexion-header" style="float: right;">';
    echo "<div>";
    if (isset($_SESSION["idf"]))
        {
            echo "<a href='deconnexion.php' class='btn btn-outline-dark' btn-sm'>Se déconnecter</a>";
        }
    else
        {
        echo "Pour pouvoir commander, merci de vous connecter :";
        echo '
                    <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#myModal">
                        Connexion
                    </button>
                    

                    <!-- The Modal -->
                    <div class="modal fade" id="myModal" role = "dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title text-center">Connexion</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                            <form action="vitrine.php" method="post">
                                <div class="mb-3">
                                <label for="idf">Identifiant :</label>
                                <input type="text" class="form-control" id="idf" name="idf" placeholder="Entrez votre identifiant">
                                </div>
                                <div class="mb-3">
                                <label for="pswd">Password:</label>
                                <input type="password" class="form-control" id="pwd" placeholder="Entrez votre mot de passe" name="pswd">
                                </div>
                                <button type="submit" class="btn btn-danger">Connexion</button>
                            </form>';
                            // Traitement du formulaire de connexion
                            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pswd'])) {
                                if (verif($_POST['pswd'] , $_POST['idf'])) {
                                    // Authentification réussie, stockage de la session
                                    $_SESSION['idf'] = $_POST['idf'];
                                    // Redirection vers la page d'accueil
                                    header("Location: vitrine.php");
                                }
                                else {
                                    $erreur = "<div class='alert alert-danger alert-dismissible fade show'>
                                            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                            <strong>Attention !</strong> Identifiant ou mot de passe incorrect.
                                        </div>";
                                }
                            }
                            echo '<br>';
                            if(isset($erreur)) {
                                echo $erreur;
                            }
                            echo '</div>

                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <p><a href=vitrine.php?inscription=inscription>Sinscrire ?</a></p><br>
                            </div>
                            </div>
                        </div>
                    </div>';
                }
                    echo '</div>';
                    echo '</div>
                    <h2>🍔 Big K 🍔</h2> 
                    </div>

                    <nav class="navbar navbar-expand-sm bg-success navbar-dark justify-content-center">
                    <!-- Brand/logo -->
                    <a class="navbar-brand " href="vitrine.php?acceuil=acceuil">
                    <div>Big K</div>
                    </a>

                    <!-- Links -->
                    <ul class="navbar-nav">
                    <li class="nav-item">';

                    if (isset($_SESSION["idf"])){
                        if ($_SESSION["idf"] == 'admin'){
                            echo '<a class="nav-link" href="administrer.php">Administration</a>';
                        }
                    }

                    echo'</li>
                    <li class="nav-item">';


                    if (isset($_SESSION["idf"])){
                        echo '<a class="nav-link" href="vitrine.php?profil=profil">Profil</a>';
                    }
                    
                    echo '</li>
                    <li class="nav-item">
                    <a class="nav-link text-white " href="vitrine.php?menu=menu">Menu <span class="sr-only"></span></a>
                    </li>

                    </li>
                    <li class="nav-item">
                    <a class="nav-link text-white" href="vitrine.php?localisation=localisation">Localisation</a>
                    </li>

                    </li>
                    <li class="nav-item">
                    <a class="nav-link text-white" href="vitrine.php?panier=panier">Panier</a>
                    </li>

                    </ul>
                    </nav>';

?>