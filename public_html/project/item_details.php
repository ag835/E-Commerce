<?php
include_once(__DIR__."/partials/header.partial.php");
if(Common::is_logged_in()){
}
?>
<h6>Back to store</h6>
<hr>
<h1>Product Name: <?php echo Common::get($item,"name");?>, [category]</h1>
<h6>Category</h6>
<p>[video/images]</p>
<p>[description]</p>
<p>Add to cart</p>
<h3>Reviews</h3>
<hr>
