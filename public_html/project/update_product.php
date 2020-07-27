<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once(__DIR__."/partials/header.partial.php");

if(Common::is_logged_in()){
    //this will auto redirect if user isn't logged in
    if(!Common::has_role("Admin")){
        die(header("Location: home.php"));
        //add access denied alert
    }
}
if(isset($_GET["p"])){
    $product_id = $_GET["p"];
}
else{
    Common::flash("Not a valid product", "warning");
    die(header("Location: edit_products.php"));
}
?>
<a href="edit_products.php" class="btn btn-small btn-secondary">Back to products</a>
<h2>Update a product</h2>
<div class="container-fluid">
<form method="POST">
    <div class="form-group">
        <label for="product_name">Product Name</label>
        <input class="form-control" type="text" id="product_name" name="product_name" required/>
    </div>
    <div class="form-group">
        <label for="product_category">Category</label>
        <input class="form-control" type="text" id="product_category" name="product_category" value="Game" required/>
    </div>
    <div class="form-group">
        <label for="product_quantity">Quantity</label>
        <input class="form-control" type="number" id="product_quantity" name="product_quantity" required min="0"/>
    </div>
    <div class="form-group">
        <label for="product_price">Price</label>
        <input class="form-control" type="number" id="product_price" name="product_price" value="0.00" step="0.01" min="0.00"/>
    </div>
    <div class="form-group">
        <label for="product_desc">Product Description</label>
        <textarea class="form-control" type="text" id="product_desc" name="product_desc"></textarea>
    </div>
    <div class="form-group">
        <label for="active">Active?</label>
        <input class="form-control" type="checkbox" id="active" name="active"/>
    </div>
    <div class="form-group">
        <input type="submit" name="submit" class="btn btn-primary" value="Update Product"/>
    </div>
</form>