<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once(__DIR__."/../partials/header.partial.php");
$item = "Hellblade";
echo var_export($item);
if(Common::is_logged_in()){
    //this will auto redirect if user isn't logged in
    $result = DBH::get_item($item);
    echo var_export($item);
    $_item = Common::get($result, "data", false);
    if($_item){
        $item = $_item;
        echo var_export($item);
        //echo var_export($items);
    }
    echo var_export($item);
}
?>
<button class="btn btn-sm btn-secondary">Back to store</button>
<hr>
<h1><?php echo Common::get($item,"name"); ?><small>(<?php echo Common::get($item,"category");?>)</small> </h1>
<h5>Release date: <?php echo Common::get($item,"Release_Date");?></h5>
<p>[video/images]</p>
<p><?php echo Common::get($item,"description");?></p>
<div class="inline"><h4>$<?php echo Common::get($item,"price"); ?></h4><button class="btn btn-success">Add to cart</button></div>
<h3>Reviews</h3>
<hr>