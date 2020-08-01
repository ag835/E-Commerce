<?php
include_once(__DIR__."/partials/header.partial.php");
$orders = array();
if(Common::is_logged_in()){
    $user_id = Common::get_user_id();
    $result = DBH::get_user_orders($user_id);
    $_orders = Common::get($result, "data", false);
    if($_orders) {
        $orders = $_orders;
        echo var_export($orders);
    }
}
?>

----
<div class="container-fluid">
    <h4>Order History</h4>
    <div class="list-group">
        <?php $length = count($orders);
        if($length > 0):
            //echo "\$orders[0][\"order_id\"]: " . $orders[0]["order_id"];
            $i = -1;
            $outerID = $orders[$i]["order_id"];
            echo "Outer id: " . $outerID;?>
            <?php foreach($orders as $row):
            $i++;
            //$outerID = $orders[0]["order_id"]; //should stay at one
            echo "Outer ID: " . $outerID + "\n"; //nope, equals 0. I guess you can't access it from inside the loop?
                echo "\$row[\"order_id\"] " . $row["order_id"]; //1 1 2 3 4 //$row //Outputs Array Array Array Array Array?>
                <?php foreach($row as $innerArray):
                    echo null; //$innerArray;
                //1 1 Prey 1 29.99 2020-07-22 21:53:38 2 1 Outlast 2 2.99 2020-07-22 21:53:38 8 2 Prey 1 29.99 2020-07-26 18:37:05 9 3 Headset 1 49.99 2020-07-26 19:04:14 10 4 Headset 1 49.99 2020-07-26 21:07:09?>
                    <?php echo null //$innerArray["order_id"]; //whaaat - 1 1 P 1 2 2 2 1 O 2 2 2 8 2 P 1 2 2 9 3 H 1 4 2 1 4 H 1 4 2?>
                <?php endforeach;?>
            <?php endforeach;?>
        <?php endif;?>

