<?php
require(__DIR__ . "/../includes/common.inc.php");
if(isset($_GET["p"])){
    $product_id = $_GET["p"];
}
$response = DBH::deactivate_item($product_id);
if(Common::get($response, "status", 400) == 200){
    Common::flash("Successfully deactivated product", "success");
    die(header("Location: " . Common::url_for("edit_products")));
}
else{
    Common::flash("There was an error deactivating the product", "danger");
}
?>