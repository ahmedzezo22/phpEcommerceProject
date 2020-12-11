<?php
    ob_start();
     session_start();
      $pageTitle="categories";
       if(isset($_SESSION['username'])){
        include'inti.php';
        $do=isset($_GET['do'])?$_GET['do']:'manage';
        if($do=='manage'){
            //sorting asc and desc
            $sort='Asc';
            $sort_array=array("Asc","Desc");
           
            if(isset($_GET['sort'] )&& in_array($_GET['sort'],$sort_array)){
                $sort=$_GET['sort'];
            }
            $stmt=$con->prepare("SELECT * FROM category WHERE parent=0 ORDER BY ordering $sort");
            $stmt->execute();
            $cats=$stmt->fetchAll();
            if(!empty($cats)){?>
            <div class="container category">
                <h1 class="text-center">manage categories</h1>
                <div class="panel panel-default">
                    <div class="panel-heading head">
                        <i class="fa fa-edit edit"></i> categories
                    <div class="option pull-right">
                        <i class="fa fa-sort"></i> Ordering:
                        [ <a class="<?php if($sort=='Asc'){ echo "active";} ?>" href="?sort=Asc">Asc</a> /
                        <a class="<?php if($sort=='Desc'){ echo "active";} ?>"href="?sort=Desc">Desc</a> ]
                         <i class="fa fa-eye"></i> View:
                        [ <span class="active" data-view="full">Full</span> /
                        <span data-view="classic">Classic</span> ]
                        
                    </div>
                    
                    </div>
                    <div class="panel-body">
                        <?php
                        foreach($cats as$cat){
                            echo '<div class="cat">';
                                        echo '<div class="hidden-btn">';
                                             echo "<a href='categories.php?do=edit&catId=".$cat['id']."' class='btn btn-xs btn-primary btnn-hidden'><i class='fa fa-edit '> Edit</i> </a>";
                                             echo "<a href='categories.php?do=delete&catId=".$cat['id']."' class=' confirm btn btn-xs btn-danger btnn-hidden'><i class='fa fa-close '> Delete</i> </a>";
                                             echo"</div>";
                                             echo '<h3>'.$cat['name'] .'</h3>';
                                             echo'<div class="full-view">';
                                                  
                                                  echo '<p>'; if($cat['description']==''){echo "this category has no description";}else{echo $cat['description'];}echo'</p>';
                                                  if($cat['visibility']==1){echo '<span class="visible">Hidden</span>';}
                                                  if($cat['allow_Comments']==1){echo '<span class="commenting">Comment Disabled</span>';}
                                                 if($cat['allow_Ads'] ==1){echo '<span class="ads">Ads Disabled</span>';}
                                                 
                                                  $stmt=$con->prepare("SELECT * FROM category WHERE parent=? ORDER BY id DESC");
                            $stmt->execute(array($cat['id']));
                            $rows=$stmt->fetchAll();
                            if(! empty($rows)){
                                echo '<h4 class="childHead">Child Categories</h4>';
                                echo'<ul class="list-unstyled childcats">';
                            foreach($rows as $row){
                                echo'<li  class="childcat">';
                                echo '<a href="categories.php?do=edit&catId=' .$row['id'].'">'.$row['name']. '</a>';
                            echo "<a href='categories.php?do=delete&catId=".$row['id']."' class=' confirm  showdelete'><i class='fa fa-close '> Delete</i> </a>";
                            echo '</li>';
                            }
                            
                            echo'</ul>';
                            }
                                             echo '</div>';
                            echo'</div>';
                           
                             echo '<hr/>';
                        }
                       
                  ?>
                    </div>
                </div>
                <a href="categories.php?do=add" class="btn btn-primary bt-ad"><i class="fa fa-plus"> add new category</i></a>
            </div>
          <?php  }
            else{ echo '<div class="container">';
                  echo'<div class=" nice-message ">there is no categories to show </div>';
                 echo'<a href="categories.php?do=add" class="btn btn-primary bt-ad"><i class="fa fa-plus"> add new category</i></a>';

                  echo'</div>';
          }
          
            
        }elseif($do=='add'){?>
            <h1 class="text-center">Add NewCategory</h1>
                           <div class="container">
                               <form class="form-horizontal" method="post" action="?do=insert">
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Name</label>
                                 <div class="col-sm-10 col-md-6">
                                    <input type="text" required="required" name="categoryName" autocomplete="off" class="form-control"placeholder="Name of category">
                               </div>
            
                                  </div>
       
       
       <div class="form-group form-group-lg">
           <label class="col-sm-2 control-label">Description</label>
        <div class="col-sm-10 col-md-6">
            <input type="text" name="describe" class="form-control"autocomplete="off" placeholder="Describe of category">

        </div>
            
        </div>

      <div class="form-group form-group-lg">
        <label class="col-sm-2 control-label">Ordering</label>
        <div class="col-sm-10 col-md-6">
            <input type="text" name="order"  class="form-control" autocomplete="off" placeholder="Number to arrange category"  >
        </div>
            
        </div>
          <div class="form-group form-group-lg">
        <label class="col-sm-2 control-label">Parent?</label>
        <div class="col-sm-10 col-md-6">
            <select name="parent" class="form-control">
                <option value="0">None</option>
                <?php
                $stmt=$con->prepare("SELECT * FROM category WHERE parent=0 ORDER BY id DESC");
                $stmt->execute();
                $rows=$stmt->fetchAll();
                foreach($rows as $row){
                ?>
                <option value="<?php echo $row['id']?>"><?php echo $row['name']?></option> <?php }?>
            </select>
        </div>
        </div>
      <div class="form-group form-group-lg ">
        <label class="col-sm-2 control-label">visibility</label>
        <div class="col-sm-10 col-md-6">
            <div>
                <input id="visibleYes"type="radio" name="visible" value="0" checked="checked"/>
                <label for="visibleYes">Yes</label>
            </div>
             <div>
                <input id="visibleNo" type="radio" name="visible" value="1">
                <label for="visibleNo">No</label>
            </div>
        </div>
            
        </div>
        <!-- comment field allow -->
      <div class="form-group form-group-lg ">
        <label class="col-sm-2 control-label">allow Commenting</label>
        <div class="col-sm-10 col-md-6">
            <div>
                <input id="comYes"type="radio" name="com" value="0" checked="checked"/>
                <label for="comYes">Yes</label>
            </div>
             <div>
                <input id="comNo" type="radio" name="com" value="1">
                <label for="comNo">No</label>
            </div>
        </div>
            
        </div>
          <div class="form-group form-group-lg ">
        <label class="col-sm-2 control-label">allow ads</label>
        <div class="col-sm-10 col-md-6">
            <div>
                <input id="addsYes" type="radio" name="ad" value="0" checked="checked"/>
                <label for="addsYes">Yes</label>
            </div>
             <div>
                <input id="addsNo" type="radio" name="ad" value="1">
                <label for="addsNo">No</label>
            </div>
        </div>
            
        </div>

     <div class="form-group form-group-lg">
        
        <div class="col-sm-offset-2 col-sm-10 ">
            <input type="submit" name="save" value="add category" class="btn btn-primary addcat">
        </div>
        </div>
       </div>
    </form> 
            <?php
        }elseif($do=='insert'){
            
            if($_SERVER['REQUEST_METHOD']=="POST"){
        echo "<h1 class='text-center'>add Category</h1>";
        echo "<div class='container'>";
         $name=$_POST['categoryName'];
         $describe=$_POST['describe'];
          $ordering=$_POST['order'];
         $visible=$_POST['visible'];
          $comment=$_POST['com'];
          $ads=$_POST['ad'];
          $parent=$_POST['parent'];
         
       
      /* check if category exist or not */
      $check=checkItem("name","category",$name);
         if($check==1){
            $msg= '<div class= "alert alert-danger">sorry this category exist please choose another name  </div>';
            redirectHome($msg,'back');
         }else{           
          $stmt= $con->prepare("INSERT INTO category(name,description,parent,ordering ,visibility ,allow_comments,allow_Ads) VALUES (:zname,:zdescribe,:zp,:zorder,:zvisible,:zcomment,:zads)");
           
           $stmt->bindParam('zname',$name);
            $stmt->bindParam('zdescribe',$describe);
            $stmt->bindParam('zdescribe',$describe);
            $stmt->bindParam('zorder',$ordering);
            $stmt->bindParam('zvisible',$visible);
            $stmt->bindParam('zcomment',$comment);
            $stmt->bindParam('zads',$ads);
             $stmt->bindParam('zp',$parent);
             $stmt->execute();
                echo"<div class='container'>";
           $msg= '<div class= "alert alert-success">' .$stmt->rowCount().'record inserted </div>';
           redirectHome($msg,'back');
           echo "</div>";
           }
      
        } else{
        $msg='<div class= "alert alert-danger">you can not browse this page directly</div>';
        redirectHome($msg,'back');
    }
        }elseif($do=='edit'){
            //check if categoryod is numeric and get numeric value of it
                      $catId=isset($_GET['catId'])&& is_numeric($_GET['catId'])?intval($_GET['catId']):0;
       //connect database
                      $stmt=$con->prepare("SELECT * FROM category WHERE id=:catid limit 1 ");
                      $stmt->bindParam('catid',$catId);
                      $stmt->execute();
      //fetch data from database
                     $cat=$stmt->fetch();
       /* check if row exist or not */
                     $count=$stmt->rowCount();
                    if($stmt->rowCount()>0){?>
                        <h1 class="text-center">Edit Category</h1>
                           <div class="container">
                               <form class="form-horizontal" method="post" action="?do=update">
                                <input type="hidden" name="catid" value="<?php echo $catId?>"> 
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Name</label>
                                 <div class="col-sm-10 col-md-6">
                                    <input type="text" required="required" name="categoryName" class="form-control" value="<?php echo $cat['name'];?>"placeholder="Name of category">
                               </div>
            
                                  </div>
       
       
       <div class="form-group form-group-lg">
           <label class="col-sm-2 control-label">Description</label>
        <div class="col-sm-10 col-md-6">
            <input type="text" name="describe"value="<?php echo $cat['description'];?>" class="form-control"autocomplete="off" placeholder="Describe of category">

        </div>
            
        </div>

      <div class="form-group form-group-lg">
        <label class="col-sm-2 control-label">Ordering</label>
        <div class="col-sm-10 col-md-6">
            <input type="text" name="order" value="<?php echo $cat['ordering'];?>"  class="form-control" autocomplete="off" placeholder="Number to arrange category"  >
        </div>
            
        </div>
      <div class="form-group form-group-lg">
        <label class="col-sm-2 control-label">Parent?</label>
        <div class="col-sm-10 col-md-6">
            <select name="parent" class="form-control">
                <option value="0">None</option>
                <?php
                $stmt=$con->prepare("SELECT * FROM category  ORDER BY id DESC");
                $stmt->execute();
                $rows=$stmt->fetchAll();
                foreach($rows as $row){
                ?>
                <option value="<?php echo $row['id']?>"
                <?php if($cat['parent']==$row['id']){echo "selected";}?>
                ><?php echo $row['name']?></option> <?php }?>
            </select>
        </div>
        </div>
      
      
      <div class="form-group form-group-lg ">
        <label class="col-sm-2 control-label">visibility</label>
        <div class="col-sm-10 col-md-6">
            <div>
                <input id="visibleYes"type="radio" name="visible" value="0" <?php if($cat['visibility']=='0'){echo "checked"; }?> />
                <label for="visibleYes">Yes</label>
            </div>
             <div>
                <input id="visibleNo" type="radio" name="visible" value="1" <?php if($cat['visibility']=='1'){echo "checked"; }?>>
                <label for="visibleNo">No</label>
            </div>
        </div>
            
        </div>
        <!-- comment field allow -->
      <div class="form-group form-group-lg ">
        <label class="col-sm-2 control-label">allow Commenting</label>
        <div class="col-sm-10 col-md-6">
            <div>
                <input id="comYes"type="radio" name="com" value="0" <?php if($cat['allow_Comments']=='0'){echo "checked"; }?>/>
                <label for="comYes">Yes</label>
            </div>
             <div>
                <input id="comNo" type="radio" name="com" value="1" <?php if($cat['allow_Comments']=='1'){echo "checked"; }?>>
                <label for="comNo">No</label>
            </div>
        </div>
            
        </div>
          <div class="form-group form-group-lg ">
        <label class="col-sm-2 control-label">allow ads</label>
        <div class="col-sm-10 col-md-6">
            <div>
                <input id="addsYes" type="radio" name="ad" value="0" <?php if($cat['allow_Ads']=='0'){echo "checked"; }?>/>
                <label for="addsYes">Yes</label>
            </div>
             <div>
                <input id="addsNo" type="radio" name="ad" value="1" <?php if($cat['allow_Ads']=='1'){echo "checked"; }?>>
                <label for="addsNo">No</label>
            </div>
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
          echo '<div class="container">';
          echo'<h1 class="text-center">Update category</h1>';
          if($_SERVER['REQUEST_METHOD']=='POST'){
            $catId=$_POST['catid'];
           $catname=$_POST['categoryName'];
           $describe=$_POST['describe'];
           $ordering=$_POST['order'];
           $par=$_POST['parent'];
           $comment=$_POST['com'];
           $visible=$_POST['visible'];
           $ads=$_POST['ad'];
          $stmt=$con->prepare("UPDATE category SET name=?,description=?,ordering=?,parent=?,visibility=?,allow_Comments=?,allow_Ads=? WHERE id=?");
          $stmt->execute(array($catname,$describe,$ordering,$par,$visible,$comment,$ads,$catId));
         
          $msg= '<div class= "alert alert-success">' .$stmt->rowCount().'record updated  </div>';
          redirectHome($msg,'back',5);
           }
    
    else{
        $msg='<div class= "alert alert-danger">you can not browse this page directly</div>';
        redirectHome($msg,'back',5);
    }
    echo "</div>"; 
        }elseif($do=='delete'){
            echo "<h1 class='text-center'>delete category</h1>";
                echo "<div class='container'>";
          //check if userid is numeric and get numeric value of it
                      $catId=isset($_GET['catId'])&& is_numeric($_GET['catId'])?intval($_GET['catId']):0;
       //connect database
                      $stmt=$con->prepare("SELECT * FROM category WHERE id=:cat limit 1 ");
                      $stmt->bindParam('cat',$catId);
                      $stmt->execute();
       /* check if row exist or not */
                     $count=$stmt->rowCount();
                    if($stmt->rowCount()>0){
                     $stmt=$con->prepare("DELETE FROM category WHERE id=:cat");
                     $stmt->bindParam('cat',$catId);
                     $stmt->execute();
                   $msg= '<div class= "alert alert-success"> '.$stmt->rowCount().'deleted  </div>';
                   redirectHome($msg,'back');
          }
  echo "</div>";
        
        }
        
         include  $tpl. "footer.php";
        }
        ob_end_flush();
      