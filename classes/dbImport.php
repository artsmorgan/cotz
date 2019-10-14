<?php
include_once(AS_PATH.'/adodb/adodb.inc.php');
include_once (AS_PATH.'/classes/dbConfig.php');

/**
 * Description of dbItem
 *
 * @author oswald
 * @modified by Alex
 */
class dbImport {
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
        $this->_adoconn->SetFetchMode(ADODB_FETCH_ASSOC);
    }

    function closeConnection() {
        try {
            $this->_adoconn->Close();
        }catch(Exception $e) {
        }
    }

    static public function getInstancia() {
        if (self::$instancia == NULL) {
            self::$instancia = new dbImport ();
        }
        return self::$instancia;
    }

   
    protected function getQryYMDFormat($date) {
        // order is month day year
        list($m, $d, $y) = explode('/', $date);
        return trim($y) . "-" . trim($m) . "-" . trim($d);
    }

    public function insertEmail($email){
        $id = 0;
        // var_dump($this->_adoconn);die();
        try {
            $sql ='insert into email(emailaddress) values ("'.$email.'"); SELECT LAST_INSERT_ID()';
            // echo $sql;
            $this->getConnection();           
           
            $this->_adoconn->Execute($sql);
            $id =  $this->_adoconn->Insert_ID();

            return $id;
         }catch(Exception $e ){
            print_r($e);
            $this->closeConnection();
        }

        return $id;    
    }

     public function insertAddressBlank(){
        $id = 0;
        // var_dump($this->_adoconn);die();
        try {
            $sql ='insert into address(city,country,postalcode,street1,street2,state) values ("","","","","",""); SELECT LAST_INSERT_ID()';
            // echo $sql;
            $this->getConnection();           
           
            $this->_adoconn->Execute($sql);
            $id =  $this->_adoconn->Insert_ID();

            return $id;
         }catch(Exception $e ){
            print_r($e);
            $this->closeConnection();
        }

        return $id;    
    }

    public function insertCustomField(){
        $id = 0;
        // var_dump($this->_adoconn);die();
        try {
            $sql ='insert into customfield(value) values (""); SELECT LAST_INSERT_ID()';
            // echo $sql;
            $this->getConnection();                      
            $this->_adoconn->Execute($sql);
            $id =  $this->_adoconn->Insert_ID();
            $this->closeConnection();

            $this->getConnection(); 
            $update = 'update customfield set basecustomfield_id = ' . $id .' where id = ' .$id;
            $this->_adoconn->Execute($update);

            return $id;
         }catch(Exception $e ){
            print_r($e);
            $this->closeConnection();
        }

        return $id;    
    }


    public function insertOwner($ownerId){
        $id = 0;
        // var_dump($this->_adoconn);die();
        try {

            $select ='select id from _user where export_id = ?';
            // $sql ='insert into customfield(value) values (""); SELECT LAST_INSERT_ID()';
            // echo $sql;
            $this->getConnection();                      
            $rs = $this->_adoconn->Execute($select,$ownerId);
            // $id =  $this->_adoconn->Insert_ID();
            // $this->closeConnection();
             $result = $rs->getRows();

             $userid = $result[0]['id'];
             
            $sql ='insert into ownedsecurableitem(owner__user_id) values ("'.$userid.'"); SELECT LAST_INSERT_ID()';
            // echo $sql;
            $this->getConnection();                      
            $this->_adoconn->Execute($sql);
            $id =  $this->_adoconn->Insert_ID();
            $this->closeConnection();

            $this->getConnection(); 
            $update = 'update ownedsecurableitem set securableitem_id = ' . $id .' where id = ' .$id;
            $this->_adoconn->Execute($update);
            return $id;
         }catch(Exception $e ){
            print_r($e);
            $this->closeConnection();
        }

        return $id;    
    }

    public function insertPerson($firstname,$lastname, $mobilephone, $officephone, $ownedsecurableitem,
                                 $primaryaddress_address_id , $primaryemail_email_id, $title_customfield_id){
        
        $id = 0;
        try {

            
            $sql ='insert INTO person
                    (department,firstname,jobtitle,
                    lastname,mobilephone,officephone,
                    officefax,ownedsecurableitem_id,
                    primaryaddress_address_id,
                    primaryemail_email_id,
                    title_customfield_id)
                    VALUES ("","'.$firstname.'","","'.$lastname.'","'.$mobilephone.'","'.$officephone.'",
                    "",'.$ownedsecurableitem.','.$primaryaddress_address_id.','.$primaryemail_email_id.','.$title_customfield_id.') ; SELECT LAST_INSERT_ID();';
            // echo $sql;
            $this->getConnection();                      
            $this->_adoconn->Execute($sql);
            $id =  $this->_adoconn->Insert_ID();
            return $id;
         }catch(Exception $e ){
            print_r($e);
            $this->closeConnection();
        }

        return $id;    
    }
    

    public function insertContacto($companyname,$person_id, $secondaryaddress_address_id,$secondaryemail_email_id ){
        
        $id = 0;
        try {

            
            $sql ='insert INTO contact (companyname, description, latestactivitydatetime, website, googlewebtrackingid, person_id, account_id, industry_customfield_id, secondaryaddress_address_id, secondaryemail_email_id, source_customfield_id, state_contactstate_id, cedulacstm, codigocstm, provinciacstm, cantoncstm, distritocstm, postalcstm, telefono_seccstm, extcstm, paiscstm, propietariocstm) VALUES ("'.$companyname.'" , "", "", "", "", "'.$person_id.'","","63","'
                .$secondaryaddress_address_id.'","'.$secondaryemail_email_id.'", "43","4", "", "","","","","","","","", "" ) ; 
                SELECT LAST_INSERT_ID();';
            echo $sql;
            $this->getConnection();                      
            $this->_adoconn->Execute($sql);
            $id =  $this->_adoconn->Insert_ID();
            return $id;
         }catch(Exception $e ){
            print_r($e);
            $this->closeConnection();
        }

        return $id;    
    }
    
    
    

}
?>
