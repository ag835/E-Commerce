<?php
include_once(__DIR__."/partials/header.partial.php");

if(Common::is_logged_in()){
    //this will auto redirect if user isn't logged in
}
?>
<h4>Home</h4>
<style>
    body {
        background-image: url('signs.png');
        background-repeat: no-repeat;
        background-size: cover;
    }
</style>
<div>
    <p>Welcome, <?php echo Common::get_username();?></p>
</div>