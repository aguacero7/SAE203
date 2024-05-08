<?php

function generate_hashed_password() {
    return password_hash('motdepasse', PASSWORD_DEFAULT);
}

$users_json = file_get_contents('../assets/utilisateurs.json');
$users = json_decode($users_json, true);

$groupes = ["admin","manager","comptable","dirigeant"];
$prenoms = ['Jean', 'Paul', 'Marie', 'Pierre', 'Luc', 'Sophie', 'Alice', 'Antoine', 'Julie', 'Alexandre', 'Nicolas', 'Isabelle', 'Christophe', 'Emilie', 'François', 'Valérie', 'Thomas', 'Catherine', 'Martin', 'Elise'];
$noms = ['Dubois', 'Martin', 'Bernard', 'Thomas', 'Petit', 'Robert', 'Richard', 'Durand', 'Leroy', 'Moreau', 'Simon', 'Laurent', 'Lefebvre', 'Michel', 'Garcia', 'David', 'Bertrand', 'Roux', 'Vincent', 'Fournier'];

function generate_username($prenom, $nom) {

    $random_number = mt_rand(10, 95);
    return strtolower($prenom) . strtolower($nom) . $random_number;
}
function contact_exists($contact, $users) {
    foreach ($users as $user) {
        if ($user["contact"] == $contact) {
            return true;
        }
    }
    return false;
}

for($i=0;$i<50;$i++){
    $random_prenom = $prenoms[array_rand($prenoms)];
    $random_nom = $noms[array_rand($noms)];
    $username = generate_username($random_prenom, $random_nom);
    $hashed_password = generate_hashed_password();


    do {                //verifier le n° de contact
         $contact = mt_rand(100, 999);
    } while (contact_exists($contact, $users));

            
    $user_groupes = ["salarie"]; // Par défaut
    $random_group_count = mt_rand(1, 3);
    $random_groupes = array_rand(array_flip($groupes), $random_group_count); //prendre entre 1 et 3 grp au hasard
    if (is_array($random_groupes)) {
        foreach ($random_groupes as $groupe) {
            $user_groupes[] = $groupe;
        }
    } else {
        $user_groupes[] = $random_groupes;
    }

    $new_user = [
        "password" => $hashed_password,
        "email" => $random_prenom . '.' . $random_nom . '@bigk.fr',
        "groupes" => $user_groupes,
        "username" => $username,
        "fullname" => $random_prenom . ' ' . $random_nom,
        "pfp" => "default.png",
        "contact" => mt_rand(100, 999),
        "age" => mt_rand(18, 65)
    ];

    
    array_push($users,$new_user);
}
file_put_contents('../assets/utilisateurs.json', json_encode($users, JSON_PRETTY_PRINT));

echo "Les nouveaux utilisateurs ont été générés avec succès.";
