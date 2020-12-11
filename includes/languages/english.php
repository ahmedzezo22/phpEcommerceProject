<?php
 function lang($phrase){
    static $langs=array(
     //navbar page
      "CATEGORIES"      =>'categories',
      "ITEMS"           =>'items',
      "HOME_ADMIN"      =>'Home',
      "STATISTICS"      =>'statistics',
      "LOGS"            =>'logs',
      "MEMBERS"         =>'members',
      "COMMENTS"        =>'comments'
     
    );
    return $langs[$phrase];
 }