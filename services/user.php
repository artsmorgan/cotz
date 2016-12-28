<?php
	include_once ('../conspath.php');
	include_once (AS_PATH.'/classes/dbAdmin.php');

	$action = $_REQUEST['action'];



	switch ($action) {
		case 'login':
			
			$username = $_POST['username'];
			$password = $_POST['password'];
			//$login = new userLogin();
			// print_r(array($username, $password));

			$login = dbAdmin::getInstancia()->doLogin($username, $password);
			// print_r($login);
			if($login){	
				session_start();	
				$_SESSION['username'] = $login['username'];
				$_SESSION['token']= $login['token'];
				$_SESSION['login_time']	=  time();
		        echo '<script> window.location = "/dashboard.php" </script>';
		    }else{
		         echo '<script> window.location = "/index.php?r=0" </script>';
		    }    
			break;
		
		default:
			# code...
			break;
	}

?>