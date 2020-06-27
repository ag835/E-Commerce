<?php
$search = "";
if(isset($_POST["search"])){
    $search = $_POST["search"];
}
?>
    <form method="POST">
        <input type="text" name="search" placeholder="Search for Product"
               value="<?php echo $search;?>"/>
        <input type="submit" value="Search"/>
    </form>
<?php
if(isset($search)) {

    require("common.inc.php");
    $query = file_get_contents(__DIR__ . "/Queries/search_products.sql");
    if (isset($query) && !empty($query)) {
        try {
            $stmt = getDB()->prepare($query);
            //Note: With a LIKE query, we must pass the % during the mapping
            $stmt->execute([":product"=>$search]);
            //Note the fetchAll(), we need to use it over fetch() if we expect >1 record
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
?>
    <!--This part will introduce us to PHP templating,
    note the structure and the ":" -->
    <!-- note how we must close each check we're doing as well-->
<?php if(isset($results) && count($results) > 0):?>
    <p>Results: </p>
    <ul>
        <!-- Here we'll loop over all our results and reuse a specific template for each iteration,
        we're also using our helper function to safely return a value based on our key/column name.-->
        <?php foreach($results as $row):?>
            <li>
                <?php echo get($row, "name")?>
                <?php echo get($row, "quantity")?>
                <?php echo get($row, "price");?>
                <a href="delete.php?productId=<?php echo get($row, "id");?>">Delete</a>
            </li>
        <?php endforeach;?>
    </ul>
<?php else:?>
    <p>No results</p>
<?php endif;?>