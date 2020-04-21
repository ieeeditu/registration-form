<?php

	require_once $_SERVER['DOCUMENT_ROOT'].'/forms/assets/lib/includeall.php';
	define('FORM_PATH_R','forms/form-template');
	define('FORM_ASSETS',DOMAIN_NAME.'/'.FORM_PATH_R.'/assets');
	/**
	 * Event Tablename in database
	 */
	define('TABLE', 'id19ce');

	/**
	 * Event Name. Will displayed in title bar, payment reciept
	 */
	define('NAME', 'Circuit Engima\'19');

	/**
	 * Event Start Date
	 */
	define('EVENT_START_DATE', '20/05/20');

	/**
	 * Event End Date. Leave empty for a single day event
	 */
	define('EVENT_END_DATE', '');

	/**
	 * Total number of registration allowed
	 */
	define('TOTAL_REG',90);

?>