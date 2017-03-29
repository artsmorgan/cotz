<?php

	include_once('conspath.php');
	include_once('classes/dbImport.php');

	$str = file_get_contents('json_example.json');
	$json = json_decode($str, true);
	// echo '<pre>' . print_r($json, true) . '</pre>';


	foreach ($json as $key => $val) {
	
		$email_id = dbImport::getInstancia()->insertEmail($val['email']);
		$secondaryemail_email_id = dbImport::getInstancia()->insertEmail($val['email']);
		$address_id = dbImport::getInstancia()->insertAddressBlank();
		$secondaryaddress_address_id = dbImport::getInstancia()->insertAddressBlank();
		$customField_id =  dbImport::getInstancia()->insertCustomField();
		$owner_id = dbImport::getInstancia()->InsertOwner($val['ID_de_propietario_de_Contacto']);

		$person_id = dbImport::getInstancia()->InsertPerson(
			$val['Nombre'], $val['Apellidos'], $val['Telefono_particular'], $val['Telefono'], $owner_id, 
			$address_id, $email_id, $customField_id
		);



		$contacto_id = dbImport::getInstancia()->insertContacto($val['ID_de_Compania'],$person_id, 
			$secondaryaddress_address_id,$secondaryemail_email_id);
		
		echo $contacto_id;


	}


?>