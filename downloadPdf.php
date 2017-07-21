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

$errors = array();

if ( empty( $params['userid'] ) ){
    $errors[] = 'Seleccione un vendedor';
}

if ( empty( $params['company_id'] ) ){
    $errors[] = 'Seleccione una compañia';
}

if( !empty($errors) ){
    echo '<h3>Se encontraron algunos errores:</h3>';
    echo  '<p>' . join($errors, '</p><p>') . '</p>';
    die();
}


if( $params['contact_id'] ){
    $params['contacto_info'] = dbAdmin::getInstancia()->getContactInfoById($params['contact_id']);
}

$params['salesperson_info'] = dbAdmin::getInstancia()->getAllFromPersonById($params['userid']);
$params['company_info'] = dbAdmin::getInstancia()->getInfoFromCompanyById($params['company_id']);
$params['lineas'] = json_decode($params['lineas'], true);

// echo '<pre>';
// print_r($params);
// echo '</pre>';
// die();

PDF::printPDF($params, $fileName);