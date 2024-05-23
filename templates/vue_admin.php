<?php
class VueAdminPanel
{
    public $tabs_html;
    protected $content;

    private function renderBody($activeTab)
    {
        ob_start();
?>
        <div class="container ">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="text-center mb-0">Administration</h1>
                <div class="d-flex">
                    <button class="btn btn-outline-secondary me-2 ml-auto" onclick="cancelChanges()">
                        <i class="fas fa-arrow-left"></i> Annuler changements
                    </button>
                    <button class="btn btn-success mr-auto" onclick="applyChanges()">
                        Sauvegarder & Appliquer
                    </button>
                </div>
            </div>
            <ul class="nav nav-tabs" id="adminTab">
                <li class="nav-item">
                    <a class="nav-link <?php if ($activeTab === 'users') echo 'active'; ?>" id="users-tab" data-toggle="tab" href="?action=users" role="tab" aria-controls="users" aria-selected="<?php echo $activeTab === 'users' ? 'true' : 'false'; ?>">Gestion des utilisateurs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if ($activeTab === 'groups') echo 'active'; ?>" id="groups-tab" data-toggle="tab" href="?action=groups" role="tab" aria-controls="groups" aria-selected="<?php echo $activeTab === 'groups' ? 'true' : 'false'; ?>">Gestion des groupes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if ($activeTab === 'logs') echo 'active'; ?>" id="logs-tab" data-toggle="tab" href="?action=logs" role="tab" aria-controls="logs" aria-selected="<?php echo $activeTab === 'logs' ? 'true' : 'false'; ?>">Visualisation des logs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-secondary <?php if ($activeTab === 'files') echo 'active'; ?>" id="files-tab" onclick="alert('todo')" data-toggle="tab" href="?action=files" role="tab" aria-controls="files" aria-selected="<?php echo $activeTab === 'files' ? 'true' : 'false'; ?>">Gestion des fichiers</a>
                </li>

            </ul>
            <?= $this->content ?>
        </div>
<?php
        return ob_get_clean();
    }
    protected function __construct($tab)
    {
        $this->tabs_html = $this->renderBody($tab);
    }
}
