<?php
	ini_set('memory_limit', '1024M');
	include_once ('../conspath.php');
	include_once (AS_PATH.'/classes/dbAdmin.php');

	$action = $_REQUEST['action'];

	switch ($action) {
		case 'save_cot':
				
				$data = $_REQUEST['data'];
				$params = array();
				parse_str($data, $params);

				//$params = dbAdmin::getInstancia()->changeCharset($params, 'utf-8', 'latin1');
				
				$vendedor_id		 = $params['userid'];
				$fecha_cotizacion	 = $params['fechaCotizacion'];
				$fecha_vencimiento	 = $params['fechaVencimiento'];
				$tasa_impuestos 	 = $params['tasaImpuestos'];
				$moneda 			 = $params['moneda'];
				$factor_redondeo 	 = $params['redondeo'];
                $no_solicitud 		 = $params['noSolicitud'];
                $no_cotizacion 	 	 = $params['noCotizacion'];
                $account_id 		 = $params['company_id'] ;
                $contact_id 		 = $params['contact_id'];
                $tiempo_entrega 	 = $params['tiempoEntrega'];
                $lugar_entrega		 = $params['lugarEntrega'];
                $forma_pago 		 = $params['formaPago'];
                $marca 				 = $params['marca'];
                $fase 				 = $params['fase'];
                $notas 				 = $params['notasCotizacion'];
                $notas_crm 			 = $params['notasCRM'];
                $subtotal 			 = $params['subtotal'];
                $descuento 		     = $params['totalDescuento'];
                $impuesto 			 = $params['totalIva'];
                $total				 = $params['total'];
                $tasa_cambio		 = $params['tasaCambio'];
                $lineas				 = $params['lineas'];
                $lineasObj			 = json_decode($lineas, true);

                $cot_id = dbAdmin::getInstancia()->insertHeader($vendedor_id,$fecha_cotizacion,$fecha_vencimiento,$tasa_impuestos,$moneda,$factor_redondeo,
                                $no_solicitud,$no_cotizacion,$account_id,$contact_id,$tiempo_entrega,$lugar_entrega,
                                $forma_pago,$marca,$fase,$notas,$notas_crm,$subtotal,$descuento,$impuesto,$total,$tasa_cambio);
                
                foreach ($lineasObj as $key => $val) {
				    
				    $row = dbAdmin::getInstancia()->insertRow($cot_id, $val['codigoArticulo'],$val['nombreArticulo'],
				    										  $val['descripcionArticulo'],$val['cantidad'],$val['unidadMedida'],$val['precioUnitario'],
				    										 $val['porcentajeDescuento'],$val['monto'], $val['exonerado']);
				}

				
				//echo json_encode($cot_id);
				echo json_encode( array( 'id' => $cot_id ) );
			break;

		case 'update_cot':
				
				$data = $_REQUEST['data'];
				$params = array();
				parse_str($data, $params);

				//$params = dbAdmin::getInstancia()->changeCharset($params, 'utf-8', 'latin1');
				
				$vendedor_id		 = $params['userid'];
				$fecha_cotizacion	 = $params['fechaCotizacion'];
				$fecha_vencimiento	 = $params['fechaVencimiento'];
				$tasa_impuestos 	 = $params['tasaImpuestos'];
				$moneda 			 = $params['moneda'];
				$factor_redondeo 	 = $params['redondeo'];
                $no_solicitud 		 = $params['noSolicitud'];
                $no_cotizacion 	 	 = $params['noCotizacion'];
                $account_id 		 = $params['company_id'] ;
                $contact_id 		 = $params['contact_id'];
                $tiempo_entrega 	 = $params['tiempoEntrega'];
                $lugar_entrega		 = $params['lugarEntrega'];
                $forma_pago 		 = $params['formaPago'];
                $marca 				 = $params['marca'];
                $fase 				 = $params['fase'];
                $notas 				 = $params['notasCotizacion'];
                $notas_crm 			 = $params['notasCRM'];
                $subtotal 			 = $params['subtotal'];
                $descuento 		     = $params['totalDescuento'];
                $impuesto 			 = $params['totalIva'];
                $total				 = $params['total'];
                $tasa_cambio		 = $params['tasaCambio'];
                $lineas				 = $params['lineas'];
                $id				 	= $params['cotId'];
                $lineasObj			 = json_decode($lineas, true);

                $cot_id = dbAdmin::getInstancia()->updateHeader($vendedor_id,$fecha_cotizacion,$fecha_vencimiento,$tasa_impuestos,$moneda,$factor_redondeo,
                                $no_solicitud,$no_cotizacion,$account_id,$contact_id,$tiempo_entrega,$lugar_entrega,
                                $forma_pago,$marca,$fase,$notas,$notas_crm,$subtotal,$descuento,$impuesto,$total,$tasa_cambio,$id);
                
                $deleteRows = dbAdmin::getInstancia()->deleteRows($id);

                foreach ($lineasObj as $key => $val) {
				    
				    $row = dbAdmin::getInstancia()->insertRow($id, $val['codigoArticulo'],$val['nombreArticulo'],
				    										  $val['descripcionArticulo'],$val['cantidad'],$val['unidadMedida'],$val['precioUnitario'],
				    										 $val['porcentajeDescuento'],$val['monto'], $val['exonerado']);
				}

				
				echo json_encode($cot_id);
			break;	
		case 'update_cot_batch':
				$data = $_REQUEST['data'];
				$params = array();
				parse_str($data, $params);

				$ids 			 	 = $params['cotsId'];
				$vendedor_id		 = $params['userid'];

				$cots_id = array();

				foreach($ids as $id ){
					if( dbAdmin::getInstancia()->updateHeaderBatch($vendedor_id, $id) ){
						$cots_id[] = $id;
					}
				}

				$response = array();

				if( count($cots_id) === count( $ids  ) ){
					$response['success'] = true;
					
				}

				$response['ids'] = $ids;
				$response['ids_count'] = count($cots_id);
				
				echo json_encode($response);
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
			
		case 'term_contact':
			
			$term_name = $_REQUEST['termName'];
			$term_email = $_REQUEST['termEmail'];
			$term_company = $_REQUEST['termCompany'];
			$term_company_id = $_REQUEST['termCompanyId'];

			$search = dbAdmin::getInstancia()->getContactList($term_name, $term_email, $term_company, $term_company_id);

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

		case 'get_usersAccount':

				$id = $_REQUEST['acc_id'];

				$results = dbAdmin::getInstancia()->getContactsByAccount($id);
				
				if(count($results)<=0){
					echo json_encode(array("result"=>0, "ok"=>false));
					return;
				}


				echo json_encode(array("result"=>$results, "ok"=>true));
			break;		


		case 'get_cotizacionesById':
			$id = $_REQUEST['id'];
			$results = dbAdmin::getInstancia()->getCotizacionById($id);
			echo json_encode(array("result"=>$results, "ok"=>true));

			break;

		case 'get_cotizacionesByUserId':
			$id = $_REQUEST['id'];
			$results = dbAdmin::getInstancia()->getCotizacionHeaderByCustomerId($id);
			echo json_encode(array("result"=>$results, "ok"=>true));
			
			break;
			
		case 'get_cotizacionesAll':
			
			$results = dbAdmin::getInstancia()->getCotizacionHeaderByCustomerAll();
			
			echo json_encode($results);		
			break;


		case 'get_cotizacionesAllMIN':
			$results = dbAdmin::getInstancia()->getCotizacionHeaderByCustomerAllMIN();
			echo json_encode($results);		
			break;
	
		case 'delete_cot':
			$response = array();
			$data = $_REQUEST['data'];

			if( empty($data)){
				$response['success'] = false;
			}  
			else{
				$response['success'] = dbAdmin::getInstancia()->deleteCot($data['id'], $data['username'] );
			}

			echo json_encode($response);	
			break;
}



?>
