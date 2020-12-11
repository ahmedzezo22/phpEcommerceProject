<?php
 $do="";
 if(isset($_GET['do'])){
    $do=$_GET['do']; 
 }else{
    $do="manage";
 }
 if($do=='manage'){
    echo"you are in manage page";
 }elseif($do=='add'){
    echo"you are  in add page";
 }elseif($do=='insert'){
    echo'you are in insert page';
    }else{
    echo'error';
 }