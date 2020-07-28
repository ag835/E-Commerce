<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once(__DIR__."/partials/header.partial.php");
$items = array();
if(Common::is_logged_in()){
    //this will auto redirect if user isn't logged in
    $result = DBH::get_shop_items();
    $_items = Common::get($result, "data", false);
    if($_items){
        $items = $_items;
        //echo var_export($items);
    }
}
$last_updated = Common::get($_SESSION, "last_sync", false);
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark justify-content-between">
    <a class="navbar-brand text-white">Store</a>
    <form class="form-inline">
        <input class="form-control mr-sm-2" type="search" placeholder="search the store" aria-label="Search">
        <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
    </form>
</nav>
<div>
    <?php if($last_updated):?>
        <p>Points Last Updated: <?php echo $last_updated->format('Y-m-d H:i:s');?></p>
    <?php endif;?>
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
                                    <img class="card-img-top" src="images/<?php echo Common::get($item,"name");?>.jpg" alt="<?php echo Common::get($item,"name");?>">
                                    <div class="card-body">
                                        <h5><a class="card-title" href="products/<?php echo Common::get($item,"name");?>.php">
                                                <?php echo Common::get($item,"name");?></a></h5>
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
                                        onclick="addToCart(this);">Add</button>
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
        <div class="col-4">
            <h5>Cart</h5>
            <h6 class="row">Total: <div id="used">0</div></h6>
            <ul class="list-group" id="cart">

            </ul>
            <button class="btn btn-secondary" onclick="purchase();">Complete Purchase</button>
            <button class="btn btn-sm btn-danger" onclick="emptyCart();">Remove all Items</button>
        </div>
    </div>
</div>
<script>
    //$ in var name signifies a jquery obj
    let $cart = $("#cart");
    //this is fine because php is executed first on the server then the result is sent to the browser
    //and will be the expected value by the time JS gets to this
    let total = 0;


    function updatePrice(){
        let sum = 0;
        $cart.find("li").each(function (index, item) {
            let q = $(item).data("quantity");
            let p = $(item).data("price");
            sum += (q * p);

        });
        total = (sum); //.toFixed(2); //Caution: Returns string
        let $used = $("#used");
        $used.text(total);

    }
    function addToCart(ele){

        let itemPrice = $(ele).data("price");
        let itemName = $(ele).data("name");
        let itemId = $(ele).data("id");

        let updated = false;
        $cart.find("li").each(function (index, item) {
            let _itemName = $(item).data("name");
            if(_itemName == itemName){
                let q = $(item).data("quantity");
                q++;
                $(item).data("quantity", q);
                $(item).find("span").text(_itemName + ": "+ q);
                updated = true;
            }
        });
        if(!updated){
            let $li = $("<li></li>");
            $li.attr("class", "list-group-item");
            //$li.append("<span></span><input class='cart-quantity-input'  type='number' " +
                //"name='item_quantity' id='item_quantity' min='1' data-quantity value='1'/>");
            $li.append("<span></span><button onclick='removeFromCart(this);' class='btn btn-sm btn-danger'>X</button>");
            //let itemQuantity = $("#item_quantity").data("quantity");
            $li.data("quantity", 1);
            $li.data("price", itemPrice);
            $li.data("name", itemName);
            $li.data("id", itemId);
            $li.find("span").text(itemName + ": "+ 1);

            $cart.append($li);
        }
        updatePrice();
        updateCart();
    }
    function updateCart() {
        let data = [];
        $cart.find("li").each(function(index, item){
            let itemQuantity = $(item).data("quantity");
            let itemId = $(item).data("id");
            data.push({quantity: itemQuantity, id: itemId});
        });
        console.log(data);
        console.log(JSON.stringify(data));
        $.post("api/update_cart.php", {"cart": JSON.stringify(data)}, function(data, status){
            alert("Data: " + data + "\nStatus: " + status);
        });
    }
    function removeFromCart(ele){
        $(ele).closest("li").remove();
        updatePrice();
    }
    function emptyCart() {
        //while $cart.has($li) { not needed apparently
        removeFromCart("li");
        //}
    }
    function purchase(){
        let data = [];
        $cart.find("li").each(function(index, item){
            let itemQuantity = $(item).data("quantity");
            let itemPrice = $(item).data("price");
            let itemId = $(item).data("id");
            data.push({quantity: itemQuantity, price: itemPrice, id: itemId});
        });
        console.log(data);
        console.log(JSON.stringify(data));
        $.post("api/complete_purchase.php", {"order": JSON.stringify(data)}, function(data, status){
            alert("Data: " + data + "\nStatus: " + status);
            //reload the page
            window.location.replace("store.php");
            <?php //Common::flash("Purchase complete", "success");?>
            //purchase complete flash alert, not sure if it works like this

        });
    }
</script>