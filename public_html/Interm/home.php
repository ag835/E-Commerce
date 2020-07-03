<?php
include("header.php");

?>
<h4>Home</h4>
<style>
    body {
        background-image: url('signs.png');
        background-repeat: no-repeat;
        background-size: cover;
    }
</style>

<?php
echo "Hello, " . $_SESSION["user"]["email"];
?>

