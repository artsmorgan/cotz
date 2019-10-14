<?php 

$db_params = array();
$db_params['host'] = 'localhost';
$db_params['user'] = 'root';
$db_params['pass'] = 'rootatlocalhost';
$db_params['db'] = 'new_ts_2';

$db = null;
$db = newAdoConnection('mysqli');
$db->connect($db_params["host"],$db_params["user"],$db_params["pass"],$db_params["db"]);
$db->SetFetchMode(ADODB_FETCH_ASSOC);

$db->debug = true;

function dbErrorFile($msg,$newline){
	$filename = "log_.".date("Ymd").".txt";
	$h = fopen($filename,"a+");
	fwrite($h, $msg);
	fwrite($h, "\n");
	fclose($h);
}
define("ADODB_OUTP",'dbErrorFile');
