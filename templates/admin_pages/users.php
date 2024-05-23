<?php
class VueAdminUsers extends VueAdminPanel
{
    public $content;
    private $user_list;
    private $groupe;
    public function __construct($groupe)
    {

        if($groupe =="all"){
            $this->user_list = User::tmp_load_all();
            $this->groupe="Tous";}
        else{
            if(!in_array($groupe,User::load_all_grp())){
                $this->user_list = User::tmp_load_all();
                $this->groupe="Tous";
            }
            else{
                $this->user_list = User::tmp_load_by_grp($groupe);
                $this->groupe=$groupe;
            }
        }
        $this->content = $this->renderPage();
        parent::__construct("users");
    }
    private function renderPage()
    {
        ob_start(); ?>

        <div class="container mt-3">
            <h1 class="mb-4">Gestion des utilisateurs</h1>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <label for="search" class="col-form-label text-md-end">Chercher un utilisateur :</label>
                    <input type="text" id="search" class="form-control" placeholder="Recherche par username">
                </div>
                <div class="col-md-6">
            <form id="groupFilterForm">
                <label for="groupFilter" class="col-form-label text-md-end me-2">Filtrer par groupe :</label>
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="groupFilterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <?=$this->groupe?>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="groupFilterDropdown">
                        <li><a class="dropdown-item" href="#" onclick="document.getElementById('groupInput').value = 'all'; document.getElementById('groupFilterForm').submit();">Tous</a></li>
                        <?php foreach (User::tmp_load_all_grp() as $group) : ?>
                            <li><a class="dropdown-item" href="#" onclick="document.getElementById('groupInput').value = '<?= htmlspecialchars($group) ?>'; document.getElementById('groupFilterForm').submit();"><?= htmlspecialchars($group) ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <input type="hidden" id="action" name="action" value="users">
                <input type="hidden" id="groupInput" name="group">
            </form>
        </div>
                <button class="btn btn-primary" onclick="ajouterUtilisateur()">
                    <i class="fa-solid fa-user-plus"></i> Ajouter utilisateur
                </button>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Nom entier</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Age</th>
                                <th>Groupes</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($this->user_list as $user) : ?>
                                <tr>
                                    <td><img src="../assets/pfp/<?= htmlspecialchars($user->pfp) ?>" class="img-fluid" alt="Profile Picture" width="50px"></td>
                                    <td><?= htmlspecialchars($user->fullname) ?></td>
                                    <td><?= htmlspecialchars($user->username) ?></td>
                                    <td><?= htmlspecialchars($user->email) ?></td>
                                    <td><?= htmlspecialchars($user->age) ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="groupDropdown<?= $user->username ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                                Groupes
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="groupDropdown<?= $user->username ?>">
                                                <?php foreach (User::tmp_load_all_grp() as $group) : ?>
                                                    <li>
                                                        <div class="form-check">
                                                            <label class="form-check-label" for="<?= $user->username ?>_<?= htmlspecialchars($group) ?>"><?= htmlspecialchars($group) ?></label>

                                                            <input class="form-check-input" type="checkbox" id="<?= $user->username ?>_<?= htmlspecialchars($group) ?>" <?= in_array($group, $user->groupes) ? 'checked' : '' ?>>
                                                        </div>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>


                                    </td>

                                    <td>
                                        <button class="btn btn-outline-primary btn-sm" onclick="editUser('<?= $user->username ?>')">
                                            <i class="fa-solid fa-user-pen"></i>
                                        </button>
                                        <button class="btn btn-outline-danger btn-sm" onclick="deleteUser('<?= $user->username ?>')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
<?php
        return ob_get_clean();
    }
}
