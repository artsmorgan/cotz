<?php 

include ('classes/ApiRestHelper.php');
include 'conspath.php';
require (AS_PATH.'/classes/dbAdmin.php');


////////////////////////////////////////////////////////////////////////

$helper = new ApiRestHelper();
$authenticationData = $helper->login('super','super');

//Add code to check if user is logged successfully

$headers = array(
    'Accept: application/json',
    'ZURMO_SESSION_ID: ' . $authenticationData['sessionId'],
    'ZURMO_TOKEN: ' . $authenticationData['token'],
    'ZURMO_API_REQUEST_TYPE: REST',
);
////////////////////////////////////////////////////////////////////////

// Load Json File
// $json_url = "json_clients.single.json"; // TEST ONLY
$json_url = "json_clients.json"; // json_clients
$json = file_get_contents($json_url);
$data = json_decode($json, TRUE);
// echo count($data); die();
// print_all($data[0]);die();
$data_count = count($data);
$counter = 0;
echo "Total de objetos: " . $data_count .'<br><br>';

 foreach ($data as $key => $value) {
    $counter++;
    // print_all($value); die();
    $data = Array(
            'firstName' => $value['Nombre'],
            'lastName' => $value['Apellidos'],
            'officePhone' => $value['Telefono'],
            'mobilePhone' => $value['Telefono_particular'],
            'title' => Array
                (
                    'value' => 'Sr.'
                ),

            'primaryEmail' => Array
                (
                    'emailAddress' => $value['email']
                ),
            'state' => Array
                (
                    'id' => 5
                ),    


       
        );
       

        $response = ApiRestHelper::createApiCall($helper->contact_create_url, 'POST', $headers, array('data' => $data));
        $response = json_decode($response, true);
        // print_all($response);
        if ($response['status'] == 'SUCCESS')
        {
            $contact = $response['data'];
            dbAdmin::getInstancia()
                                ->updateContactExternalData( $value['ID_de_propietario_de_Contacto'], 
                                                             $value['ID_de_Contacto'], 
                                                             $value['ID_de_Compania'],
                                                             $contact['id']);
             echo 'Contact created id: ' . $contact['id'] .' | '.$counter.' de '.$data_count.' Agregado. \n';    
             
             if($counter == $data_count){
                echo "<br> ----------------------- FINISH -------------------------------";
             }

        }
        else
        {
            // Error
            $errors = $response['errors'];
            // Do something with errors, show them to user
        }
}


?>  