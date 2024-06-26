<?php $title = "Menu";?>

<div class="container">
<br>
<h4>Commandez en ligne !</h4><br>
<form action="index.php?menu=menu" method="post" class="mb-4">

<label><input class="form-check-input" type="radio" name="livraison" value="emporter"> A EMPORTER 🛒</label>
<br>
<label><input class="form-check-input" type="radio" name="livraison" value="livraison"> LIVRAISON 🛵</label>
<br>

    <div class="row text-center">
        <div class="col">
            <div class="card bg-dark text-white">
                <h2>Tacos</h2>
                    <p>Choisissez le nombres de viandes :</p>
                    <label><input class="form-check-input" type="radio" id="1viande" name="nb_viandes" value="1"> 1 Viande</label>
                    <label><input class="form-check-input" type="radio" id="2viandes" name="nb_viandes" value="2"> 2 Viandes</label>
                    <label><input class="form-check-input" type="radio" id="3viandes" name="nb_viandes" value="3"> 3 Viandes</label>
                    <p>Choisissez une viandes :</p>
                    <label><input class="form-check-input" type="checkbox" id="boeuf" name="viande" value="boeuf"> Boeuf</label>
                    <label><input class="form-check-input" type="checkbox" id="poulet" name="viande" value="poulet"> Poulet</label>
                    <label><input class="form-check-input" type="checkbox" id="kebab" name="viande" value="kebab"> kebab</label>
                    <p>Choisissez des frites :</p>
                    <label><input class="form-check-input" type="radio" id="classique" name="frites" value="frites-classiques"> Frites classiques</label>
                    <label><input class="form-check-input" type="radio" id="cheddar" name="frites" value="frites-chedar"> Frites chedar</label>
                    <p>Choisissez une boisson :</p>
                    <label><input class="form-check-input" type="radio" id="eau" name="boisson" value="eau"> Eau</label>
                    <label><input class="form-check-input" type="radio" id="coca" name="boisson" value="coca"> Coca </label>
                    <label><input class="form-check-input" type="radio" id="ice" name="boisson" value="ice-tea"> Ice Tea </label>
                    <label><input class="form-check-input" type="radio" id="orangina" name="boisson" value="orangina"> Orangina </label>
                    <label><input class="form-check-input" type="radio" id="fanta" name="boisson" value="fanta"> Fanta </label>
            </div>
        </div>
    </div>
    <br>



   <div class="mb-3">
        <label for="adresse" class="form-label">Adresse (Si le code postale de votre ville n est pas en 354XX, cela fait trop loin pour nous à livrer !) :</label>
        <input type="adresse" name="adresse" class="form-control" id="adresse" placeholder="Format : nom rue 354XX Ville" required>
    </div>
    
    <br>
    <input type="submit" class="btn btn-success" value="Commander" name="submit">
</form>

<?php

$path = 'assets/utilisateurs.json';
$jsonString = file_get_contents($path);
$jsonData = json_decode($jsonString, true);

if (isset($_POST['livraison']) && isset($_POST['submit']) && isset($_POST['nb_viandes']) && isset($_POST['viande']) && isset($_POST['frites']) && isset($_POST['boisson']) && isset($_POST['adresse'])){

    var_dump($_POST['viande']);
        
    
    $newData = array("manger"=>$_POST['livraison'],"nb_viandes"=>$_POST['nb_viandes'],"viandes"=>[$_POST['viande']],"frites"=>$_POST['frites'],"boisson"=>$_POST['boisson'],"adresse"=>$_POST['adresse']);
    
    foreach ($jsonData as $key => $value){
        if ($_SESSION["idf"] == $jsonData[$key]['username']){
            $jsonData[$key]['commande'] = $newData;
            $jsonData[$key]['fidelite'] += 1;
        }
    }
    $data = json_encode($jsonData, JSON_PRETTY_PRINT);
    file_put_contents('assets/utilisateurs.json', $data);
}

?>

</div>