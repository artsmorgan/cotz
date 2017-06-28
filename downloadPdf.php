<?php
if( !isset($_POST['data']) ){
    exit;
}

include_once ('conspath.php');
include_once (AS_PATH.'/classes/dbAdmin.php');
include_once (AS_PATH.'/classes/Pdf.php');

$data = $_POST['data'];
$params = array();
parse_str($data, $params);

$dt = new DateTime();
$fileName = 'cotizacion_' . $params['userid'] . '_' . $dt->format('Y-m-d His') . '.pdf';
header("Content-Disposition: attachment; filename=$fileName");

$params['contacto_info'] = dbAdmin::getInstancia()->getContactInfoById($params['contact_id']);
$params['salesperson_info'] = dbAdmin::getInstancia()->getAllFromPersonById($params['userid']);
$params['company_info'] = dbAdmin::getInstancia()->getInfoFromCompanyById($params['company_id']);
$params['lineas'] = json_decode($params['lineas'], true);

if( isset( $params['incluirFirma'] ) ){
    $firmasPath =  AS_PATH . '/assets/images/firmas/';
    switch( $params['userid'] ){
        case 7:
            $params['signaturepath'] = $firmasPath . 'alonso_vargas.png';
        break;
    }
}

PDF::printPDF($params, $fileName);