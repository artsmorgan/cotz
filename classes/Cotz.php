<?php

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

		public function saveCotization($data){}

		private function saveHeader($header){}

		private function saveContent($content){}


	}