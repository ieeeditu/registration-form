<?php

	require_once $_SERVER['DOCUMENT_ROOT'].'/forms/assets/lib/includeall.php';
	define('FORM_PATH_R','forms/form-template');//may change if folder's(form-template) name is changed
	define('FORM_LINK',DOMAIN_NAME.'/'.FORM_PATH_R);
	define('FORM_ASSETS',FORM_LINK.'/assets');
	/**
	 * Event Tablename in database
	 */
	define('TABLE', '');

	/**
	 * Event Name. Will displayed in title bar, payment reciept
	 */
	define('NAME', '');

	/**
	 * Event Start Date
	 */
	define('EVENT_START_DATE', '');

	/**
	 * Event End Date. Leave empty for a single day event
	 */
	define('EVENT_END_DATE', '');

	/**
	 * Total number of registration allowed
	 */
	define('TOTAL_REG',);//enter in number

?>