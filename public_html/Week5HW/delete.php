<?php
require("common.inc.php");
$db = getDB();
$productId = -1;
$result = array();

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
    <input type="submit" name="delete" value="Delete Product"/>
</form>

<?php
if(isset($_POST["delete"])){
    $delete = isset($_POST["delete"]);
    $name = $_POST["name"];
    $category = $_POST["category"];
    $quantity = $_POST["quantity"];
    $price = $_POST["price"];
    $description = $_POST["description"]; #maybe these can be deleted?
    if(!empty($name) && !empty($category) && !empty($price)){ #this too
        try{
            $stmt = $db->prepare("DELETE from Products where id=:id");
            $result = $stmt->execute(array(
                ":id" => $productId
            ));
            $e = $stmt->errorInfo();
            if($e[0] != "00000"){
                echo var_export($e, true);
            }
            else{
                echo var_export($result, true);
                if ($result){
                    echo "Successfully deleted product: " . $name;
                }
                else{
                    echo "Error deleting record";
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
