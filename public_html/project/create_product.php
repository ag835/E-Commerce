<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once(__DIR__."/partials/header.partial.php");

if(Common::is_logged_in()){
    //this will auto redirect if user isn't logged in
    if(!Common::has_role("Admin")){
        die(header("Location: home.php"));
    }
}
$last_updated = Common::get($_SESSION, "last_sync", false);
?>
<h2>Add a product</h2>
<hr>
<div class="container-fluid">
<form method="POST">
    <div class="form-group">
        <label for="product_name">Product Name</label>
        <input class="form-control" type="text" id="product_name" name="product_name" required/>
    </div>
    <div class="form-group">
        <label for="product_category">Category</label>
        <input class="form-control" type="text" id="product_category" name="product_category" value="Game" required/>
    </div>
    <div class="form-group">
        <label for="product_quantity">Quantity</label>
        <input class="form-control" type="number" id="product_quantity" name="product_quantity" required min="0"/>
    </div>
    <div class="form-group">
        <label for="product_price">Price</label>
        <input class="form-control" type="number" id="product_price" name="product_price" value="0.00" step="0.01" min="0.00"/>
    </div>
    <div class="form-group">
        <label for="product_desc">Product Description</label>
        <textarea class="form-control" type="text" id="product_desc" name="product_desc"></textarea>
    </div>
    <div class="form-group">
        <label for="active">Active?</label>
        <input class="form-control" type="checkbox" id="active" name="active"/>
    </div>
   <!-- <div class="list-group">
        <div class="list-group-item">
            <div class="form-group">
                <label for="question_0">Question</label>
                <input class="form-control" type="text" id="question_0" name="question_0" required/>
            </div>
            <button class="btn btn-danger" onclick="event.preventDefault(); deleteMe(this);">X</button>
            <div class="list-group">
                <div class="list-group-item">
                    <div class="form-group">
                        <label for="question_0_answer_0">Answer</label>
                        <input class="form-control" type="text" id="question_0_answer_0" name="question_0_answer_0" required/>
                    </div>
                    <button class="btn btn-danger" onclick="event.preventDefault(); deleteMe(this);">X</button>
                    <div class="form-group">
                        <label for="question_0_answeroe_0">Allow Open Ended?</label>
                        <input class="form-control" type="checkbox" id="question_0_answeroe_0" name="question_0_answeroe_0"/>
                    </div>
                </div>
            </div>
            <button class="btn btn-secondary" onclick="event.preventDefault(); cloneThis(this);">Add Answer</button>
        </div>
    </div>
    <button class="btn btn-secondary" onclick="event.preventDefault(); cloneThis(this);">Add Question</button> -->

    <div class="form-group">
        <input type="submit" name="submit" class="btn btn-primary" value="Create Product"/>
    </div>
</form>
<?php
    if(Common::get($_POST, "submit", false)){
        //echo "<pre>" . var_export($_POST, true) . "</pre>";
        //TODO this isn't going to be the best way to parse the form, and probably not the best form setup
        //so just use this as an example rather than what you should do.
        //this is based off of naming conversions used in Python WTForms (I like to try to see if I can get some
        //php equivalents implemented (to a very, very basic degree))
        $product_name = Common::get($_POST, "product_name", '');
        $is_valid = true;
        if(strlen($product_name) > 0) {
            //make sure we have a name
            $product_category = Common::get($_POST, "product_category", "Game");
            $product_desc = Common::get($_POST, "product_desc", ''); #q_desc -> product_desc
            $product_quantity = Common::get($_POST, "product_quantity", 0); #attempts_per_day -> product_quantity
            //TODO important to note, if a checkbox isn't toggled/checked it won't be sent with the request.
            //Checkboxes have a poor design and usually need a hidden form and/or JS magic to work for unchecked values
            //so here we're just going to default to false if it's not present in $_POST
            $active = Common::get($_POST, "active", false);//used to hard limit the number of attempts
            #use_max -> active, idk if this will do what I want it too
            if(is_numeric($product_quantity) && (int)$product_quantity > 0){
                $product_quantity = (int)$product_quantity;
            }
            else{
                $is_valid = false;
                Common::flash("Product quantity must be a numerical value greater than zero", "danger");
            }
            $product_price = Common::get($_POST, "product_price", 0); #max_attempts -> product_price
            if(is_numeric($product_price) && (int)$product_price >= 0){
                $product_price = (int)$product_price;
            }
            else{
                $is_valid = false;
                Common::flash("Price must be a numerical value greater than or equal to zero, even if not used", "danger");
            } #don't think I need the below, just for questions & answers
            if($is_valid){
                //TODO here's where it gets a tad hacky and there are better ways to do it.
                /*$index = 0;
                $assumed_max_questions = 100;//this isn't a realistic limit, it's just to ensure
                $questions = [];
                //we don't get stuck in an infinite loop since while(true) is dangerous if not handled appropriately
                for($index = 0; $index < $assumed_max_questions; $index++){
                    $question = Common::get($_POST, "question_$index", false);
                    if($question){
                        $assumed_max_answers = 100;//same as $assumed_max_questions (var sits here so it resets each loop)
                        $answers = [];//reset array each loop
                        for($i = 0; $i < $assumed_max_answers; $i++){
                            $check = "".join(["question_",$index, "_answer_", $i]);
                            error_log("Checking for pattern $check");
                            $answer = Common::get($_POST, $check, false);
                            if($answer){
                                $check2 = "".join(["question_",$index, "_answeroe_", $i]);
                                //TODO important to note, if a checkbox isn't toggled/checked it won't be sent with the request.
                                //Checkboxes have a poor design and usually need a hidden form and/or JS magic to work for unchecked values
                                //so here we're just going to default to false if it's not present in $_POST
                                $oe = Common::get($_POST, $check2, false);
                                //checkbox comes in as 'on'
                                if($oe == 'on'){
                                    $oe = true;
                                }
                                //TODO we don't ignore if false, it should be true or false so a default of false is perfectly fine
                                array_push($answers, ["answer"=>$answer, "open_ended"=>$oe]);
                            }
                            else{
                                //we can break this loop since we have no more answers to parse
                                break;
                            }
                        }
                        array_push($questions,[
                            "question"=>$question,
                            "answers"=>$answers
                        ]);
                    }
                    else{
                        //we don't have anymore questions in post, early terminate the loop
                        break;
                    }
                }*/
                //echo "<pre>" . var_export($questions, true) . "</pre>";
                //echo "<pre>" . var_export($answers, true) . "</pre>";
                //TODO going to try to do this with as few db calls as I can
                //wrap it up so we can just pass one param to DBH
                $product = [ #questionnaire -> product
                    "name"=>$product_name,
                    "category"=>$product_category,
                    "quantity"=>$product_quantity,
                    "price"=>$product_price,
                    "description"=>$product_desc,
                    "active"=>$active
                ];
                $response = DBH::save_product($product);
                if(Common::get($response, "status", 400) == 200){
                    Common::flash("Successfully saved product", "success");
                }
                else{
                    Common::flash("There was an error creating the product", "danger");
                }
            }
        }
        else{
            $is_valid = false;
            Common::flash("A product name must be provided", "danger");
        }
        if(!$is_valid){
            //this will erase the form since it's a page refresh, but we need it to show the session messages
            //this is a last resort as we should use JS/HTML5 for a better UX
            die(header("Location: questionnaire.php"));
        }
    }
?>
<script>
    function update_names_and_ids($ele){
        let $lis = $ele.children(".list-group-item");
        //loop over all list-group-items of list-group
        $lis.each(function(index, item){
           let $fg = $(item).find(".form-group");
           let liIndex = index;
           //loop over all form-groups inside list-group-item
           $fg.each(function(index, item){
               let $label = $(item).find("label");
               if(typeof($label) !== 'undefined' && $label != null){
                   let forAttr = $label.attr("for");
                   let pieces = forAttr.split('_');
                   //Note this is different since it's a plain array not a jquery object
                   pieces.forEach(function(item, index){
                       if(!isNaN(item)){
                           pieces[index] = liIndex;
                       }
                   });
                   let updatedRef = pieces.join("_");
                   $label.attr("for", updatedRef);
                   let $input = $(item).find(":input");
                   if(typeof($input) !== 'undefined' && $input != null){
                       $input.attr("id", updatedRef);
                       $input.attr("name", updatedRef);
                   }
               }
           });
           //See if we have any children list-groups (this would be our answers)
           let $child_lg = $(item).find(".list-group");//probably doesn't need an each loop but it's fine
           $child_lg.each(function(index, item){
               let $childlis = $(item).find(".list-group-item");
               $childlis.each(function (index, item) {
                   let $fg = $(item).find(".form-group");
                   let childLiIndex = index;
                   //loop over all form-groups inside list-group-item
                   $fg.each(function(index, item){
                       let $label = $(item).find("label");
                       if(typeof($label) !== 'undefined' && $label != null){
                           let forAttr = $label.attr("for");
                           let pieces = forAttr.split('_');
                           //Note this is different since it's a plain array not a jquery object
                           let lastIndex = -1;
                           pieces.forEach(function(item, index){
                               if(!isNaN(item)){
                                   //question_#_answer_#
                                   if(lastIndex == -1) {
                                       //question_#
                                       pieces[index] = liIndex;//replace the first # with the parent outer loop index
                                       lastIndex = index;
                                   }
                                   else{
                                       //question_#_answer_#
                                       pieces[index] = childLiIndex;//replace the second # with the child loop index
                                   }
                               }
                           });
                           let updatedRef = pieces.join("_");
                           $label.attr("for", updatedRef);
                           let $input = $(item).find(":input");
                           if(typeof($input) !== 'undefined' && $input != null){
                               $input.attr("id", updatedRef);
                               $input.attr("name", updatedRef);
                           }
                       }
                   });
               });
           });
        });
    }
    function cloneThis(ele){ //creates additional text boxes?
        let $lg = $(ele).siblings(".list-group");
        let $li = $lg.find(".list-group-item:first");
        let $clone = $li.clone();
        $lg.append($clone);
        update_names_and_ids($(".list-group:first"));
    }
    function deleteMe(ele){ //deletes additional text boxes?
        let $li = $(ele).closest(".list-group-item");
        let $lg = $li.closest(".list-group");
        let $children = $lg.children(".list-group-item");
        if($children.length > 1){
            $li.remove();
            update_names_and_ids($(".list-group:first"));
        }
    }
</script>
</div> <!-- Why the heck is there a div here -->