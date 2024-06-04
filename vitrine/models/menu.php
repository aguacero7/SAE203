<?php $title = "Menu";?>

<div class="row">
<div class="col-md-4">

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
<div class="col-md-4">
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
<div class="col-md-4">
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
    <script>
        // Écouteur d'événement pour le formulaire
        document.getElementById('commandeForm').addEventListener('submit', function(event) {
            // Empêche le comportement par défaut du formulaire (rafraîchissement de la page)
            event.preventDefault();

            // Récupère les données du formulaire
            const formData = new FormData(event.target);

            // Convertit les données du formulaire en objet JavaScript
            const commandeObject = {};
            formData.forEach((value, key) => {
                commandeObject[key] = value;
            });

            // Convertit l'objet JavaScript en chaîne JSON
            const commandeJson = JSON.stringify(commandeObject, null, 2);

            // Enregistre la chaîne JSON dans un fichier
            const blob = new Blob([commandeJson], { type: 'application/json' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'commande.txt';
            a.click();
        });
        </script>
    <p id="message"></p>
    <script src="script.js"></script>
</div>