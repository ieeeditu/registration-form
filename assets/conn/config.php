<?php 
	date_default_timezone_set('Asia/calcutta');
	$path=$_SERVER['DOCUMENT_ROOT'];
	$docRootPath =$_SERVER["DOCUMENT_ROOT"];
	$ServerHost = $_SERVER['HTTP_HOST'];

	if($ServerHost=='www.ieeeditu.org'||$ServerHost=='ieeeditu.org'||$ServerHost=='ieeeditu.azurewebsites.net')
	{	
		$DomainName = "https://".$ServerHost;
		define("PATH","forms/"); // change in reg.js
		include_once("srvdb.php");
		include_once("payment/credS.php");
		define('DEBUG', false);
	}
	else
	{	
		$DomainName = "http://".$_SERVER['HTTP_HOST'];
		define("PATH","");
		include_once("lcldb.php");
		include_once("payment/credL.php");
		define('DEBUG', true);
	}



	if(DEBUG == true)
	{
	    ini_set('display_errors', 'On');
	    error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		error_reporting(E_ALL);
	}
	else
	{
	    ini_set('display_errors', 'Off');
	    error_reporting(0);
	}

	define("VOL", "volunteer");
?>