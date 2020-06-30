<?php
include_once(__DIR__."/partials/header.partial.php");
?>
    <div>
        <h1>Sign in</h1>
        <form method="POST">
            <div>
                <label for="email">Email address</label>
                <input type="email" id="email" name="email" required/>
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required min="3"/>
            </div>
            <input type="submit" name="submit" value="Sign in"/>
        </form>
    </div>
<?php
if (Common::get($_POST, "submit", false)){
    $email = Common::get($_POST, "email", false);
    $password = Common::get($_POST, "password", false);
    if(!empty($email) && !empty($password)){
        $result = DBH::login($email, $password);
        echo var_export($result, true);
        if(Common::get($result, "status", 400) == 200){
            $_SESSION["user"] = Common::get($result, "data", NULL);
            die(header("Location: " . Common::url_for("home")));
        }
        else{
            Common::flash(Common::get($result, "message", "Error logging in"));
            die(header("Location: " . Common::url_for("login")));
        }
    }
    else{
        Common::flash("Please fill out all input fields.", "warning");
        die(header("Location: " . Common::url_for("login")));
    }
}