<?php
session_start();
session_destroy();
header('Location: admin_login.php'); // Or user_login.php depending on the context
exit;
?>
