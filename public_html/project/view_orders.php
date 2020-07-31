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
    $total = 0;
    for ($i = 0; $i < count($orders); $i++) {
        //echo orders[$i]["cost"]; outputs nothing but the var $total works..
        $total += $orders[$i]["cost"];
    }
    $profit = number_format($total, 2, ".", ",");
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark justify-content-between">
    <a class="navbar-brand text-white">Orders</a>
    <form class="form-inline" method="POST">
        <label style="color: aliceblue">Category:  </label>
        <select class="form-control form-control-sm mr-sm-2" name="category">
            <option value="Demo">Demo</option>
            <option value="DLC">DLC</option>
            <option value="Game">Game</option>
            <option value="Hardware">Hardware</option>
            <option value="Mod">Mod</option>
        </select>
        <select class="form-control form-control-sm mr-sm-2" name="time">
            <option value="created DESC">Newest</option>
            <option value="created ASC">Oldest</option>
        </select>
        <input type="submit" class="btn btn-sm btn-outline-primary my-2 my-sm-0" value="Filter"/>
    </form>
</nav>
<h2>Customer Orders</h2>
<div class="container-fluid">
    <h4>Profit: $<?php echo $profit?></h4>
    <div class="list-group">
        <?php foreach($orders as $o): ?>
            <div class="list-group-item">
                <h6>Order ID: <?php echo Common::get($o,"order_id");?></h6>
                <p><small><?php echo Common::get($o, "created");?></small></p>
                <p>User: <?php echo Common::get($o, "username");?></p>
                <!--get individual items-->
                <h6>Items:</h6>
                <p><?php echo Common::get($o, "name");?> - <?php echo Common::get($o, "quantity");?>
                    - <?php echo Common::get($o, "cost");?></p>
                <!--sum the total-->
                <br>
                <p>Total: <?php echo Common::get($o,"cost", 0);?></p>
            </div>
        <?php endforeach; ?>
        <?php if(count($orders) == 0):?>
            <div class="list-group-item">
                No orders exist, sad.
            </div>
        <?php endif; ?>
    </div>
</div>

