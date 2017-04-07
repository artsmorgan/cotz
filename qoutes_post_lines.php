<?php 


include 'conspath.php';
require (AS_PATH.'/classes/dbAdmin.php');

$data = array(
			"C:/AppServ/www/crmtecnosagot/cotz/json/lines_1.json",
			"C:/AppServ/www/crmtecnosagot/cotz/json/lines_2.json",
			"C:/AppServ/www/crmtecnosagot/cotz/json/lines_3.json"
		);


for ($i = 0; $i < count($data); $i++) {
        $json_url = $data[$i];
        $json = file_get_contents($json_url);
        $json_data = json_decode($json, TRUE);

        // echo "Count for file  is ". count($json_data) ."\n";
       
        foreach ($json_data as $key => $val) {

        		$row = dbAdmin::getInstancia()->insertRowImport(0,  $val['ID_de_Inventario'], "-",
                                                              $val['descripcion_del_producto'], $val['Cantidad'],
                                                              "", $val['Precio_de_lista'],
                                                              0, $val['Total_neto'], $val['quote_id']);

                echo "new line_id inserted ".$row . " / quote_id: ".$val['quote_id']."\n";
        }


       
}



?>  