<?php
//TODO: remember me
//https://stackoverflow.com/questions/244882/what-is-the-best-way-to-implement-remember-me-for-a-website
include_once(__DIR__."/partials/header.partial.php");
?>
<div>
    <h4>SIGN IN</h4>
    <hr>
    <div class="container-sm">
        <form method="POST">
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" id="email" name="email" required/>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required min="3"/>
            </div>
            <div class="form-group">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Remember Me</label>
            </div>
            <input type="submit" name="submit" class="btn btn-primary" value="Login"/>
        </form>
    </div>
</div>
<?php
if (Common::get($_POST, "submit", false)){
    $email = Common::get($_POST, "email", false);
    $password = Common::get($_POST, "password", false);
    if(!empty($email) && !empty($password)){
        $result = DBH::login($email, $password);
        //echo var_export($result, true);
        if(Common::get($result, "status", 400) == 200){
            $_SESSION["user"] = Common::get($result, "data", NULL);

            //fetch system user id and put it in session to reduce DB calls to fetch it when we need
            //to generate points from activity on the app
            $result = DBH::get_system_user_id();
            $result = Common::get($result, "data", false);
            if($result) {
                $_SESSION["system_id"] = Common::get($result, "id", -1);
                //error_log("Got system_id " . $_SESSION["system_id"]);
            }
            Common::flash(Common::get($result, "message", "Successfully signed in"));
            die(header("Location: " . Common::url_for("home")));
        }
        else{
            Common::flash("Invalid credentials", "warning");
            die(header("Location: " . Common::url_for("login")));
        }
    }
    else{
        Common::flash("Email and password must not be empty", "warning");
        die(header("Location: " . Common::url_for("login")));
    }
}
?>