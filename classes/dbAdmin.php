<?php
include_once(AS_PATH.'/adodb/adodb.inc.php');
include_once (AS_PATH.'/classes/dbConfig.php');

/**
 * Description of dbItem
 *
 * @author oswald
 * @modified by Alex
 */
class dbAdmin {
    private $_adoconn;
    static private $instancia = NULL;
    
    
    function __construct() {
        date_default_timezone_set("America/Costa_Rica");
    }

    function getConnection() {
        $this->_adoconn = ADONewConnection(dbConfig::$db_driver);
        $this->_adoconn->PConnect(dbConfig::$db_conn_server,
                dbConfig::$db_conn_user,dbConfig::$db_conn_pass,
                dbConfig::$db_conn_database);
    }

    function closeConnection() {
        try {
            $this->_adoconn->Close();
        }catch(Exception $e) {
        }
    }

    static public function getInstancia() {
        if (self::$instancia == NULL) {
            self::$instancia = new dbAdmin ();
        }
        return self::$instancia;
    }

   
    protected function getQryYMDFormat($date) {
        // order is month day year
        list($m, $d, $y) = explode('/', $date);
        return trim($y) . "-" . trim($m) . "-" . trim($d);
    }

    public function getAllFromUser($username){
        // var_dump($this->_adoconn);die();
        try {
            $sql ='select * from _user';
            $this->getConnection();
            $rs = $this->_adoconn->Execute($sql);
           
            $this->_adoconn->SetFetchMode(ADODB_FETCH_ASSOC);
            $result = $rs->getRows();
         }catch(Exception $e ){
            $this->closeConnection();
        }

        return $result;    
    }
   

    public function doLogin($uid,$password){
        $_params=null;
        $result=null;

        $pw =  md5($password);
        // echo $pw.' ////';
        try {
            $sql ='select count(*) as count from user where username = "'.$uid.'" and password = "'.$pw.'"';
            $rs = null;
            $this->getConnection();
            
            // print_r($sql);die();
            $this->_adoconn->SetFetchMode(ADODB_FETCH_ASSOC);
            $rs = $this->_adoconn->Execute($sql);
                        
            $result = $rs->getRows();

            if($result[0]['count']>0){
                $token = $this->generateToken();
                //insert the token
                $sql ='update user set token = "'.$token.'" where username = "'.$uid.'" and password = "'.$pw.'"';
                $this->_adoconn->Execute($sql);
            }

            $sql ='select * from user where username = "'.$uid.'" and password = "'.$pw.'"';
            $rs = $this->_adoconn->Execute($sql);
            $result = $rs->getRows();
            // print_r($result);die();

            $this->closeConnection();

        }catch(Exception $e ){
            $this->closeConnection();
        }

        return $result[0];
    }


    private function generateToken(){
        $length = 20;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return md5($randomString);
    }

    

}
?>
