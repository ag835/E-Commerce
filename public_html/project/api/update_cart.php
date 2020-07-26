<?php
$response = array("status"=>400, "message"=>"Unknown error");
if(isset($_POST["cart"])){
    $cart = $_POST["cart"];
    $cart = json_decode($cart, true);
    try {
        require(__DIR__ . "/../includes/common.inc.php");
        if (Common::is_logged_in(false)) {
            $quantity = 0;
            foreach ($cart as $item) {
                $q = (int)$item["quantity"];
                $quantity += $q;
            }
            $response = DBH::save_cart_items($cart);
            //get cart
            // if db item IS NOT IN $cart
            //remove item
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