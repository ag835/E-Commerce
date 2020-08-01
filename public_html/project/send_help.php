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
                echo $row;?>
                <?php foreach($row as $innerArray):
                    echo null; //$innerArray;?>
                    <?php echo null; //$innerArray["order_id"];?>
                <?php endforeach;?>
            <?php endforeach;?>
        <?php endif;?>

