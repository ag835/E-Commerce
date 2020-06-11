<?php
include("header.php");

?>
<h4>Home</h4>

<?php
echo "Hello, " . $_SESSION["user"]["email"];
?>

