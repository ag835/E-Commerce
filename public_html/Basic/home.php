<?php
include("header.php");

?>
<h4>Home</h4>
<style>
    body {
        background-image: url('bigbang.jpg');
    }
</style>

<?php
echo "Hello, " . $_SESSION["user"]["email"];
?>

