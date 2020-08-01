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
                    echo $innerArray?>
                    <?php echo $innerArray["order_id"];?>
                <?php endforeach;?>
            <?php endforeach;?>
        <?php endif;?>












<!--<div class="container-fluid">
    <h4>Order History</h4>
    <div class="list-group">
        <?php $total = count($orders);
        if($total > 0):?>
            <?php for ($i = 0; $i <= count($orders); $i++):
                echo var_export($orders[$i]);?>
                <?php foreach($orders as $o):
                $order_id = $o["order_id"]; //works, gets 1, 1, 2, 3, 4
                echo $order_id;
                //echo var_export($o);?>
                <div class="list-group-item">
                    <h6>Order ID: <?php echo Common::get($o,"order_id");?></h6>
                    <p><small><?php echo Common::get($o, "created");?></small></p>-->
                    <!--get individual items-->
                    <p><?php echo Common::get($o, "name");?> - <?php echo Common::get($o, "quantity");?>
                        - <?php echo Common::get($o, "cost");?></p>
                    <!--sum total-->
                    <!--<br>
                    <p>Total: <?php echo Common::get($o,"cost", 0);?></p>
                </div>
            <?php endforeach; ?>
            <?php endfor;?>
            <?php if(count($orders) == 0):?>
                <div class="list-group-item">
                    No purchases on record. Check out the store!
                </div>
            <?php endif; ?>
        <?php endif;?>
    </div>
</div>-->
