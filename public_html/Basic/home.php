<?php
include("header.php");

?>
<h4>Home</h4>
<style>
    body {
        background-image: url('andromeda.jpg');
        background-size:auto;
    }
</style>

<?php
echo "Hello, " . $_SESSION["user"]["email"];
?>

