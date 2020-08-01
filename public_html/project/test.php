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
            $i = 0; //start at -1
            $outerID = $orders[$i]["order_id"]; //equals 1 ?>
            <?php foreach($orders as $row) {
                $innerID = $row["order_id"]; //equals 1,1,2,3,4
                if ($innerID == $outerID) {
                    //add to list group
                }
                else {
                    //create new list group
                    $i++;
                }
        }
            //$i++;?>
        <?php //endforeach?>
        <?php endif;?>

