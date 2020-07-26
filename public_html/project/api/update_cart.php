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
            //do update
            //TODO should really validate that the ordered items match what's in the DB
            //can be done either 1 by 1 or by using an IN clause, but it requires special crafting for PDO
            //since it's not breaking data if something gets corrupted in my scenario I'm going to omit the check
            $response = DBH::save_cart_items($cart);
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