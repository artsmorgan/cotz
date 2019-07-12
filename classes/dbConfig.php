<?php

/**
 * Description of dbConfig
 *
 * @author Alex Morgan
 */
class dbConfig {

	$this->$env = 'local';
    $this->$svr = $_SERVER['SERVER_NAME'];

    $this->$localKnownHosts = array(
        'crm.local',
        'tecnosagot.crm.local'
    );
    $this->$stageKnownHosts = array(
        'zurmojames.com',
        'demo-ts.united-crm.com'
    );
    $this->$prodKnownHosts = array(
        'tecnosagot.united-crm.com'
    );
    if(in_array($this->$svr, $this->$localKnownHosts)){
        $this->$isLocal = true;
        $this->$env = 'local';
    }else if(in_array($this->$svr, $this->$stageKnownHosts)){
        $this->$isLocal = false;
        $this->$env = 'stage';
    }else if(in_array($this->$svr, $this->$prodKnownHosts)){
        $this->$isLocal = false;
        $this->$env = 'prod';
    }else{
        //Not known environmet
        die('not known environment');
    }

    define('ENV', $this->$env);


    $this->$hostInfo = 'http://'.$this->$svr;

    $this->$dbAccess['prod']['username'] = 'root';
    $this->$dbAccess['prod']['password'] = 'rootatlocalhost';

    $this->$dbAccess['stage']['username'] = 'zurmouser';
    $this->$dbAccess['stage']['password'] = 'kalika@123';

    $this->$dbAccess['local']['username'] = 'root';
    $this->$dbAccess['local']['password'] = 'rootatlocalhost';
    
    public static $db_conn_server = "localhost";
    public static $db_conn_user = $this->$dbAccess[$env]['username'];
    public static $db_conn_pass = $this->$dbAccess[$env]['password'];
    public static $db_conn_database = "new_ts_4";
    public static $db_driver = 'mysqli';

}
?>
