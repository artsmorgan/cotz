<?php

require_once '../phpExcelReader/Excel/reader.php';

class Excel {
    public function getInvFromExcel(){
        // ExcelFile($filename, $encoding);
        $data = new Spreadsheet_Excel_Reader();

        $data->setOutputEncoding('CP1251');


        set_time_limit (0);
        $data->read('../phpExcelReader/inv.xls');



        error_reporting(E_ALL ^ E_NOTICE);

        $cells = $data->sheets[0]['cells'];

        // echo '<pre>';
        // print_r($cells);
        // echo '</pre>';
        $arrRst = array();

        foreach($cells as $key => $value){
            if($key > 1){
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
            }    
        }

        // return json_encode($arrRst,JSON_UNESCAPED_UNICODE);
        return $arrRst;
    }
}