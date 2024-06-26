<?php

function generate_hashed_password() {
    return password_hash('motdepasse', PASSWORD_DEFAULT);
}

$users_json = file_get_contents('../assets/utilisateurs.json');
$users = json_decode($users_json, true);

$groupes = ["Dirigeant","Manager","Salarie","Comptable"];
$prenoms = ['Jean', 'Paul', 'Marie', 'Pierre', 'Luc','Yassine','Noé', 'Sophie', 'Alice', 'Antoine','Arda','Bruno','Omer','Homer', 'Julie', 'Alexandre', 'Nicolas', 'Isabelle', 'Christophe', 'Emilie', 'François','Mathilde',"Alice",'Jeanne','Marie', 'Valérie', 'Thomas', 'Catherine', 'Martin', 'Elise'];
$noms = ['Dubois',"Malherre",'Fernandes','Garnacho','Ronaldo','Yilmaz', 'Martin', 'Bernard', 'Thomas', 'Petit','Mbappe', 'Robert','Simpsons', 'Richard', 'Durand', 'Leroy', 'Moreau', 'Simon', 'Laurent', 'Lefebvre', 'Michel', 'Garcia', 'David', 'Bertrand', 'Roux', 'Vincent', 'Fournier'];

$question = ['mere','plat','voiture'];
$plat = ['ratatouille','pizza','hamburger','tacos','kebab','poutine']; 
$mere = ['Dupont','Martin','Bernard','Ronaldo','Messi'];
$voiture = ['Aventador','Urus','Supra','Scenic','Fiesta','C1','Ami'];
$question = ['mere','plat','voiture'];

$answer_mere = ['Dupont','Martin','Dubois','Thomas','Robert','Richard'];
$answer_plat = ['hamburger','pizza','tacos','fajitas','galette','putin'];
$answer_voiture = ['Toyota','Citroen','Mercedes','Lamborghini','Porsche','Fiat'];

function generate_username($prenom, $nom) {
    $prenom = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $prenom);
    $nom = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $nom);

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
function generateRandomBirthday() {
    $currentYear = date('Y');
    
    $earliestYear = $currentYear - 65;
    $latestYear = $currentYear - 17;
    
    $randomYear = rand($earliestYear, $latestYear);
    
    $randomMonth = rand(1, 12);
    $randomDay = rand(1, 28);
    
    $randomDate = sprintf('%04d-%02d-%02d', $randomYear, $randomMonth, $randomDay);
    
    return $randomDate;
}



for($i=0;$i<50;$i++){
    $random_question = $question[array_rand($question)];

    if ($random_question == 'mere'){
        $random_answer = $mere[array_rand($mere)];
    }
    elseif ($random_question == 'plat'){
        $random_answer = $plat[array_rand($plat)];
    }
    elseif ($random_question == 'voiture'){
        $random_answer = $voiture[array_rand($voiture)];
    }

    $random_prenom = $prenoms[array_rand($prenoms)];
    $random_nom = $noms[array_rand($noms)];
    $username = generate_username($random_prenom, $random_nom);
    $hashed_password = generate_hashed_password();

    $random_question = $question[array_rand($question)];

    if ($random_question == 'mere'){
        $random_answer = $answer_mere[array_rand($answer_mere)];
    }
    elseif ($random_question == 'plat'){
        $random_answer = $answer_plat[array_rand($answer_plat)];
    }
    elseif ($random_question == 'voiture'){
        $random_answer = $answer_voiture[array_rand($answer_voiture)];
    }


    do {                //verifier le n° de contact
         $contact = mt_rand(100, 999);
    } while (contact_exists($contact, $users));

            
    $user_groupes = ["Salarie"]; // Par défaut
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
        "question" => $random_question,
        "answer" => $random_answer,
        "pfp" => "default.png",
        "contact" => mt_rand(100, 999),
        "birthday" => generateRandomBirthday()
    ];

    
    array_push($users,$new_user);
}
file_put_contents('../assets/utilisateurs.json', json_encode($users, JSON_PRETTY_PRINT));

echo "Les nouveaux utilisateurs ont été générés avec succès.";
