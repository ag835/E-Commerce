<?php
require_once (__DIR__."/../includes/common.inc.php");
$logged_in = Common::is_logged_in(false);
?>
<!-- Bootstrap 4 CSS only (CHANGED LINK)-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<!-- Include jQuery 3.5.1 (ACTUALLY MORE THAN THAT)-->
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <ul class="navbar-nav mr-auto">
        <?php if($logged_in):?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo Common::url_for("home");?>">Home</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="<?php echo Common::url_for("profile");?>" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo Common::get_username();?>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="<?php echo Common::url_for("create_questionnaire");?>">Order History</a>
                    <a class="dropdown-item" href="<?php echo Common::url_for("edit_products");?>">Friends</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Edit Details</a>
                </div>
            </li>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo Common::url_for("shop");?>">Store</a>
            </li>
            <?php if (Common::has_role("Admin")):?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="<?php echo Common::url_for("create_questionnaire");?>" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Manage Products
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="<?php echo Common::url_for("create_questionnaire");?>">Add a product</a>
                        <a class="dropdown-item" href="<?php echo Common::url_for("edit_products");?>">Edit products</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo Common::url_for("view_orders");?>">View Orders</a>
                </li>
            <?php endif;?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo Common::url_for("surveys");?>">Surveys</a>
            </li>
        <?php endif; ?>
        <?php if(!$logged_in):?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo Common::url_for("login");?>">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo Common::url_for("register");?>">Register</a>
            </li>
        <?php else:?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo Common::url_for("logout");?>">Logout</a>
            </li>
        <?php endif; ?>
    </ul>
</nav>
<div id="messages">
    <?php $flash_messages = Common::getFlashMessages();?>
    <?php if(isset($flash_messages) && count($flash_messages) > 0):?>
        <?php foreach($flash_messages as $msg):?>
            <div class="alert alert-<?php echo Common::get($msg, "type");?>"><?php
                echo Common::get($msg, "message");
                //We have the opening and closing tags right after/before the div tags to remove any whitespace characters
                ?></div>
        <?php endforeach;?>
    <?php endif;?>
</div>