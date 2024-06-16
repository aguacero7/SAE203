<?php 

$title = "Profil";

session_start();

$path = 'data/utilisateurs.json';
$jsonString = file_get_contents($path);
$jsonData = json_decode($jsonString, true);

$compteur = 0;



if ($_SERVER["REQUEST_METHOD"] == "POST") {
  foreach ($jsonData as $key => $value){
    echo 'ok';
    if ($_SESSION['idf'] == $jsonData[$key]['utilisateur']){
      $jsonData[$key]['utilisateur'] = $_POST['utilisateur'];
      $jsonData[$key]['vehicule'] = $_POST['vehicule'];
      $jsonData[$key]['email'] = $_POST['email'];
      $jsonData[$key]['role'] = $jsonData[$key]['role'];
      $_SESSION['idf'] = $jsonData[$key]['utilisateur'];

      $data = json_encode($jsonData, JSON_PRETTY_PRINT);
      file_put_contents($path, $data);
      header("Location: profil.php");
    }
  }
}

foreach ($jsonData as $key => $value){
  if ($_SESSION['idf'] == $jsonData[$key]['utilisateur']){

    echo '
    <style>
    .card {
      margin: 0 auto; /* Added */
      float: none; /* Added */
      margin-bottom: 10px; /* Added */
    }
    </style>
    <div class="jumbotron bg-danger jumbotron-fluid text-center text-white p-3">
    <h2><kbd>Profil :</kbd></h2>
    </div>

    <div class="container">
    <br>
    <h4>Votre profil :</h4><br>

    <div class="card mb-3 justify-content-center" style="max-width: 540px;">
      <div class="row g-0">
        <div class="col-md-4">
          <img src="images/profil_vierge.png" class="img-fluid rounded-start" alt="profil_vierge">
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <p class="card-text">
            <form action="profil.php" class="was-validated" method="POST">
            <div class = "row">
            <div class="mb-3 mt-3 col">
          <label for="utilisateur" class="form-label">Pseudo :</label>
          <input type="text" class="form-control" id="utilisateur" placeholder="'.$jsonData[$key]['utilisateur'].'" name="utilisateur" required>
          <div class="valid-feedback">Valide.</div>
          <div class="invalid-feedback">Remplissez ce champ si vous voulez modifier votre profil</div>
        </div>
        <div class="mb-3 mt-3 col">
          <label for="vehicule" class="form-label">Véhicule :</label>
          <input type="text" class="form-control" id="vehicule" placeholder="'.$jsonData[$key]['vehicule'].'" name="vehicule" required>
          <div class="valid-feedback">Valide.</div>
          <div class="invalid-feedback">Remplissez ce champ si vous voulez modifier votre profil</div>
        </div>
        </div>
        <div class = "row">
        <div class="mb-3 mt-3 col">
          <label for="email" class="form-label">Email :</label>
          <input type="text" class="form-control" id="email" placeholder="'.$jsonData[$key]['email'].'" name="email" required>
          <div class="valid-feedback">Valide.</div>
          <div class="invalid-feedback">Remplissez ce champ si vous voulez modifier votre profil</div>
        </div>
        </div>
        <div class = "row">
            <div class="mb-3 mt-3 col">
                <label for="role" class="form-label">Rôle :</label>
                <input type="text" class="form-control" id="role" placeholder="'.$jsonData[$key]['role'].'" name="role" disabled>
            </div>
            </div>
            <br>
            <button type="submit" class="btn btn-danger">Modifier</button>
            <p class="card-text"><small class="text-body-secondary">Vous pouvez modifier votre profil</small></p>
          </form>
            </p>
          </div>
        </div>
      </div>
    </div>
    </div>';
  }
}

$compteur ++;

?>