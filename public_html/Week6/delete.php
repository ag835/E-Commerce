<?php
if (isset($_GET["productId"]) && !empty($_GET["productId"])){
    if(is_numeric($_GET["productId"])){
        $productId = (int)$_GET["productId"];
        $query = file_get_contents(__DIR__ . "/Queries/delete_one_product.sql");
        if(isset($query) && !empty($query)) {
            require("common.inc.php");
            $stmt = getDB()->prepare($query);
            $stmt->execute([":id"=>$productId]);
            $e = $stmt->errorInfo();
            if($e[0] == "00000"){
                die(header("Location: list.php"));
            }
            else{
                echo var_export($e, true);
            }
        }
    }
}
else{
    echo "Invalid product to delete";
}