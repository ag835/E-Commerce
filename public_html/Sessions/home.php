<?php
session.start();
echo "Hello, " . $_SESSION["user"]["email"] #replace with account name later
?>
<a href="logout.php">Logout</a>