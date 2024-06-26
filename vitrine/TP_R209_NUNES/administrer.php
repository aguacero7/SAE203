<?php
session_start();

include 'functions.php';
head();
nav();

echo '<div class="jumbotron bg-danger jumbotron-fluid text-center text-white p-3">
<h2><kbd>Administration :</kbd></h2>
</div>

<div class="container">
<br>
<h4>Utilisateurs inscrits :</h4><br>
</div>';

administration();
foot();

?>