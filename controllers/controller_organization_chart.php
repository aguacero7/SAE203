<?php
$users_json = file_get_contents("../assets/utilisateurs.json");
$users = json_decode($users_json, true);


// Get all unique groups
$groups = [];
foreach ($users as $user) {
    $groups = array_merge($groups, $user["groupes"]);
}
$groups = array_unique($groups);


function generateCard($user)
{
    ob_start(); ?>
    <div class="card ml-2 d-flex" style="width:250px; position: relative;" id="<?= $user["fullname"] ?>">
        <img class="card-img-top" src="../assets/pfp/<?= $user["pfp"] ?>" alt="<?= $user["fullname"] ?>">
        <div class="card-body">
            <h4 class="card-title"><?= $user["fullname"] ?></h4>
            <h6 class="card-text">Contact:</h6>
            <p class="card-text"><?= $user["contact"] ?></p>
            <p class="card-text"><?= $user["age"] ?> ans</p>
        </div>
    </div>
    <?php return ob_get_clean();
}


//-------------------------------------------------------------------Sort by group part-------------------------------------//
if(isset($get["group"])){
$group_input = $get['group'];
}
if (isset($group_input) && (in_array($group_input, $groups) || $group_input == "all")) {
    $sorted_users = [];
    if ($group_input == "salaries") {
        $sorted_users = $users;
    } else {
        foreach ($users as $user) {
            if (in_array($group_input, $user["groupes"])) {
                array_push($sorted_users, $user);
            }
        }
    }
    
    $all_cards = array_map("generateCard", $sorted_users);
    
    
}//-------------------------------------------------------------------END Sort by group part-------------------------------------//
else {
    $all_cards = array_map("generateCard", $users);

}


