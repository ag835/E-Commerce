<?php
include_once(__DIR__."/partials/header.partial.php");

if(Common::is_logged_in()){
    //this will auto redirect if user isn't logged in

    //Common::aggregate_stats_and_refresh();
}
//$last_updated = Common::get($_SESSION, "last_sync", false);
?>
<div class="container-fluid">
    <h4>Home</h4>
    <p>Welcome, <?php echo Common::get_username();?></p>
</div>