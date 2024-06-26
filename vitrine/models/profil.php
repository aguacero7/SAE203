<?php 

$title = "Profil";


$path = 'assets/utilisateurs.json';
$jsonString = file_get_contents($path);
$jsonData = json_decode($jsonString, true);

$compteur = 0;



if ($_SERVER["REQUEST_METHOD"] == "POST") {
  foreach ($jsonData as $key => $value){
    echo 'ok';
    if ($_SESSION['idf'] == $jsonData[$key]['username']){
      $jsonData[$key]['email'] = $_POST['email'];
      $jsonData[$key]['username'] = $_POST['username'];
      $jsonData[$key]['fullname'] = $_POST['fullname'];
      $jsonData[$key]['age'] = $jsonData[$key]['age'];
      $_SESSION['idf'] = $jsonData[$key]['utilisateur'];

      $data = json_encode($jsonData, JSON_PRETTY_PRINT);
      file_put_contents($path, $data);
      header("Location: vitrine.php");
    }
  }
}

foreach ($jsonData as $key => $value){
  if ($_SESSION['idf'] == $jsonData[$key]['username']){

    echo '
    <style>
    .card {
      margin: 0 auto; /* Added */
      float: none; /* Added */
      margin-bottom: 10px; /* Added */
    }
    </style>

    <div class="container">
    <br>
    <h4>Votre profil :</h4><br>

    <div class="card mb-3 justify-content-center" style="max-width: 540px;">
      <div class="row g-0">
        <div class="col-md-4">
          <img src="img/profil_vierge.png" class="img-fluid rounded-start" alt="profil_vierge">
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <p class="card-text">
            <form action="vitrine.php" class="was-validated" method="POST">
            <div class = "row">
            <div class="mb-3 mt-3 col">
          <label for="fullname" class="form-label">Prénom Nom :</label>
          <input type="text" class="form-control" id="fullname" placeholder="'.$jsonData[$key]['fullname'].'" name="fullname" required>
          <div class="valid-feedback">Valide.</div>
          <div class="invalid-feedback">Remplissez ce champ si vous voulez modifier votre profil</div>
        </div>
        <div class="mb-3 mt-3 col">
          <label for="username" class="form-label">Pseudo :</label>
          <input type="text" class="form-control" id="username" placeholder="'.$jsonData[$key]['username'].'" name="username" required>
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
                <label for="age" class="form-label">Âge :</label>
                <input type="text" class="form-control" id="age" placeholder="'.$jsonData[$key]['age'].'" name="age" required>
            </div>
            </div>
            <div class = "row">
        <div class="mb-3 mt-3 col">
          <label for="fidelite" class="form-label">Points de fidélités :</label>
          <input type="text" class="form-control" id="fidelite" placeholder="'.$jsonData[$key]['fidelite'].'" name="fidelite" disabled>
          <div class="valid-feedback">Valide.</div>
          <div class="invalid-feedback">Remplissez ce champ si vous voulez modifier votre profil</div>
        </div>
        </div>
            <br>
            <button type="submit" class="btn btn-success">Modifier</button>
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