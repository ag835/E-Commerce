<?php
include_once(__DIR__."/partials/header.partial.php");

//if(Common::is_logged_in()){
    //this will auto redirect if user isn't logged in

    //Common::aggregate_stats_and_refresh();
}
//$last_updated = Common::get($_SESSION, "last_sync", false);
?>
<?php
echo "Hello, " . $_SESSION["user"]["username"];
?>