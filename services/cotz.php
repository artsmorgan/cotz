<?php
	include_once ('../conspath.php');
	include_once (AS_PATH.'/classes/dbAdmin.php');

	$action = $_REQUEST['action'];



	switch ($action) {
		case 'save_cot':
				print_all($_REQUEST);
			break;
		case 'list_cotz':
				return json_encode(array("test"=>"yes"));
			break;

		case 'list_cot':
						
			break;	

		case 'update_cot':
						
			break;			
		
	}

?>