<?php ob_start(); ?>
<div class="bg-success text-white">
    <nav class="navbar navbar-expand-lg navbar-light bg-dark">
        <a class="navbar-brand text-white" href="#">Big K</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link text-white " href="#">Menu <span class="sr-only"></span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Localisation</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="panier.php">Panier</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h1 class="text-center my-5">Le Big K</h1>
        <p class="text-center mb-5">Notre numéro de téléphone : 01 23 45 67 89</p>

        <h2 class="text-center my-5">Menu</h2>
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
</div>
            </div>
        </div>
        <div class="container bg-dark text-white">        
        <h2 class="text-center my-5">Localisation</h2>
        
        <div class="embed-responsive embed-responsive-16by9">
        <iframe class="embed-responsive-item w-100" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1234.5678901234567!2d-1.987174!3d48.6582371!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x480e8349143218df:0xfb5a23e824f9e950!2sBig+K!5e0!3m2!1sfr!2sfr!4v1671234567890!5m2!1sfr!2sfr" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>        </div>
        </div>
        </div>
</div>
<?php $content = ob_get_clean(); ?>