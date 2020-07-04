<?php
if (isset($_GET["productId"]) && !empty($_GET["productId"])){
    if(is_numeric($_GET["productId"])){
        $productId = (int)$_GET["productId"];
        $userId = $_SESSION["user"]["id"];
        $query = file_get_contents(__DIR__ . "/Queries/insert_into_cart.sql");
        if(isset($query) && !empty($query)) {
            #require("common.inc.php");
            $stmt = getDB()->prepare($query);
            $stmt->execute([":productID"=>$productId], [":userID"=>$userId]); //:id -> :productID, added user id stuff
            $e = $stmt->errorInfo();
            if($e[0] == "00000"){
                echo "Successfully added to cart.";
                die(header("Location: store.php"));
            }
            else{
                echo var_export($e, true);
            }
        }
    }
}
else{
    echo "Invalid product to add";
}