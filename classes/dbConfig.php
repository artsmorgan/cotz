<?php

/**
 * Description of dbConfig
 *
 * @author Alex Morgan
 */
class dbConfig {

	function __construct(){
		
			$isLocal = false;
		    $env = 'local';
		    $svr = $_SERVER['SERVER_NAME'];

		    $localKnownHosts = array(
		        'crm.local',
		        'tecnosagot.crm.local'
		    );
		    $stageKnownHosts = array(
		        'zurmojames.com',
		        'demo-ts.united-crm.com'
		    );
		    $prodKnownHosts = array(
		        'tecnosagot.united-crm.com'
		    );
		    if(in_array($svr, $localKnownHosts)){
		        $isLocal = true;
		        $env = 'local';
		    }else if(in_array($svr, $stageKnownHosts)){
		        $isLocal = false;
		        $env = 'stage';
		    }else if(in_array($svr, $prodKnownHosts)){
		        $isLocal = false;
		        $env = 'prod';
		    }else{
		        //Not known environmet
		        die('not known environment');
		    }

		    define('ENV', $env);


		    $hostInfo = 'http://'.$svr;

		    $this->$dbAccess['prod']['username'] = 'root';
		    $this->$dbAccess['prod']['password'] = 'rootatlocalhost';

		    $this->$dbAccess['stage']['username'] = 'zurmouser';
		    $this->$dbAccess['stage']['password'] = 'kalika@123';

		    $this->$dbAccess['local']['username'] = 'root';
		    $this->$dbAccess['local']['password'] = 'rootatlocalhost';
		}


    
    public static $db_conn_server = "localhost";
    public static $db_conn_user = $this->$dbAccess[$env]['username'];
    public static $db_conn_pass = $this->$dbAccess[$env]['password'];
    public static $db_conn_database = "new_ts_4";
    public static $db_driver = 'mysqli';

}
?>
