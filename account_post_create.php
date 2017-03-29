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
$json_url = "json_acc.test.json";
$json = file_get_contents($json_url);
$data = json_decode($json, TRUE);
echo count($data); die();


foreach ($data as $key => $value) {
    // print_all($value); die();
    $data = Array(
                    'name' => $value['Nombre_de_Compania'],
                    'officePhone' => $value['Telefono'],
                    'officeFax' => $value['Fax'],
                    'website' => $value['Sitio_web'],
                    'description' => $value['Descripcion'],
                    'cedula_juridcstm' => '-',
                    'extencion_imCstm' => $value['Exencion_impuestos'],  
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


                //echo $helper->account_create_url; die();

                $response = $helper->createApiCall($helper->account_create_url, 'POST', $headers, array('data' => $data));
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
                    echo 'User created id: ' . $contact['id'] . ', nombre: '.$value['Nombre_de_Compania'].'<br>';
                }
                else
                {
                    // Error
                    $errors = $response['errors'];
                    print_r($errors);
                    // Do something with errors, show them to user
                }
}


// // print_all($data);
// die();


// $json['extenarl_id'] = 'zcrm_1189182000002744063';



// echo '<pre>';
// print_r($response);
// echo '</pre>';




?>  