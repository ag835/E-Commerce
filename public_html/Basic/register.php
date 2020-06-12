<?php
include("header.php");
?>
<h1>Create an account</h1>
<form method="POST">
    <label for="email">Email address
    <input type="email" id="email" name="email"/>
    </label>
    <br>
    <label for="p">Choose password
    <input type="password" id="p" name="password"/>
    </label>
    <br>
    <label for="cp">Re-enter password
    <input type="password" id="cp" name="cpassword"/>
    </label>
    <br>
    <label>Country of Residence</label>
    <select name="country">
        <option value="australia">Australia</option>
        <option value="canada">Canada</option>
        <option value="new zealand">New Zealand</option>
        <option value="united kingdom">United Kingdom</option>
        <option value="united states" selected>United States of America</option>
    </select>
    <br>
    <hr>
    <input type="checkbox" id="robot" name="robot">
    <label for="robot">I'm not a robot</label>
    <br><hr>
    <h2>Terms and Conditions</h2>
    <p>[...terms, conditions...]</p>
    <br>
    <input type="checkbox" id="agree" name="agree">
    <label for="agree">I agree to the Terms and Conditions</label>
    <br><br>
    <input type="submit" name="register" value="Complete sign up"/>
</form>

<?php
#include("header.php"); #wrong spot
#echo var_export($_GET, true);
#echo var_export($_POST, true);
#echo var_export($_REQUEST, true);
if(isset($_POST["register"])) {
    if(isset($_POST["password"]) && isset($_POST["cpassword"]) && isset($_POST["email"])) {
        $password = $_POST["password"];
        $cpassword = $_POST["cpassword"];
        $email = $_POST["email"];
        if($password == $cpassword) {
            #echo "<div>Passwords Match</div>";
            #require("config.php");
            $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
            try {
                $db = new PDO($connection_string, $dbuser, $dbpass);
                $hash = password_hash($password, PASSWORD_BCRYPT);
                $stmt = $db->prepare("INSERT INTO Users (email, password) VALUES(:email, :password)");
                $stmt->execute(array(
                    ":email" => $email,
                    ":password" => $hash #Don't save the raw password $password
                ));
                $e = $stmt->errorInfo();
                if ($e[0] != "00000") {
                    echo var_export($e, true);
                }
                else {
                    echo "<div>Successfully registered</div>";
                }
            }
            catch (Exception $e) {
                echo $e->getMessage();
            }
        }
        else{
            echo "<div>Passwords do not match</div>";
        }
    }
}
?>
