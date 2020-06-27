<script src="js/script.js"></script>
<form method="POST" onsubmit="return validate(this);">
    <label for="pname">Name
        <input type="text" id="pname" name="name" required />
    </label>
    <label for="category">Category
        <input type="text" id="category" name="category" value="Game" required />
    </label>
    <label for="q">Quantity
        <input type="number" id="q" name="quantity" required min="0"/>
    </label>
    <label for="p">Price
        <input type="number" step="0.01" min="0" id="p" name="price" value = "0.00" required min="0"/>
    </label>
    <label for="description">Description
        <input type="text" id="description" name="description" />
    </label>
    <input type="submit" name="created" value="Create Product"/>
</form>

<?php
if(isset($_POST["created"])) {
    $name = "";
    $quantity = -1;
    if(isset($_POST["name"]) && !empty($_POST["name"])){
        $name = $_POST["name"];
    }
    if(isset($_POST["category"]) && !empty($_POST["category"])){
        $name = $_POST["category"];
    }
    if(isset($_POST["quantity"]) && !empty($_POST["quantity"])){
        if(is_numeric($_POST["quantity"])){
            $quantity = (int)$_POST["quantity"];
        }
    }
    if(isset($_POST["price"]) && !empty($_POST["price"])){
        if(is_numeric($_POST["price"])){
            $quantity = (float)$_POST["price"];
        }
    }
    if(empty($name) || empty($category) || $quantity < 0 || $price < 0){
        echo "Name, category must not be empty and quantity, price must be greater than or equal to 0";
        echo $name
        echo $category
        echo $quantity
        echo $price
        die();//terminates the rest of the script
    }
    try {
        require("common.inc.php");
        $query = file_get_contents(__DIR__ . "/Queries/insert_products.sql");
        if(isset($query) && !empty($query)) {
            $stmt = getDB()->prepare($query);
            $result = $stmt->execute(array(
                ":name" => $name,
                ":category" => $category,
                ":quantity" => $quantity,
                ":price" => $price,
                ":description" => $description
            ));
            $e = $stmt->errorInfo();
            if ($e[0] != "00000") {
                echo var_export($e, true);
            } else {
                if ($result) {
                    echo "Successfully inserted new product: " . $name;
                } else {
                    echo "Error inserting record";
                }
            }
        }
        else{
            echo "Failed to find insert_products.sql file";
        }
    }
    catch (Exception $e){
        echo $e->getMessage();
    }
}
?>
