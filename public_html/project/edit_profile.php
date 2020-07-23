<?php
include_once(__DIR__."/partials/header.partial.php");
if(Common::is_logged_in()){
?>
<h1>Edit Details</h1>
<div class="container-fluid">
    <form class="method="POST">
        <div class="form-group">
            <label for="new_username">Username</label>
            <input class="form-control" type="text" id="new_username" name="new_username"/>
        </div>
        <div class="form-group">
            <input type="submit" name="submit" class="btn btn-primary" value="Change"/>
        </div>
        <hr>
        <div class="form-group">
            <label for="new_email">Email address</label>
            <input class="form-control" type="text" id="new_email" name="new_email"/>
        </div>
        <div class="form-group">
            <input type="submit" name="submit" class="btn btn-primary" value="Change"/>
        </div>
        <hr>
        <div class="form-group">
            <label for="new_pass">New Password</label>
            <input class="form-control" type="password" id="new_pass" name="new_pass"/>
        </div>
        <div class="form-group">
            <label for="confirm_newPass">Confirm New Password</label>
            <input class="form-control" type="password" id="confirm_newPasse" name="confirm_newPass"/>
        </div>
        <div class="form-group">
            <input type="submit" name="submit" class="btn btn-primary" value="Reset Password"/>
        </div>
    </form>
</div>


<?php
}
?>