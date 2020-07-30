<?php
include_once(__DIR__."/partials/header.partial.php");

if(Common::is_logged_in()){
    //this will auto redirect if user isn't logged in

}
?>
<div>
    <h1>Home</h1>
    <p>Welcome, <?php echo Common::get_username();?></p>
</div>
<p><strong>FEATURED AND RECOMMENDED</strong></p>
<div id="carouselExampleIndicators" class="carousel slide" style="width: 400px" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="d-block w-100" src="images/Hellblade.jpg" alt="Hellblade">
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" src="images/Prey.jpg" alt="Prey">
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" src="images/outlast2_1.jpg" alt="Outlast 2">
        </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>