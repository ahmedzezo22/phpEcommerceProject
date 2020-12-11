<?php
  session_start();
  $pageTitle='profile';
  include 'inti.php';
  if(isset($_SESSION['user'])){
    $stmt=$con->prepare("SELECT * FROM users WHERE username=?");
    $stmt->execute(array($_SESSION['user']));
    $info=$stmt->fetch();
  ?>
 
  <div class="information">
    <div class="container">
      <h1 class="text-center"><?php echo $_SESSION['user']?> Profile</h1>
      <div class="panel panel-primary">
         <div class="panel-heading">My information</div>
         <div class="panel-body">
          <ul class="list-unstyled">
            <li><i class="fa fa-unlock-alt fa-fw"></i><span>name</span>: <?php echo $info['username'];?></li>
             <li><i class="fa fa-envelope-o fa-fw"></i><span>E-mail</span>: <?php echo $info['email']?></li>
            <li> <i class="fa fa-user fa-fw"></i><span>fullName</span>: <?php echo $info['fullName']?></li>
           <li><i class="fa fa-calendar fa-fw"></i><span>RegisterDate</span>: <?php echo $info['date']?></li>
          <li><i class="fa fa-tags fa-fw"></i><span>favouriteCategory</span>:
          </ul>
          <a href="#" class="btn btn-default infoEdit">Edit information</a>
         </div>
      </div>
      </div>
     <div class="ads">
    <div class="container">
      <div class="panel panel-primary">
         <div class="panel-heading">My ads</div>
         <div class="panel-body">
            <div class="row">
        <?php
        if(!empty(getItems( 'member_id',$info['userID'] ))){
        foreach( getItems( 'member_id',$info['userID'],1)as $item){
            echo '<div class="col-sm-6 col-md-4">';
            echo '<div class="thumbnail">';
            if($item['approve']==0){
              echo '<div class="waiting-approval">Waiting Approval</div>';
            }
             echo '<span>'.$item['price'].'</span>'; 
            if(empty($item['image'])){echo '<img src="layout/images/img.png">';}else{
            echo'<img src="uploades/'. $item['image'].'" class="img-responsive center-block imgshow">';}
            echo '<div class="caption">';
            echo '<h3><a href="item.php?itemid='.$item['itemID'].'">'.$item['name'].'</a><h3>';
            echo '<p>' .$item['description'].'<p>';
            echo '<div class="date">' .$item['date'].'</div>';
             echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        }else{
          echo '&nbsp;&nbsp;&nbsp;there is no ads create new ad <a href="ads.php">add Ad</a>';
        }
        
        ?>
         </div>
      </div>
      </div>
     <div class="comments">
    <div class="container">
      <div class="panel panel-primary">
         <div class="panel-heading">My Latest Comments</div>
         <div class="panel-body">
            <?php
            $stmt=$con->prepare("SELECT comment FROM comments WHERE user_id=?");
            $stmt->execute(array($info['userID']));
            $com=$stmt->fetchAll();
            if(!empty($com)){
              foreach($com as $co){
                
                echo $co['comment'] ."<br>";
              }
            }else{
              echo'there is no comments to show';
            }
            
            
            
            ?>
         </div>
      </div>
      </div>
     
  
  </div>
  <?php
  }else{
    header('location:login.php');
    exit();
  }
  
  include $tpl .'footer.php';?>