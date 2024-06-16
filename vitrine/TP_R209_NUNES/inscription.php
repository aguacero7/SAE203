<?php
session_start();

include 'functions.php';
head();
nav();

echo '<div class="jumbotron bg-danger jumbotron-fluid text-center text-white p-3">
<h2><kbd>Inscription :</kbd></h2>
</div>

<div class="container">
<div class="container mt-3">
  <h3>Créer votre compte :</h3>
    
  <form action="inscription.php" class="was-validated" method="POST">
  <div class = "row">
    <div class="mb-3 mt-3 col">
      <label for="utilisateur" class="form-label">Pseudo :</label>
      <input type="text" class="form-control" id="utilisateur" placeholder="Entrez votre identifiant" name="utilisateur" required>
      <div class="valid-feedback">Valide.</div>
      <div class="invalid-feedback">Remplissez ce champ avant de continuer</div>
    </div>
    <div class="mb-3 mt-3 col">
      <label for="vehicule" class="form-label">Véhicule :</label>
      <input type="text" class="form-control" id="vehicule" placeholder="Entrez la marque de votre véhicule" name="vehicule" required>
      <div class="valid-feedback">Valide.</div>
      <div class="invalid-feedback">Remplissez ce champ avant de continuer</div>
    </div>
    </div>
    <div class = "row">
    <div class="mb-3 mt-3 col">
      <label for="email" class="form-label">Email :</label>
      <input type="text" class="form-control" id="email" placeholder="Entrez votre adresse mail" name="email" required>
      <div class="valid-feedback">Valide.</div>
      <div class="invalid-feedback">Remplissez ce champ avant de continuer</div>
    </div>
    <div class="mb-3 mt-3 col">
            <label for="role" class="form-label">Rôle :</label>
            <input type="text" class="form-control" id="role" placeholder="User" name="role" disabled>
        </div>
    </div>
    <div class = "row">
        <div class="mb-3 mt-3 col">
            <label for="motdepasse" class="form-label">Mot de passe :</label>
            <input type="password" class="form-control" id="motdepasse" placeholder="Entrez votre mot de passe" name="motdepasse" required>
            <div class="valid-feedback">Valide.</div>
            <div class="invalid-feedback">Remplissez ce champ avant de continuer</div>
    </div>
    <div class="mb-3 mt-3 col">
            <label for="motdepasse" class="form-label">Confirmation de mot de passe :</label>
            <input type="password" class="form-control" id="motdepasse" placeholder="Entrez le même mot de passe" name="confirmation" required>
            <div class="valid-feedback">Valide.</div>
            <div class="invalid-feedback">Remplissez ce champ avant de continuer</div>
    </div>
    </div>
    <div class="form-check mb-3">
      <input class="form-check-input" type="checkbox" id="myCheck"  name="remember" required>
      <label class="form-check-label" for="myCheck">Je suis ok à envoyer les données au formulaire</label>
      <div class="valid-feedback">Valide.</div>
      <div class="invalid-feedback">Cochez cette case avant de continuer</div>
    </div>
  <button type="submit" class="btn btn-dark" name="submit">Envoyer</button>
  </form>';
  
  $fileContent = file_get_contents('data/utilisateurs.json');
  $jsonData = json_decode($fileContent, true);

  $tableau = array();
  foreach ($jsonData as $key => $value){
    $value = $jsonData[$key]['utilisateur'];
    array_push($tableau, $value);
  }
  
    if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['submit']) and isset($_POST['motdepasse']) and isset($_POST['utilisateur'])) {
      $newData = array('utilisateur'=>$_POST['utilisateur'],'motdepasse' => password_hash($_POST['motdepasse'], PASSWORD_DEFAULT),'vehicule'=>$_POST['vehicule'],'email'=>$_POST['email'],'role'=>'user');
          if(in_array($_POST['utilisateur'], $tableau)){
            echo "
            <br>
            <div class='alert alert-danger alert-dismissible fade show'>
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            <strong>Attention !</strong> Nom d'utilisateur déjà utilisé
            </div>";
          }
          elseif($_POST['motdepasse'] != $_POST['confirmation']){
            echo "
            <br>
            <div class='alert alert-danger alert-dismissible fade show'>
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            <strong>Attention !</strong> Vous n'avez pas tapé le même mot de passe
            </div>";
          }
          else{
            $jsonData[] = $newData;
            $data = json_encode($jsonData, JSON_PRETTY_PRINT);
            file_put_contents('data/utilisateurs.json', $data);

            echo '<br>';
            echo "<div class='alert alert-success alert-dismissible fade show'>
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            <strong>C'est bon !</strong> Inscription terminée
            </div>";
          }
    }

echo '</div>
</div>';

foot();