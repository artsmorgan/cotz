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

		case 'term_company':
				
				$term = $_REQUEST['term'];

				$search = dbAdmin::getInstancia()->getCompanyList($term);

				echo json_encode($search);
			break;		

		case 'account_has_contacts':
				
				$id = $_REQUEST['id'];

				$results = dbAdmin::getInstancia()->getCompanyContactsByCompany($id);
				
				if(count($results)<=0){
					echo json_encode(array("result"=>0, "ok"=>false));
					return;
				}


				echo json_encode(array("result"=>$results, "ok"=>false));
			break;					
		
	}

?>