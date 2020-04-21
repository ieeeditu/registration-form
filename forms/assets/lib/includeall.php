<!-- 
    Module to import configuration file annd all libraries
-->
<?php
    /**
     * Import Config according to envirnoment
     */
    require_once 'config.php';
    
    require_once 'database/dbconnect.php';

    require_once 'custom/importall.php';
    
    require_once 'PHPMailer/src/Exception.php';
    require_once 'PHPMailer/src/PHPMailer.php';
    require_once 'PHPMailer/src/SMTP.php';
    
    require_once 'payment/Instamojo.php';
?>