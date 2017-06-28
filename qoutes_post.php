<?php 


include 'conspath.php';
require (AS_PATH.'/classes/dbAdmin.php');

$data = array(
			"json/june/quotes.json"
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

        		$vendedor_id		 = -1;
				$fecha_cotizacion_ex	 = $params['created_at'];
				$fecha_vencimiento_ex= $params['vencimiento'];

                
				
				if($fecha_vencimiento_ex != '' ){
					$fechaSlice 		 = explode("/", $fecha_vencimiento_ex);
                    // print_r($fechaSlice);
					$fecha_vencimiento	 = $fechaSlice[2].'-'.$fechaSlice[0].'-'.$fechaSlice[1]; //YYYYMMDD
				}else{
					$fecha_vencimiento	 = "now()";
				}

                if($fecha_cotizacion_ex != '' ){
                    $fechaSlice          = explode("/", $fecha_cotizacion_ex);
                    // print_r($fechaSlice);
                    $fix = explode(" ", $fechaSlice[2]);
                    // print_r($fix);
                    $fecha_cotizacion   = $fix[0].'-'.$fechaSlice[0].'-'.$fechaSlice[1];
                }else{
                    $fecha_cotizacion   = "now()";
                }

                // echo '$fecha_cotizacion : ' . $fecha_cotizacion ."\n";
                // echo '$fecha_vencimiento : ' . $fecha_vencimiento ."\n";
                // die();
								
				$tasa_impuestos 	 = $params['tasa_de_impuestos'];
				$moneda 			 = "colones";
				$factor_redondeo 	 = "";
                $no_solicitud 		 = $params['Solicitud_No'];
                $no_cotizacion 	 	 = $params['Asunto'];//number_format($params['no_cotizacion'],0, '.', '');
                $account_id 		 = "";
                $contact_id 		 = "";
                $tiempo_entrega 	 = $params['tiempo_de_entrega'];
                $lugar_entrega		 = $params['lugar_de_entrega'];
                $forma_pago 		 = $params['forma_de_pago'];
                $marca 				 = $params['Marca'];
                $fase 				 = $params['Fase'];
                $notas 				 = $params['descripcion'];
                $notas_crm 			 = "";
                $subtotal 			 = $params['subtotal_antes_descuento'];
                $descuento 		     = $params['Descuentos'];
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
                // die();
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