<?php
include_once(__DIR__."/partials/header.partial.php");
$orders = array();
if(Common::is_logged_in()){
    //this will auto redirect if user isn't logged in
    $result = DBH::get_orders();
    $_orders = Common::get($result, "data", false);
    if($_orders) {
        $orders = $_orders;
    }

}
?>
<h2>Past Purchases</h2>
