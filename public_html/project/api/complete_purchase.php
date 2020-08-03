<?php
//TODO: prevent page access?
$response = array("status"=>400, "message"=>"Unknown error");
if(isset($_POST["order"])){
    $order = $_POST["order"];
    $order = json_decode($order, true);
    try {
        require(__DIR__ . "/../includes/common.inc.php");
        if (Common::is_logged_in(false)) {
            $price = 0;
            $quantity = 0;
            foreach ($order as $item) {
                $p = (int)$item["price"];
                $q = (int)$item["quantity"];
                $quantity += $q;
                $price += ($p * $q);
            }
            //make sure cost is not free or negative
            //make sure it's at least the same as quantity (helps reduce, not eliminates, the need to check our Items table for confirmation)
            //make sure we can afford
            //Note: technically should check db for user's points, but I'm assuming session should be accurate enough
            //your projects shouldn't make such assumptions
            if ($price > 0 && $price >= $quantity) {
                //do purchase
                //TODO should really validate that the ordered items match what's in the DB
                //can be done either 1 by 1 or by using an IN clause, but it requires special crafting for PDO
                //since it's not breaking data if something gets corrupted in my scenario I'm going to omit the check
                foreach ($order as $item) {
                    $response = DBH::verify_item($item);
                    if(!(Common::get($response, "status", 400) == 200)) {
                        $response["message"] = "Item unavailable or in error";
                        Common::flash("Item unavailable", "warning");
                    }
                }
                $response = DBH::verify_items($order);
                if(Common::get($response, "status", 400) == 200) {
                    $response = DBH::save_order($order);
                    if(Common::get($response, "status", 400) == 200) {
                        $response["status"] = 200;
                        $response["message"] = "Purchase complete";
                        Common::flash("Purchase complete", "success");
                    }
                }
                else {
                    $response["message"] = "Item unavailable or in error";
                    Common::flash("Item unavailable or in error", "warning");
                }
                /*$response = DBH::save_order($order);
                if(Common::get($response, "status", 400) == 200) {
                    $response["status"] = 200;
                    $response["message"] = "Purchase complete";
                }*/
            }
            else {
                $response["message"] = "Pricing error";
            }
        }
    }
    catch(Exception $e){
        error_log($e->getMessage());
    }
}
echo json_encode($response);
?>