<?php
include_once(__DIR__."/partials/header.partial.php");
if(Common::is_logged_in()):?>
<style>
   body {
        background-color: black;
        color: aliceblue;
    }
</style>

<h1>Profile</h1>

<h3><?php echo $_SESSION["user"]["username"];?>'s Profile</h3>
    <h5>Joined: <?php echo $_SESSION["user"]["created"];?></h5>
<hr>
    <h3>Library:</h3>
    <p>TBD</p>
    <hr>
<br>
<h3>User Details</h3>
<p>Email: <?php echo $_SESSION["user"]["email"];?></p>
<p>Username: <?php echo $_SESSION["user"]["username"];?></p>
<p>Location: <?php echo $_SESSION["user"]["country"];?></p>

<?php endif;?>