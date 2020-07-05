<?php
include("header.php");
$query = file_get_contents(__DIR__ . "/Queries/select_cart.sql");
if(isset($query) && !empty($query)){
    try {
        $stmt = getDB()->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (Exception $e){
        echo $e->getMessage();
    }
}
?>
<?php if(isset($results)):?>
<h1>Cart</h1>
    <p>Your items:</p>
    <ul>
        <?php foreach($results as $row):?>
            <li>
                <?php echo get($row, "name")?>
                <?php echo get($row, "quantity")?>
                <?php echo get($row, "price");?>
                <a href="delete.php?productId=<?php echo get($row, "id");?>">Remove from cart</a>
            </li>
        <?php endforeach;?>
    </ul>
<?php else:?>
    <p>No results</p>
<?php endif;?>

<input type="submit" value="Purchase"/>

