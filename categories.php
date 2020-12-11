<?php
session_start();

$pageTitle="categories";
include "inti.php"; ?>
    <div class="container">
        <h1 class="text-center">Category</h1>
        <div class="row">
        <?php
        foreach( getItems( 'cat_id', $_GET['pageid'])as $item){
            echo '<div class="col-sm-6 col-md-4">';
            echo '<div class="thumbnail">';
             echo '<span>'.$item['price'].'</span>'; 
             if(empty($item['image'])){echo '<img src="layout/images/img.png">';}else{
            echo'<img src="uploades/'. $item['image'].'" class="img-responsive img-thumbnail center-block imgshow">';}
            echo '<div class="caption">';
            echo '<h3><a href="item.php?itemid='.$item['itemID'].'">'.$item['name'].'</a><h3>';
            echo '<p>' .$item['description'].'<p>';
             echo '<div class="date">' .$item['date'].'</div>';
             echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        
        ?>
    </div>

<?php include  $tpl. 'footer.php'; ?>
  