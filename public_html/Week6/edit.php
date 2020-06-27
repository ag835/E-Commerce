<?php
$productId = -1;
if(isset($_GET["$productId"]) && !empty($_GET["$productId"])){
    $productId = $_GET["$productId"];
}
$result = array();
require("common.inc.php");
?>

<?php
if(isset($_POST["updated"])){
    $name = "";
    $quantity = -1;
    if(isset($_POST["name"]) && !empty($_POST["name"])){
        $name = $_POST["name"];
    }
    if(isset($_POST["category"]) && !empty($_POST["category"])){
        $category = $_POST["category"];
    }
    if(isset($_POST["quantity"]) && !empty($_POST["quantity"])){
        if(is_numeric($_POST["quantity"])){
            $quantity = (int)$_POST["quantity"];
        }
    }
    if(isset($_POST["price"]) && !empty($_POST["price"])){
        if(is_numeric($_POST["price"])){
            $price = (float)$_POST["price"];
        }
    }
    if(!empty($name) && !empty($category) && $quantity > -1 && $price > -1){
        try{
            $query = NULL;
            echo "[Quantity" . $quantity . "]";
            $query = file_get_contents(__DIR__ . "/Queries/update_products.sql");
            if(isset($query) && !empty($query)) {
                $stmt = getDB()->prepare($query);
                $result = $stmt->execute(array(
                    ":name" => $name,
                    ":category" => $category,
                    ":quantity" => $quantity,
                    ":price" => $price,
                    ":description" => $description,
                    ":id" => $productId
                ));
                $e = $stmt->errorInfo();
                if ($e[0] != "00000") {
                    echo var_export($e, true);
                } else {
                    if ($result) {
                        echo "Successfully updated product: " . $name;
                    } else {
                        echo "Error updating record";
                    }
                }
            }
            else{
                echo "Failed to find update_products.sql file";
            }
        }
        catch (Exception $e){
            echo $e->getMessage();
        }
    }
    else{
        echo "Name, category, and price must not be empty.";
    }
}
?>
<?php
//moved the content down here so it pulls the update from the table without having to refresh the page or redirect
//now my success message appears above the form so I'd have to further restructure my code to get the desired output/layout
if($productId > -1){
    $query = file_get_contents(__DIR__ . "/Queries/select_one_product.sql");
    if(isset($query) && !empty($query)) {
        //Note: SQL File contains a "LIMIT 1" although it's not necessary since ID should be unique (i.e., one record)
        try {
            $stmt = getDB()->prepare($query);
            $stmt->execute([":id" => $productId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        catch (Exception $e){
            echo $e->getMessage();
        }
    }
    else{
        echo "Failed to find select_one_product.sql file";
    }
}
else{
    echo $productId;
    echo "No productId provided in url.";
}
?>
<script src="js/script.js"></script>
<form method="POST" onsubmit="return validate(this);">
    <label for="pname">Name
        <input type="text" id="pname" name="name" value="<?php echo get($result, "name");?>" required />
    </label>
    <label for="category">Category
        <input type="text" id="category" name="category" value="<?php echo get($result, "category");?>" required />
    </label>
    <label for="q">Quantity
        <input type="number" id="q" name="quantity" value="<?php echo get($result, "quantity");?>" required min = "0"/>
    </label>
    <label for="p">Price
        <input type="number" step="0.01" min="0" id="p" name="price" value = "<?php echo get($result, "price");?>" required min = "0.00" />
    </label>
    <label for="description">Description
        <input type="text" id="description" name="description" value="<?php echo get($result, "description");?>"/>
    </label>
    <input type="submit" name="updated" value="Update Product"/>
</form>