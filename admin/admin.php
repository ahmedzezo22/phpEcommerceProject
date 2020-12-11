<?php
session_start();
$nonavbar="";
$pageTitle="logIn";

/*
if(isset($_SESSION['username'])){
  header('location:dashboard.php');
}
*/

include "inti.php";

/** check if exist server post **/
if($_SERVER['REQUEST_METHOD']=='POST'){
  /* identify username and password of admin */
  $username=$_POST['username'];
  $password=$_POST['pass'];
  $hashedPass=sha1($password);
  /* connectto database */
$stmt=$con->prepare("SELECT userID,username,password FROM users WHERE username=:user AND password=:password AND groupID=1 LIMIT 1");
   $stmt->bindParam('user',$username);
  $stmt->bindParam('password',$hashedPass);
  $stmt->execute();
  /* check if row exist or not */
  $row=$stmt->fetch();
  $count=$stmt->rowCount();  
    
    if($count>0){
      $_SESSION['username']=$username;
      $_SESSION['id']=$row['userID'];//register session id
      header('Location:dashboard.php');
      exit();
  }
}
     
  ?>
<form action=" <?php $_SERVER['PHP_SELF'];?>" method="POST" class="login">
  <h1 class="text-center">Admin Login</h1>
  <input class="form-control" type="text" name="username" placeholder="username" autocomplete="off">
  <input class="form-control"type="password" name="pass" placeholder="password">
  <input class="btn btn-primary btn-block" type="submit" name="submit" value="login">
</form>
  <?php
  include  $tpl. 'footer.php';
  ?>