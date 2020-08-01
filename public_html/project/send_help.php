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
        if($length > 0):?>
            <?php foreach($orders as $row):
                echo null; //$row; Outputs Array Array Array Array Array?>
                <?php foreach($row as $innerArray):
                    echo null; //$innerArray;
                //1 1 Prey 1 29.99 2020-07-22 21:53:38 2 1 Outlast 2 2.99 2020-07-22 21:53:38 8 2 Prey 1 29.99 2020-07-26 18:37:05 9 3 Headset 1 49.99 2020-07-26 19:04:14 10 4 Headset 1 49.99 2020-07-26 21:07:09?>
                    <?php echo $innerArray["order_id"];?>
                <?php endforeach;?>
            <?php endforeach;?>
        <?php endif;?>

