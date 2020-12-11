<?php
   ob_start();
     session_start();
      $pageTitle="items";
       if(isset($_SESSION['username'])){
                include'inti.php';
                $do=isset($_GET['do'])?$_GET['do']:'manage';
                if($do=='manage'){
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
                                      users
                                      ON
                                      users.userID=items.member_id ");
                  $stmt->execute();
                  $items=$stmt->fetchAll();
                   if(!empty($items)){
    ?>
          <h1 class="text-center">manage items</h1>
          <div class="container">
             <div class="table-responsive text-center">
                  <table class="table table-bordered main-table">
                     <tr>
                        <td>#ID</td>
                        <td>name</td>
                        <td>description</td>
                        <td>price</td>
                        <td>register date</td>
                        <td>userName</td>
                        <td>category</td>
                        <td>control</td>
                     </tr>
                    <?php
                   
                        foreach($items as $item){
                              echo' <tr>';
                              echo '<td>' .$item['itemID'].'</td>';
                              echo '<td>' .$item['name'].'</td>';
                              echo '<td>' .$item['description'].'</td>';
                              echo '<td>' .$item['price'].'</td>';
                              echo  '<td>' .$item['date'].'</td>';
                              echo '<td>' .$item['username'].'</td>';
                              echo  '<td>' .$item['category_Name'].'</td>';
                              echo '<td>
                                    <a href="item.php?do=edit&itemid='.$item['itemID'].'" class="btn btn-success"><i class="fa fa-edit"></i>Edit</a>
                                    <a href="item.php?do=delete&itemid='.$item['itemID'].'" class="btn btn-danger confirm"><i class="fa fa-close"></i>Delete</a>';
                                    if($item['approve']==0){
                                  echo'<a  href="item.php?do=approve&itemid='.$item['itemID'].'" class="btn btn-info" style="margin-left:4px">
                                  <i class="fa fa-check"></i>Approve</a>';}
                        

                              echo'</td>';
                        
                              echo'</tr>';
                        }
                        
                               echo' </table>';
                                echo'</div>';
                                 
                                ?>
                                 <a href='item.php?do=add' class="btn btn-primary " style="width:200px"><i class="fa fa-plus"></i>add new item</a>
                              </div>
            
                     <?php 
                    }else{ echo '<div class="container">';
                  echo'<div class=" nice-message ">there is no items to show </div>';
                  echo'<a href="item.php?do=add" class="btn btn-primary " style="width:200px"><i class="fa fa-plus"></i>add new item</a>';

                  echo '</div>';
   }
   
                    
                }elseif($do=='add'){?>
                      <h1 class="text-center">Add New item</h1>
                           <div class="container">
                               <form class="form-horizontal" method="post" action="?do=insert" enctype="multipart/form-data">
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Name</label>
                                 <div class="col-sm-10 col-md-6">
                                    <input type="text" name="itemName"class="form-control"placeholder="Name of item" required="required"/>
                               </div>
            
                                  </div>
                                 
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">description</label>
                                 <div class="col-sm-10 col-md-6">
                                    <input type="text" name="describe" required="required"  class="form-control"placeholder="description of item">
                               </div>
            
                                  </div>
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">price</label>
                                 <div class="col-sm-10 col-md-6">
                                    <input type="text"  name="price" required="required"  class="form-control"placeholder="price of item">
                               </div>
            
                                  </div>
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Country</label>
                                 <div class="col-sm-10 col-md-6">
                                    <input type="text"  name="country"  required="required" class="form-control"placeholder="country of made ">
                               </div>
            
                                  </div>
                            <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">status</label>
                                 <div class="col-sm-10 col-md-6">
                                    <select class="form-control" name="status">
                                        <option value="0">---</option>
                                        <option value="1">New</option>
                                        <option value="2">Like New</option>
                                        <option value="3">Used</option>
                                        <option value="4">Old</option>
                                    </select>
                                 </div>
            
                            </div>
                            <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Member</label>
                                 <div class="col-sm-10 col-md-6">
                                    <select class="form-control" name="users">
                                        <option value="0">---</option>
                                        <?php
                                        $stmt=$con->prepare("SELECT username,userID FROM users WHERE groupID !=1");
                                        $stmt->execute();
                                        $column=$stmt->fetchAll();
                                        foreach($column as$col){
                                            echo'<option value="'.$col['userID'].'">' .$col['username'].'</option>';
                                        }
                                        
                                        ?>
                                    </select>
                               </div>
            
                                  </div>
                               <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">category</label>
                                 <div class="col-sm-10 col-md-6">
                                    <select class="form-control" name="cat">
                                        <option value="0">---</option>
                                        <?php
                                        $stmt=$con->prepare("SELECT * FROM category WHERE parent=0");
                                        $stmt->execute();
                                        $column=$stmt->fetchAll();
                                        foreach($column as$col){
                                            echo'<option value="'.$col['id'].'">' .$col['name'].'</option>';
                                            $stmt=$con->prepare("SELECT * FROM category WHERE parent=?");
                                            $stmt->execute(array($col['id']));
                                             $child=$stmt->fetchAll();
                                             foreach($child as $ch){
                                               echo'<option value="'.$ch['id'].'">-----' .$ch['name'].'</option>';

                                             }
                                            
                                            
                                        }
                                        
                                        ?>
                                    </select>
                               </div>
            
                                  </div>
                               
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Add image</label>
                                 <div class="col-sm-10 col-md-6">
                                    <input type="file" name="a"   class="form-control" required="required">
                                   
                               </div>
            
                                  </div>
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Add Tags</label>
                                 <div class="col-sm-10 col-md-6">
                                    <input type="text" name="tag"   class="form-control"placeholder="Add tags with separator(,)">
                                   
                               </div>
            
                                  </div>
       
                                <div class="form-group form-group-lg">
                                   
                                   <div class="col-sm-offset-2 col-sm-10 ">
                                       <input type="submit" name="save" value="add item" class="btn btn-primary addcat">
                                   </div>
                                   </div>
                               
                                    </form>
                                  </div>
                        
                              
            <?php
                    }elseif($do=='insert'){
                         if($_SERVER['REQUEST_METHOD']=="POST"){                     
        echo "<h1 class='text-center'>add item</h1>";
        echo "<div class='container'>";
         $name=$_POST['itemName'];
         $describe=$_POST['describe'];
         $price=$_POST['price'];
         $country=$_POST['country'];
         $status=$_POST['status'];
         $member=$_POST['users'];
         $category=$_POST['cat'];
         $tags=$_POST['tag'];
         $imageName=$_FILES['a']['name'];
         $imageSize=$_FILES['a']['size'];
         $imageTmp=$_FILES['a']['tmp_name'];
         $imageType=$_FILES['a']['type'];
         $imageAllowedExtension=array("jpg","jpeg","png","gif");
         $imageExtension=strtolower(end(explode(".",$imageName)));
       
       /* validate form*/
       $formErrors=array();
       if(empty($imageName)){
                   $formErrors[]='<div class= "alert alert-danger">please you must put image of item</div>';
       }
       if(!empty($imageName)&&  ! in_array($imageExtension,$imageAllowedExtension)){
      $formErrors[]='<div class= "alert alert-danger">not allowed extension</div>';
       }
       if(empty($name)){
          $formErrors[]='<div class= "alert alert-danger">please fill input name</div>';
       }
       if(empty($describe)){
          $formErrors[]='<div class= "alert alert-danger">please fill input description</div>';
       }
       if(empty($price)){
          $formErrors[]='<div class= "alert alert-danger">please fill input price</div>';
       }
       if(empty($country)){
          $formErrors[]='<div class= "alert alert-danger">please fill input  country</div>';
       }
        if($status=='0'){
          $formErrors[]='<div class= "alert alert-danger">please fill input status</div>';
       }
       if($member=='0'){
          $formErrors[]='<div class= "alert alert-danger">please fill input member</div>';
       }
       if($category=='0'){
          $formErrors[]='<div class= "alert alert-danger">please fill input category</div>';
       }
      foreach($formErrors as $error){
           echo $error;
      }
      /* check if user exist or not */
      if(empty($formErrors)){
         $image=rand(0,100) .'_'.$imageName;
         move_uploaded_file($imageTmp,'../uploades\\'.$image);
          $stmt= $con->prepare("INSERT INTO items(name,description,price,country_made,status,date,cat_id,member_id,tags,image) VALUES(:zname,:zdesc,:zprice,:zcountry,:zstatus,now(),:zcat,:zmember,:ztags,:zm)");
           $stmt->execute(array(
                                
                           'zname'=>$name,
                           'zdesc'=>$describe,
                           'zprice'=>$price,
                           'zcountry'=>$country,
                           'zstatus'=>$status,
                           'zcat'=>$category,
                           'zmember'=>$member,
                           'ztags'=>$tags,
                           'zm'=>$image
                           ));
           echo"<div class='container'>";
           $msg= '<div class= "alert alert-success">' .$stmt->rowCount().'record inserted </div>';
           redirectHome($msg,'back');
           }
            echo "</div>";
      }
                    }
      
      elseif($do=='edit'){
                //check if userid is numeric and get numeric value of it
                      $itemID=isset($_GET['itemid'])&& is_numeric($_GET['itemid'])?intval($_GET['itemid']):0;
       //connect database
                      $stmt=$con->prepare("SELECT * FROM items WHERE itemID=:item");
                      $stmt->bindParam(':item',$itemID);
                      $stmt->execute();
      //fetch data from database
                     $row=$stmt->fetch();
       /* check if row exist or not */
                     $count=$stmt->rowCount();
                    if($stmt->rowCount()>0){?>
                    <h1 class="text-center">Edit item</h1>
                           <div class="container">
                               <form class="form-horizontal" method="post" action="?do=update">
                                 <input type="hidden" name="hid" value="<?php echo $itemID;?>">
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Name</label>
                                 <div class="col-sm-10 col-md-6">
                                    <input type="text" name="itemName"class="form-control"placeholder="Name of item" value="<?php echo $row['name'] ?>"/>
                               </div>
            
                                  </div>
                                 
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">description</label>
                                 <div class="col-sm-10 col-md-6">
                                    <input type="text" name="describe" required="required"  class="form-control"placeholder="description of item" value="<?php echo $row['description'] ?>">
                               </div>
            
                                  </div>
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">price</label>
                                 <div class="col-sm-10 col-md-6">
                                    <input type="text"  name="price" required="required"  class="form-control"placeholder="price of item" value="<?php echo $row['price'] ?>">
                               </div>
            
                                  </div>
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Country</label>
                                 <div class="col-sm-10 col-md-6">
                                    <input type="text"  name="country"  required="required" class="form-control"placeholder="country of made "value="<?php echo $row['country_made'] ?>">
                               </div>
            
                                  </div>
                            <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">status</label>
                                 <div class="col-sm-10 col-md-6">
                                    <select class="form-control" name="status">
                                        <option value="0">---</option>
                                        <option value="1" <?php if($row['status']==1){ echo "selected";}?>>New</option>
                                        <option value="2" <?php if($row['status']==2){ echo "selected";}?>>Like New</option>
                                        <option value="3" <?php if($row['status']==3){ echo "selected";}?>>Used</option>
                                        <option value="4" <?php if($row['status']==4){ echo "selected";}?>>Old</option>
                                    </select>
                                 </div>
            
                            </div>
                            <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Member</label>
                                 <div class="col-sm-10 col-md-6">
                                    <select class="form-control" name="users">
                                        
                                        <?php
                                        $stmt=$con->prepare("SELECT username,userID FROM users WHERE groupID !=1");
                                        $stmt->execute();
                                        $column=$stmt->fetchAll();
                                        foreach($column as$col){
                                            echo'<option value="'.$col['userID'].'"';
                                            if($row['member_id']==$col['userID']){ echo "selected";}echo '>'
                                            .$col['username'].'</option>';
                                        }
                                        
                                        ?>
                                    </select>
                               </div>
            
                                  </div>
                               <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">category</label>
                                 <div class="col-sm-10 col-md-6">
                                    <select class="form-control" name="cat">
                                        
                                        <?php
                                        $stmt=$con->prepare("SELECT * FROM category");
                                        $stmt->execute();
                                        $column=$stmt->fetchAll();
                                        foreach($column as$col){
                                          echo'<option value="'.$col['id'].'"';
                                            if($row['cat_id']==$col['id']){ echo "selected";}echo '>'
                                            .$col['name'].'</option>';
                                        }
                                        
                                        ?>
                                    </select>
                               </div>
            
                                  </div>
                               <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Add Tags</label>
                                 <div class="col-sm-10 col-md-6">
                                    <input type="text" name="tag"   class="form-control"placeholder="Add tags with separator(,)" value="<?php echo $row['tags']?>">
                               </div>
            
                                  </div>
       
                                <div class="form-group form-group-lg">
                                   
                                   <div class="col-sm-offset-2 col-sm-10 ">
                                       <input type="submit" name="save" value="update item" class="btn btn-primary addcat">
                                   </div>
                                   </div>
                               </form>
                               <?php 
                 
                  $stmt=$con->prepare("SELECT comments.*, users.username AS username FROM comments
                                       INNER JOIN users ON
                                      users.userID=comments.user_id
                                      WHERE item_id=?
                                      ");
                  $stmt->execute(array($itemID));
                  $rows=$stmt->fetchAll();
                  if(!empty($rows)){
                  ?>
          <h1 class="text-center"> Manage [<?php echo $row['name'];?>] comments</h1>
             <div class="table-responsive text-center">
                  <table class="table table-bordered main-table">
                     <tr>
                        
                        <td>comment</td>
                        <td>userName</td>
                        <td>Added date</td>
                        <td>controls</td>
                     </tr>
                    <?php
                        foreach($rows as $row){
                              echo' <tr>';
                              echo '<td>' .$row['comment'].'</td>';
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
                  }        
                   ?>
                    
                </table>
                </div>
                  </div>
              
      <?php

                    
                    }      
//if userid not exist
else{
   echo "<div class='container'>";
    $msg= '<div class="alert alert-danger">there is no such id</div>';
    redirectHome($msg);
    echo "</div>";
}
            }elseif($do=='update'){
              echo '<div class="container">';
          echo'<h1 class="text-center">Update item</h1>';
          if($_SERVER['REQUEST_METHOD']=='POST'){
                           $name=$_POST['itemName'];
                           $desc=$_POST['describe'];
                           $price=$_POST['price'];
                           $country=$_POST['country'];
                           $status=$_POST['status'];
                           $cat=$_POST['cat'];
                           $member=$_POST['users'];
                           $tag=$_POST['tag'];
                           $item_id=$_POST['hid'];
          $stmt=$con->prepare("UPDATE items SET name=?,description=?,price=?,country_made=?,status=?,cat_id=?,member_id=?,tags=? WHERE itemID=?");
          $stmt->execute(array($name,$desc,$price,$country,$status,$cat,$member,$tag,$item_id));
         
          $msg= '<div class= "alert alert-success">' .$stmt->rowCount().'record updated  </div>';
          redirectHome($msg,'back',5);
           }
    
    else{
        $msg='<div class= "alert alert-danger">you can not browse this page directly</div>';
        redirectHome($msg,'back',5);
    }
    echo "</div>";      
            }elseif($do=='delete'){
                           echo "<h1 class='text-center'>delete item</h1>";
                echo "<div class='container'>";
          //check if userid is numeric and get numeric value of it
                      $itemId=isset($_GET['itemid'])&& is_numeric($_GET['itemid'])?intval($_GET['itemid']):0;
       //connect database
                      $stmt=$con->prepare("SELECT * FROM items WHERE itemID=:item limit 1 ");
                      $stmt->bindParam('item',$itemId);
                      $stmt->execute();
       /* check if row exist or not */
                     $count=$stmt->rowCount();
                    if($stmt->rowCount()>0){
                     $stmt=$con->prepare("DELETE FROM items WHERE itemID=:item");
                     $stmt->bindParam('item',$itemId);
                     $stmt->execute();
                   $msg= '<div class= "alert alert-success"> '.$stmt->rowCount().'deleted  </div>';
                   redirectHome($msg,'back');
          }else{
            
             $msg= '<div class="alert alert-danger">there is no such id</div>';
    redirectHome($msg);
          }
  echo "</div>";
        
               }elseif($do=='approve'){
                  //check if userid is numeric and get numeric value of it
                      $itemId=isset($_GET['itemid'])&& is_numeric($_GET['itemid'])?intval($_GET['itemid']):0;
       //connect database
                      $stmt=$con->prepare("SELECT * FROM items WHERE itemID=:item limit 1 ");
                      $stmt->bindParam('item',$itemId);
                      $stmt->execute();
       /* check if row exist or not */
                     $count=$stmt->rowCount();
                    if($stmt->rowCount()>0){
                     $stmt=$con->prepare("UPDATE items SET approve=1 WHERE itemID=:item");
                      $stmt->bindParam('item',$itemId);
                          $stmt->execute();
                   $msg= '<div class= "alert alert-success"> '.$stmt->rowCount().'approved  </div>';
                   redirectHome($msg,'back');
               }
               }
        include  $tpl. "footer.php";
       }