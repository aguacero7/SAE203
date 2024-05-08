<?php ob_start(); ?>
<div class="container-fluid">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Annuaire des salariés</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Trier par groupe
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="../models/organization_chart.php?group=all">Tous</a></li>
                        <?php foreach ($groups as $key => $groupe) {
                            echo '<li><a class="dropdown-item" href="../models/organization_chart.php?group='.$groupe.'" >' . $groupe . '</a></li>';
                        }
                        ?>
                    </ul>
                </li>
            </ul>
        </div>
        <form class="form-inline my-2 my-lg-0">
            <div class="input-group ml-auto">
                <span class="input-group-text">@</span>
                <input class="form-control mr-sm-2" type="search" placeholder="Rechercher par nom" aria-label="Search"
                    id="searchInput" oninput="searchUser(this.value)">
            </div>
        </form>
</div>
</nav>

<div id="searchResults" class="mt-3"></div>

<div id="cards-container" class="row">
    <?php foreach ($all_cards as $card) { ?>
        <div class="col mb-4"><?php echo $card; ?></div>
    <?php } ?>
</div>
</div>
<?php
$content = ob_get_clean();
?>