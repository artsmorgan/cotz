<?php 

include ('classes/ApiRestHelper.php');
include 'conspath.php';
require (AS_PATH.'/classes/dbAdmin.php');

$contacts = dbAdmin::getInstancia()->getCotzHeaderWithExternalRelationship();

foreach ($contacts as $key => $value) {

	// print_r($value);

	$cotId = (isset($value['cotz_id']) || $value['cotz_id'] != '') ? $value['cotz_id'] : -1;
	$user_id = (isset($value['user_id']) || $value['user_id'] != '') ? $value['user_id'] : -1;
	$acount_id = (isset($value['acount_id']) || $value['acount_id'] != '') ? $value['acount_id'] : -1;
	$contact_id = (isset($value['contact_id']) || $value['contact_id'] != '') ? $value['contact_id'] : -1;

  $update = dbAdmin::getInstancia()->updateCotzWithExternal($cotId,$user_id, $acount_id, $contact_id);
  echo "my cotz_id is ".$value['cotz_id']."\n";
}






?>  