<?php
class VueAdminUsers extends VueAdminPanel
{
    public $content;
    private $user_list;
    private $groupe;
    public function __construct($groupe)
    {

        if ($groupe == "all") {
            $this->user_list = User::tmp_load_all();
            $this->groupe = "Tous";
        } else {
            if (!in_array($groupe, User::tmp_load_all_grp())) {
                $this->user_list = User::tmp_load_all();
                $this->groupe = "Tous";
            } else {
                $this->user_list = User::tmp_load_by_grp($groupe);
                $this->groupe = $groupe;
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
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="groupFilterDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <?= $this->groupe ?>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="groupFilterDropdown">
                                <li><a class="dropdown-item" href="#"
                                        onclick="document.getElementById('groupInput').value = 'all'; document.getElementById('groupFilterForm').submit();">Tous</a>
                                </li>
                                <?php foreach (User::tmp_load_all_grp() as $group): ?>
                                    <li><a class="dropdown-item" href="#"
                                            onclick="document.getElementById('groupInput').value = '<?= htmlspecialchars($group) ?>'; document.getElementById('groupFilterForm').submit();"><?= htmlspecialchars($group) ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <input type="hidden" id="action" name="action" value="users">
                        <input type="hidden" id="groupInput" name="group">
                    </form>
                </div>
                <button class="btn btn-primary" onclick="addUser()">
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
                            <?php foreach ($this->user_list as $user): ?>

                                <tr>
                                    <td><img src="../assets/pfp/<?= htmlspecialchars($user->pfp) ?>" class="img-fluid"
                                            alt="Profile Picture" width="50px"></td>
                                    <td><?= htmlspecialchars($user->fullname) ?></td>
                                    <td><?= htmlspecialchars($user->username) ?></td>
                                    <td><?= htmlspecialchars($user->email) ?></td>
                                    <td><?= htmlspecialchars($user->age) ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                                id="groupDropdown<?= $user->username ?>" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                Groupes
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="groupDropdown<?= $user->username ?>">
                                                <?php foreach (User::tmp_load_all_grp() as $group): ?>
                                                    <li>
                                                        <div class="form-check">
                                                            <label class="form-check-label"
                                                                for="<?= $user->username ?>_<?= htmlspecialchars($group) ?>"><?= htmlspecialchars($group) ?></label>
                                                            <input class="form-check-input" type="checkbox"
                                                                onclick="updateGroup('<?= $user->username ?>', '<?= htmlspecialchars($group) ?>', this.checked)"
                                                                id="<?= $user->username ?>_<?= htmlspecialchars($group) ?>"
                                                                <?= in_array($group, $user->groupes) ? 'checked' : '' ?>>
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
                                        <button class="btn btn-outline-danger btn-sm"
                                            onclick="deleteUser('<?= $user->username ?>')">
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
        <!-- Modal -->
        <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Créer/Éditer Utilisateur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="userForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="profilePicture" class="form-label">Photo de profil</label>
                                        <div>
                                            <img id="currentProfilePicture" src="" alt="Photo de profil" class="img-thumbnail"
                                            style="width: 200px; height: 200px;">
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="profilePicture" class="form-label">Changer la photo de profil</label>
                                        <input type="file" onchange="tryPfp()" accept="image/*" class="form-control" id="profilePicture"  name="profilePicture">
                                        <small class="form-text text-muted">Il est fortement recommandé d'entrer une image carrée</small>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="fullname" class="form-label">Nom complet</label>
                                <input type="text" class="form-control" id="fullname" name="fullname"
                                    placeholder="Homer Simpsons">
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Nom d'utilisateur</label>
                                <div class="input-group">
                                    <input type="disabled" class="form-control" id="username" name="username"
                                        placeholder="homersimpsons24">
                                    <button type="button" class="btn btn-outline-secondary" onclick="genUsername()">
                                        <i class="fa-solid fa-dice"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Mot de passe</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password">
                                    <button onmousedown="seePassword()" onmouseleave="hidePassword()" onmouseup="hidePassword()"
                                        type="button" class="btn btn-outline-secondary" id="togglePassword">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                            <div class="mb-3">
                                <label for="pfp" class="form-label">Photo de profil</label>
                                <input type="text" class="form-control" id="pfp" name="pfp">
                            </div>
                            <div class="mb-3">
                                <label for="contact" class="form-label">Contact</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="contact" name="contact">
                                    <button type="button" class="btn btn-outline-secondary" onclick="genNumber()">
                                        <i class="fa-solid fa-dice"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="birthday" class="form-label">Date de naissance</label>
                                <input type="date" class="form-control" id="birthday" name="birthday">
                            </div>
                            <!-- Truc d'antoine : a demander
          <div class="mb-3">
            <label for="question" class="form-label">Question secrète</label>
            <input type="text" class="form-control" id="question" name="question">
          </div>
          <div class="mb-3">
            <label for="answer" class="form-label">Réponse secrète</label>
            <input type="text" class="form-control" id="answer" name="answer">
          </div>-->
                            <div class="mb-3">
                                <label class="form-label">Groupes</label>
                                <div>
                                    <?php foreach (User::tmp_load_all_grp() as $group): ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="<?= htmlspecialchars($group) ?>"
                                                name="groupes[]" value="<?= htmlspecialchars($group) ?>">
                                            <label class="form-check-label" for="<?= htmlspecialchars($group) ?>">
                                                <?= htmlspecialchars($group) ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <input type="hidden" id="edit" name="action">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="button" class="btn btn-primary" onclick="saveUser()">Sauvegarder</button>
                    </div>
                </div>
            </div>
        </div>


        <?php
        return ob_get_clean();
    }
}
