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
            <option value="asc">Lowest Price</option>
            <option value="desc">Highest Price</option>
        </select>
        <input type="submit" value="Search"/>
    </form>
<?php
if(isset($search)) {
    require("common.inc.php");
    if(isset($_POST["sort"])){
        echo $_POST["sort"];
        $sort = $_POST["sort"];
    }
    $query = file_get_contents(__DIR__ . "/Queries/search_products.sql");
    $query .= $sort;
    if (isset($query) && !empty($query)) {
        try {
            echo $query;
            $stmt = getDB()->prepare($query);
            $stmt->execute([":product"=>$search]);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    } //move all this in sort
}
?>

<?php if(isset($results) && count($results) > 0):?>
    <p>Results: </p>
    <ul>
        <?php foreach($results as $row):?>
            <li>
                <?php echo get($row, "name")?>
                <?php echo get($row, "price");?>
            </li>
        <?php endforeach;?>
    </ul>
<?php else:?>
    <p>No results</p>
<?php endif;?>