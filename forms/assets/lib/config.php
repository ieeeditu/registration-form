<!-- 
	This is a file which set's configuration according to the envirnoment
-->
<?php 
	
	date_default_timezone_set('Asia/calcutta');
	
	define('SERVER_HOST',$_SERVER['HTTP_HOST']);
	define('DOC_ROOT_PATH',$_SERVER['DOCUMENT_ROOT']);
	define('VOL', 'volunteer');

	/**
	 * Checking envirnoment for server or local
	 */
	if(SERVER_HOST=='www.ieeeditu.org.in'||SERVER_HOST=='ieeeditu.org.in'||SERVER_HOST=='ieeeditu.azurewebsites.net') {	
		define('DOMAIN_NAME', 'https://'.SERVER_HOST);
		define('ENV', 'server');
		define('DEBUG', false);
	} else {	
		define('DOMAIN_NAME', 'http://'.SERVER_HOST);
		define('ENV', 'local');
		define('DEBUG', true);
	}

	include_once('configurations/mail.php');
	include_once('configurations/'.ENV.'/db.php');
	include_once('configurations/'.ENV.'/instamojo.php');

	define('COMMON_ASSETS',DOMAIN_NAME.'/forms/assets');

	if(DEBUG == true) {
	    ini_set('display_errors', 'On');
	    error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		error_reporting(E_ALL);
	} else {
	    ini_set('display_errors', 'Off');
	    error_reporting(0);
	}

?>
