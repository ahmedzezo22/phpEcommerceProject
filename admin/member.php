   <?php
   session_start();
   $pageTitle="members";
   if(isset($_SESSION['username'])){
      include 'inti.php';
           $do=isset($_GET['do'])?$_GET['do']:'manage';
    //manage page
              
               if($do=='manage'){
                  $query='';
              if(isset($_GET['page'])&& $_GET['page']=='pending'){
               $query='AND registerStatus=0';
              }
                  $stmt=$con->prepare("SELECT * FROM users WHERE groupID !=1 $query ORDER BY userID DESC");
                  $stmt->execute();
                  $rows=$stmt->fetchAll();
                  if(!empty($rows)){
    ?>
          <h1 class="text-center">manage Members</h1>
          <div class="container">
             <div class="table-responsive text-center">
                  <table class="table table-bordered main-table">
                     <tr>
                        <td>#ID</td>
                        <td>username</td>
                         <td>image</td>
                        <td>Email</td>
                        <td>fullName</td>
                        <td>register date</td>
                        <td>controls</td>
                     </tr>
                    <?php
                        foreach($rows as $row){
                              echo' <tr>';
                              echo '<td>' .$row['userID'].'</td>';
                               echo '<td>'.$row['username'].'</td>';
                               echo '<td>';
                               if(empty($row['images'])){echo '<img src="layout/images/img.png">';}else{
                               echo'<img src="uploades/' .$row['images'].'">';}
                               echo'</td>';
                              echo '<td>' .$row['email'].'</td>';
                              echo '<td>' .$row['fullName'].'</td>';
                              echo  '<td>' .$row['date'].'</td>';
                              echo '<td>
                                    <a href="member.php?do=edit&userid='.$row['userID'].'" class="btn btn-success"><i class="fa fa-edit"></i>Edit</a>
                                    <a href="member.php?do=delete&userid='.$row['userID'].'" class="btn btn-danger confirm"><i class="fa fa-close"></i>Delete</a>';
                                    if($row['registerStatus']==0){
                                  echo'<a href="member.php?do=activate&userid='.$row['userID'].'" class="btn btn-info activate">Activate</a>';
                                    }
                              echo'</td>';
                              echo'</tr>';
                      }
                   ?>
                    
                </table>
                
             </div>
             <a href='member.php?do=add' class="btn btn-primary " style="width:200px"><i class="fa fa-plus"></i>add new member</a>
             
          </div>
   
   <?php
                  }else{ echo '<div class="container">';
                  echo'<div class=" nice-message ">there is no members to show </div>';
                   echo'<a href="member.php?do=add" class="btn btn-primary " style="width:200px"><i class="fa fa-plus"></i>add new member</a>';
   }
                  echo '</div>';
                 
   
               }elseif($do=='add'){?>
        <h1 class="text-center">Add Member</h1>
                           <div class="container">
                               <form class="form-horizontal" method="post" action="?do=insert" enctype="multipart/form-data">
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">user name</label>
                                 <div class="col-sm-10 col-md-6">
                                    <input type="text" required="required" name="username" class="form-control"autocomplete="off"placeholder="username to login shop">
                               </div>
            
                                  </div>
       
       
       <div class="form-group form-group-lg">
           <label class="col-sm-2 control-label">password</label>
        <div class="col-sm-10 col-md-6">
            <input type="password" name="password" class="form-control password"autocomplete="off" placeholder="password must be hard & complex">
             <i class="fa fa-eye fa-2x showpass"></i>
        </div>
            
        </div>

      <div class="form-group form-group-lg">
        <label class="col-sm-2 control-label">E-mail</label>
        <div class="col-sm-10 col-md-6">
            <input type="email" name="email" required="required" class="form-control" autocomplete="off" placeholder="enter invalid email"  >
        </div>
            
        </div>
      
      
      <div class="form-group form-group-lg ">
        <label class="col-sm-2 control-label">full name</label>
        <div class="col-sm-10 col-md-6">
            <input type="text" required="required" name="fullname" class="form-control"autocomplete="off" placeholder="enter full name">
        </div>
            
        </div>
      <div class="form-group form-group-lg ">
        <label class="col-sm-2 control-label">user image</label>
        <div class="col-sm-10 col-md-6">
            <input type="file"  name="a" required="required" class="form-control">
        </div>
            
        </div>

     <div class="form-group form-group-lg">
        
        <div class="col-sm-offset-2 col-sm-10 ">
            <input type="submit" name="save" value="add" class="btn btn-primary">
        </div>
        </div>
       </div>
    </form>
         <?php }
         elseif($do=='insert'){
            
    if($_SERVER['REQUEST_METHOD']=="POST"){   
      
        
        echo "<h1 class='text-center'>add member</h1>";
        echo "<div class='container'>";
        
         $imageName=$_FILES['a']['name'];
         $imageSize=$_FILES['a']['size'];
         $imageType=$_FILES['a']['type'];
         $imageTmp=$_FILES['a']['tmp_name'];
         $imageAllowedExtension=array("jpg","jpeg","gif","png");
         $imageExtension=strtolower(end(explode('.',$imageName)));
        
         $username=$_POST['username'];
         $password=$_POST['password'];
         $hashpass=sha1($password);
         $email=$_POST['email'];
         $full=$_POST['fullname'];
        
        
       
       /* validate form*/
       $formErrors=array();
       if(strlen($username)<2){
           $formErrors[]='<div class= "alert alert-danger">user name can not less than 4 character</div>';
       }
       if(strlen($username)>20){
          $formErrors[]='<div class= "alert alert-danger">user name can not greater than 20 character</div>';
       }
       if(empty($username)){
          $formErrors[]='<div class= "alert alert-danger">please fill input username</div>';
       }
       if(empty($password)){
          $formErrors[]='<div class= "alert alert-danger">please fill input password</div>';
       }
       if(empty($email)){
          $formErrors[]='<div class= "alert alert-danger">please fill input email</div>';
       }
       if(empty($full)){
          $formErrors[]='<div class= "alert alert-danger">please fill input full name</div>';
       } if( ! empty($imageName) && ! in_array($imageExtension,$imageAllowedExtension)){
          $formErrors[]='<div class= "alert alert-danger">Extension not allowed</div>';
         }
         if(empty($imageName)){
          $formErrors[]='<div class= "alert alert-danger">You must upload image</div>';

         } if($imageSize > 4194304){
          $formErrors[]='<div class= "alert alert-danger">image can not larger than 4Mb</div>';

         }
         $image=rand(0,1000000).'_' .$imageName;
         move_uploaded_file($imageTmp,"uploades\\".$image);
         
         
      foreach($formErrors as $error){
           echo $error;
      }
      //check if user exist or not 
      if(empty($formErrors)){
       $check=checkItem("username","users",$username);
         if($check==1){
            $msg= '<div class= "alert alert-danger">sorry this user exist please choose another name  </div>';
            redirectHome($msg,'back');
         }else{           
          $stmt= $con->prepare("INSERT INTO users(username,password,email,fullName,registerstatus,date,images) VALUES(:zuser,:zpassword,:zemail,:zfullname,1,now(),:zimage)");
           $stmt->execute(array(
                                
                           'zuser'=>$username,
                           'zpassword'=>$hashpass,
                           'zemail'=>$email,
                           'zfullname'=>$full,
                            'zimage'=>$image 
                             ));
           echo"<div class='container'>";
           $msg= '<div class= "alert alert-success">' .$stmt->rowCount().'record inserted </div>';
           redirectHome($msg,'back');
           echo "</div>";
           }
      }
 
   }else{
        $msg='<div class= "alert alert-danger">you can not browse this page directly</div>';
        redirectHome($msg,'back');
    }
   
    
         }
    
    
    
    elseif($do=='edit'){
    //check if userid is numeric and get numeric value of it
                      $userID=isset($_GET['userid'])&& is_numeric($_GET['userid'])?intval($_GET['userid']):0;
       //connect database
                      $stmt=$con->prepare("SELECT * FROM users WHERE userID=:user limit 1 ");
                      $stmt->bindParam('user',$userID);
                      $stmt->execute();
      //fetch data from database
                     $row=$stmt->fetch();
       /* check if row exist or not */
                     $count=$stmt->rowCount();
                    if($stmt->rowCount()>0){?>
                           <h1 class="text-center">Edit Member</h1>
                           <div class="container">
                               <form class="form-horizontal" method="post" action="?do=update" enctype="multipart/form-data">
                                    <input type="hidden" name="userid" value="<?php echo $userID?>"> 
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">user name</label>
                                 <div class="col-sm-10 col-md-6">
                                    <input type="text" required="required" name="username" class="form-control"autocomplete="off" value="<?php echo $row['username']?>">
                               </div>
            
                                  </div>
       
       
       <div class="form-group form-group-lg">
           <label class="col-sm-2 control-label">password</label>
        <div class="col-sm-10 col-md-6">
            <input type="hidden" name="oldpassword" class="form-control"autocomplete="off"value="<?php echo $row['password']?>">
            <input type="password" name="newpassword" class="form-control"autocomplete="off" placeholder="leave empty if you do not want change it" >

        </div>
            
        </div>

      <div class="form-group form-group-lg">
        <label class="col-sm-2 control-label">E-mail</label>
        <div class="col-sm-10 col-md-6">
            <input type="email" name="email" required="required" class="form-control" autocomplete="off" value="<?php echo $row['email']?>" >
        </div>
            
        </div>
      
      
      <div class="form-group form-group-lg ">
        <label class="col-sm-2 control-label">full name</label>
        <div class="col-sm-10 col-md-6">
            <input type="text" required="required" name="fullname" class="form-control"autocomplete="off"value="<?php echo $row['fullName']?>" >
        </div>
            
        </div>
      <div class="form-group form-group-lg ">
        <label class="col-sm-2 control-label">image</label>
        <div class="col-sm-10 col-md-6">
            <input type="file" required="required" name="a" class="form-control"value="<?php echo $row['a'] ?>">
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
    echo "<h1 class='text-center'>update member</h1>";
    echo "<div class='container'>";
    if($_SERVER['REQUEST_METHOD']=="POST"){
      
         $imageName=$_FILES['a']['name'];
         $imageSize=$_FILES['a']['size'];
         $imageType=$_FILES['a']['type'];
         $imageTmp=$_FILES['a']['tmp_name'];
         $imageAllowedExtension=array("jpg","jpeg","gif","png");
         $imageExtension=strtolower(end(explode('.',$imageName)));

         $id=$_POST['userid'];
       $username=$_POST['username'];
       $email=$_POST['email'];
       $full=$_POST['fullname'];
      
       //password secure
       $pass="";
       if(empty($_POST['newpassword'])){
        $pass=$_POST['oldpassword'];
       }else{
        $pass=sha1($_POST['newpassword']);
       }
       /* validate form*/
       $formErrors=array();
       if(strlen($username)<2){
           $formErrors[]='<div class= "alert alert-danger">user name can not less than 4 character</div>';
       }
       if(strlen($username)>20){
          $formErrors[]='<div class= "alert alert-danger">user name can not greater than 20 character</div>';
       }
       if(empty($username)){
          $formErrors[]='<div class= "alert alert-danger">please fill input username</div>';
       }
       if(empty($email)){
          $formErrors[]='<div class= "alert alert-danger">please fill input email</div>';
       }
       if(empty($full)){
          $formErrors[]='<div class= "alert alert-danger">please fill input full name</div>';
       }
       if( ! empty($imageName) && ! in_array($imageExtension,$imageAllowedExtension)){
          $formErrors[]='<div class= "alert alert-danger">Extension not allowed</div>';
         }
         if(empty($imageName)){
          $formErrors[]='<div class= "alert alert-danger">You must upload image</div>';

         } if($imageSize > 4194304){
          $formErrors[]='<div class= "alert alert-danger">image can not larger than 4Mb</div>';

         }
         $image=rand(0,1000000).'_' .$imageName;
         move_uploaded_file($imageTmp,"uploades\\".$image);
         
         
      foreach($formErrors as $error){
           echo $error;
      }
      if(empty($formErrors)){
         $stmt=$con->prepare("SELECT * FROM users WHERE username=? AND userID!=?");
         $stmt->execute(array($username,$id));
         $check=$stmt->rowCount();
         if($check==1){
            $msg= '<div class= "alert alert-danger">sorry this user exist please choose another name  </div>';
            redirectHome($msg,'back');
         
         }else{
         
         
          $stmt= $con->prepare("UPDATE users set username=? ,password=?, email=? ,fullName=? ,images=? WHERE userID=?");
           $stmt->execute(array($username,$pass,$email,$full,$image,$id));
          $msg= '<div class= "alert alert-success">' .$stmt->rowCount().'record updated  </div>';
          redirectHome($msg,'back',5);
           }
      }
 
    }
    
    else{
        $msg='<div class= "alert alert-danger">you can not browse this page directly</div>';
        redirectHome($msg,'back',5);
    }
    echo "</div>"; 
} elseif($do=='delete'){
               echo "<h1 class='text-center'>delete member</h1>";
                echo "<div class='container'>";
          //check if userid is numeric and get numeric value of it
                      $userID=isset($_GET['userid'])&& is_numeric($_GET['userid'])?intval($_GET['userid']):0;
       //connect database
                      $stmt=$con->prepare("SELECT * FROM users WHERE userID=:user limit 1 ");
                      $stmt->bindParam('user',$userID);
                      $stmt->execute();
       /* check if row exist or not */
                     $count=$stmt->rowCount();
                    if($stmt->rowCount()>0){
                     $stmt=$con->prepare("DELETE FROM users WHERE userID=:user");
                     $stmt->bindParam('user',$userID);
                     $stmt->execute();
                   $msg= '<div class= "alert alert-success"> '.$stmt->rowCount().'deleted  </div>';
                   redirectHome($msg,'back');
          }
  echo "</div>";
}elseif($do=='activate'){
    echo "<h1 class='text-center'>delete member</h1>";
                echo "<div class='container'>";
          //check if userid is numeric and get numeric value of it
                      $userID=isset($_GET['userid'])&& is_numeric($_GET['userid'])?intval($_GET['userid']):0;
       //connect database
                      $stmt=$con->prepare("SELECT * FROM users WHERE userID=:user limit 1 ");
                      $stmt->bindParam('user',$userID);
                      $stmt->execute();
       /* check if row exist or not */
                     $count=$stmt->rowCount();
                    if($stmt->rowCount()>0){
                     $stmt=$con->prepare("UPDATE users set registerStatus=1 WHERE userID=:user");
                     $stmt->bindParam('user',$userID);
                     $stmt->execute();
                   $msg= '<div class= "alert alert-success"> '.$stmt->rowCount().'acivated </div>';
                   redirectHome($msg,'back');
          }
  echo "</div>";
}
     include  $tpl. "footer.php";
  
}else{
    header('location:admin.php');
    exit();
}
