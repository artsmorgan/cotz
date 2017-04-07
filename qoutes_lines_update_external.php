<?php 

include ('classes/ApiRestHelper.php');
include 'conspath.php';
require (AS_PATH.'/classes/dbAdmin.php');

$contacts = dbAdmin::getInstancia()->getCotzDetailWithExternalRelationship();

foreach ($contacts as $key => $value) {

	// print_r($value);

  $update = dbAdmin::getInstancia()->updateCotzDetailWithExternal($value['cotz_header_id'], $value['id']);
  echo "my id is ".$value['id']."\n";
}






?>  