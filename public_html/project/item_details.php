<?php
//TODO: Format release date
//TODO: Reviews pagination
//TODO: Add review button if user owns the product
//TODO: Make it so user can only input rating up to 5 in backend:
//https://stackoverflow.com/questions/12868213/is-it-possible-to-set-a-maximum-value-for-a-column-in-sql-server-2008-r2
//TODO: Add a dropdown selector to sort reviews
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once(__DIR__."/partials/header.partial.php");
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
    .list-group-item {
        background-color: dimgrey;
        color: aliceblue;
    }
</style>
<h1><?php echo Common::get($item,"name", "");?> <span
            style="font-size: 50%;">(<?php echo Common::get($item,"category", "");?>)</span></h1>
<h5>Release date: <?php echo Common::get($item,"Release_Date");?></h5>
<iframe width="560" height="315" src="https://www.youtube.com/embed/PRQgOfb9EGc" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
<p><?php echo Common::get($item,"description");?></p>
<span style="font-size: 120%;">$<?php echo Common::get($item,"price");?></span>
<button class="btn btn-success inline">Add to cart</button>
<br>
<hr style="color: aquamarine">
<?php
$response = DBH::get_item_reviews($product_id);
$reviews = [];
if(Common::get($response, "status", 400) == 200){
    $reviews = Common::get($response, "data", []);
}
?>
<div class="container-fluid">
    <h3>Reviews</h3>

    <div class="text-right">
        <!--<button type="button" class="btn btn-light btn-sm">Write a Review</button>-->
        <a href="write_review.php?p=<?php echo $product_id;?>" class="btn btn-small btn-light">Write a Review</a>

    </div>
    <div class="list-group">
        <?php foreach($reviews as $r): ?>
            <div class="list-group-item">
                <h6>(<?php echo Common::get($r, "rating", 0);?>/5) - <?php echo Common::get($r, "title", 0);?></h6>
                <p style="color: darkgray" ><i>Reviewed <?php echo Common::get($r, "created");?></i></p>
                <p><?php echo Common::get($r, "description", ""); ?></p>
            </div>
        <?php endforeach; ?>
        <?php if(count($reviews) == 0):?>
            <div class="list-group-item">
                No reviews yet. Try out the <?php echo Common::get($item,"category", "");?>
                and tell us what you think!
            </div>
        <?php endif; ?>
    </div>
</div>
