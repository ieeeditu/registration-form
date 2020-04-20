<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	require_once "../../assets/conn/config.php";
	require_once "../../assets/conn/dbconnect.php";
	require_once "../../assets/conn/function.php";
	require_once '../../assets/conn/PHPMailer/src/Exception.php';
	require_once '../../assets/conn/PHPMailer/src/PHPMailer.php';
	require_once '../../assets/conn/PHPMailer/src/SMTP.php';
	require_once "../../assets/conn/payment/Instamojo.php";

	define("TABLE", "");
	define("NAME", "");
	define("EVENT_START_DATE", "");
	define("EVENT_END_DATE", "");

	// Mail Configuration
	define('MAIL_HOST','')
	define('MAIL_USERNAME','')
	define('MAIL_PASSWORD','')
	define('MAIL_PORT',443)
?>