<?php
require("config.php");
$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
$db = new PDO($connection_string, $dbuser, $dbpass);
$thingId = -1;
$result = array();
function get($arr, $key){
    if(isset($arr[$key])){
        return $arr[$key];
    }
    return "";
}
if(isset($_GET["productId"])){
    $productId = $_GET["productId"];
    $stmt = $db->prepare("SELECT * FROM Products where id = :id");
    $stmt->execute([":id"=>$productId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if(!$result){
        $thingId = -1;
    }
}
else{
    echo "No productId provided in url, don't forget this or sample won't work.";
}
?>

    <form method="POST">
        <label for="pname">Name
            <input type="text" id="pname" name="name" value="<?php echo get($result, "name");?>" />
        </label>
        <label for="category">Category
            <input type="text" id="category" name="category" value="<?php echo get($result, "category");?>" />
        </label>
        <label for="q">Quantity
            <input type="number" id="q" name="quantity" value="<?php echo get($result, "quantity");?>" />
        </label>
        <label for="p">Price
            <input type="number" step="0.01" min="0" id="p" name="price" value="<?php echo get($result, "price");?>" />
        </label>
        <label for="description">Description
            <input type="text" id="description" name="description" value="<?php echo get($result, "description");?>" />
        </label>
        <?php if($productId > 0):?>
            <input type="submit" name="updated" value="Update Product"/>
        <?php elseif ($productId < 0):?>
            <input type="submit" name="created" value="Create Product"/>
        <?php endif;?>
    </form>

<?php
if(isset($_POST["updated"]) || isset($_POST["created"])){
    $name = $_POST["name"];
    $category = $_POST["category"];
    $quantity = $_POST["quantity"];
    $price = $_POST["price"];
    $description = $POST_["description"];
    if(!empty($name) && !empty($category) && !empty($price)){
        try{
            if($productId > 0) {
                $stmt = $db->prepare("UPDATE Products set name = :name, quantity=:quantity where id=:id");
                $result = $stmt->execute(array(
                    ":name" => $name,
                    ":category" => $category,
                    ":quantity" => $quantity,
                    ":id" => $thingId
                ));
            }
            else{
                $stmt = $db->prepare("INSERT INTO Products (name, quantity) VALUES (:name, :quantity)");
                $result = $stmt->execute(array(
                    ":name" => $name,
                    ":category" => $category,
                    ":quantity" => $quantity
                ));
            }
            $e = $stmt->errorInfo();
            if($e[0] != "00000"){
                echo var_export($e, true);
            }
            else{
                echo var_export($result, true);
                if ($result){
                    echo "Successfully inserted or updated product: " . $name;
                }
                else{
                    echo "Error inserting or updating record";
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