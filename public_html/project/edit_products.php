<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once(__DIR__."/partials/header.partial.php");
if(Common::is_logged_in()){
    //this will auto redirect if user isn't logged in
    if(!Common::has_role("Admin")){
        die(header("Location: home.php"));
        //add access denied alert
    }
    $result = DBH::get_shop_items();
    $items = [];
    if(Common::get($result, "status", 400) == 200){
        $items = Common::get($result, "data", []);
    }
    //echo var_export($items);
}
?>
<h2>Update or delete products</h2>
<div class="container-fluid">
    <h4>Products</h4>
    <div class="list-group">
        <?php foreach($items as $p): ?>
            <div class="list-group-item">
                <h6><?php echo Common::get($p, "name", ""); ?></h6>
                <p>Category: <?php echo Common::get($p, "category", ""); ?></p>
                <p>Release Date: <?php echo Common::get($p, "Release_Date", ""); ?></p>
                <p><?php echo Common::get($p, "description", ""); ?></p>
                <?php if(Common::get($p, "active", false)): ?>
                    <div>Inactive</div>
                <?php else:?>
                    <div>Active</div>
                <?php endif; ?>
                <a href="update_product.php?p=<?php echo Common::get($p, 'id', -1);?>" class="btn btn-small btn-secondary">Update</a>
                <button class="btn btn-sm btn-secondary"
                        data-id="<?php echo Common::get($p, "id", -1);?>"
                        onclick="deleteProduct(this);">Delete</button>
            </div>
        <?php endforeach; ?>
        <?php if(count($items) == 0):?>
            <div class="list-group-item">
                No products exist, please use the add products form.
            </div>
        <?php endif; ?>
    </div>
</div>

<!--
<div class="row">
    <div class="col-12">
        <table class="table">
            <tbody>
            <?php $total = count($items);
            if($total > 0):?>
                <?php

                $rows = (int)($total/ 5) + 1;
                //echo "<br>Rows: $rows<br>";
                ?>
                <?php for($i = 0; $i < $rows; $i++):?>
                    <tr>
                        <?php for($k = 0; $k < 5; $k++):?>
                            <?php $index = (($i) * 5) + ($k);
                            $item = null;
                            if($index < $total){
                                $item = $items[$index];
                            }
                            ?>
                            <?php if(isset($item)):?>
                                <td>
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                <?php echo Common::get($item,"name");?></h5>
                                            <p class="card-text">
                                                <?php echo Common::get($item, "description");?>
                                            </p>
                                            <p class="card-text">
                                                Price: <?php echo Common::get($item,"price", 0);?>
                                            </p>
                                            <button class="btn btn-sm btn-secondary"
                                                    data-id="<?php echo Common::get($item, "id", -1);?>"
                                                    data-price="<?php echo Common::get($item, "price", 0);?>"
                                                    data-name="<?php echo Common::get($item, "name");?>"
                                                    onclick="updateProduct(this);">Update</button>
                                            <button class="btn btn-sm btn-secondary"
                                                    data-id="<?php echo Common::get($item, "id", -1);?>"
                                                    data-price="<?php echo Common::get($item, "price", 0);?>"
                                                    data-name="<?php echo Common::get($item, "name");?>"
                                                    onclick="deleteProduct(this);">Delete</button>
                                        </div>

                                    </div>
                                </td>
                            <?php endif;?>
                        <?php endfor;?>
                    </tr>
                <?php endfor;?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>-->
<script>
    function updateProduct() {
        location.href='update_product.php';
    }
    function deleteProduct(target) {
        //set inactive
    }
</script>
