<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once(__DIR__."/../partials/header.partial.php");
$item = [];
if(Common::is_logged_in()){
    //this will auto redirect if user isn't logged in
    if(isset($_GET["p"])){
        $product_id = $_GET["p"];
    }
    $result = DBH::get_item_by_id($product_id);
    $_item = Common::get($result, "data", false);
    if($_item){
        $item = $_item;
    }
}
?>
<style>
    body {
        background-color: black;
        color: aliceblue;
    }
</style>
<button class="btn btn-sm btn-dark">Back to store</button>
<h1><?php echo Common::get($item,"name", "");?> <span
            style="font-size: 50%;">(<?php echo Common::get($item,"category", "");?>)</span></h1>
<h5>Release date: <?php echo Common::get($item,"Release_Date");?></h5>
<iframe width="560" height="315" src="https://www.youtube.com/embed/PRQgOfb9EGc" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
<p><?php echo Common::get($item,"description");?></p>
<span style="font-size: 120%;">$<?php echo Common::get($item,"price");?></span>
<button class="btn btn-success inline">Add to cart</button>
<br>
<br>
<h3>Reviews</h3>
<hr style="color: aquamarine">
