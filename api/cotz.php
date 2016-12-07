<?php
	
	require('../classes/cotz.php');

	$action = $_REQUEST['action'];

	if(!isset($action)) {
			echo 'La accion es requerida'; 
			die();
	}

	$cotz  =  new Cotz();

	switch ($action) {
		case 'getJsonSample':
			echo $cotz->getJsonSanmple();
			break;

		case 'processCot':
			$cotz->saveCotization($_POST);
			// echo '<pre>';
			// 	print_r($_POST);
			// echo '</pre>';
			break;	
		
		default:
			# code...
			break;
	}