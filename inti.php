
<?php
ini_set('display_error','on');
error_reporting(E_ALL);
include "admin/connect.php";
//routs in my page//
  $tpl='includes/template/'; //template directory
  $css='layout/css/'; //css directory
  $js='layout/js/';  //js directory
  $lan="includes/languages/";
  $func="includes/functions/";
  //include important files
  include $lan. "english.php";
  include $func. "fun.php";
  include  $tpl. "header.php";
