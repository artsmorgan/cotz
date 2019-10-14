<?php
// Test CVS

require_once './Excel/reader.php';


// ExcelFile($filename, $encoding);
$data = new Spreadsheet_Excel_Reader();


// Set output Encoding.
$data->setOutputEncoding('CP1251');

/***
* if you want you can change 'iconv' to mb_convert_encoding:
* $data->setUTFEncoder('mb');
*
**/

/***
* By default rows & cols indeces start with 1
* For change initial index use:
* $data->setRowColOffset(0);
*
**/



/***
*  Some function for formatting output.
* $data->setDefaultFormat('%.2f');
* setDefaultFormat - set format for columns with unknown formatting
*
* $data->setColumnFormat(4, '%.3f');
* setColumnFormat - set format for column (apply only to number fields)
*
**/
set_time_limit (0);
$data->read('./inv.xls');

/*


 $data->sheets[0]['numRows'] - count rows
 $data->sheets[0]['numCols'] - count columns
 $data->sheets[0]['cells'][$i][$j] - data from $i-row $j-column

 $data->sheets[0]['cellsInfo'][$i][$j] - extended info about cell
    
    $data->sheets[0]['cellsInfo'][$i][$j]['type'] = "date" | "number" | "unknown"
        if 'type' == "unknown" - use 'raw' value, because  cell contain value with format '0.00';
    $data->sheets[0]['cellsInfo'][$i][$j]['raw'] = value if cell without format 
    $data->sheets[0]['cellsInfo'][$i][$j]['colspan'] 
    $data->sheets[0]['cellsInfo'][$i][$j]['rowspan'] 
*/

error_reporting(E_ALL ^ E_NOTICE);

$cells = $data->sheets[0]['cells'];

// echo '<pre>';
// print_r($cells);
// echo '</pre>';
$arrRst = array();

foreach($cells as $key => $value){
	if($key > 1){
		// foreach ($value as $k => $v) {
			$obj = array(
				"Apellidos" => $value[1],
				"Bodega" => $value[2],
				"Codigo" => $value[3],
				"NombreDelArticulo" =>  mb_convert_encoding( $value[4], 'UTF-8' ),
				"Linea" => $value[5],
				"NoDeParte" => $value[6],
				"Unidad" => $value[7],
				"CantidadDisponible" => $value[8],
				"Precio" => $value[9],
				"Provedor" => $value[10],
				"DetallesDelArticulo" => mb_convert_encoding( $value[11], 'UTF-8' ),
			);
			array_push($arrRst, $obj);
		// }
	}
}

// echo '<pre>';
// print_r($arrRst);
// echo '</pre>';
echo json_encode($arrRst,JSON_UNESCAPED_UNICODE);
// for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {

// 	for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
// 		echo "\"".$data->sheets[0]['cells'][$i][$j]."\",";
// 	}

// 	echo "\n \n \n";

// }




//print_r($data);
//print_r($data->formatRecords);
?>
