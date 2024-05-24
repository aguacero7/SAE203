<?php

class VueAdminGroups extends VueAdminPanel
{
    public $content;
    private $group_list;
    public function __construct()
    {
        $this->group_list = $this->loadGroupsFromJson();
        $this->content = $this->renderPage();
        parent::__construct("groups");
    }

    private function loadGroupsFromJson()
    {
        $json_file = '../assets/groups.json';  
        if (file_exists($json_file)) {
            $json_data = file_get_contents($json_file);
            return json_decode($json_data, true);
        } else {
            return [];  
        }
    }

    private function renderPage()
    {
        ob_start(); ?>
    
        <div class="container mt-3">
            <h1 class="mb-4">Gestion des groupes</h1>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <button class="btn btn-success" onclick="addGroup()"><i class="fas fa-plus"></i></button>
            </div>
            <div class="row" id="groupCardsContainer">
                <?php
                // Récupérer et décoder le JSON
                $json = file_get_contents("../assets/tempgroups.json");
                $groupData = json_decode($json, true);
    
                // Générer le code HTML pour chaque groupe
                foreach ($groupData as $groupName => $groupDetails) {
                    ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $groupName; ?></h5>
                                <ul class="list-group" id="<?php echo $groupName; ?>Categories">
                                    <?php
                                    // Afficher les catégories interdites
                                    foreach ($groupDetails['categories_interdites'] as $category) {
                                        echo "<li class='list-group-item'>$category <button class='btn btn-sm btn-danger' onclick='deleteCategory(\"$groupName\", \"$category\")'><i class='fas fa-trash'></i></button></li>";
                                    }
                                    ?>
                                </ul>
                                <?php
                                // Afficher le champ d'entrée pour ajouter une catégorie interdite
                                if ($groupName !== 'SuperUser') {
                                    echo "<div class='input-group mt-2'>
                                            <input type='text' class='form-control' id='$groupName" . "CategoryInput' placeholder='Nouvelle catégorie'>
                                            <div class='input-group-append'>
                                                <button class='btn btn-primary' onclick='addCategory(\"$groupName\")'><i class='fas fa-plus'></i></button>
                                            </div>
                                        </div>";
                                }
                                ?>
                                <?php
                                ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    
        <script>
            function addCategory(groupName) {
                // Récupérer la nouvelle catégorie interdite
                var newCategory = document.getElementById(groupName + "CategoryInput").value;
                if (newCategory.trim() !== "") {
                    // Envoyer une requête AJAX pour ajouter la nouvelle catégorie interdite
                    fetch("../controllers/c_admin_groups", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            group: groupName,
                            category: newCategory
                        })
                    }).then(response => {
                        // Actualiser la page si nécessaire
                        if (response.ok) {
                            window.location.reload();
                        }
                    }).catch(error => console.error('Erreur lors de l\'ajout de la catégorie:', error));
                }
            }
    
            function deleteCategory(groupName, category) {
                // Envoyer une requête AJAX pour supprimer la catégorie interdite
                fetch("../controllers/c_admin_groups", {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        group: groupName,
                        category: category
                    })
                }).then(response => {
                    // Actualiser la page si nécessaire
                    if (response.ok) {
                        window.location.reload();
                    }
                }).catch(error => console.error('Erreur lors de la suppression de la catégorie:', error));
            }
    
            function addGroup() {
                // Code pour ajouter un groupe via AJAX
            }
    
            function deleteGroup(groupName) {
                // Code pour supprimer un groupe via AJAX
            }
        </script>
    
        <?php
        return ob_get_clean();
    }


}

