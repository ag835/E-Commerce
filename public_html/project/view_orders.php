<?php
include_once(__DIR__."/partials/header.partial.php");
if(Common::is_logged_in()){
    //this will auto redirect if user isn't logged in
    if(!Common::has_role("Admin")){
        die(header("Location: home.php"));
    }
}
?>
<h2>Customer Orders</h2>
