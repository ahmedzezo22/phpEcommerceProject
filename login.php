 <?php
  session_start();
  $pageTitle='login';
 
  if(isset($_SESSION['user'])){
    header('location:index.php');
    
  }
   include 'inti.php';
  if($_SERVER['REQUEST_METHOD']=='POST'){
    if(isset($_POST['login'])){    
    $user=$_POST['name'];
    $password=$_POST['pass'];
    $hash=sha1($password);
    $stmt=$con->prepare("SELECT userID,username,password FROM users WHERE username=? AND password=?");
    $stmt->execute(array($user,$hash));
    $get=$stmt->fetch();
    $row=$stmt->rowCount();
    if($row>0){
        $_SESSION['user']=$user;
        $_SESSION['Uid']=$get['userID'];
        header('location:index.php');
        exit();
    }
  }else{
    $formErrors=array();
    $filteruser=filter_var($_POST['name'],FILTER_SANITIZE_STRING);
    if(strlen($filteruser)<4){
        $formErrors[]='username must larger than 4 charcter';
    }
    
    if(isset($_POST['pass']) && isset($_POST['pass-again'])){
        if(empty($_POST['pass'])){
            $formErrors[]='password can not be empty';
        }
        $pass1=sha1($_POST['pass']);
        $pass2=sha1($_POST['pass-again']);
        if($pass1!==$pass2){
            $formErrors[]='password not match';
        }
    }
    if(isset($_POST['email'])){
        $filterEmail=filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
        if(filter_var($filterEmail,FILTER_VALIDATE_EMAIL)==false){
            $formErrors[]='your email not valid';
        }
    }
    
   $stmt=$con->prepare("SELECT * FROM users WHERE username=?");
   $stmt->execute(array($_POST['name']));
   $count=$stmt->rowCount();
   if($count==1){
    $formErrors[]='sorry user name exist';
   }else{
    $imageName=$_FILES['a']['name'];
    $imageSize=$_FILES['a']['size'];
    $imageTmp=$_FILES['a']['tmp_name'];
    $imageType=$_FILES['a']['type'];
    $imageAllowedExtension=array('jpg','png','jpeg','gif');
    $imageExtension=@strtolower(end(explode('.',$imageName)));
    if(! empty($imageName)&& ! in_array($imageExtension,$imageAllowedExtension)){
     $formError[]='sorry extension not allowed';
     }
    if(empty($imageName)){
     $formError[]='you must upload your image';
    }
    if($imageSize > 4194304){
          $formErrors[]='<div class= "alert alert-danger">image can not larger than 4Mb</div>';

         }
    
      $image=rand(1,1000000).'_'.$imageName;
         move_uploaded_file($imageTmp,'admin\uploades\\'.$image);
    $st=$con->prepare("INSERT INTO users(username,password,email,registerStatus,date,images) VALUES (:user,:pass,:email,0,now(),:im)");
    $st->execute(array(
                      ':user'=>$_POST['name'],
                      ':pass'=>sha1($_POST['pass']),
                      ':email'=>$_POST['email'],
                      ':im'  =>$image
                      ));
    $count=$st->rowCount();
    if($count==1){
        $formErrors[]='you register successfully';
    }
    
   }
   
   
   }
  }
  ?>

  <div class="container loginPage">
    <h1 class="text-center"><span class="selected" data-class="login">login</span>  | <span  data-class="signup">signup</span></h1>
        <form class="login" method='post' action="<?php echo $_SERVER['PHP_SELF']; ?>">
         <input type="text" name='name' autocomplete="off" class="form-control" placeholder="username">
         <input type="password" name='pass' autocomplete="new-password" class="form-control" placeholder="password">
         <input type="submit" value="Login" name="login" class="btn btn-primary btn-block">
        </form>
        <!-- sign up form -->
        <form class="signup" method='post' action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
         <input type="text" name='name'pattern=".{4,}" title="username must be larger than 4 character"required autocomplete="off" class="form-control" placeholder="type username">
         <input type="password"minlength="5" required name='pass' autocomplete="off" class="form-control" placeholder=" type complex password">
        <input type="password" minlength="5" required name='pass-again' autocomplete="off" class="form-control" placeholder=" confirm password">

        <input type="email" name='email' autocomplete="off" class="form-control" placeholder=" type valid E-mail">
        <input type="file" name="a" required="required" class="form-control">

         <input type="submit" value="signup" class="btn btn-success btn-block">
        </form>
  </div>
  
     <?php if(isset($formErrors)){
        echo'<div class="container">';
        echo'<div class="text-center nice-message">';
        foreach($formErrors as $error){
            echo $error .'</br>';
            echo'</div>';
            echo'</div>';
        }
        }?>
  
 


<?php include  $tpl. 'footer.php'; ?>


