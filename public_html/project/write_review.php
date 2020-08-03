<?php
//TODO: Integrate the JS form validation script? (week 6)
//TODO: see create/update product for array
//TODO: Fix restrict reviewing if user doesnt own product
//think i did the abvoe and forgot to delete it but just in case
//TODO: Have rating form item be /5
//TODO: check error for modifying header, still works though
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
include_once(__DIR__."/partials/header.partial.php");
if(isset($_GET["p"])){
    $product_id = $_GET["p"];
}
else{
    Common::flash("Not a valid product", "warning");
    die(header("Location: " . Common::url_for("store")));
}
if(Common::is_logged_in()){
    //could changed this akin to response == 200 in other uses
    if (empty(DBH::has_ownership($product_id))) {
        Common::flash("You need to own the product before writing a review.", "warning");
        die(header("Location: item_details.php?p=$product_id"));
    }
}
?>
<?php
$result = DBH::get_item_by_id($product_id);
$item = [];
if(Common::get($result, "status", 400) == 200){
    $item = Common::get($result, "data", []);
    // echo var_export($item);
}
$name = Common::get($item, "name");
?>
<a href="item_details.php?p=<?php echo $product_id?>" class="btn btn-small btn-secondary">Back to details</a>
<h2>Review <?php echo $name;?></h2>
<hr>
<div class="container-fluid">
    <form method="POST">
        <div class="form-group">
            <label for="review_rating">Rating</label>
            <input class="form-control" type="number" id="review_rating" name="review_rating" required min="0" max="5"/>
        </div>
        <div class="form-group">
            <label for="review_title">Title</label>
            <input class="form-control" type="text" id="review_title" name="review_title" required/>
        </div>
        <div class="form-group">
            <label for="review_desc">Text</label>
            <textarea class="form-control" type="text" id="review_desc" name="review_desc"></textarea>
        </div>
        <div class="form-group">
            <input type="submit" name="submit" class="btn btn-primary" value="Post Review"/>
        </div>
    </form>
<?php
if(isset($_POST["submit"])){
    $title = "";
    $rating = -1;
    if(isset($_POST["review_title"]) && !empty($_POST["review_title"])){
        $title = $_POST["review_title"];
    }
    if(isset($_POST["review_rating"])
        && (!empty($_POST["review_rating"]) || $_POST["review_rating"] == 0)){
        if(is_numeric($_POST["review_rating"]) && $_POST["review_rating"] <= 5){
            $rating = (int)$_POST["review_rating"];
        }
    }
    if(isset($_POST["review_desc"]) && !empty($_POST["review_desc"])){
        $description = $_POST["review_desc"];
    }

    if($rating > -1 && $rating <= 5 && !empty($title) && !empty($description)){
        $response = DBH::review_item($rating, $title, $description, $product_id);
        //check create for how to pass $review array instead
        if(Common::get($response, "status", 400) == 200){
            Common::flash("Successfully reviewed " . $name, "success");
            die(header("Location: item_details.php?p=$product_id"));
        }
        else{
            Common::flash("There was an error reviewing " . $name, "danger");
        }
    }
    else {
        echo $name, $rating, $title, $description;
        Common::flash("All fields must be filled", "warning");
    }
}
?>
</div>
