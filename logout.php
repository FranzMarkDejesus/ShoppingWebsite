<?php
// This is entirely for logout purposes that is used in different parts of the pages
session_start();
session_destroy();
header("Location: login.php");
exit();
?>
