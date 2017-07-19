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


if( $contact_id ){
    $params['contacto_info'] = dbAdmin::getInstancia()->getContactInfoById($params['contact_id']);
}

$params['salesperson_info'] = dbAdmin::getInstancia()->getAllFromPersonById($params['userid']);
$params['company_info'] = dbAdmin::getInstancia()->getInfoFromCompanyById($params['company_id']);
$params['lineas'] = json_decode($params['lineas'], true);


$firmasPath =  AS_PATH . '/assets/images/firmas/';
switch( $params['userid'] ){
    //Alonso Vargas
    case 5:
        $params['usersignature'] = $firmasPath . 'alonso_vargas.png';
    break;
    //alvaro araya
    case 6:
        $params['usersignature'] = $firmasPath . 'alvaro_araya.png';
    break;
    //Ana Belent Ojeda
    case 8:
        $params['usersignature'] = $firmasPath . 'ana_belen.png';
    break; 
    //David Alvarado
    case 9:
        $params['usersignature'] = $firmasPath . 'david_alvarado.png';
    break;
        //Diego conejo
    case 10:
        $params['usersignature'] = $firmasPath . 'diego_conejo.png';
    break;
        //Johny Bustamante
    case 12:
        $params['usersignature'] = $firmasPath . 'johnny_bustamante.png';
    break;
        //Jorge Iparraguirre
    case 13:
        $params['usersignature'] = $firmasPath . 'jorge_iparraguire.png';
    break;
    //Jose Manuel Salazar
    case 14:
        $params['usersignature'] = $firmasPath . 'jose_manuel_salazar.png';
    break;
    //Luis gonzales
    case 15:
        $params['usersignature'] = $firmasPath . 'luis_gonzalez.png';
    break;
    //Michael Quintero
    case 16:
        $params['usersignature'] = $firmasPath . 'michael_quintero.png';
    break;
    //Diana Venegas
    case 21:
        $params['usersignature'] = $firmasPath . 'diana_venegas.png';
    break;
}


// echo '<pre>';
// print_r($params);
// echo '</pre>';
// die();

PDF::printPDF($params, $fileName);