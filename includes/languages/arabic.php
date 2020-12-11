<?php
 function lang($phrase){
    static $langs=array(
      "welcome"=>'اهلا',
      "admin"=>'المدير'
    );
    return $langs[$phrase];
 }