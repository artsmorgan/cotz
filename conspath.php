<?php
error_reporting(E_ALL & ~E_STRICT & ~E_DEPRECATED);
if(!defined('AS_PATH')){
    define('AS_PATH',dirname(__FILE__));
}
if(!defined('PATH')){
    define('PATH', $_SERVER['SERVER_NAME']);
}


// $API_URL = $_SERVER['SERVER_NAME'];


function print_all($arr, $dump = false){
	echo '<pre>';
	if($dump)
		var_dump($arr);
	else
		print_r($arr);
	echo '</pre>';
}

?>