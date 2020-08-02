<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once(__DIR__."/partials/header.partial.php");
?>
    <div>
        <h4>Create an account</h4>
        <div class="container-sm">
        <form method="POST">
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" id="email" name="email" required/>
            </div>
            <div class="form-group">
                <label for="username">Account Name</label>
                <input type="username" id="username" name="username" required min="2"/>
            </div>
            <div class="form-group">
                <label for="password">Choose password</label>
                <input type="password" id="password" name="password" required min="3"/>
            </div>
            <div class="form-group">
                <label for="cpassword">Re-enter password</label>
                <input type="password" id="cpassword" name="cpassword" required min="3"/>
            </div>
            <div class="form-group">
                <label>Country of Residence</label>
                <select name="country">
                    <option value="Australia">Australia</option>
                    <option value="Canada">Canada</option>
                    <option value="New Zealand">New Zealand</option>
                    <option value="United Kingdom">United Kingdom</option>
                    <option value="United States" selected>United States</option>
                </select>
            </div>
            <input type="submit" name="submit" class="btn btn-primary" value="Register"/>
        </form>
        </div>
    </div>
<?php
if (Common::get($_POST, "submit", false)){
    $email = Common::get($_POST, "email", false);
    $username = Common::get($_POST, "username", false);
    $password = Common::get($_POST, "password", false);
    $confirm_password = Common::get($_POST, "cpassword", false);
    $country = Common::get($_POST, "country", false);
    if($password != $confirm_password){
        Common::flash("Passwords must match", "warning");
        die(header("Location: register.php"));
    }
    if(!empty($email) && !empty($username) && !empty($password) && !empty($country)){
        $result = DBH::register($email, $username, $password, $country);
        echo var_export($result, true);
        if(Common::get($result, "status", 400) == 200){
            Common::flash("Successfully registered, please login", "success");
            die(header("Location: " . Common::url_for("login")));
        }
    }
    else{
        Common::flash("Email, username, and password must not be empty", "warning");
        die(header("Location: register.php"));
    }
}