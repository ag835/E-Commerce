<form method="POST">
    <label for="title">Title
        <input type="text" id="title" name="name" />
    </label>
    <label for="category">Category
        <input type="text" id="category" name="category" value="Game" />
    </label>
    <label for="q">Quantity
        <input type="number" id="q" name="quantity" />
    </label>
    <label for="p">Price
        <input type="number" step="0.01" min="0" id="p" name="price" value = "0.00" />
    </label>
    <label for="description">Description
        <input type="text" id="description" name="description" />
    </label>
    <input type="submit" name="created" value="Create Product"/>
</form>

<?php
require("common.inc.php");
$db = getDB();
if(isset($_POST["created"])){
    $name = $_POST["name"];
    $category = $_POST["category"];
    $quantity = $_POST["quantity"];
    $price = $_POST["price"];
    $description = $POST_["description"];
    if(!empty($name) && !empty($category) && !empty($price)){
        try{
            $stmt = $db->prepare("INSERT INTO Products (name, category, quantity, price, description) 
                                 VALUES (:name, :category, :quantity, :price, :description)");
            $result = $stmt->execute(array(
                ":name" => $name,
                ":category" => $category,
                ":quantity" => $quantity,
                ":price" => $price,
                ":description" => $description
            ));
            $e = $stmt->errorInfo();
            if($e[0] != "00000"){
                echo var_export($e, true);
            }
            else{
                echo var_export($result, true);
                if ($result){
                    echo "Successfully inserted new product: " . $name;
                }
                else{
                    echo "Error inserting record";
                }
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
