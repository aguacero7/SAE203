<?php
session_start();

include 'functions.php';
head();
nav();

echo '<div class="jumbotron bg-danger jumbotron-fluid text-center text-white p-3">
<h2><kbd>Accueil :</kbd></h2>
</div>

<div class="container">
<br>
<h4>Bienvenue à vous !</h4><br>
<p>Vous pouvez retrouver la page dédiée aux commentaires et à l’utilisation de ce site en cliquant sur celle-ci : <a href="infos.php">infos.php<a><p>
</div>';

foot();

?>