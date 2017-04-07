<?php 


include 'conspath.php';
require (AS_PATH.'/classes/dbAdmin.php');

$data = array(
			"C:/AppServ/www/crmtecnosagot/cotz/json/quotes_1_5000.json",
			"C:/AppServ/www/crmtecnosagot/cotz/json/quotes_5000_10000.json",
			"C:/AppServ/www/crmtecnosagot/cotz/json/quotes_10000.json"
		);


for ($i = 0; $i < count($data); $i++) {
        // echo 'key: ' . $data[$i] . '<br>.';
		// echo $i . '---';
        $json_url = $data[$i];
       //  if($i == 1){
       // 		print_r($json_url);
       // }
        // echo $json_url . '----';
        $json = file_get_contents($json_url);
        $json_data = json_decode($json, TRUE);
       
        foreach ($json_data as $key => $params) {

        		$vendedor_id		 = "";
				$fecha_cotizacion	 = "now()";
				$fecha_vencimiento_ex= $params['vencimiento'];
				
				if($fecha_vencimiento_ex != '' ){
					$fechaSlice 		 = explode("/", $fecha_vencimiento_ex);
					$fecha_vencimiento	 = $fechaSlice[2].'-'.$fechaSlice[0].'-'.$fechaSlice[1];
				}else{
					$fecha_vencimiento	 = "now()";
				}
								
				$tasa_impuestos 	 = $params['Impuesto'];
				$moneda 			 = "colones";
				$factor_redondeo 	 = "";
                $no_solicitud 		 = $params['Solicitud_No'];
                $no_cotizacion 	 	 = number_format($params['no_cotizacion'],0, '.', '');
                $account_id 		 = "";
                $contact_id 		 = "";
                $tiempo_entrega 	 = $params['tiempo_de_entrega'];
                $lugar_entrega		 = $params['lugar_de_entrega'];
                $forma_pago 		 = $params['forma_de_pago'];
                $marca 				 = $params['Marca'];
                $fase 				 = $params['Fase'];
                $notas 				 = $params['descripcion'];
                $notas_crm 			 = "";
                $subtotal 			 = $params['Subtotal'];
                $descuento 		     = $params['Descuento'];
                $impuesto 			 = $params['Impuesto'];
                $total				 = $params['total'];
                $tasa_cambio		 = "";
                $externalID			 = $params['id_cotizacion'];
                $externalContact	 = $params['id_contacto'];
                $externalAccount	 = $params['id_compania'];
                $externalCreateId	 = $params['id_owner'];

                $cot_id = dbAdmin::getInstancia()->insertHeaderImport(
                				$vendedor_id,$fecha_cotizacion,$fecha_vencimiento,$tasa_impuestos,$moneda,$factor_redondeo,
                                $no_solicitud,$no_cotizacion,$account_id,$contact_id,$tiempo_entrega,$lugar_entrega,
                                $forma_pago,$marca,$fase,$notas,$notas_crm,$subtotal,$descuento,$impuesto,$total,$tasa_cambio,
                                $externalID, $externalContact, $externalAccount, $externalCreateId, 'zoho'
                           );

                echo "new id inserted ".$cot_id ."\n";
        }


       
}

// echo "Total de objetos: " . $data_count .'<br><br>';

//  foreach ($data as $key => $value) {
//     $counter++;
//     // print_all($value); die();
//     $data = Array(
//             'firstName' => $value['Nombre'],
//             'lastName' => $value['Apellidos'],
//             'officePhone' => $value['Telefono'],
//             'mobilePhone' => $value['Telefono_particular'],
//             'title' => Array
//                 (
//                     'value' => 'Sr.'
//                 ),

//             'primaryEmail' => Array
//                 (
//                     'emailAddress' => $value['email']
//                 ),
//             'state' => Array
//                 (
//                     'id' => 5
//                 ),    


       
//         );
       

//         $response = ApiRestHelper::createApiCall($helper->contact_create_url, 'POST', $headers, array('data' => $data));
//         $response = json_decode($response, true);
//         // print_all($response);
//         if ($response['status'] == 'SUCCESS')
//         {
//             $contact = $response['data'];
//             dbAdmin::getInstancia()
//                                 ->updateContactExternalData( $value['ID_de_propietario_de_Contacto'], 
//                                                              $value['ID_de_Contacto'], 
//                                                              $value['ID_de_Compania'],
//                                                              $contact['id']);
//              echo 'Contact created id: ' . $contact['id'] .' | '.$counter.' de '.$data_count.' Agregado. \n';    
             
//              if($counter == $data_count){
//                 echo "<br> ----------------------- FINISH -------------------------------";
//              }

//         }
//         else
//         {
//             // Error
//             $errors = $response['errors'];
//             // Do something with errors, show them to user
//         }
// }


?>  