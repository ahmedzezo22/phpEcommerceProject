<?php
  session_start();
  $pageTitle='New Ad';
  include 'inti.php';
  if(isset($_SESSION['user'])){
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $formError=array();
       $name=filter_var($_POST['itemName'],FILTER_SANITIZE_STRING);
       $desc=filter_var($_POST['describe'],FILTER_SANITIZE_STRING);
       $price=filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_INT);
       $country=filter_var($_POST['country'],FILTER_SANITIZE_STRING);
       $status=filter_var($_POST['status'],FILTER_SANITIZE_NUMBER_INT);
       $cat=filter_var($_POST['cat'],FILTER_SANITIZE_NUMBER_INT);
       $tag=filter_var($_POST['tag'],FILTER_SANITIZE_STRING);
       //image of items
         $imageName=$_FILES['a']['name'];
         $imageSize=$_FILES['a']['size'];
         $imageType=$_FILES['a']['type'];
         $imageTmp=$_FILES['a']['tmp_name'];
         $imageAllowedExtension=array("jpg","jpeg","gif","png");
         $images=@end(explode('.',$imageName));
         $imageExtension=strtolower($images);
        
       if(strlen($name)<4){
        $formError[]='name must greater than 4 charcter';
       }
       if(strlen($desc)<10){
        $formError[]='description must greater than 10 charcter';
       }
        if(empty($price)){
        $formError[]='you must enter price';
       }
        if(strlen($country)<2){
        $formError[]='You must enter country';
       }
       if(empty($status)){
        $formError[]='you must enter status';
       }
       if(empty($cat)){
        $formError[]='you must enter category';
       }
        if(empty($imageName)){
          $formErrors[]='<div class= "alert alert-danger">You must upload image</div>';

         } if($imageSize > 4194304){
          $formErrors[]='<div class= "alert alert-danger">image can not larger than 4Mb</div>';

         }
         $image=rand(0,1000000).'_' .$imageName;
         move_uploaded_file($imageTmp,"uploades\\".$image);
       if(empty($formError)){
       $stmt=$con->prepare("INSERT INTO items(name,description,price,country_made,cat_id,tags,member_id,status,date,image) VALUES(:n,:d,:p,:c,:ca,:tag,:me,:s,now(),:z)");
       $stmt->execute(array(
        'n'=>$name,
        'd'=>$desc,
        'p'=>$price,
        'c'=>$country,
        'ca'=>$cat,
        'tag'=>$tag,
        'me'=>$_SESSION['Uid'],
        's'=>$status,
        'z'=>$image
       
       ));
       $row=$stmt->rowCount();
       if($row==1){
     echo '<div class="alert alert-success">good your item is successfully added</div>';

       }
    }
    }

  ?>
 
  <div class="create-ad ">
    <div class="container">
      <h1 class="text-center"><?php echo $_SESSION['user']?> Create new ad</h1>
      <div class="panel panel-primary">
         <div class="panel-heading">Create New Ad</div>
         <div class="panel-body">
          <div class="row">
            <div class="col-md-8">
    
                               <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'];?>">
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Name</label>
                                 <div class="col-sm-10 col-md-9">
                                    <input type="text" name="itemName"class="form-control livename"placeholder="Name of item" required="required"/>
                               </div>
            
                                  </div>
                                 
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">description</label>
                                 <div class="col-sm-10 col-md-9">
                                    <input type="text" name="describe" required="required"  class="form-control liveDesc"placeholder="description of item">
                               </div>
            
                                  </div>
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">price</label>
                                 <div class="col-sm-10 col-md-9">
                                    <input type="text"  name="price" required="required"  class="form-control liveprice"placeholder="price of item">
                               </div>
            
                                  </div>
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Country</label>
                                 <div class="col-sm-10 col-md-9">
                                    <input type="text"  name="country"  required="required" class="form-control"placeholder="country of made ">
                               </div>
            
                                  </div>
                            <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">status</label>
                                 <div class="col-sm-10 col-md-9">
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
                                    <label class="col-sm-2 control-label">category</label>
                                 <div class="col-sm-10 col-md-9">
                                    <select class="form-control" name="cat">
                                        <option value="0">---</option>
                                        <?php
                                        $stmt=$con->prepare("SELECT * FROM category");
                                        $stmt->execute();
                                        $column=$stmt->fetchAll();
                                        foreach($column as$col){
                                            echo'<option value="'.$col['id'].'">' .$col['name'].'</option>';
                                        }
                                        
                                        ?>
                                    </select>
                               </div>
            
                                  </div>
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Add Tags</label>
                                 <div class="col-sm-10 col-md-9">
                                    <input type="text" name="tag"   class="form-control"placeholder="Add tags with separator(,)">
                                   
                               </div>
            
                                  </div>
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Add img</label>
                                 <div class="col-sm-10 col-md-9">
                                    <input type="file" name="a"  liveimage   class="form-control">
                                   
                               </div>
            
                                  </div>
       
                                <div class="form-group form-group-lg">
                                   
                                   <div class="col-sm-offset-2 col-sm-10 ">
                                       <input type="submit" name="save" value="add item" class="btn btn-primary addcat">
                                   </div>
                                   </div>
                                    </form>
                                  </div>
            
            
            <div class="col-md-4">
            <div class="thumbnail livepreview">
             <span>0</span>
            <img src="layout/images/img.png" class="img-thumbnail">
            <div class="caption">
            <h3>Title</h3>
            <p> description</p>
             </div>
            </div>
            </div>
            </div>
          <!-- start error message -->
          <?php
          if(! empty($formError)){
            foreach($formError as $errors){
                 echo '<div class="alert alert-danger">'. $errors.'</div>';
            }
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