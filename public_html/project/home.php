<?php
include_once(__DIR__."/partials/header.partial.php");
$items = array();
$result = DBH::get_new_releases();
$_items = Common::get($result, "data", false);
if($_items){
    $items = $_items;
}
?>
<style>
    body {
        background-color: black;
        color: aliceblue;
    }
    .list-group-item {
        background-color: dimgrey;
        color: aliceblue;
    }
</style>
<div>
    <h1>Home</h1>
    <?php if (Common::is_logged_in(false)): ?>
        <p>Welcome, <?php echo Common::get_username();?></p>
    <?php endif;?>
</div>
<p><strong>FEATURED AND RECOMMENDED</strong></p>
<div id="carouselExampleIndicators" class="carousel slide" style="width: 800px; margin: 0 auto"
     data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
    </ol>
    <div class="carousel-inner">
        <?php $total = count($items);
        if($total > 0):
        $firstItem = $items[0];
        ?>
            <div class="carousel-item active">
                <img class="d-block w-100" src="images/<?php echo Common::get($firstItem,"name");?>.jpg"
                     alt="<?php echo Common::get($firstItem,"name");?>">
            </div>
            <?php for($i = 1; $i < 5; $i++):
                $item = null;
                if($i < $total){
                    $item = $items[$i];
                }
                ?>
                <?php if(isset($item)):?>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="images/<?php echo Common::get($item,"name");?>.jpg"
                             alt="<?php echo Common::get($item,"name");?>">
                    </div>
                <?php endif;?>
            <?php endfor;?>
        <?php endif;?>
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
<?php if (!Common::is_logged_in(false)): ?>
    <hr>
    <p><i>Register or log in to purchase items and access more features</i></p>
<?php endif;?>
