<?php
 ob_start();
   session_start();
   $pageTitle="members";
   if(isset($_SESSION['username'])){
      include 'inti.php';
           $do=isset($_GET['do'])?$_GET['do']:'manage';
    //manage page
              
               if($do=='manage'){
                 
                  $stmt=$con->prepare("SELECT comments.*,items.name AS itemName,users.username AS username FROM comments
                                      INNER JOIN items ON items.itemID=comments.item_id INNER JOIN users ON
                                      users.userID=comments.user_id
                                      ");
                  $stmt->execute();
                  $rows=$stmt->fetchAll();
                  if(!empty($rows)){
    ?>
          <h1 class="text-center">comments</h1>
          <div class="container">
             <div class="table-responsive text-center">
                  <table class="table table-bordered main-table">
                     <tr>
                        <td>#ID</td>
                        <td>comment</td>
                        <td>ItemName</td>
                        <td>userName</td>
                        <td>Added date</td>
                        <td>controls</td>
                     </tr>
                    <?php
                        foreach($rows as $row){
                              echo' <tr>';
                              echo '<td>' .$row['c_id'].'</td>';
                              echo '<td>' .$row['comment'].'</td>';
                              echo '<td>' .$row['itemName'].'</td>';
                              echo '<td>' .$row['username'].'</td>';
                              echo  '<td>' .$row['date'].'</td>';
                              echo '<td>
                                    <a href="comment.php?do=edit&comid='.$row['c_id'].'" class="btn btn-success"><i class="fa fa-edit"></i>Edit</a>
                                    <a href="comment.php?do=delete&comid='.$row['c_id'].'" class="btn btn-danger confirm"><i class="fa fa-close"></i>Delete</a>';
                                    if($row['status']==0){
                                  echo'<a href="comment.php?do=approve&comid='.$row['c_id'].'" class="btn btn-info activate">Approve</a>';
                                    }
                              echo'</td>';
                              echo'</tr>';
                      }
                   ?>
                    
                </table>
                
             </div>
             
          </div>
          <?php
          }else{ echo '<div class="container">';
                  echo'<div class=" nice-message ">there is no comments to show </div>';
                  echo'</div>';
          }
   
   }elseif($do=='edit'){
    //check if comid is numeric and get numeric value of it
                      $comid=isset($_GET['comid'])&& is_numeric($_GET['comid'])?intval($_GET['comid']):0;
       //connect database
                      $stmt=$con->prepare("SELECT * FROM comments WHERE c_id=:id limit 1 ");
                      $stmt->bindParam('id',$comid);
                      $stmt->execute();
      //fetch data from database
                     $row=$stmt->fetch();
       /* check if row exist or not */
                     $count=$stmt->rowCount();
                    if($stmt->rowCount()>0){?>
                           <h1 class="text-center">Edit comment</h1>
                           <div class="container">
                               <form class="form-horizontal" method="post" action="?do=update">
                                    <input type="hidden" name="comid" value="<?php echo $comid?>"> 
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Comment</label>
                                 <div class="col-sm-10 col-md-6">
                                    <textarea class="form-control" name="comment"><?php echo $row['comment'];?></textarea>
                               </div>
            
                                  </div>

     <div class="form-group form-group-lg">
        
        <div class="col-sm-offset-2 col-sm-10 ">
            <input type="submit" name="save" value="save" class="btn btn-primary">
        </div>
        </div>
       </div>
    </form>
<?php
} 
    
//if userid not exist
else{
   echo "<div class='container'>";
    $msg= '<div class="alert alert-danger">there is no such id</div>';
    redirectHome($msg,'back');
    echo "</div>";
}
}elseif($do=='update'){
    echo "<h1 class='text-center'>update comment</h1>";
    echo "<div class='container'>";
    if($_SERVER['REQUEST_METHOD']=="POST"){
         $id=$_POST['comid'];
       $comment=$_POST['comment'];
    
          $stmt= $con->prepare("UPDATE comments set comment=? WHERE c_id=?");
           $stmt->execute(array($comment,$id));
          $msg= '<div class= "alert alert-success">' .$stmt->rowCount().'record updated  </div>';
          redirectHome($msg,'back',5);
           
 
    }
    
    else{
        $msg='<div class= "alert alert-danger">you can not browse this page directly</div>';
        redirectHome($msg,'back',5);
    }
    echo "</div>"; 
} elseif($do=='delete'){
               echo "<h1 class='text-center'>delete comment</h1>";
                echo "<div class='container'>";
          //check if comid is numeric and get numeric value of it
                      $comid=isset($_GET['comid'])&& is_numeric($_GET['comid'])?intval($_GET['comid']):0;
       //connect database
                      $stmt=$con->prepare("SELECT * FROM comments WHERE c_id=:co ");
                      $stmt->bindParam('co',$comid);
                      $stmt->execute();
       /* check if row exist or not */
                     $count=$stmt->rowCount();
                    if($stmt->rowCount()>0){
                     $stmt=$con->prepare("DELETE FROM comments WHERE c_id=:co");
                     $stmt->bindParam('co',$comid);
                     $stmt->execute();
                   $msg= '<div class= "alert alert-success"> '.$stmt->rowCount().'deleted  </div>';
                   redirectHome($msg,'back');
          }
  echo "</div>";
   }elseif($do=='approve'){
    echo "<h1 class='text-center'>approve comment</h1>";
                echo "<div class='container'>";
          //check if comid is numeric and get numeric value of it
                      $comid=isset($_GET['comid'])&& is_numeric($_GET['comid'])?intval($_GET['comid']):0;
                      
                      
                       //connect database
                      $stmt=$con->prepare("SELECT * FROM comments WHERE c_id=:co ");
                      $stmt->bindParam('co',$comid);
                      $stmt->execute();
       /* check if row exist or not */
                     $count=$stmt->rowCount();
                    if($stmt->rowCount()>0){
                        $stmt=$con->prepare("UPDATE comments SET status=1 WHERE c_id=? ");
                        $stmt->execute(array($comid));
                         $msg= '<div class= "alert alert-success"> '.$stmt->rowCount().' comment approved </div>';
                   redirectHome($msg,'back');
   }
   }
   
    include  $tpl. "footer.php";
   }
        ob_end_flush();
      
   