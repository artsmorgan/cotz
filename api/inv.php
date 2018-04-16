<?php
	
	require('../classes/Excel.php');

	$action = $_REQUEST['action'];

	if(!isset($action)) {
			echo 'La accion es requerida'; 
			die();
	}

	$excel  =  new Excel();

	switch ($action) {
		case 'getInventario':
			echo json_encode($excel->getInvFromExcel(),JSON_UNESCAPED_UNICODE);
			break;
		
		default:
			# code...
			break;
	}