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
            self::$instancia = new dbAdmin ();
        }
        return self::$instancia;
    }

   
    protected function getQryYMDFormat($date) {
        // order is month day year
        list($m, $d, $y) = explode('/', $date);
        return trim($y) . "-" . trim($m) . "-" . trim($d);
    }

    public function getAllFromUser(){
        // var_dump($this->_adoconn);die();
        try {
            $sql ='SELECT u.username, u.role_id, p.* FROM _user u inner join person p where u.person_id = p.id;';
            $this->getConnection();
            $rs = $this->_adoconn->Execute($sql);
           
            $result = $rs->getRows();
         }catch(Exception $e ){
            $this->closeConnection();
        }

        return $result;    
    }
    
    public function getAllFromUserByUsername($username){
        // var_dump($this->_adoconn);die();
        try {
            $sql ='SELECT u.username, u.role_id, p.* FROM _user u inner join person p where u.person_id = p.id and u.username = ?';
            $this->getConnection();
            $rs = $this->_adoconn->Execute($sql, $username);
           
            
            $result = $rs->getRows();
         }catch(Exception $e ){
            $this->closeConnection();
        }

        return $result;    
    }

    public function getAllFromPersonById($id){
        try {
            $sql ='SELECT concat(p.firstname, " ", p.lastname ) as completename, p.jobtitle, 
            p.mobilephone, p.officephone, p.officefax, e.emailaddress
            FROM person p inner join email e on p.primaryaddress_address_id = e.id where p.id = ?';
            $this->getConnection();
            $rs = $this->_adoconn->Execute($sql, $id);
           
            
            $result = $rs->fetchRow();
         }catch(Exception $e ){
            $this->closeConnection();
        }

        return $result;    
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

    public function getInfoFromCompanyById($id){
        try {
            $sql ='SELECT a.name, a.officephone, a.officefax, a.cedula_juridcstm FROM account a where a.id = ?';
            $this->getConnection();
            $rs = $this->_adoconn->Execute($sql, $id);
           
            
            $result = $rs->fetchRow();
         }catch(Exception $e ){
            $this->closeConnection();
        }

        return $result;  
    }


    public function getCompanyList($term) {

            $sql ='SELECT id,description, name, officephone, website FROM account where name LIKE "'.$term.'%";';

            // echo $sql;

            $this->getConnection();
            $rs = $this->_adoconn->Execute($sql);
           
            
            $result = $rs->getRows();

            return $result;
       
    }


    public function getCompanyContactsByCompany($id) {

            $result = 0;

            $sql ='SELECT count(*) as count FROM accountcontactaffiliation where accountaffiliation_account_id =?;';

            $this->getConnection();
            $rs = $this->_adoconn->Execute($sql, $id);
            
            $result = $rs->getRows();
            $this->closeConnection();

           

            if($result[0]['count']>=0){

                $userSql = "SELECT ac.id as ac_id , c.companyname, e.emailaddress as email,
                            p.firstname, p.lastname, p.jobtitle, p.mobilephone, p.officephone
                            FROM accountcontactaffiliation ac 
                            inner join contact c on ac.contactaffiliation_contact_id = c.id
                            inner join person p on c.person_id = p.id
                            inner join email e on p.primaryemail_email_id = e.id
                            where ac.accountaffiliation_account_id = ?;";
                $this->getConnection();
                $rs = $this->_adoconn->Execute($userSql, $id);     
                $result = $rs->getRows();

                 return $result;


            }


            return $result;
       
    }

    public function updateContactExternalData($ownerId, $externalId, $companyId, $userId) {

           // echo $ownerId + ' | ownerId <br>';
           // echo $accountId + ' | accountId <br>';

            $sql ='update contact set 
                            external_owner_id = "'.$ownerId.'"
                            , external_id="'.$externalId.'"
                            , external_company_id="'.$companyId.'"
                             where id = '.$userId.';';

            

            //echo $sql; die();
             $this->getConnection();
            $rs = $this->_adoconn->Execute($sql);
            $this->closeConnection();


            return true;
       
    }

    public function updateAccountUserOwner($ownerId, $externalId, $accountId) {

           // echo $ownerId + ' | ownerId <br>';
           // echo $accountId + ' | accountId <br>';

            $sql ='update account set external_owner_id = "'.$ownerId.'", external_id="'.$externalId.'" where id = '.$accountId.';';

            

            //echo $sql; die();
             $this->getConnection();
            $rs = $this->_adoconn->Execute($sql);
            $this->closeConnection();


            return true;
       
    }


    public function updateContactUserOwner($ownerId, $externalId, $accountId) {

           // echo $ownerId + ' | ownerId <br>';
           // echo $accountId + ' | accountId <br>';

            $sql ='update account set external_owner_id = "'.$ownerId.'", external_id="'.$externalId.'" where id = '.$accountId.';';

            

            //echo $sql; die();
             $this->getConnection();
            $rs = $this->_adoconn->Execute($sql);
            $this->closeConnection();


            return true;
       
    }

    public function getCompanyIds() {

            $result = 0;

            $sql ='select a.id as a_id, a.external_owner_id, a.ownedsecurableitem_id, u.username, u.id as u_id 
                    from account a inner join _user u on a.external_owner_id = u.external_id;';

            $this->getConnection();
            $rs = $this->_adoconn->Execute($sql);
            
            $result = $rs->getRows();
            $this->closeConnection();
                    
            return $result;
       
    }


    public function getContactIds() {

            $result = 0;

            $sql ='select c.id as contact, c.person_id,c.external_owner_id,  p.ownedsecurableitem_id , u.id as u_id
                    from contact c 
                    inner join person p on c.person_id = p.id
                    inner join _user u on c.external_owner_id = u.external_id;';

            $this->getConnection();
            $rs = $this->_adoconn->Execute($sql);
            
            $result = $rs->getRows();
            $this->closeConnection();
                    
            return $result;
       
    }

    public function getAccountExternalId(){
        $result = 0;
        $sql = 'select a.id as account_id, a.external_id as account_external_id, c.id as contact_id
                from account a inner join contact c on c.external_company_id = a.external_id;';

        $this->getConnection();
        $rs = $this->_adoconn->Execute($sql);
        
        $result = $rs->getRows();
        $this->closeConnection();
                
        return $result;        
    }


    public function updateCompanyOwnerById($ownerId, $securableId) {

            $result = 0;

            $sql ='update ownedsecurableitem SET owner__user_id='.$ownerId.' WHERE id= '. $securableId;

            $this->getConnection();
            $rs = $this->_adoconn->Execute($sql);
            $this->closeConnection();


            return true;
       
    }

    public function createCompanyOwnerRelation($companyID, $userID) {

            $result = 0;

            $sql ='update contact set account_id = '.$companyID.' where id = '.$userID.';
                    INSERT INTO accountcontactaffiliation (`primary`,`item_id`,`role_customfield_id`,`accountaffiliation_account_id`,`contactaffiliation_contact_id`) VALUES(1,21008,null,'.$companyID.','.$userID.');';

            $this->getConnection();
            $rs = $this->_adoconn->Execute($sql);
            $this->closeConnection();


            return true;
       
    }
    

    public function getContactsByAccount($acount_id){
        $result = 0;
        $sql = 'select c.id, p.firstname, p.lastname, p.officephone, p.officefax, e.emailaddress
                from contact c
                inner join person p on c.person_id = p.id
                inner join email e on p.primaryemail_email_id = e.id
                where c.account_id = '.$acount_id.';';

        $this->getConnection();
        $rs = $this->_adoconn->Execute($sql);
        
        $result = $rs->getRows();
        $this->closeConnection();
                
        return $result;        
    }



    public function insertHeader($vendedor_id,$fecha_cotizacion,$fecha_vencimiento,$tasa_impuestos,$moneda,$factor_redondeo,
                                $no_solicitud,$no_cotizacion,$account_id,$contact_id,$tiempo_entrega,$lugar_entrega,
                                $forma_pago,$marca,$fase,$notas,$notas_crm,$subtotal,$descuento,$impuesto,$total,$tasa_cambio){
        $sql = 'insert INTO `cotz_header`
                (`vendedor_id`,`fecha_cotizacion`,`fecha_vencimiento`,`tasa_impuestos`,`moneda`,
                `factor_redondeo`,`no_solicitud`,`no_cotizacion`,`account_id`,`contact_id`,`tiempo_entrega`,
                `lugar_entrega`,`forma_pago`,`marca`,`fase`,`notas`,`notas_crm`,`fecha_creacion`,
                `fecha_modificacion`,`modificado_por`,`subtotal`,`descuento`,`impuesto`,`total`, `tasa_cambio`)
                VALUES("'.$vendedor_id.'","'.$fecha_cotizacion.'","'.$fecha_vencimiento.'",
                "'.$tasa_impuestos.'","'.$moneda.'","'.$factor_redondeo.'","'.$no_solicitud.'",
                "'.$no_cotizacion.'","'.$account_id.'","'.$contact_id.'","'.$tiempo_entrega.'",
                "'.$lugar_entrega.'","'.$forma_pago.'","'.$marca.'","'.$fase.'","'.$notas.'",
                "'.$notas_crm.'",now(),"","","'.$subtotal.'","'.$descuento.'","'.$impuesto.'","'.$total.'","'.$tasa_cambio.'");';
                // echo $sql;die();
                // $sql = 'select 1 as test';
        $this->getConnection();
        $rs = $this->_adoconn->Execute($sql);   
        $id = $this->_adoconn->Insert_ID();
        $this->closeConnection();
       

        return $id;        


    }


    public function insertHeaderImport
    (   $vendedor_id,$fecha_cotizacion,$fecha_vencimiento,$tasa_impuestos,$moneda,$factor_redondeo,
        $no_solicitud,$no_cotizacion,$account_id,$contact_id,$tiempo_entrega,$lugar_entrega,
        $forma_pago,$marca,$fase,$notas,$notas_crm,$subtotal,$descuento,$impuesto,$total,$tasa_cambio, $externalID,
        $externalContact, $externalAccount, $externalCreateId, $version){

        $sql = 'insert INTO `cotz_header`
                (`vendedor_id`,`fecha_cotizacion`,`fecha_vencimiento`,`tasa_impuestos`,`moneda`,
                `factor_redondeo`,`no_solicitud`,`no_cotizacion`,`account_id`,`contact_id`,`tiempo_entrega`,
                `lugar_entrega`,`forma_pago`,`marca`,`fase`,`notas`,`notas_crm`,`fecha_creacion`,
                `fecha_modificacion`,`modificado_por`,`subtotal`,`descuento`,`impuesto`,`total`, `tasa_cambio`, `external_cot_id`, `external_contact`, `external_account`, `external_create_id`, `version`)
                VALUES("'.$vendedor_id.'",now(),"'.$fecha_vencimiento.'",
                "'.$tasa_impuestos.'","'.$moneda.'","'.$factor_redondeo.'","'.$no_solicitud.'",
                "'.$no_cotizacion.'","'.$account_id.'","'.$contact_id.'","'.$tiempo_entrega.'",
                "'.$lugar_entrega.'","'.$forma_pago.'","'.$marca.'","'.$fase.'","'.$notas.'",
                "'.$notas_crm.'",now(),"","","'.$subtotal.'","'.$descuento.'","'.$impuesto.'","'.$total.'","'.$tasa_cambio.'","'.$externalID.'","'.$externalContact.'","'.$externalAccount.'","'.$externalCreateId.'","'.$version.'");';
                // echo $sql;die();
                // $sql = 'select 1 as test';

             $this->getConnection();
                    $rs = $this->_adoconn->Execute($sql);   
                    $id = $this->_adoconn->Insert_ID();
                    $this->closeConnection();
                   

                    return $id;        


    }


    public function updateHeader($vendedor_id,$fecha_cotizacion,$fecha_vencimiento,$tasa_impuestos,$moneda,$factor_redondeo,
                                $no_solicitud,$no_cotizacion,$account_id,$contact_id,$tiempo_entrega,$lugar_entrega,
                                $forma_pago,$marca,$fase,$notas,$notas_crm,$subtotal,$descuento,$impuesto,$total,$tasa_cambio, $id){
        $sql = 'update `cotz_header`
                SET
                `vendedor_id` = "'.$vendedor_id.'",
                `fecha_cotizacion` = "'.$fecha_cotizacion.'",
                `fecha_vencimiento` = "'.$fecha_vencimiento.'",
                `tasa_impuestos` = "'.$tasa_impuestos.'",
                `moneda` = "'.$moneda.'",
                `factor_redondeo` = "'.$factor_redondeo.'",
                `no_solicitud` = "'.$no_solicitud.'",
                `no_cotizacion` = "'.$no_cotizacion.'",
                `account_id` = "'.$account_id.'",
                `contact_id` = "'.$contact_id.'",
                `tiempo_entrega` = "'.$tiempo_entrega.'",
                `lugar_entrega` = "'.$lugar_entrega.'",
                `forma_pago` = "'.$forma_pago.'",
                `marca` = "'.$marca.'",
                `fase` = "'.$fase.'",
                `notas` = "'.$notas.'",
                `notas_crm` = "'.$notas_crm.'",
                `fecha_modificacion` = now(),
                `modificado_por` = "'.$vendedor_id.'",
                `subtotal` = "'.$subtotal.'",
                `descuento` = "'.$descuento.'",
                `impuesto` = "'.$impuesto.'",
                `total` = "'.$total.'",
                `tasa_cambio` = "'.$tasa_cambio.'"
                WHERE `id` ='.$id;
                // echo $sql;die();
                // $sql = 'select 1 as test';
        $this->getConnection();
        $rs = $this->_adoconn->Execute($sql); 
        $this->closeConnection();
       

        return true;        


    }

    public function deleteRows($id){
        $sql = 'delete from cotz_detail
                WHERE `id_header` ='.$id;
                // echo $sql;die();
                // $sql = 'select 1 as test';

        $this->getConnection();
        $rs = $this->_adoconn->Execute($sql);   
        $id = $this->_adoconn->Insert_ID();
        $this->closeConnection();

        return true;        



    }

    public function insertRow($id_header, $codigo_articulo,$nombre_articulo,$descripcion,$cantidad,$unidad_medida,$precio,$descuento_porcentaje,$monto){
        
        $sql = 'insert INTO `cotz_detail` (`id_header`,`codigo_articulo`,`nombre_articulo`,`descripcion`,
                            `cantidad`,`unidad_medida`,`precio`,`descuento_porcentaje`,`monto`)  VALUES
                            ("'.$id_header.'","'.$codigo_articulo.'","'.$nombre_articulo.'","'.$descripcion.'",
                            "'.$cantidad.'","'.$unidad_medida.'","'.$precio.'","'.$descuento_porcentaje.'","'.$monto.'");';
                // echo $sql;die();
                // $sql = 'select 1 as test';
        $this->getConnection();
        $rs = $this->_adoconn->Execute($sql);   
        $id = $this->_adoconn->Insert_ID();
        $this->closeConnection();
       

        return $id;        


    }


    public function insertRowImport($id_header, $codigo_articulo,$nombre_articulo,$descripcion,$cantidad,$unidad_medida,$precio,$descuento_porcentaje,$monto, $externalId){
        
        $sql = 'insert INTO `cotz_detail` (`id_header`,`codigo_articulo`,`nombre_articulo`,`descripcion`,
                            `cantidad`,`unidad_medida`,`precio`,`descuento_porcentaje`,`monto`,`header_external`,`version`)  VALUES
                            ("'.$id_header.'","'.$codigo_articulo.'","'.$nombre_articulo.'","'.$descripcion.'",
                            "'.$cantidad.'","'.$unidad_medida.'","'.$precio.'","'.$descuento_porcentaje.'","'.$monto.'"
                            ,"'.$externalId.'","zoho");';
                // echo $sql;die();
                // $sql = 'select 1 as test';
        $this->getConnection();
        $rs = $this->_adoconn->Execute($sql);   
        $id = $this->_adoconn->Insert_ID();
        $this->closeConnection();
       

        return $id;        


    }


    public function getCotizacionById($id) {

            $result = 0;

            $sql ='select cot.*, acc.name as account_name, concat(contactp.firstname, " ", contactp.lastname ) as contact_name, 
                          concat( salesp.firstname, " ", salesp.lastname ) as vendedor_nombre 
                          from `cotz_header` as cot 
                          inner join `account` as acc on cot.account_id = acc.id 
                          inner join `contact` as con on cot.contact_id = con.id 
                          inner join `person` as contactp on con.person_id = contactp.id 
                          left join `person` as salesp on cot.vendedor_id = salesp.id where cot.id = ?;';

            $this->getConnection();
            $rs = $this->_adoconn->Execute($sql, $id);
            
            $result = $rs->getRows();
            $this->closeConnection();

    
            $userSql = "select * from cotz_detail where id_header = ?;";
            $this->getConnection();
            $rs = $this->_adoconn->Execute($userSql, $id);     
            $lines = $rs->getRows();

            $result['lines'] = $lines;
            

            return $result;
       
    }


     public function getCotizacionHeaderByCustomerId($id) {

            $result = 0;

            $sql ='select c.*, u.username, p.firstname, p.lastname, a.name from cotz_header c 
                    inner join _user u on c.vendedor_id = u.id
                    inner join account a on c.account_id = a.id
                    inner join contact co on c.contact_id = co.id
                    inner join person p on   co.person_id = p.id
                    where c.id = ?;';

            $this->getConnection();
            $rs = $this->_adoconn->Execute($sql, $id);
            
            $result = $rs->getRows();
            $this->closeConnection();


            return $result;
       
    }

    public function getCotizacionHeaderByCustomerAll() {

            $result = 0;

            $sql ='select c.*, u.username, p.firstname, p.lastname, a.name from cotz_header c 
                    inner join _user u on c.vendedor_id = u.id
                    inner join account a on c.account_id = a.id
                    inner join contact co on c.contact_id = co.id
                    inner join person p on   co.person_id = p.id;';

            $this->getConnection();
            $rs = $this->_adoconn->Execute($sql);
            
            $result = $rs->getRows();
            $this->closeConnection();


            return $result;
       
    }


    public function getCotizacionHeaderByCustomerAllMIN() {

            $result = 0;

            $sql ='select c.id, c.marca, c.fase, c.total, c.fecha_cotizacion, 
                    u.username, p.firstname, p.lastname, a.name from cotz_header c 
                    inner join _user u on c.vendedor_id = u.id
                    inner join account a on c.account_id = a.id
                    inner join contact co on c.contact_id = co.id
                    inner join person p on   co.person_id = p.id;';

            $this->getConnection();
            $rs = $this->_adoconn->Execute($sql);
            
            $result = $rs->getRows();
            $this->closeConnection();


            return $result;
       
    }

    public function getCotzHeaderWithExternalRelationship(){
        $result;


        $sql = "select cot.id as cotz_id, a.id as acount_id, c.id as contact_id, u.id as user_id
                 from cotz_header cot
                inner join account a on cot.external_account = a.external_id
                inner join contact c on cot.external_contact = c.external_id
                inner join _user u on cot.external_create_id = u.external_id;";

        $this->getConnection();
            $rs = $this->_adoconn->Execute($sql);
            
            $result = $rs->getRows();
            $this->closeConnection();


            return $result;        

    }


    public function updateCotzWithExternal($cotz_id, $vendedor_id, $account_id, $contact_id) {

            $result = 0;

            $sql ='update cotz_header set
                    vendedor_id = "'.$vendedor_id.'",
                    account_id = "'.$account_id.'",
                    contact_id = "'.$contact_id.'"
                    where id = '.$cotz_id.';';

            $this->getConnection();
            $rs = $this->_adoconn->Execute($sql);
            $this->closeConnection();


            return true;
       
    }

    public function getCotzDetailWithExternalRelationship(){
        $result;


        $sql = "select l.id, h.id as cotz_header_id FROM cotz_detail l
                inner join cotz_header h on l.header_external = h.external_cot_id;";

        $this->getConnection();
            $rs = $this->_adoconn->Execute($sql);
            
            $result = $rs->getRows();
            $this->closeConnection();


            return $result;        

    }


    public function updateCotzDetailWithExternal($id_header, $idRow) {

            $result = 0;

            $sql ='update cotz_detail set id_header = "'.$id_header.'" where id = '.$idRow;

            $this->getConnection();
            $rs = $this->_adoconn->Execute($sql);
            $this->closeConnection();


            return true;
       
    }


}
?>
