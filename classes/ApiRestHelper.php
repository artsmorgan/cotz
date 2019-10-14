<?php 
ini_set('max_execution_time', 5000000);
class ApiRestHelper
{
    
    function __construct() {
       $this->base_url = '';
       $this->login_url = 'http://crm.local/app/index.php/zurmo/api/login';
       $this->contact_create_url = 'http://crm.local/app/index.php/contacts/contact/api/create/';
       $this->account_create_url = 'http://crm.local/app/index.php/accounts/account/api/create/';

   }

    public function login($username, $password){
        $headers = array(
            'Accept: application/json',
            'ZURMO_AUTH_USERNAME: ' . $username,
            'ZURMO_AUTH_PASSWORD: ' . $password,
            'ZURMO_API_REQUEST_TYPE: REST',
        );



        $response = $this->createApiCall($this->login_url, 'POST', $headers);
        $response = json_decode($response, true);

        if ($response['status'] == 'SUCCESS')
        {
            return $response['data'];
        }
        else
        {
            return "false";
        }
    }


    public function contact_create_url(){        
        return  $this->contact_create_url;
    }

    public function account_create_url(){
        return  $this->account_create_url;
    }


    public  function createApiCall($url, $method, $headers, $data = array())
    {
        if ($method == 'PUT')
        {
            $headers[] = 'X-HTTP-Method-Override: PUT';
        }

        // echo '<pre>';
        // print_r(array($url, $method, $headers, $data));
        // echo '</pre>';


        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);

        switch($method)
        {
            case 'GET':
                break;
            case 'POST':
                curl_setopt($handle, CURLOPT_POST, true);
                curl_setopt($handle, CURLOPT_POSTFIELDS, http_build_query($data));
                break;
            case 'PUT':
                curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($handle, CURLOPT_POSTFIELDS, http_build_query($data));
                break;
            case 'DELETE':
                curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
        }
        $response = curl_exec($handle);
        return $response;
    }
}
?>