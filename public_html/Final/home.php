<?php
include("header.php");

?>
<h1>Home</h1>
<style>
    body {
        background-image: url('signs.png');
        background-repeat: no-repeat;
        background-size: cover;
    }
</style>

<?php
echo "Hello, " . $_SESSION["user"]["username"];
?>

