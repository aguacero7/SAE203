<?php
$users_json = file_get_contents("../assets/utilisateurs.json");
$users = json_decode($users_json, true);


// Get all unique groups
$groups=User::load_all_grp();


function generateCard($user)
{
    ob_start(); ?>
    <div class="card ml-2 d-flex" style="width:200px; position: relative;" id="<?= $user["fullname"] ?>">
        <div class="card-img-wrapper">
            <img class="card-img-top" src="../assets/pfp/<?= $user["pfp"] ?>" alt="<?= $user["fullname"] ?>">
        </div>
        <div class="card-body">
            <h4 class="card-title"><?= $user["fullname"] ?></h4>
            <h6 class="card-text">Contact:</h6>
            <p class="card-text"><?= $user["contact"] ?></p>
            <p class="card-text"><?= User::calculateAge($user["birthday"]) ?> ans</p>
        </div>
    </div>
    <style>
.card-img-wrapper {
    width: 100%;
    height: 210px; /* Hauteur fixe pour toutes les images */
    overflow: hidden; /* Pour s'assurer que les images ne débordent pas */
}

.card-img-top {
    width: 100%; /* Largeur de 100% pour s'adapter à la carte */
    height: 100%; /* Hauteur de 100% pour remplir la boîte du conteneur */
    object-fit: cover; /* Pour ajuster l'image sans déformation */
}
</style>
    <?php return ob_get_clean();
}


//-------------------------------------------------------------------Sort by group part-------------------------------------//
$all_groups = User::load_all_grp(); // Utilisation de la fonction pour récupérer tous les groupes

if(isset($get["group"])){
    $group_input = $get['group'];
}

if (isset($group_input) && (in_array($group_input, $all_groups) || $group_input == "all")) {
    $sorted_users = [];
    if ($group_input == "all") {
        $sorted_users = $users;
    } else {
        foreach ($users as $user) {
            if (in_array($group_input, $user["groupes"])) {
                array_push($sorted_users, $user);
            }
        }
    }
    
    $all_cards = array_map("generateCard", $sorted_users);
}
//-------------------------------------------------------------------END Sort by group part-------------------------------------//
else {
    $all_cards = array_map("generateCard", $users);

}


