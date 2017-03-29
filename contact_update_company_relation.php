<?php 

include ('classes/ApiRestHelper.php');
include 'conspath.php';
require (AS_PATH.'/classes/dbAdmin.php');

$contacts = dbAdmin::getInstancia()->getAccountExternalId();

// print_r($admin);die();
//cross fingers 
$i = 0;
foreach ($contacts as $key => $value) {
    $i++;

    // if($i == 1){
    //  print_all($value);
    //  die();
    // }
    
  // $update = dbAdmin::getInstancia()->updateCompanyOwnerById($value['u_id'] , $value['ownedsecurableitem_id']);
  // echo "my ownedsecurableitem_id is ".$value['ownedsecurableitem_id']." and my owner id is ". $value['u_id']."<br>";

  $update = dbAdmin::getInstancia()->createCompanyOwnerRelation($value['account_id'] , $value['contact_id']);
  echo "my companyID is ".$value['account_id']." and my id is ". $value['contact_id']."<br>";
}






?>  