<?php 

include ('classes/ApiRestHelper.php');
include 'conspath.php';
require (AS_PATH.'/classes/dbAdmin.php');

$contacts = dbAdmin::getInstancia()->getCotzHeaderWithExternalRelationship();

foreach ($contacts as $key => $value) {

	// print_r($value);

  $update = dbAdmin::getInstancia()->updateCotzWithExternal($value['cotz_id'], $value['user_id'],
  															 $value['acount_id'], $value['contact_id']);
  echo "my cotz_id is ".$value['cotz_id']."\n";
}






?>  