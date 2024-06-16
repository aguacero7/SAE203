<?php
session_start();

include 'functions.php';
head();
nav();
?>

<div class="jumbotron bg-danger jumbotron-fluid text-center text-white p-3">
<h2><kbd>Infos du site :</kbd></h2>
</div>
<br>

<div class="container">
    <p>Page <a href="index.php">index.php</a> :</p>
    <ul>
        <li>Formulaire, sous forme modal, permettant de se connecter au site en utilisant un nom d’utilisateur et un
        mot de passe et qui vérifie la validité des champs avec les données disponibles dans le fichier « utilisateurs.json » déjà
        fourni sur Moodle (affiche une erreur si non correspondance).
        </li>
        <br>
        <li>Un bouton « se connecter » sur l’entête de la page d’accueil permet de faire apparaître les différentes
        options : « se connecter » pour les utilisateurs déjà inscrits, « s’inscrire » ou juste visiter pour avoir un accès limité
        aux annonces en tant qu’utilisateur anonyme (affiche l'utilisateur connecté à droite du bouton connexion).
        </li>
        <br>
        <li>
            Liste des fonctions utilisées : 
        </li>
        <ul>
            <li>head()</li>
            <li>nav()</li>
            <li>foot()</li>
        </ul>
    </ul>
    <p>Page <a href="inscription.php">inscription.php</a> :</p>
    <ul>
        <li>Formulaire présent dans le modal de la page de connexion.
        </li>
        <br>
        <li>Formulaire permettant de déclarer les éléments nécessaires au profil, pseudo (unique, affichage d'une erreur si déjà utilisé), le type de véhicule, l’adresse email, mot de passe (champ de confirmation du mot de passe) et rôle (ne peut être changé que par l'admin).
        </li>
        <br>
        <li>
            Liste des fonctions utilisées : 
        </li>
        <ul>
            <li>head()</li>
            <li>nav()</li>
            <li>foot()</li>
        </ul>
    </ul>
    <p>Page <a href="administrer.php">administrer.php</a> :</p>
    <ul>
        <li> Formulaire permettant à l’admin de modifier le rôle (sous forme de radio avec validation pour éviter les fausses manip'), ou d’effacer l’utilisateur (avec ❌).
        </li>
        <br>
        <li>
            Liste des fonctions utilisées : 
        </li>
        <ul>
            <li>head()</li>
            <li>nav()</li>
            <li>administration() => gestion des droits de chaques compte et accessibles que par l'admin</li>
            <li>foot()</li>
        </ul>
    </ul>
    <p>Boutton <b>déconnexion.php</b> :</p>
    <ul>
        <li> Fichier permettant la redirection vers index.php dès lors que la SESSION est lancée.
        </li>
        <li> Le lien est présent en haut de chaque page et actif uniquement si une session avec un utilisateur enregistré existe.
        </li>
    </ul>
    <p>Page <a href="profil.php">profil.php</a> :</p>
    <ul>
        <li> Un utilisateur peut changer ou ajouter un véhicule, pseudo, email ...
        </li>
        <br>
        <li>
            Liste des fonctions utilisées : 
        </li>
        <ul>
            <li>head()</li>
            <li>nav()</li>
            <li>foot()</li>
        </ul>
    </ul>
    <p>Page <a href="annonces.php">annonces.php</a> :</p>
    <ul>
        <li>  Formulaire pour créer une annonce qui contient les champs : date départ, heure, ville départ, ville arrivée,
places disponibles, une zone de commentaire libre.
        </li>
        <li>
        La structure de données contient aussi les pseudos des utilisateurs déjà inscrits sur ce voyage. 
        </li>
        <li>
        Message de confirmation affiché puis l’utilisateur peut poster une deuxième annonce.
        </li>
        <br>
        <li>
            Liste des fonctions utilisées : 
        </li>
        <ul>
            <li>head()</li>
            <li>nav()</li>
            <li>annonces() => permet de gérer le droit d'accès aux annonces (annonymous = pas d'accès aux pseudos ni aux dates ; user et modo = peuvent ajouter une annonce ; admin = peut supprimer annonces)</li>
            <li>foot()</li>
        </ul>
    </ul>
    <br>
    <p>Gestion des sessions & utilisateurs pris en compte :</p>
    <ol>
        <li>
        <b>Visiteur anonyme</b> : une session sans mot de passe ni identifiant (« anonymous » par défaut) est
automatiquement ouverte. On peut alors simplement consulter la page « Annonces » pour voir les
annonces existantes. Certains détails ne seront pas alors lisibles : pseudo du post, et date.
        </li>
        <br>
        <li><b>Utilisateur enregistré</b> : un lien permet de faire apparaître un modal de connexion ou d’inscription
(page spécifique inscription) et alors on devient automatiquement utilisateur enregistré. Ce type
d’utilisateur a la possibilité de voir toutes les annonces sans restriction, et d’en proposer lui-même.
        </li>
        <br>
        <li><b>Modérateur</b> : cet utilisateur peut supprimer les annonces
        </li>
        <br>
        <li><b>Administrateur</b> : accès à la page « Administrer », essentiellement l’affichage des utilisateurs et la
possibilité de modifier leur rôle (jusque modérateur) et les effacer
        </li>
    </ol> 
</div>

<?php
foot();
?>
