<?php
	
	
	require_once('../classes/conn.php');
	/**
	* 
	*/
	class Cotz 
	{
		
		function __construct()
		{
			$this->now = date("Y-m-d H:i:s");
		}


		public function getCotzBySellerId($sellerId){}

		public function getCotzByClientId($clientId){}

		public function getCotzAll(){}

		public function getJsonSanmple(){
			
			$content = array();
			for($i = 0; $i < 15; $i++){
				$cot = array(
						"cot_no" => $i,
						"client" => "client_".rand (1, 99),
						"seller" => "seller_".rand (1, 99),
						"description" => "Descripcion de la cotizacion: ".rand (1, 99),
						"cot_date" => $this->now,
						"edit" => $i
					);
				array_push($content, $cot);
			}

			return json_encode($content);
		}

		public function saveCotization($data){
			
			$header = $this->saveHeader($data);

			print_r($header);

			//save content
		}

		private function parseToNull($arr){
			// print_r($data);
			$data = Array();
			foreach ($arr as $key => $value) {
				// echo 'value: '. $value;
				if($value==''){

					$value = "NULL";
				}
				// print_r(array($key=>$value));
				//array_push($data, array($key=>$value));
				$data[$key] = $value;
			}
			$data['numeroCotizacion'] = 0;
			$data['sessionId'] = 8;

			return $data;
		}

		private function saveHeader($data){
			global $db;
			$data = $this->parseToNull($data);
			// echo 'db';
			// print_r($db);
			//save header
			$sql = "INSERT INTO cotz_header(nombre_empresa,cedula_juridica,contacto,owner,solicitud_no,fecha,
								telefono,fax,correo,vigente_hasta,cotz_no,subtotal,total,tax,descuento,createdAt,createdBy)
								VALUES(
								'".$data['nombreCliente']."',
								'".$data['cedulaJuridica']."',
								'".$data['nombreContacto']."',
								'".$data['vendedor']."',
								'".$data['noSolicitud']."',
								'".$data['fechaCotizacion']."',
								'".$data['telefono1']."',
								'".$data['Fax']."',
								'".$data['email']."',
								'".$data['fechaVencimiento']."',
								'".$data['numeroCotizacion']."',
								'".$data['subtotal']."',
								'".$data['total']."',
								'".$data['totalIva']."',
								'".$data['totalDescuento']."',
								'".$this->now."',							
								'".$data['sessionId']."'); SELECT LAST_INSERT_ID() ;";
			echo $sql;
			$id = $db->Execute($sql);

			return $id;
		}

		private function saveContent($content){}


	}