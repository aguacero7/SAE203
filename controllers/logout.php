<?php
session_start();
session_unset();
session_destroy();
header("location: ../models/login.php");
echo json_encode(["success" => true]);
exit;
