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
    else {
        echo "No purchases on record. Check out the store!"; //probably a better way to do this...
    }
}
?>
<h2>Past Purchases</h2>
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
                            <h5><?php echo Common::get($order,"order_id");?></h5>
                            <p class="card-text">
                                <?php echo Common::get($order, "name");?> - <?php echo Common::get($order, "category");?> (<?php echo Common::get($order, "quantity");?>)
                            </p>
                            <p class="card-text">
                                Total: <?php echo Common::get($order,"cost", 0);?>
                            </p>
                            <!--<button class="btn btn-sm btn-secondary"
                                                    data-id="<?php echo Common::get($order, "id", -1);?>"
                                                    data-price="<?php echo Common::get($order, "cost", 0);?>"
                                                    data-name="<?php echo Common::get($order, "name");?>"
                                                    onclick="addToCart(this);">Add</button>-->
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
</div>
