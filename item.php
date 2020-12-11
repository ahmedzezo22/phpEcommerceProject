<?php
  session_start();
  $pageTitle='item page';
  include 'inti.php';

    //check if itemid is numeric and get numeric value of it
                      $itemid=isset($_GET['itemid'])&& is_numeric($_GET['itemid'])?intval($_GET['itemid']):0;
       //connect database
                      $stmt=$con->prepare("SELECT
                                      items.* ,
                                      category.name As category_Name,
                                      users.username As username
                                      FROM
                                      items
                                      INNER JOIN category
                                      ON
                                      category.id=items.cat_id
                                      INNER JOIN
                                      users WHERE itemID=:item AND approve=1");
                      $stmt->bindParam(':item',$itemid);
                      $stmt->execute();
      //fetch data from database
                     $row=$stmt->fetch();
       /* check if row exist or not */
                     $count=$stmt->rowCount();
                    if($stmt->rowCount()>0){?>
                    <h1 class="text-center"><?php echo $row['name']?></h1>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-3">
                                <img src="uploades/<?php echo $row['image'] ?>" class='img-responsive img-thumbnail center-block'>
                            </div>
                            <div class="col-md-9 item-info">
                                <h2><?php echo $row['name']?></h2>
                                <p><?php echo $row['description']?></p>
                                <ul class="list-unstyled">
                                <li>
                                    <i class="fa fa-calendar fa-fw"></i>
                                    <span>date</span> : <?php echo $row['date']?></li>
                                <li>
                                    <i class="fa fa-money fa-fw"></i>
                                    <span> price </span> : <?php echo $row['price']?></li>
                                <li>
                                    <i class="fa fa-building fa-fw"></i>
                                    <span> made in </span> : <?php echo $row['country_made']?></li>
                                <li>
                                    <i class="fa fa-tags fa-fw"></i>
                                    <span> category Name </span> : <a href="categories.php?pageid=<?php echo $row['cat_id']?>"><?php echo $row['category_Name']?></a></li>
                                <li>
                                    <i class="fa fa-user fa-fw"></i>
                                    <span> Added By </span> : <a href="#"><?php echo $row['username']?></a></li>
                                     
                                     <li>
                                      <i class="fa fa-tags fa-fw"></i>
                                    <span> tags </span> :
                                      <?php $alltags=explode(",",$row['tags']);
                                      foreach($alltags as $tag){
                                        if(!empty($tag)){
                                        $tag=str_replace(" ","",$tag);
                                        $lowertag=strtolower($tag);
                                        echo "<a href='tags.php?name={$lowertag}'class='tags'>".$tag."</a> ";
                                      }
                                      }
                                      ?>
                                     </li>
                                </ul>
                            </div>
                        </div>
                        <hr class="custom-hr">
                        <?php if(isset($_SESSION['user'])){?>
                        <div class="row">
                            <div class="col-md-offset-3">
                                <div class="comment-add">
                                <h3>Add your comment</h3>
                                <form action="<?php echo $_SERVER['PHP_SELF'] . '?itemid='.$row['itemID'] ;?>" method="POST">
                                    <textarea name="comment" required ></textarea>
                                    <input type="submit" class="btn btn-primary" value="Add comment">
                                </form>
                                <?php
                                if($_SERVER['REQUEST_METHOD']=='POST'){
                                $name=filter_var($_POST['comment']);
                                $userid=$_SESSION['Uid'];
                                $itemid=$row['itemID'];
                                if(!empty($name)){
                                    $stmt=$con->prepare("INSERT INTO comments(comment,status,date,user_id,item_id)VALUES(:a,0,now(),:d,:b)");
                                    $stmt->execute(array(
                                                         ':a'=>$name,
                                                         ':d'=>$userid,
                                                         ':b'=>$itemid
                                                         ));
                                    if($stmt){
                                        echo'<div class="alert alert-success">comment added successfuly</div>';
                                    }
                                }
                                
                                }
                                
                                
                                
                                
                                ?>
                                
                                
                                
                                </div>
                            </div>
                        </div>
                        <?php
                        }else{
            echo "<a href='login.php'>login</a> to add comment";
            
          }
                        ?>
                            <hr class="custom-hr">
                                                  <?php
                                     $stmt=$con->prepare("SELECT comments.*,users.username AS username FROM comments
                                       INNER JOIN users ON
                                      users.userID=comments.user_id WHERE item_id=? AND status=1
                                      ");
                  $stmt->execute(array($row['itemID']));
                  $rows=$stmt->fetchAll();
                  
                  ?>
                            <?php
                                foreach($rows as $com){?>
                               <div class="comment-box">
                                <div class="row">

                                <div class="col-sm-2 text-center">
                                <img src="layout/images/img.png"class="img-thumbnail img-responsive img-circle">

                                <?php echo $com['username'] ?>
                                </div>
                                <div class="col-sm-10 lead"><?php echo $com['comment'] ?></div>
                                </div>
                                </div>
                                                   <hr class="custom-hr">
                                <?php }?>
                               
                            
                        
                    </div>

          <?php     
                    }      
//if userid not exist
else{
   echo "<div class='container'>";
    $msg= '<div class="alert alert-danger">there is no such id And your items not approve yet</div>';
    redirectHome($msg,'back',6);
    echo "</div>";
}
  include $tpl .'footer.php';?>