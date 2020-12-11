<?php
session_start();

$pageTitle="";
include "inti.php";
if(isset($_GET['name'])){
    $page=$_GET['name'];
?>

    <div class="container">
        <h1 class="text-center"><?php echo $page?></h1>
        <div class="row">
        <?php
        $stmt=$con->prepare("SELECT * FROM items WHERE tags LIKE '%$page%' AND approve=1 ");
        $stmt->execute();
        $items=$stmt->fetchAll();
        foreach( $items as $item){
            echo '<div class="col-sm-6 col-md-4">';
            echo '<div class="thumbnail">';
             echo '<span>'.$item['price'].'</span>'; 
                 if(empty($item['image'])){echo '<img src="layout/images/img.png" class="img-circle headimg">';}else{
            echo'<img src="uploades/'. $item['image'].'" class="img-circle headimg">';}
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
        <?php }?>
<?php include  $tpl. 'footer.php'; ?>
  