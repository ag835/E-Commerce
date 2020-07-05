<?php
include("header.php");
$userId = $_SESSION["user"]["id"];
if (isset($_GET["productId"]) && !empty($_GET["productId"])){
    if(is_numeric($_GET["productId"])){
        $productId = (int)$_GET["productId"];
        $query = file_get_contents(__DIR__ . "/Queries/remove_from_cart.sql");
        if(isset($query) && !empty($query)) {
            #require("common.inc.php");
            $stmt = getDB()->prepare($query);
            $stmt->execute([":productId"=>$productId])  //:id -> productID
            $e = $stmt->errorInfo();
            if($e[0] == "00000"){
                die(header("Location: cart.php"));
            }
            else{
                echo var_export($e, true);
            }
        }
    }
}
else{
    echo "Invalid product to remove";
}