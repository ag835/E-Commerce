<?php
$search = "";
if(isset($_POST["search"])){
    $search = $_POST["search"];
}
?>
    <form method="POST">
        <input type="text" name="search" placeholder="Search for Product"
               value="<?php echo $search;?>"/>
        <label>Sort by</label>
        <select name="sort">
            <option value="lowPrice">Lowest Price"</option>
            <option value="highPrice">Highest Price</option>
        </select>
        <input type="submit" value="Search"/>
    </form>
<?php
if(isset($search)) {

    require("common.inc.php");
    $query = file_get_contents(__DIR__ . "/Queries/search_products.sql");
    if (isset($query) && !empty($query)) {
        try {
            $stmt = getDB()->prepare($query);
            $stmt->execute([":product"=>$search]);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
?>

<?php if(isset($results) && count($results) > 0):?>
    <p>Results: </p>
    <ul>
        <?php foreach($results as $row):?>
            <li>
                <?php echo get($row, "name")?>
                <?php echo get($row, "price");?>
                <a href="delete.php?productId=<?php echo get($row, "id");?>">Delete</a>
            </li>
        <?php endforeach;?>
    </ul>
<?php else:?>
    <p>No results</p>
<?php endif;?>