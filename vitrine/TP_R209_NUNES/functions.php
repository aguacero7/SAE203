<?php

//§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§
function head(){
    echo '<!DOCTYPE html>
    <html lang="fr">
    <head>
    <title>TP1 R209</title>
    <link rel="icon" type="image/x-icon" href="images/portail.png">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>
    </head> 

    <body>
    <div class="jumbotron jumbotron-fluid bg-danger p-5 py-3 text-white">
    <p>';


    // Set the new timezone
    date_default_timezone_set('Europe/Paris');
    $date = "Date 🕔: ".date('d/m/y h').'h'.date('i');
    echo $date;

    echo '</p>
    <div class="connexion-header" style="float: right;">';
    echo "<div>";
    if (isset($_SESSION["idf"]))
        {
            echo "Salut ".$_SESSION["idf"]." ! ";
            echo "<a href='deconnexion.php' class='btn btn-outline-dark' btn-sm'>Se déconnecter</a>";
        }
    else
        {
        echo "Salut anonymous !";
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
                            <form action="index.php" method="post">
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
                                    header("Location: index.php");
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
                                <p><a href=inscription.php>Sinscrire ?</a></p><br>
                            </div>
                            </div>
                        </div>
                    </div>';
                }
                    echo '</div>';
                    

}

//§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§
function nav(){
    echo '</div>
    <h2>SITE COCO - Voit 🚗</h2> 
    </div>

    <nav class="navbar navbar-expand-sm bg-danger navbar-dark justify-content-center">
    <!-- Brand/logo -->
    <a class="navbar-brand " href="index.php">
    <div>Accueil</div>
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
        echo '<a class="nav-link" href="profil.php">Profil</a>';
    }
    
    echo '</li>
    <li class="nav-item">
    <a class="nav-link" href="annonces.php">Annonces</a>
    </li>
    </ul>
    </nav>';
}

//§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§
function foot(){
echo '
<div class="p-5 bg-white text-black text-center">
  <p><img src="images/iut.png" alt="Logo" style="float: left; width:200px"><img src="images/iut2.png" alt="Logo" style="float: right; width:100px"></p>
  <p class="center">TP n°1 • Création d’un site web  • 2023-2024</p>
</div>

</body>
</html>';

}

//§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§
// fct verification mdp et id :
function verif($mdp , $id) {
// Lecture dans le json :
    $path = 'data/utilisateurs.json';
    $jsonString = file_get_contents($path);
    $jsonData = json_decode($jsonString, true);

    foreach ($jsonData as $tableaux){
        $mdp = $tableaux['motdepasse'];
        $id = $tableaux['utilisateur'];
        if (isset($_POST["idf"]) and password_verify($_POST['pswd'], $mdp) == $mdp and $_POST['idf'] == $id){ 
            return true;
        }
    }
    return false;
}

//§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§
function administration(){

    $path = 'data/utilisateurs.json';
    $jsonString = file_get_contents($path);
    $jsonData = json_decode($jsonString, true);
    //var_dump($jsonData);

    echo '<table class="table container mt-6">';
    echo '<thead>';
    echo "<tr><th>🗑️</th><th>Utilisateurs :</th><th>Email :</th><th>Véhicules 🚗:</th><th>Rôles :</th><th>Modifier rôles :</th></tr>";
    echo '</thead>';

    $compteur = 0;
    foreach ($jsonData as $key => $value) {
        if(isset($_POST[$compteur])){
        echo "<div class='alert alert-success alert-dismissible fade show'>
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
        <strong>C'est bon !</strong> Le rôle de l'utilisateur a été modifié
        </div>";
    }

        if (isset($_POST[$compteur])){
            $jsonData[$key]['role'] = $_POST[$compteur];
            $role = $_POST[$compteur];
        }
        else{
            $role = $value['role'];
        }

        if(isset($_GET['supprimer']) && $_GET['supprimer'] != ''){
            if ($value['utilisateur'] == $_GET['supprimer']){
                unset($jsonData[$key]);
                continue;
        }
        }

        echo "<tbody>";
        echo "<tr>";
        echo '<td><a style="text-decoration:none" href="administrer.php?supprimer='.$value['utilisateur'].'">❌</a></td>';
        

        echo "<td>".$value['utilisateur']."</td>";
        echo "<td>".$value['email']."</td>";
        echo "<td>".$value['vehicule']."</td>";
        echo "<td>".$role."</td>";
        echo '<td>
        <div class="dropdown">
            <button type="button" class="btn btn-outline-danger dropdown-toggle" data-bs-toggle="dropdown">'
            .$role.
            '</button>
            <ul class="dropdown-menu">
            <form action="administrer.php" method="POST">
            <div class="container mt-3">
            <li>
            <div class="form-check container">
                <input type="radio" class="form-check-input" id="radio2" name="'.$compteur.'" value="modo">
                <label class="form-check-label" for="radio2">Modo</label>
            </div>
            </li>
            <li>
            <div class="form-check container">
                <input type="radio" class="form-check-input" id="radio3" name="'.$compteur.'" value="user">
                <label class="form-check-label" for="radio3">User</label>
            </div>
            </li>
            <li>
            <div class="form-check container">
                <input type="radio" class="form-check-input" id="radio4" name="'.$compteur.'" value="visitor">
                <label class="form-check-label" for="radio4">Visitor</label>
            </div>
            </li>
            <button type="submit" class="btn btn-link" style="--bs-btn-font-size: .75rem;">Valider</button>
            </form>
            </ul>
        </div></div></td>';
        echo "</tr>";

        $compteur ++;
}
    $data = json_encode($jsonData, JSON_PRETTY_PRINT);
    file_put_contents($path, $data);
    echo "</tbody>";
    echo '<table>';
}
//§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§
function annonces(){
    if(isset($_GET['delete']) && $_GET['delete'] != ''){
        echo "<div class='alert alert-success alert-dismissible fade show'>
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
        <strong>C'est bon !</strong> L'annonce a été supprimée
        </div>";
    }

    //pour les modos : 
    $path = 'data/utilisateurs.json';
    $jsonString = file_get_contents($path);
    $jsonData = json_decode($jsonString, true);

    foreach($jsonData as $cle => $valeur){
        if($valeur['role'] == 'modo'){
            $modo = $valeur['utilisateur'];
        }
    }
    //

    $annonces = 'data/annonces.json';
    $jsonAnnonces = file_get_contents($annonces);
    $jsonDonnees = json_decode($jsonAnnonces, true);

    //nouvelle annonce : 
    if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['submit'])) {
        $newData = array('Pseudo'=>$_SESSION['idf'],'Date' => $_POST['date'],'Depart'=>$_POST['depart'],'Arrivee'=>$_POST['arrivee'],'Places'=>$_POST['places'],'Commentaire'=>$_POST['commentaire'],'Inscrits'=>array());
        $fileContent = file_get_contents($annonces);
        $existingData = json_decode($fileContent, true);
        $existingData[] = $newData;
        $jsonDonnees = json_encode($existingData, JSON_PRETTY_PRINT);
        file_put_contents($annonces, $jsonDonnees);

        header("Location: annonces.php");

        $alerte = "<div class='alert alert-success alert-dismissible fade show'>
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
        <strong>C'est bon !</strong> L'annonce a été postée
        </div>";
    }
    //

    echo '<h4>Les dernières annonces :</h4><br>
    </div>';


    if (isset($_SESSION["idf"])){

        //pour les admins et les modos : ---------------------------------------------------------------------------------------------------------------------------------------------------- 
        if ($_SESSION["idf"] == 'admin' or $_SESSION["idf"] == $modo){
            echo '<table class="table container mt-6">';
            echo '<thead>';
            echo "<tr><th>🗑️</th><th>Conducteur :</th><th>Date 🕔:</th><th>Départ :</th><th>Arrivée :</th><th>Place(s) :</th><th>Commentaire :</th><th>Inscrit(s) :</th><th>Modifier annonces :</th></tr>";
            echo '<br>
                 </thead>';

            $compteur = 0;
            foreach ($jsonDonnees as $key => $value) {
                if(isset($_GET['delete']) && $_GET['delete'] != ''){
                    if ($key == $_GET['delete']){
                        unset($jsonDonnees[$key]);
                        continue;
                }
                }
                echo "<tbody>";
                echo "<tr>";
                echo '<td><a style="text-decoration:none" href="annonces.php?delete='.$key.'">❌</a></td>';
                
                echo "<td>".$value['Pseudo']."</td>";
                echo "<td>".$value['Date']."</td>";
                echo "<td>".$value['Depart']."</td>";
                echo "<td>".$value['Arrivee']."</td>";
                echo "<td>".$value['Places']."</td>";
                echo "<td>".$value['Commentaire']."</td>";
                echo "<td>";
                foreach ($value['Inscrits'] as $i){
                    echo $i.", ";
                }
                echo "</td>";
                echo "<td><button type='button' class='btn btn-outline-danger' style='--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;' data-bs-toggle='modal' data-bs-target='#myModal2'>Modifier</button></td>";
                echo '<!-- The Modal -->
                    <div class="modal fade" id="myModal2" role = "dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title text-center">Modifier annonce :</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                        <form action="annonces.php" method="POST">
                            <div class="mb-3">
                            <label for="date">Date :</label>
                            <input type="text" class="form-control" id="date" name="date" placeholder="'.$value['Date'].'" required>
                            <div class="invalid-feedback">Veuillez remplir ce champ avant de continuer</div>
                            </div>

                            <div class="mb-3">
                            <label for="depart">Ville départ :</label>
                            <input type="text" class="form-control" id="depart" name="depart" placeholder="'.$value['Depart'].'" required>
                            <div class="invalid-feedback">Veuillez remplir ce champ avant de continuer</div>
                            </div>

                            <div class="mb-3">
                            <label for="arrivee">Ville arrivée :</label>
                            <input type="text" class="form-control" id="arrivee" name="arrivee" placeholder="'.$value['Arrivee'].'" required>
                            <div class="invalid-feedback">Veuillez remplir ce champ avant de continuer</div>
                            </div>

                            <div class="mb-3">
                            <label for="places">Place(s) :</label>
                            <input type="text" class="form-control" id="places" name="places" placeholder="'.$value['Places'].'" required>
                            <div class="invalid-feedback">Veuillez remplir ce champ avant de continuer</div>
                            </div>

                            <div class="mb-3">
                            <label for="commentaire" class="form-label">Commentaire(s) :</label>
                            <textarea class="form-control" id="commentaire" rows="3" name="commentaire" placeholder="'.$value['Commentaire'].'"></textarea>
                            <div class="invalid-feedback">Veuillez remplir ce champ avant de continuer</div>
                            </div>

                            <button type="submit" name="submit2" class="btn btn-danger">Envoyer</button>
                        </form>
                        </div>
                        </div>  
                    </div>
                    </div>';
                echo "</tr>";
        
                $compteur ++;
        }
            $donnees = json_encode($jsonDonnees, JSON_PRETTY_PRINT);
            file_put_contents($annonces, $donnees);
            echo "</tbody>";
            echo '<table>';
        }
        // pour les users et visitors : ---------------------------------------------------------------------------------------------------------------------------------------------------- 
        else {
            echo '
                    <div class="container">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#myModal">+ Nouvelle annonce</button>
                    </div>
                    <br>
                    <!-- The Modal -->
                    <div class="modal fade" id="myModal" role = "dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title text-center">Nouvelle annonce :</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                        <form action="annonces.php" method="POST">
                            <div class="mb-3">
                            <label for="date">Date :</label>
                            <input type="text" class="form-control" id="date" name="date" placeholder="Entrez la date de départ" required>
                            <div class="invalid-feedback">Veuillez remplir ce champ avant de continuer</div>
                            </div>

                            <div class="mb-3">
                            <label for="depart">Ville départ :</label>
                            <input type="text" class="form-control" id="depart" name="depart" placeholder="Entrez la ville" required>
                            <div class="invalid-feedback">Veuillez remplir ce champ avant de continuer</div>
                            </div>

                            <div class="mb-3">
                            <label for="arrivee">Ville arrivée :</label>
                            <input type="text" class="form-control" id="arrivee" name="arrivee" placeholder="Entrez la ville" required>
                            <div class="invalid-feedback">Veuillez remplir ce champ avant de continuer</div>
                            </div>

                            <div class="mb-3">
                            <label for="places">Place(s) :</label>
                            <input type="text" class="form-control" id="places" name="places" placeholder="Entrez la ville" required>
                            <div class="invalid-feedback">Veuillez remplir ce champ avant de continuer</div>
                            </div>

                            <div class="mb-3">
                            <label for="commentaire" class="form-label">Commentaire(s) :</label>
                            <textarea class="form-control" id="commentaire" rows="3" name="commentaire"></textarea>
                            <div class="invalid-feedback">Veuillez remplir ce champ avant de continuer</div>
                            </div>

                            <button type="submit" name="submit" class="btn btn-success">Envoyer</button>
                        </form>
                        </div>
                        </div>  
                    </div>';

                    echo '</div>';
            echo '<table class="table container mt-6">';
            echo '<thead>';
            echo "<tr><th>Départ :</th><th>Arrivée :</th><th>Place(s) :</th><th>Commentaire :</th><th>Inscrit(s) :</th></tr>";
            echo '</thead>';
            foreach ($jsonDonnees as $key => $value) {

                echo "<tbody>";
                echo "<tr>";
                echo "<td>".$value['Depart']."</td>";
                echo "<td>".$value['Arrivee']."</td>";
                echo "<td>".$value['Places']."</td>";
                echo "<td>".$value['Commentaire']."</td>";
                echo "<td>";
                foreach ($value['Inscrits'] as $i){
                    echo $i.", ";
                }
                echo "</td>";
                echo '<td></td>';
                echo "</tr>";
        }
            echo "</tbody>";
            echo '<table>';
        }
    }
    //pour les anonymes : ---------------------------------------------------------------------------------------------------------------------------------------------------- 
    else{
        echo '<table class="table container mt-6">';
        echo '<thead>';
        echo "<tr><th>Départ :</th><th>Arrivée :</th><th>Place(s) :</th><th>Commentaire :</th><th>Inscrit(s) :</th></tr>";
        echo '</thead>';
        foreach ($jsonDonnees as $key => $value) {

            echo "<tbody>";
            echo "<tr>";
            echo "<td>".$value['Depart']."</td>";
            echo "<td>".$value['Arrivee']."</td>";
            echo "<td>".$value['Places']."</td>";
            echo "<td>".$value['Commentaire']."</td>";
            echo "<td>";
            foreach ($value['Inscrits'] as $i){
                echo $i.", ";
            }
            echo "</td>";
            echo '<td></td>';
            echo "</tr>";
    }
        $donnees = json_encode($jsonDonnees, JSON_PRETTY_PRINT);
        file_put_contents($annonces, $donnees);
        echo "</tbody>";
        echo '<table>';
    }
}

?>