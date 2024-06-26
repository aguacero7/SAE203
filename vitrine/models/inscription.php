<?php $title = "Inscription";?>


<div class="jumbotron bg-success jumbotron-fluid text-center text-white p-3">
<h2><kbd>Inscription :</kbd></h2>
</div>

<div class="container">
<div class="container mt-3">
  <h3>Créer votre compte :</h3>
    
  <form action="index.php?inscription=inscription" class="was-validated" method="POST">
  <div class = "row">
    <div class="mb-3 mt-3 col">
      <label for="fullname" class="form-label">Prénom Nom :</label>
      <input type="text" class="form-control" id="fullname" placeholder="Entrez votre prénom et votre nom" name="fullname" required>
      <div class="valid-feedback">Valide.</div>
      <div class="invalid-feedback">Remplissez ce champ avant de continuer</div>
    </div>
    <div class="mb-3 mt-3 col">
      <label for="username" class="form-label">Pseudo :</label>
      <input type="text" class="form-control" id="username" placeholder="Entrez votre pseudo" name="username" required>
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
      <label for="age" class="form-label">Âge :</label>
      <input type="text" class="form-control" id="age" placeholder="Entrez votre âge" name="age" required>
      <div class="valid-feedback">Valide.</div>
      <div class="invalid-feedback">Remplissez ce champ avant de continuer</div>
    </div>
    <div class = "row">
        <div class="mb-3 mt-3 col">
            <label for="password" class="form-label">Mot de passe :</label>
            <input type="password" class="form-control" id="password" placeholder="Entrez votre mot de passe" name="password" required>
            <div class="valid-feedback">Valide.</div>
            <div class="invalid-feedback">Remplissez ce champ avant de continuer</div>
    </div>
    <div class="mb-3 mt-3 col">
            <label for="password" class="form-label">Confirmation de mot de passe :</label>
            <input type="password" class="form-control" id="password" placeholder="Entrez le même mot de passe" name="confirmation" required>
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
  <button type="submit" class="btn btn-dark mb-4" name="submit">Envoyer</button>
  </form>

<?php
    $fileContent = file_get_contents('assets/utilisateurs.json');
    $jsonData = json_decode($fileContent, true);

    $tableau = array();
    foreach ($jsonData as $key => $value){
    $value = $jsonData[$key]['username'];
    array_push($tableau, $value);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['submit']) and isset($_POST['password']) and isset($_POST['username'])) {
        $newData = array('password'=>password_hash($_POST['password'], PASSWORD_DEFAULT),'email' => $_POST['email'], 'username'=>$_POST['username'],'fullname'=>$_POST['fullname'],'age'=>$_POST['age'],'fidelite'=> 0);
            if(in_array($_POST['username'], $tableau)){
            echo "
            <br>
            <div class='alert alert-success alert-dismissible fade show'>
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            <strong>Attention !</strong> Nom d'utilisateur déjà utilisé
            </div>";
            }
            elseif($_POST['password'] != $_POST['confirmation']){
            echo "
            <br>
            <div class='alert alert-success alert-dismissible fade show'>
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            <strong>Attention !</strong> Vous n'avez pas tapé le même mot de passe
            </div>";
            }
            else{
            $jsonData[] = $newData;
            $data = json_encode($jsonData, JSON_PRETTY_PRINT);
            file_put_contents('assets/utilisateurs.json', $data);

            echo '<br>';
            echo "<div class='alert alert-success alert-dismissible fade show'>
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            <strong>C'est bon !</strong> Inscription terminée
            </div>";
            }
    }
?>

</div>
</div>