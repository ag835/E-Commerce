<?php
include_once(__DIR__."/partials/header.partial.php");
if(Common::is_logged_in()){
?>
<h1>Profile</h1>

<h3><?php echo $_SESSION["user"]["username"];?></h3>
    <h5>User Since: TBD</h5>
<hr>
    <h3>Library:</h3>
    <p>TBD</p>
    <hr>
<h3>Past Orders</h3>
<p>TBD</p>
<br>
<h3>Edit Profile</h3>
<p>Email: <?php echo $_SESSION["user"]["email"];?></p>
<p>Username: <?php echo $_SESSION["user"]["username"];?></p>
<p>Change Password</p>

<?php
}
?>