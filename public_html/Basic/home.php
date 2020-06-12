<?php
include("header.php");

?>
<h4>Home</h4>
<style>
    body {
        background-image: url('andromeda.jpg');
        background-repeat: no-repeat;
        background-size: 300px 100px;
    }
</style>

<?php
echo "Hello, " . $_SESSION["user"]["email"];
?>

