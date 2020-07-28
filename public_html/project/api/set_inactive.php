<?php
require(__DIR__ . "/../includes/common.inc.php");
/*if(isset($_GET["p"])){
    $product_id = $_GET["p"];
}
$response = DBH::deactivate_item($product_id);
if(Common::get($response, "status", 400) == 200){
    Common::flash("Successfully deactivated product", "success");
    die(header("Location: " . Common::url_for("edit_products")));
}
else{
    Common::flash("There was an error deactivating the product", "danger");
}*/
$response = array("status"=>400, "message"=>"Unknown error");
if(isset($_POST["deactivate"])){
    $item_id = $_POST["deactivate"];
    $item_id = json_decode($item_id, true);
    try {
        require(__DIR__ . "/../includes/common.inc.php");
        if (Common::is_logged_in(false)) {
            if ($item_id > -1) {
                $response = DBH::deactivate_item($item_id);
                if(Common::get($response, "status", 400) == 200) {
                    $response["status"] = 200;
                    $response["message"] = "Item deactivated";

                }
                else {
                    $response["message"] = "Deactivation error";
                }
            }
            else {
                $response["message"] = "Invalid product id";
            }
        }
    }
    catch(Exception $e){
        error_log($e->getMessage());
    }
}
echo json_encode($response);
?>

