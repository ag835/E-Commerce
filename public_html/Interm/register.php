<?php
include_once(__DIR__."/Partials/header.partial.php");
?>
<h1>Create an account</h1>
<form method="POST">
    <label for="email">Email address
    <input type="email" id="email" name="email" required/>
    </label>
    <br>
    <label for="p">Choose password
    <input type="password" id="p" name="password" required min="3"/>
    </label>
    <br>
    <label for="cp">Re-enter password
    <input type="password" id="cp" name="cpassword" required min="3"/>
    </label>
    <br>
    <label>Country of Residence</label>
    <select name="country">
        <option value="australia">Australia</option>
        <option value="canada">Canada</option>
        <option value="new zealand">New Zealand</option>
        <option value="united kingdom">United Kingdom</option>
        <option value="united states" selected>United States</option>
    </select>
    <br>
    <hr>
    <input type="checkbox" id="robot" name="robot" required>
    <label for="robot">I'm not a robot</label>
    <br><hr>
    <h2>Terms and Conditions</h2>
    <p>[...terms, conditions...]</p>
    <br>
    <input type="checkbox" id="agree" name="agree" required>
    <label for="agree">I agree to the Terms and Conditions</label>
    <br><br>
    <input type="submit" name="register" value="Complete sign up"/>
</form>
<footer><p>Copyright &copy 2020, amo</p></footer>
<?php
//have to adjust this for additonal requirements, username and country (also adjust db_helper)
if (Common::get($_POST, "submit", false)){
    $email = Common::get($_POST, "email", false);
    $password = Common::get($_POST, "password", false);
    $confirm_password = Common::get($_POST, "cpassword", false);
    if($password != $confirm_password){
        Common::flash("Passwords must match", "warning");
        die(header("Location: register.php"));
    }
    if(!empty($email) && !empty($password)){
        $result = DBH::register($email, $password);
        echo var_export($result, true);
        if(Common::get($result, "status", 400) == 200){
            Common::flash("Successfully registered, please login", "success");
            die(header("Location: " . Common::url_for("login")));
        }
    }
    else{
        Common::flash("Email and password must not be empty", "warning");
        die(header("Location: register.php"));
    }
}