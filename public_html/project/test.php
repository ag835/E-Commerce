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
        if($length > 0):?> //maybe add more php tags like store
            <?php $i = -1; //starts null for initial list group
            //$outerID = $orders[$i]["order_id"];?>
            <?php foreach($orders as $row):
                $outerID = $orders[$i]["order_id"];
                $innerID = $row["order_id"]; //equals 1,1,2,3,4?>
                <?php if ($innerID == $outerID):?>
                    <!--add to list group-->
                    <p><?php echo Common::get($row, "name");?> - <?php echo Common::get($row, "quantity");?>
                        - <?php echo Common::get($row, "cost");?></p>
                <?php else: $i++;?>
                    <!--create new list group-->
                    <div class="list-group-item">
                        <p><?php echo $outerID;?></p>
                        <h6>Order ID: <?php echo Common::get($row,"order_id");?></h6>
                        <p><small><?php echo Common::get($row, "created");?></small></p>
                        <p><?php echo Common::get($row, "name");?> - <?php echo Common::get($row, "quantity");?>
                            - <?php echo Common::get($row, "cost");?></p>
                    </div>
                <?php endif;?>
        <?php endforeach;?>
        <?php else:?>
            <div class="list-group-item">
                No purchases on record. Check out the store!
            </div>
        <?php endif;?>

