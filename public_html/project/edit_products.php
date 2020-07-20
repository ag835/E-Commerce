<?php
include_once(__DIR__."/partials/header.partial.php");
if(Common::is_logged_in()){
    //this will auto redirect if user isn't logged in
    if(!Common::has_role("Admin")){
        die(header("Location: home.php"));
    }
    $result = DBH::get_shop_items();
    $_items = Common::get($result, "data", false);
    if($_items){
        $items = $_items;
        //echo var_export($items);
    }
}
?>
<h2>Update or delete products</h2>

<div class="row">
    <div class="col-8">
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
                                                    data-type="<?php echo Common::get($item, "stat","");?>"
                                                    data-price="<?php echo Common::get($item, "price", 0);?>"
                                                    data-name="<?php echo Common::get($item, "name");?>"
                                                    onclick="addToCart(this);">Update</button>
                                            <button class="btn btn-sm btn-secondary"
                                                    data-id="<?php echo Common::get($item, "id", -1);?>"
                                                    data-type="<?php echo Common::get($item, "stat","");?>"
                                                    data-price="<?php echo Common::get($item, "price", 0);?>"
                                                    data-name="<?php echo Common::get($item, "name");?>"
                                                    onclick="addToCart(this);">Delete</button>
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
</div>