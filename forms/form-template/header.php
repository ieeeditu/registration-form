<!-- 
	HTML based header template that can be imported in all page.
	Also prefer to use footer.php template with this header.	
-->
<?php
	header("Pragma: no-cache");
	header("Cache-Control: no-cache");
	header("Expires: 0");
?>
<html lang="en">
	<head>
		<meta charset="utf-8">
	    <title><?php echo NAME.$title; ?></title>
	    <meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="<?php echo COMMON_ASSETS?>/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
		<link href="<?php echo FORM_ASSETS?>/css/style.css" rel="stylesheet" id="">
		<script src="<?php echo COMMON_ASSETS?>/js/jquery.min.js"></script>
		<script src="<?php echo COMMON_ASSETS?>/js/block.js"></script>
		<script src="<?php echo COMMON_ASSETS?>/js/bootstrap.min.js"></script>
			
		<link rel="icon" href="sign.ico" type="image/x-icon"/>
		<link rel="shortcut icon" href="sign.ico" type="image/x-icon"/>
	</head>
	<body oncontextmenu="return false" >
		<nav class="navbar navbar-light bg-light">
            <a class="navbar-brand" href="<?php echo DOMAIN_NAME?>" target="_blank">
            <img src="<?php echo COMMON_ASSETS?>/img/logo.gif" height="80" class="d-inline-block align-top" alt="">
            </a>
			<!-- Append other organization logo incase of collabration -->
            <span class="navbar-text" id="">
             <a class="navbar-brand" href="#" target="_blank">
            <img src="#" height="80" class="d-inline-block align-top" alt="" >
            </a>               
            </span>
        </nav>