<?php $title = "Panier";?>

<div class="container">
<br>
<h4>Votre Panier :</h4><br>

<?php

$path = 'assets/utilisateurs.json';
$jsonString = file_get_contents($path);
$jsonData = json_decode($jsonString, true);
//var_dump($jsonData);

echo '<table class="table container mt-6">';
echo '<thead>';
echo "<tr><th>🗑️</th><th>Nombre de viande(s) :</th><th>Viande(s) :</th><th>Livraison :</th><th>Frites :</th><th>Boisson :</th></tr>";
echo '</thead>';

$compteur = 0;
foreach ($jsonData as $key => $value) {
    if ($_SESSION['idf'] == $jsonData[$key]['username']){
        if(isset($_POST[$compteur])){
        echo "<div class='alert alert-success alert-dismissible fade show'>
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
        <strong>C'est bon !</strong> Le rôle de l'utilisateur a été modifié
        </div>";
    }

        if(isset($_GET['supprimer']) && $_GET['supprimer'] != ''){
            if ($value['username'] == $_GET['supprimer']){
                unset($jsonData[$key]['commande']);
                continue;
            }
        }

        if (isset($jsonData[$key]['commande'])){

            $viandes = implode(" ,",$jsonData[$key]['commande']['viandes']);

            echo "<tbody>";
            echo "<tr>";
            echo '<td><a style="text-decoration:none" href="index.php?supprimer='.$value['username'].'">❌</a></td>';
            
            echo "<td>".$jsonData[$key]['commande']['nb_viandes']."</td>";
            echo "<td>".$viandes."</td>";
            echo "<td>".$jsonData[$key]['commande']['manger']."</td>";
            echo "<td>".$jsonData[$key]['commande']['frites']."</td>";
            echo "<td>".$jsonData[$key]['commande']['boisson']."</td>";
            echo '<td>
            </td></tr>';
        }
    }

    $compteur ++;
}
$data = json_encode($jsonData, JSON_PRETTY_PRINT);
file_put_contents($path, $data);
echo "</tbody>";
echo '<table>';

?>

</div>