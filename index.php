<?php
 session_start();
  $pageTitle='Homepage';

include "inti.php";
$stmt=$con->prepare("SELECT * FROM items WHERE approve=1 ORDER BY itemID DESC");
$stmt->execute();
$rows=$stmt->fetchAll();?>
     <div class="container">
        <div class="row">
        <?php
        foreach( $rows as $item){
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
     </div>    
 
 <?php include  $tpl. 'footer.php';
  ?>