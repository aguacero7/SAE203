
<?php
class VueAdmin {

    public static function renderPage($activeTab) {
        ob_start();
        ?>
        <div class="container mt-5">
            <h1 class="text-center mb-4">Administration</h1>
            <ul class="nav nav-tabs" id="adminTab" >
                <li class="nav-item">
                    <a class="nav-link <?php if($activeTab === 'users') echo 'active'; ?>" id="users-tab" data-toggle="tab" href="?action=users" role="tab" aria-controls="users" aria-selected="<?php echo $activeTab === 'users' ? 'true' : 'false'; ?>">Gestion des utilisateurs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($activeTab === 'groups') echo 'active'; ?>" id="groups-tab" data-toggle="tab" href="?action=groups" role="tab" aria-controls="groups" aria-selected="<?php echo $activeTab === 'groups' ? 'true' : 'false'; ?>">Gestion des groupes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($activeTab === 'logs') echo 'active'; ?>" id="logs-tab" data-toggle="tab" href="?action=logs" role="tab" aria-controls="logs" aria-selected="<?php echo $activeTab === 'logs' ? 'true' : 'false'; ?>">Visualisation des logs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-secondary <?php if($activeTab === 'files') echo 'active'; ?>" id="files-tab" onclick="alert('todo')" data-toggle="tab" href="?action=files" role="tab" aria-controls="files" aria-selected="<?php echo $activeTab === 'files' ? 'true' : 'false'; ?>">Gestion des fichiers</a>
                </li>
            </ul>

        </div>
        <?php
        return ob_get_clean();
    }
    private static function renderUsers() {
        ob_start();
        
        return ob_get_clean();
    }

    private static function renderLogs() {
        ob_start();
        // Générer le contenu HTML pour la visualisation des logs
        // ...
        return ob_get_clean();
    }

    private static function renderGroups() {
        ob_start();
        // Générer le contenu HTML pour la gestion des groupes
        // ...
        return ob_get_clean();
    }

    private static function renderFiles() {
        ob_start();
        // Générer le contenu HTML pour la gestion des fichiers
        // ...
        return ob_get_clean();
    }
}