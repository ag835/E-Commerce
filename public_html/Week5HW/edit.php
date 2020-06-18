<?php
require("common.inc.php");
$db = getDB();
//example usage, change/move as needed
#$stmt = $db->prepare("SELECT * FROM Things");
#$stmt->execute();
#$result = $stmt->fetch(PDO::FETCH_ASSOC);
#echo var_export($result, true);
?>

<?php
#require("config.php");
#$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
#$db = new PDO($connection_string, $dbuser, $dbpass);
$productId = -1;
$result = array();
#function get($arr, $key){
    #if(isset($arr[$key])){
        #return $arr[$key];
   # }
    #return "";
#}
if(isset($_GET["productId"])){
    $productId = $_GET["productId"];
    $stmt = $db->prepare("SELECT * FROM Products where id = :id");
    $stmt->execute([":id"=>$productId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
}
else{
    echo "No productId provided in url.";
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
        <input type="number" step="0.01" min="0" id="p" name="price" value = "<?php echo get($result, "price");?>" />
    </label>
    <label for="description">Description
        <input type="text" id="description" name="description" value="<?php echo get($result, "description");?>"/>
    </label>
    <input type="submit" name="updated" value="Update Product"/>
</form>

<?php
if(isset($_POST["updated"])){
    $name = $_POST["name"];
    $category = $_POST["category"];
    $quantity = $_POST["quantity"];
    $price = $_POST["price"];
    $description = $_POST["description"];
    if(!empty($name) && !empty($category) && !empty($price)){ #check to make sure prexsiting values are there so it doesn't wipe it if empty
        try{
            $stmt = $db->prepare("UPDATE Products set name = :name, category=:category, 
            quantity=:quantity, price=:price, description=:description where id=:id");
            $result = $stmt->execute(array(
                ":name" => $name,
                ":category" => $category,
                ":quantity" => $quantity,
                ":price" => $price,
                ":description" => $description,
                ":id" => $productId
            ));
            $e = $stmt->errorInfo();
            if($e[0] != "00000"){
                echo var_export($e, true);
            }
            else{
                echo var_export($result, true);
                if ($result){
                    echo "Successfully updated thing: " . $name;
                }
                else{
                    echo "Error updating record";
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