<?php
include_once(__DIR__."/partials/header.partial.php");
$orders = array();
if(Common::is_logged_in()){
    //this will auto redirect if user isn't logged in
    $user_id = Common::get_user_id();
    $result = DBH::get_user_orders($user_id);
    $_orders = Common::get($result, "data", false);
    if($_orders) {
        $orders = $_orders;
    }
}
?>
<div class="container-fluid">
    <h4>Order History</h4>
    <div class="list-group">
        <?php foreach($orders as $o): ?>
            <div class="list-group-item">
                <h6>Order ID: <?php echo Common::get($o,"order_id");?></h6>
                <p><small><i><?php echo Common::get($o, "created");?></i></small></p>
                <p><?php echo Common::get($o, "name");?> - <?php echo Common::get($o, "category");?></p>
                <br>
                <p>Total: <?php echo Common::get($o,"cost", 0);?></p>
            </div>
        <?php endforeach; ?>
        <?php if(count($items) == 0):?>
            <div class="list-group-item">
                No purchases on record. Check out the store!
            </div>
        <?php endif; ?>
    </div>
</div>
--------
<!--<h2>Order History</h2>
<div class="row">
    <div class="col-1">
        <table class="table">
            <tbody>
            <?php $total = count($orders);
            if($total > 0):?>
            <?php

            $rows = (int)($total/ 5) + 1;
            //echo "<br>Rows: $rows<br>";
            ?>
            <?php for($i = 0; $i < $rows; $i++):?>
            <tr>
                <?php for($k = 0; $k < 5; $k++):?>
                <?php $index = (($i) * 5) + ($k);
                $order = null;
                if($index < $total){
                    $order = $orders[$index];
                }
                ?>
                <?php if(isset($order)):?>
                <td>
                    <div class="card">
                        <div class="card-body">
                            <h5>Order ID: <?php echo Common::get($order,"order_id");?></h5>
                            <p class="card-text">
                                <?php echo Common::get($order, "created");?>
                            </p>
                            <p class="card-text">
                                <?php echo Common::get($order, "name");?> - <?php echo Common::get($order, "category");?>
                            </p>
                            <p class="card-text">
                                Total: <?php echo Common::get($order,"cost", 0);?>
                            </p>
                        </div>

                    </div>
                </td>
    </div>
    <?php endif;?>
    <?php endfor;?>
    </tr>
    <?php endfor;?>
    <?php endif; ?>
    </tbody>
    </table>
</div>-->
