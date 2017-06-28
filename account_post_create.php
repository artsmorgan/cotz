<?php 

include ('classes/ApiRestHelper.php');
include 'conspath.php';
require (AS_PATH.'/classes/dbAdmin.php');


//////////////////////////////////////////////////////////////////////////

$helper = new ApiRestHelper();
$authenticationData = $helper->login('super','super');

//Add code to check if user is logged successfully

$headers = array(
    'Accept: application/json',
    'ZURMO_SESSION_ID: ' . $authenticationData['sessionId'],
    'ZURMO_TOKEN: ' . $authenticationData['token'],
    'ZURMO_API_REQUEST_TYPE: REST',
);
//////////////////////////////////////////////////////////////////////////

// Load Json File
$json_url = "json/june/accounts.json";
$json = file_get_contents($json_url);
$data = json_decode($json, TRUE);
$cdata =  count($data);
echo 'Total Results: '.$cdata."\n";
// die();
$errorsArr = Array();

$iterator = 1;
foreach ($data as $key => $value) {
    // print_all($value); die();
    // $emailCustom = ($value['Correo_electronico']=== NULL) ? 'noemail@noemail.com' : $value['Correo_electronico'];
    $data = Array(
                    'name' => $value['Nombre_de_Compania'],
                    'officePhone' => $value['Telefono'],
                    'officeFax' => $value['Fax'],
                    'website' => $value['Sitio_web'],
                    'description' => htmlentities($value['Descripcion']),
                    'cedula_juridCstm' => $value['cedula_juridica'],
                    'cuentasCstm' => $value['codigo_cliente'],
                    'extencion_imCstm' => htmlentities($value['Exencion_impuestos']),  
                    'shippingAddress' => Array(
                                'street1' => $value['Ciudad_de_envio'],
                                'street2' => '-',
                                'city' => $value['Estado_de_envio'],
                                'postalCode' => '-',
                                'country' => 'Costa Rica'
                            ),          
                    'industry' => Array
                        (
                            'value' => 'Financial Services',
                        ),
                    'type' => Array
                        (
                            'value' => 'Customer',
                        ),
                    'primaryEmail' => Array
                        (
                            'emailAddress' => $value['Correo_electronico']
                        )
                   
                    
                );


                // echo $helper->account_create_url; die();

                $response = $helper->createApiCall($helper->account_create_url, 'POST', $headers, array('data' => $data));
                // print_r($response); die();

                $response = json_decode($response, true);



                if ($response['status'] == 'SUCCESS')
                {
                    $contact = $response['data'];
                    // // print_r($contact);
                    // echo '<pre>';
                    // print_r(array($json['extenarl_id'], $contact['id']));
                    // echo '</pre>';
                    dbAdmin::getInstancia()
                                ->updateAccountUserOwner( $value['ID_de_propietario_de_Compania'], 
                                                          $value['id_de_compania'], $contact['id']);
                    //Do something with contact data
                    echo 'Account created id: ' . $contact['id'] . ', nombre: '.$value['Nombre_de_Compania']. ' | ' . $iterator  .' of '.  $cdata."\n";
                }
                else
                {
                    // Error
                    $errors = $response['errors'];
                    print_r($errors);
                    array_push($errorsArr,  $value['id_de_compania']);
                    // Do something with errors, show them to user
                }

                // die();
                $iterator++;
}

foreach ($errorsArr as $key => $value) {
    echo 'Error on: ' . $value  ."\n";
}
// // print_all($data);
// die();


// $json['extenarl_id'] = 'zcrm_1189182000002744063';



// echo '<pre>';
// print_r($response);
// echo '</pre>';




?>  