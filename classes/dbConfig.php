<?php

/**
 * Description of dbConfig
 *
 * @author Alex Morgan
 */
class dbConfig {

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

    $dbAccess['prod']['username'] = 'root';
    $dbAccess['prod']['password'] = 'rootatlocalhost';

    $dbAccess['stage']['username'] = 'zurmouser';
    $dbAccess['stage']['password'] = 'kalika@123';

    $dbAccess['local']['username'] = 'root';
    $dbAccess['local']['password'] = 'rootatlocalhost';
    
    public static $db_conn_server = "localhost";
    public static $db_conn_user = $dbAccess[$env]['username'];
    public static $db_conn_pass = $dbAccess[$env]['password'];
    public static $db_conn_database = "new_ts_4";
    public static $db_driver = 'mysqli';

}
?>
