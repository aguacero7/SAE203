<?php
header("Location: vitrine.php");
session_start();
session_unset();
session_destroy();
?>