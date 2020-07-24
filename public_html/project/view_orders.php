<?php
include_once(__DIR__."/partials/header.partial.php");
$orders = array();
if(Common::is_logged_in()){
    //this will auto redirect if user isn't logged in
    if(!Common::has_role("Admin")){
        die(header("Location: home.php"));
    }
    $result = DBH::get_orders();
    $_orders = Common::get($result, "data", false);
    if($_orders) {
        $orders = $_orders;
    }
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark justify-content-between">
    <a class="navbar-brand text-white">View Orders</a>
    <form class="form-inline">
        <input class="form-control mr-sm-2" type="search" placeholder="search orders" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
</nav>
<h2>Customer Orders</h2>
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
                        <?php for($k = 0; $k < 1; $k++):?>
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
                                            <h5>OrderID: <?php echo Common::get($order,"order_id");?> (<?php echo Common::get($order,"created")?>)</h5>
                                            <p class="card-text">
                                                User: <?php echo Common::get($order, "username");?>
                                            </p>
                                            <p class="card-text">
                                                <?php echo Common::get($order, "name");?> - <?php echo Common::get($order, "quantity");?> - <?php echo Common::get($order, "price");?>
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
