<?php
ob_start();//start output buffering for header already send error
session_start();

if(isset($_SESSION['username'])){
     
  $pageTitle="dashboard";
  include 'inti.php';
  $latestUsers=5;
  $latest= getLatest('*','users','userID',$latestUsers);
  $latestitem=5;
  $latestItems=getLatest('*','items','itemID',$latestitem);
  $numcomment=5;
  
  
   
    
  ?>
  <div class="container home-stat">
    <h1 class="text-center">DashBoard</h1>
    <div class="row">
      <div class="col-md-3">
        <div class="stat st-member">
          <i class="fa fa-users icon"></i>
          <div class="info">
          Total Members
          <span><a href="member.php">
            <?php
           echo countItem('userID','users');
            ?>
          </a></span>
        </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat st-pending">
          <i class="fa fa-user-plus icon"></i>
             <div class="info">
           Pending Members
          <span><a href="member.php?do=manage&page=pending">
          <?php
         echo checkItem('registerStatus','users',0);
          ?>
          </a></span>
             </div>
        </div>
      </div>
      <div class="col-md-3 ">
        <div class="stat st-items">
           <i class="fa fa-tag icon"></i>
             <div class="info">
          Total items
          <span><a href="item.php">
           <?php
           echo countItem('itemID','items');
            ?>
          </a></span>
        </div>
        </div>   
      </div>
      <div class="col-md-3">
        <div class="stat st-comment">
          <i class="fa fa-comments icon"></i>
             <div class="info">
               Total comments
          <span>
            <span><a href="comment.php">
           <?php
           echo countItem('C_id','comments');
            ?>
          </a></span>
        </div>
      </div>
      </div>
    </div>
  </div>
  <div class="container latest">
    <div class="row">
      <div class="col-sm-6">
       <div class= "panel panel-default">
        <div class="panel-heading">
          
          <i class="fa fa-users"></i>  Latest <?php echo $latestUsers;?> register users
          <span class="plus pull-right">
           <i class="fa fa-plus "></i>
          </span>
       </div>
       <div class="panel-body">
        <ul class="list-unstyled users-list">
        <?php
                       foreach($latest as $value){
                       echo'<li>';
                       echo $value['username'];
                        echo ' <a href="member.php?do=edit&userid='.$value['userID'].'">';
                       echo'<span class="btn btn-success pull-right">';
                        echo'<i class="fa fa-edit"></i>Edit';
                        if($value['registerStatus']==0){
                                  echo'<a href="member.php?do=activate&userid='.$value['userID'].'" class="btn btn-info pull-right activate">Activate</a>';
                                    }
                      echo' </a></span></li>';
          }
        ?>
        </ul>
       </div>
      </div>
      </div>
       <div class="col-sm-6">
       <div class= "panel panel-default">
        <div class="panel-heading">
         
        <i class="fa fa-users"></i>   <?php echo $latestitem;?> Latest items
        <span class="plus pull-right">
           <i class="fa fa-plus "></i>
          </span>
       </div>
       <div class="panel-body">
         <ul class="list-unstyled users-list">
        <?php
              if(!empty($latestItems)){
                       foreach($latestItems as $value){
                       echo'<li>';
                       echo $value['name'];
                        echo ' <a href="item.php?do=edit&itemid='.$value['itemID'].'">';
                       echo'<span class="btn btn-success pull-right">';
                        echo'<i class="fa fa-edit"></i>Edit';
                        if($value['approve']==0){
                                  echo'<a href="item.php?do=approve&itemid='.$value['itemID'].'" class="btn btn-info pull-right activate"><i class="fa fa-check">Approve</i></a>';
                                    }
                      echo' </a></span></li>';
          }
          }
          else{echo'<div class="nice-message">there is no items to show </div>';
                  
                  }
          ?>
       </div>
      </div>
    </div>
   </div>
    <div class="row">
      <div class="col-sm-6">
       <div class= "panel panel-default">
        <div class="panel-heading">
          
          <i class="fa fa-comments-o"></i>  Latest <?php echo $numcomment;?> comments
          <span class="plus pull-right">
           <i class="fa fa-plus "></i>
          </span>
       </div>
       <div class="panel-body">
       <?php
         $stmt=$con->prepare("SELECT comments.*,users.username As user FROM comments
                                       INNER JOIN users ON
                                      users.userID=comments.user_id
                                       ORDER BY c_id DESC LIMIT $numcomment
                                      ");
                  $stmt->execute();
                  $rows=$stmt->fetchAll();
                  if(!empty($rows)){
                  foreach($rows as $row){
                    echo'<div class="comment-box">';
                    echo'<span class="member-n"><a href="comment.php" style="text-decoration:none">'. $row['user'].'</a></span>';
                       echo'<p class="member-c">'. $row['comment'].'</p>';
                    echo'</div>';
                  }
                  }else{echo'<div class="nice-message">there is no comments to show </div>';}
       
       ?>
       </div>
       </div>
      </div>
  </div>
    </div>
  
  
  
  
  
  
  
  <?php
    include  $tpl. "footer.php";
  
}else{
    header('location:admin.php');
    exit();
}
ob_end_flush();
?>
