<?php
include("header.php");
?>
<h1>Sign in</h1>
<form method="POST">
    <label for="email">Email address
        <input type="email" id="email" name="email" required/>
    </label>
    <br>
    <label for="p">Password
        <input type="password" id="p" name="password" required/>
    </label>
    <input type="submit" name="login" value="Sign in"/>
</form>

<?php
#echo var_export($_GET, true);
#echo var_export($_POST, true);
#echo var_export($_REQUEST, true);
if(isset($_POST["login"])) {
    if (empty($_POST["login"])) {
        echo "<div>Please fill out all input fields.</div>";
    } else {
        if (isset($_POST["password"]) && isset($_POST["email"])) {
            $password = $_POST["password"];
            $email = $_POST["email"];
            #require("config.php");
            #$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4"; 07/04
            try {
                #$db = new PDO($connection_string, $dbuser, $dbpass); 07/04
                $stmt = getDB()->prepare("SELECT * FROM Users where email = :email LIMIT 1");
                $stmt->execute(array(
                    ":email" => $email
                ));
                $e = $stmt->errorInfo();
                if ($e[0] != "00000") {
                    echo var_export($e, true);
                } else {
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($result) {
                        $rpassword = $result["password"];
                        if (password_verify($password, $rpassword)) {
                            echo "<div>You are logged in.</div>";
                            $_SESSION["user"] = array(
                                "id" => $result["id"],
                                "email" => $result["email"]
                               #"first_name" => $result["first_name"],
                                #"last_name" => $result["last_name"]
                            );
                            echo var_export($_SESSION, true);
                            header("Location: home.php");
                        } else {
                            echo "<div>The email or password that you have entered is incorrect.</div>";
                        }
                    } else {
                        echo "<div>The email or password that you have entered is incorrect.</div>";
                    }
                    #echo "<div>Successfully registered</div>";
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    }
}
?>