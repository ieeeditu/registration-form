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
		<link href="<?php echo $DomainName?>/forms/assets/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
		<link href="assets/css/style.css" rel="stylesheet" id="">
		<script src="<?php echo $DomainName?>/forms/assets/js/jquery.min.js"></script>
		<script src="<?php echo $DomainName?>/forms/assets/js/block.js"></script>
		<script src="<?php echo $DomainName?>/forms/assets/js/bootstrap.min.js"></script>
			
		<link rel="icon" href="IEEE-sign.ico" type="image/x-icon"/>
		<link rel="shortcut icon" href="IEEE-sign.ico" type="image/x-icon"/>
	</head>
	<body oncontextmenu="return false" >
		<nav class="navbar navbar-light bg-light">
            <a class="navbar-brand" href="<?php echo $DomainName?>" target="_blank">
            <img src="<?php echo $DomainName?>/forms/assets/img/logo.gif" height="80" class="d-inline-block align-top" alt="">
            </a>
			<!-- Append other organization logo incase of collabration -->
            <span class="navbar-text" id="">
             <a class="navbar-brand" href="#" target="_blank">
            <img src="#" height="80" class="d-inline-block align-top" alt="" >
            </a>               
            </span>
        </nav>