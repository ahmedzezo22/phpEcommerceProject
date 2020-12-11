<!-- get catogries-->
        <?php
     
        $stmt=$con->prepare("SELECT * FROM category WHERE parent=0 ORDER BY id ASC ");
        $stmt->execute();
        $cats=$stmt->fetchAll();
      
        ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href= "<?php echo $css;?>bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $css;?>font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo $css;?>front.css">
    <title><?php getTitle()?></title>
    <style>
      
    </style>
    <title>admin</title> 
</head>
<body>
 
     <div class="upper-bar">
       <div class="container">
          <?php if(isset($_SESSION['user'])){
          $stmt=$con->prepare("SELECT * FROM users WHERE username =?");
          $stmt->execute(array($_SESSION['user']));
          $rows=$stmt->fetchAll();
          foreach($rows as $row){
               if(empty($row['images'])){echo '<img src="layout/images/img.png" class="img-circle headimg">';}else{
            echo'<img src="admin/uploades/'. $row['images'].'" class="img-circle headimg">';}}
          ?>

             welcome <span class="name"><?php echo $_SESSION['user'];?></span>
             <div class="pull-right">
          <a href="profile.php" class="btn btn-info">My profile</a>
          <a href="ads.php" class="btn btn-primary">New Ad</a>
          <a href="logout.php" class="btn btn-danger">Logout</a>
</div>
                
 
      <?php
      }else{ 
       ?> 
     <a href='login.php'>
      <span class="pull-right">
        Login /signup
      </span></a>
  <?php }?>
       </div>
     </div>
  <nav class="navbar navbar-inverse">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">HomePage</a>
    </div>
    
        <div class="collapse navbar-collapse" id="app">
      <ul class="nav navbar-nav navbar-right">
        <?php
        foreach($cats as $cat){
       echo '<li><a href="categories.php?pageid='.$cat['id']. '">'.$cat['name'].'</a></li>';
        }
        ?>
      </ul>
     </div>
       </div>
</nav>

  
