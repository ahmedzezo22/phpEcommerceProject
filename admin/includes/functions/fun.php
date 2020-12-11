<?php


/* set title dynamically */
function getTitle(){
    global  $pageTitle;
    if(isset($pageTitle)){
        echo $pageTitle;
    }else{
        echo "default";
    }
}
/*redirect function for error and success */
  function redirectHome($msg,$url=NULL,$seconds=3){
    if($url==null){
        $url='dashboard.php';
        $page="previous page";
    }else{
        if(isset($_SERVER['HTTP_REFERER'])&&$_SERVER['HTTP_REFERER']!=''){
            $url=$_SERVER['HTTP_REFERER'];
            $page="previous page";
        }else{
            $url='index.php';
            $page="Home page";
        }
        
    }
    
    
       echo $msg;
    echo"<div class='alert alert-info'>you will br redirct in $page aftrer $seconds seconds</div>";
    header("refresh:$seconds;url=$url");
  }
/* function to check item in database
$select : item you want to check
$from   :table
$value  :the value of item

*/
function checkItem($select,$from,$value){
    global $con;
    $statment=$con->prepare("SELECT $select FROM $from WHERE $select=?");
    $statment->execute(array($value));
   $count=$statment->rowCount();
   return $count;

}

/* function to count items in table */

function countItem($columnName,$table){
    global $con;
     $stmt=$con->prepare("SELECT COUNT($columnName) FROM $table");
    $stmt->execute();
     return $stmt->fetchColumn();
}
/* get latest items from tables */
function getLatest($select,$from,$order,$limit=5){
    global $con;
    $statment=$con->prepare("SELECT $select FROM $from ORDER BY $order DESC LIMIT $limit");
    $statment->execute();
    $rows=$statment->fetchAll();
    return $rows;
}