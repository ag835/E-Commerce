<?php
session_start();
echo "Hello, " . $_SESSION["user"]["email"];
?>
<a href="logout.php">Logout</a>