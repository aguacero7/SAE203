<?php
function renderPage()
{
    ob_start();
    $tab = json_decode(file_get_contents('../assets/stocks.json'), true);
    $g = 1;
    $cate = 'rr';
    for($i=0;$i<count($tab);$i++){
      if($cate != $tab[$i]["catégorie"] and $g!=1){
        echo '</tbody>
          </table>';
      }
      if($cate != $tab[$i]["catégorie"]){
        $cate = $tab[$i]["catégorie"];
        $g+=1;
      echo '
      <div style="text-align:center">
        </br><h2>'.$tab[$i]["catégorie"].'</h2></br>
      </div>
    <table class="table">
      <thead class="table-dark">
        <tr>
          <th scope="col">Plats</th>
          <th scope="col">Quantité restante</th>
          <th scope="col">prix</th>
        </tr>
      </thead>
      <tbody>';
      }
      echo '
      <tr>
        <td>'.$tab[$i]["username"].'</td>
        <td>'.$tab[$i]["quantite"].'</td>
        <td>'.$tab[$i]["prix"].'</td>
      </tr>';
    }
    echo '</tbody>
    </table>';

    $content = ob_get_clean();
    return $content;
}