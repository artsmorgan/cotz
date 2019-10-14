<?php 
include ('classes/ApiRestHelper.php');

$helper = new ApiRestHelper();
$authenticationData = $helper->login('super','super');

//Add code to check if user is logged successfully

$headers = array(
    'Accept: application/json',
    'ZURMO_SESSION_ID: ' . $authenticationData['sessionId'],
    'ZURMO_TOKEN: ' . $authenticationData['token'],
    'ZURMO_API_REQUEST_TYPE: REST',
);
$data = Array
(
    'firstName' => 'Michael',
    'lastName' => 'Smith',
    'jobTitle' => 'President',
    'department' => 'Sales',
    'officePhone' => '653-235-7824',
    'mobilePhone' => '653-235-7821',
    'officeFax' => '653-235-7834',
    'description' => 'Some desc.',
    'companyName' => 'Michael Co',
    'website' => 'http://sample.com',
    'industry' => Array
        (
            'value' => 'Financial Services'
        ),

    'source' => Array
        (
            'value' => 'Outbound'
        ),

    'title' => Array
        (
            'value' => 'Dr.'
        ),

    'state' => Array
        (
            'id' => 5
        ),

    'account' => Array
        (
            'id' => 1
        ),

    'primaryEmail' => Array
        (
            'emailAddress' => 'a@example.com',
            'optOut' => 1,
        ),

    'secondaryEmail' => Array
        (
            'emailAddress' => 'b@example.com',
            'optOut' => 0,
            'isInvalid' => 1,
        ),

    'primaryAddress' => Array
        (
            'street1' => '129 Noodle Boulevard',
            'street2' => 'Apartment 6000A',
            'city' => 'Noodleville',
            'postalCode' => '23453',
            'country' => 'The Good Old US of A',
        ),

    'secondaryAddress' => Array
        (
            'street1' => '25 de Agosto 2543',
            'street2' => 'Local 3',
            'city' => 'Ciudad de Los Fideos',
            'postalCode' => '5123-4',
            'country' => 'Latinoland',
        ),
);
$data['modelRelations'] = array(
    'opportunities' => array(
        array(
            'action' => 'add',
            'modelId' => 3
        ),
    ),
);

$response = $helper->createApiCall($helper->contact_create_url, 'POST', $headers, array('data' => $data));
$response = json_decode($response, true);

if ($response['status'] == 'SUCCESS')
{
    $contact = $response['data'];
    //Do something with contact data
}
else
{
    // Error
    $errors = $response['errors'];
    // Do something with errors, show them to user
}

?>  