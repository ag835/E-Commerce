<?php
include("header.php");

?>

<h1>Profile</h1>

<h3><?php echo $_SESSION["user"]["username"];?></h3>
<hr>
<h3>Past Orders</h3>
<p>TBD</p>
<br>
<h3>Edit Profile</h3>
<p>Email: <?php echo $_SESSION["user"]["email"];?></p>
<p>Username: <?php echo $_SESSION["user"]["username"];?></p>
<p>Change Password</p>
