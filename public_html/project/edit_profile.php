<?php
//TODO: Have to click twice for warning alerts to show up
//TODO: Make user confirm current pass to reset password (direct to new form?)
include_once(__DIR__."/partials/header.partial.php");
if(Common::is_logged_in()) {
    //will boot if not
}
?>
<h1>Edit Details</h1>
<div class="container-fluid">
    <form method="POST">
        <div class="form-group">
            <label for="new_username">Username</label>
            <input class="form-control" type="text" id="new_username" name="new_username" min="2"/>
        </div>
        <div class="form-group">
            <input type="submit" name="change_username" class="btn btn-primary" value="Change"/>
        </div>
        <hr>
        <div class="form-group">
            <label for="new_email">Email address</label>
            <input class="form-control" type="email" id="new_email" name="new_email"/>
        </div>
        <div class="form-group">
            <input type="submit" name="change_email" class="btn btn-primary" value="Change"/>
        </div>
        <hr>
        <div class="form-group">
            <label for="new_pass">New Password</label>
            <input class="form-control" type="password" id="new_pass" name="new_pass" min="3"/>
        </div>
        <div class="form-group">
            <label for="confirm_newPass">Confirm New Password</label>
            <input class="form-control" type="password" id="confirm_newPass" name="confirm_newPass" min="2"/>
        </div>
        <div class="form-group">
            <input type="submit" name="change_pass" class="btn btn-primary" value="Reset Password"/>
        </div>
    </form>
</div>
<?php
if(isset($_POST["change_username"])){
    $username = "";
    if(isset($_POST["new_username"]) && !empty($_POST["new_username"])){
        $username = $_POST["new_username"];
    }
    if(!empty($username) && strlen($username) > 2){
        $response = DBH::update_credentials($username, "username");
        if(Common::get($response, "status", 400) == 200){
            Common::flash("Successfully changed username", "success");
            die(header("Location: " . Common::url_for("edit_profile")));
        }
        else{
            Common::flash("Username is already taken", "warning");
            die(header("Location: " . Common::url_for("edit_profile")));
        }
    }
    else {
        //echo $name, $rating, $title, $description;
        Common::flash("Please choose a username of appropriate length", "warning");
        die(header("Location: " . Common::url_for("edit_profile")));
    }
}
else if (isset($_POST['change_email'])) {
    $email = "";
    if(isset($_POST["new_email"]) && !empty($_POST["new_email"])){
        $email = $_POST["new_email"];
    }
    if(!empty($email)){
        $response = DBH::update_credentials($email, "email");
        if(Common::get($response, "status", 400) == 200){
            Common::flash("Successfully changed email", "success");
            die(header("Location: " . Common::url_for("edit_profile")));
        }
        else{
            Common::flash("Email is already in use", "warning");
            die(header("Location: " . Common::url_for("edit_profile")));
        }
    }
    else {
        //echo $name, $rating, $title, $description;
        Common::flash("Please choose an email of appropriate length", "warning");
        die(header("Location: " . Common::url_for("edit_profile")));
    }
}
else if (isset($_POST['change_pass'])) {
    $password = "";
    $cpassword = "";
    if(isset($_POST["new_pass"]) && !empty($_POST["new_pass"])){
        $password = $_POST["new_pass"];
    }
    if(isset($_POST["confirm_newPass"]) && !empty($_POST["confirm_newPass"])){
        $cpassword = $_POST["confirm_newPass"];
    }
    if($password != $cpassword){
        Common::flash("Passwords must match", "warning");
        die(header("Location: edit_profile.php"));
    }
    if(!empty($password)){
        $response = DBH::update_credentials($password, "password");
        if(Common::get($response, "status", 400) == 200){
            Common::flash("Successfully changed password", "success");
            die(header("Location: " . Common::url_for("edit_profile")));
        }
        else{
            Common::flash("Error updating password", "warning");
            die(header("Location: " . Common::url_for("edit_profile")));
        }
    }
    else {
        //echo $name, $rating, $title, $description;
        Common::flash("Please choose a password of appropriate length", "warning");
        die(header("Location: " . Common::url_for("edit_profile")));
    }
}
?>