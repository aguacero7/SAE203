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
    $pagesAlias = User::$pagesAlias;
    ob_start(); ?>

    <div class="container mt-3">
    <div class="d-flex justify-content-between align-items-center">
            <h1>Gestion des groupes</h1>
            <button class="btn btn-primary" onclick="createGroup()">Créer un groupe</button>
        </div>
        <h3 class="mb-4">Sélectionnez des catégories du site à interdire à certains groupes</h3>
        <div class="row" id="groupCardsContainer">
            <?php
            $json = file_get_contents("../assets/tempgroups.json");
            $groupData = json_decode($json, true);
            
            foreach ($groupData as $groupName => $groupDetails) {
                ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title"><?php echo $groupName; ?></h5>
                                <?php if ($groupName !== 'SuperUtilisateur') { ?>
                                    <button class="btn btn-danger btn-sm" onclick="deleteGroup('<?php echo $groupName; ?>')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                <?php } ?>
                            </div>
                            <ul class="list-group" id="<?php echo $groupName; ?>Categories">
                                <?php
                                if ($groupName === 'SuperUtilisateur') {
                                    echo "<li class='list-group-item'>Aucune interdiction pour ce groupe</li>";
                                } else {
                                    foreach ($pagesAlias as $category => $pages) {
                                        $isChecked = in_array($category, $groupDetails['categories_interdites']) ? 'checked' : '';
                                        $isDisabled = $isChecked ? 'checked' : '';
                                        echo "<li class='list-group-item'>
                                                <input type='checkbox' class='category-checkbox' data-group='$groupName' data-category='$category' $isChecked $isDisabled> $category
                                              </li>";
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.category-checkbox');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const group = this.getAttribute('data-group');
                const category = this.getAttribute('data-category');
                const action = this.checked ? 'add' : 'remove';

                fetch('c_admin_groups.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        action: action,
                        group: group,
                        category: category
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {}
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });
    });

    function deleteGroup(groupName) {
        if (confirm(`Etes vous sur de vouloir supprimer le groupe ?: ${groupName}?`)) {
            fetch('c_admin_groups.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    action: 'deleteGroup',
                    group: groupName
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(`Group ${groupName} supprimé`);
                    location.reload(); 
                } else {
                    alert(`Failed to delete group ${groupName}.`);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    }
    function createGroup() {
        const groupName = prompt("Entrez le nom du nouveau groupe:");
        if (groupName) {
            fetch('c_admin_groups.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    action: 'createGroup',
                    group: groupName
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(`Group ${groupName} created successfully!`);
                    location.reload(); 
                } else {
                    alert(`Failed to create group ${groupName}.`);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    }
    </script>

    <?php
    return ob_get_clean();
}

    


}

