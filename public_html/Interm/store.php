<?php
include("header.php");
$search = "";
echo var_export($_SESSION, true);
if(isset($_POST["search"])){
    $search = $_POST["search"];
}
?>
    <form method="POST">
        <input type="text" name="search" placeholder="Search for Product"
               value="<?php echo $search;?>"/>
        <label>Sort by</label>
        <select name="sort">
            <option value="ASC">Lowest Price</option>
            <option value="DESC">Highest Price</option>
        </select>
        <input type="submit" value="Search"/>
    </form>
<?php
if(isset($search)) {
    require("common.inc.php");
    if(isset($_POST["sort"])){
        $sort = " " . $_POST["sort"];
    }
    $query = file_get_contents(__DIR__ . "/Queries/search_products.sql");
    $query .= $sort;
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
                <a href="add.php?productId=<?php echo get($row, "id");?>">Add to cart</a>
            </li>
        <?php endforeach;?>
    </ul>
<?php else:?>
    <p>No results</p>
<?php endif;?>