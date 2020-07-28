<?php
//steps:
//1) get product id
//2) check if updated and if so update db
//3) select product
//4) form
//TODO: Integrate the JS form validation script? (week 6)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once(__DIR__."/partials/header.partial.php");

if(Common::is_logged_in()){
    //this will auto redirect if user isn't logged in
    if(!Common::has_role("Admin")){
        Common::flash("Access denied", "danger");
        die(header("Location: " . Common::url_for("home")));
    }
}
if(isset($_GET["p"])){
    $product_id = $_GET["p"];
}
else{
    Common::flash("Not a valid product", "warning");
    die(header("Location: " . Common::url_for("edit_products")));
}
?>
<?php
if(isset($_POST["updated"])){
    $name = "";
    $quantity = -1;
    echo $_POST["product_quantity"];
    if(isset($_POST["product_name"]) && !empty($_POST["product_name"])){
        $name = $_POST["product_name"];
    }
    if(isset($_POST["product_category"]) && !empty($_POST["product_category"])){
        $category = $_POST["product_category"];
    }
    if(isset($_POST["product_quantity"])
        && (!empty($_POST["product_quantity"]) || $_POST["product_quantity"] == 0)){
        if(is_numeric($_POST["product_quantity"])){
            $quantity = (int)$_POST["product_quantity"];
        }
    }
    if(isset($_POST["product_price"]) && !empty($_POST["product_price"])){
        if(is_numeric($_POST["product_price"])){
            $price = (float)$_POST["product_price"];
        }
    }
    if(isset($_POST["product_desc"]) && !empty($_POST["product_desc"])){
        $description = $_POST["product_desc"];
    }
    if(!empty($name) && !empty($category) && $quantity > -1 && $price > -1 && !empty($description)){
        $response = DBH::update_item($name, $category, $quantity, $price, $description, $product_id);
        //check to see if i can just pass $item array instead
        //not sure if it will have the updated values
        if(Common::get($response, "status", 400) == 200){
            Common::flash("Successfully updated product", "success");
            die(header("Location: " . Common::url_for("edit_products")));
        }
        else{
            Common::flash("There was an error updating the product", "danger");
        }
    }
    else {
        echo $name, $category, $quantity, $price, $description;
        Common::flash("All fields must not be empty", "warning");
    }
}
?>
<?php
$result = DBH::get_item_by_id($product_id);
$item = [];
if(Common::get($result, "status", 400) == 200){
    $item = Common::get($result, "data", []);
   // echo var_export($item);
}
?>
<a href="edit_products.php" class="btn btn-small btn-secondary">Back to products</a>
<h2>Update a product</h2>
<div class="container-fluid">
<form method="POST">
    <div class="form-group">
        <label for="product_name">Product Name</label>
        <input class="form-control" type="text" id="product_name" name="product_name"
               value="<?php echo Common::get($item, "name");?>" required/>
    </div>
    <div class="form-group">
        <label for="product_category">Category</label>
        <input class="form-control" type="text" id="product_category" name="product_category"
               value="<?php echo Common::get($item, "category");?>" required/>
    </div>
    <div class="form-group">
        <label for="product_quantity">Quantity</label>
        <input class="form-control" type="number" id="product_quantity" name="product_quantity"
               value="<?php echo Common::get($item, "quantity");?>" required min="0"/>
    </div>
    <div class="form-group">
        <label for="product_price">Price</label>
        <input class="form-control" type="number" id="product_price" name="product_price"
               value="<?php echo Common::get($item, "price");?>" step="0.01" min="0.00"/>
    </div>
    <div class="form-group">
        <label for="product_desc">Product Description</label>
        <textarea class="form-control" type="text" id="product_desc" name="product_desc"><?php echo Common::get($item, "description", "");?></textarea>
    </div>
    <div class="form-group">
        <label for="active">Active?</label>
        <?php if(Common::get($item, "is_active", false)): ?>
            <input class="form-control" type="checkbox" id="active" name="active" />
        <?php else:?>
            <input class="form-control" type="checkbox" id="active" name="active" checked/>
        <?php endif; ?>
    </div>
    <div class="form-group">
        <input type="submit" name="updated" class="btn btn-primary" value="Update Product"/>
    </div>
</form>