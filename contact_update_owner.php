<?php 

include ('classes/ApiRestHelper.php');
include 'conspath.php';
require (AS_PATH.'/classes/dbAdmin.php');

$contacts = dbAdmin::getInstancia()->getContactIds();

// print_r($admin);die();
//cross fingers 

foreach ($contacts as $key => $value) {
    // print_all($value);
    
  $update = dbAdmin::getInstancia()->updateCompanyOwnerById($value['u_id'] , $value['ownedsecurableitem_id']);
  echo "my ownedsecurableitem_id is ".$value['ownedsecurableitem_id']." and my owner id is ". $value['u_id']."<br>";
}






?>  