<?php ob_start();?>
<a href="../controllers/logout.php">Logout</a>
<?php print_r(json_decode($_SESSION["user"]));?>
<?php $content = ob_get_clean(); ?>
