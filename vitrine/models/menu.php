<?php $title = "Menu";?>

<script>
        function autoSubmit() {
            document.getElementById("radioForm").submit();
        }
</script>

<div class="container">
<br>
<h4>Commandez en ligne !</h4><br>


<form id="radioForm" action="vitrine.php?menu=menu" method="post" class="mb-4">
    <div class="form-check">
        <input class="form-check-input" type="radio" id="option1" name="options[]" value="Option 1" onchange="autoSubmit()" <?php if (isset($_POST['options']) && in_array('Option 1', $_POST['options'])) echo 'checked'; ?>>
        <label class="form-check-label" for="option1">LIVRAISON 🛵</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" id="option2" name="options[]" value="Option 2" onchange="autoSubmit()" <?php if (isset($_POST['options']) && in_array('Option 2', $_POST['options'])) echo 'checked'; ?>>
        <label class="form-check-label" for="option2">À EMPORTER 🛒</label>
    </div>
</form>

<!--
<div class="container mt-3">
    <h3 class="text-center">Résultats</h3>
    <div class="alert alert-info">
        <?php
        /*
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['options'])) {
                echo "Options sélectionnées : " . implode(", ", $_POST['options']);
            } else {
                echo "Aucune option sélectionnée.";
            }
        } else {
            echo "Aucune option sélectionnée.";
        }
            */
        ?>
    </div>
</div>
-->


<div class="row row-cols-1 row-cols-md-3 g-4">
    <div class="col">
        <div class="card bg-dark text-white">
            <h2>Tacos 1 viande</h2>
            <p>Choisissez une viandes :</p>
            <form id="commandeForm">
                <label><input class="form-check-input" type="checkbox" id="check1" name="viande" value="boeuf"> Boeuf</label>
                <label><input class="form-check-input" type="checkbox" id="check2" name="viande" value="poulet"> Poulet</label>
                <label><input class="form-check-input" type="checkbox" id="check3" name="viande" value="kebab"> kebab</label>
                <p>Choisissez des frites :</p>
                <label><input class="form-check-input" type="radio" id="check4" name="frites" value="frites-classiques"> Frites classiques</label>
                <label><input class="form-check-input" type="radio" id="check5" name="frites" value="frites-chedar"> Frites chedar</label>
                <p>Choisissez une boisson :</p>
                <label><input class="form-check-input" type="radio" id="check6" name="boisson" value="eau"> Eau</label>
                <label><input class="form-check-input" type="radio" id="check7" name="boisson" value="coca"> Coca </label>
                <label><input class="form-check-input" type="radio" id="check8" name="boisson" value="coca"> Ice Tea </label>
                <label><input class="form-check-input" type="radio" id="check9" name="boisson" value="coca"> Orangina </label>
                <label><input class="form-check-input" type="radio" id="check10" name="boisson" value="coca"> Fanta </label>
                <input type="submit" class="btn btn-success" value="Commander">
            </form>
        </div>
    </div>

    <div class="col">
        <div class="card bg-dark text-white">
            <h2>Tacos 2 viandes</h2>
            <p>Choisissez deux viandes :</p>
            <form id="commandeForm">
                <label><input class="form-check-input" type="checkbox" id="check1" name="viande" value="boeuf"> Boeuf</label>
                <label><input class="form-check-input" type="checkbox" id="check2" name="viande" value="poulet"> Poulet</label>
                <label><input class="form-check-input" type="checkbox" id="check3" name="viande" value="kebab"> kebab</label>
                <p>Choisissez des frites :</p>
                <label><input class="form-check-input" type="radio" id="check4" name="frites" value="frites-classiques"> Frites classiques</label>
                <label><input class="form-check-input" type="radio" id="check5" name="frites" value="frites-chedar"> Frites chedar</label>
                <p>Choisissez une boisson :</p>
                <label><input class="form-check-input" type="radio" id="check6" name="boisson" value="eau"> Eau</label>
                <label><input class="form-check-input" type="radio" id="check7" name="boisson" value="coca"> Coca </label>
                <label><input class="form-check-input" type="radio" id="check8" name="boisson" value="coca"> Ice Tea </label>
                <label><input class="form-check-input" type="radio" id="check9" name="boisson" value="coca"> Orangina </label>
                <label><input class="form-check-input" type="radio" id="check10" name="boisson" value="coca"> Fanta </label>
                <input type="submit" class="btn btn-success" value="Commander">
            </form>
        </div>
    </div>

    <div class="col">
        <div class="card bg-dark text-white">
            <h2>Tacos 3 viandes</h2>
            <p>Choisissez trois viandes :</p>
            <form id="commandeForm">
                <label><input class="form-check-input" type="checkbox" id="check1" name="viande" value="boeuf"> Boeuf</label>
                <label><input class="form-check-input" type="checkbox" id="check2" name="viande" value="poulet"> Poulet</label>
                <label><input class="form-check-input" type="checkbox" id="check3" name="viande" value="kebab"> kebab</label>
                <p>Choisissez des frites :</p>
                <label><input class="form-check-input" type="radio" id="check4" name="frites" value="frites-classiques"> Frites classiques</label>
                <label><input class="form-check-input" type="radio" id="check5" name="frites" value="frites-chedar"> Frites chedar</label>
                <p>Choisissez une boisson :</p>
                <label><input class="form-check-input" type="radio" id="check6" name="boisson" value="eau"> Eau</label>
                <label><input class="form-check-input" type="radio" id="check7" name="boisson" value="coca"> Coca </label>
                <label><input class="form-check-input" type="radio" id="check8" name="boisson" value="coca"> Ice Tea </label>
                <label><input class="form-check-input" type="radio" id="check9" name="boisson" value="coca"> Orangina </label>
                <label><input class="form-check-input" type="radio" id="check10" name="boisson" value="coca"> Fanta </label>
                <input type="submit" class="btn btn-success" value="Commander">
            </form>
        </div>
    </div>
</div>
</div>