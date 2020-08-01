<?php
//TODO: if i ever fix order history, fix it here too
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
include_once(__DIR__."/partials/header.partial.php");
$category = null; //this is a load of barnacles
$time = "Newest";
if(isset($_POST["category"])){
    $category = $_POST["category"];
}
if(isset($_POST["time"])){
    $time = $_POST["time"];
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark justify-content-between">
    <a class="navbar-brand text-white">Filtered by: <?php echo $category . " " . $time;?></a>
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
            <option value="Newest">Newest</option>
            <option value="Oldest">Oldest</option>
        </select>
        <input type="submit" class="btn btn-sm btn-outline-primary my-2 my-sm-0" value="Filter"/>
    </form>
</nav>
<?php
$orders = array();
if(Common::is_logged_in()){
    //this will auto redirect if user isn't logged in
    if(!Common::has_role("Admin")){
        die(header("Location: home.php"));
    }
    if (isset($category) || isset($time)) {
        $result = DBH::get_order_results($category, $time);
        $_orders = Common::get($result, "data", false);
        if($_orders) {
            $orders = $_orders;
        }
    }
    //get total profit based on result set
    $total = 0;
    for ($i = 0; $i < count($orders); $i++) {
        //echo orders[$i]["cost"]; outputs nothing, maybe use var_export instead
        $total += $orders[$i]["cost"];
    }
    $profit = number_format($total, 2, ".", ",");
}
?>
<h2>Customer Orders</h2>
<div class="container-fluid">
    <h4>Profit: $<?php echo $profit?></h4>
    <div class="list-group">
        <?php foreach($orders as $o): ?>
            <div class="list-group-item">
                <h6>Order ID: <?php echo Common::get($o,"order_id");?></h6>
                <p><small><?php echo Common::get($o, "created");?></small></p>
                <p>User: <?php echo Common::get($o, "username");?></p>
                <h6>Items:</h6>
                <!--get individual items-->
                <!-- if order id = order id -->
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