<?php
$response = array("status"=>400, "message"=>"Unknown error");
if(isset($_POST["cart"])){
    $cart = $_POST["cart"];
    $cart = json_decode($cart, true);
    echo var_export($cart);
    try {
        require(__DIR__ . "/../includes/common.inc.php");
        if (Common::is_logged_in(false)) {
            $quantity = 0;
            foreach ($cart as $item) {
                $q = (int)$item["quantity"];
                $quantity += $q;
            }
            $response = DBH::save_cart_items($cart);
            //insert items, get cart
            // if db item IS NOT IN $cart
            //remove item
            $items = array();
            $_result = DBH::get_cart();
            $_items = Common::get($_result, "data", false);
            if($_items){
                $items = $_items;
            }
            echo var_export($items);
            foreach ($cart as $item) {
                if (!in_array($item["id"], $items)) {
                    $_response = DBH::remove_cart_item($item);
                    if(Common::get($_response, "status", 400) == 200) {
                        $response["status"] = 200;
                        $response["message"] = "Removed item";
                }
            }
            if(Common::get($response, "status", 400) == 200) {
                $response["status"] = 200;
                $response["message"] = "Update complete";
            }
        }
    }
    catch(Exception $e){
        error_log($e->getMessage());
    }
}
echo json_encode($response);
?>