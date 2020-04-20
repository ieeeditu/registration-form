<?php 
    require_once("assets/conn/common_config.php");

    /**
     * Check for the Request
     */
    if(!empty($_REQUEST)){

        /**
         * Retrieve the unique orderId corresponding to a registration from query parameters.
         */
        $id = $_REQUEST['ord'];

        /**
         * Query DB to get verification data corresponding to orderId
         */
        $sql ="SELECT otp,txn FROM ".TABLE." WHERE id = '".$id."'";       
        $details = $conn->query($sql);

        /**
         * Checking Result of Query. If number data row returned is 1 then proceed further else redirect user to registration form as no data corresponding to orderId exist on the DB
         */
        if ($details->num_rows == 1){ 

            while ($row=mysqli_fetch_array($details)) {
                $rows[] = array( 
                    'otp' => $row['otp'],                              
                    'txn'=>$row['txn']
                    );
            }

            /**
             * If txn (Transaction ID) is not empty that means payment corresponding to the given orderID has already been registered. Hence redirecting user to confirmation page.
             */
            if($rows[0]['txn']!=""){
                header('Location: '."result.php?ord=".$id);
            }
            /**
             * If request method is POST, than we need to verify otp entered by the user.
             */
            if(!empty($_POST)){
                /**
                 * Checking otp entered by the user. Once OTP has been verified, txn will store the volunteer id who accepeted the payment. If failed wrong OTP message is displayed to the user.
                 */
                if($_POST['otp']==$rows[0]['otp']){
                    $sql ="UPDATE ".TABLE." SET txn='".(int)($rows[0]['otp']/1000000)."' where id ='".$id."'";
                    if ($conn->query($sql)){
                        header('Location: '."result.php?ord=".$id);
                    }
                }else {
                    $msg="Wrong OTP please try again";
                }
            }
            /**
             * Reducing the value on each try.
             */
            $count;
            if($_POST['temp'])
                $count= $_POST['temp']-1;
            else
             $count=3;
            if($count==0)
                header('Location: '."result.php?ord=".$id);
        }else{ 
            header('Location: '."/");
        }
        $msg="";

        /**
         * Getting details of volunteer to displayed on the web page
         */
        $volID = (int)($rows[0]['otp']/1000000);
        $volName=getVolName($conn,$volID);
        $volPhn=getVolPhn($conn,$volID);
    }  
    else { 
        header('Location: '."/");
    }

    /**
     * Create a dynamic Title for the page. Used in header.php file.
     */
    $title ="-OTP Verification"; 

    /**
     * Include header template of HTML
     */
    include("header.php");
?>
 <button type="button" class="btn btn-info btn-lg" style="display: none;" id="btn-modal" data-toggle="modal" data-target="#myModal"></button>
<div class="container" style="margin-top: 1em; margin-bottom: 1em;">
    <form class="needs-validation" novalidate  method='post'>
        <div class="row">
            <div class="col-md-12" style="padding=0.5em;">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Enter OTP</h2>
                        <div class="form-group">
                            <input type="hidden" name="temp" value=<?php echo $count;?> >
                            <label for="email" class="col-form-label">Please enter the OTP. Contact <?php echo $volName.'( <a href="tel:'.$volPhn.'">'. $volPhn.'</a> )'; ?>  you selected. Make the payment to the volunteer, then he/she may provide you otp.</label>
                            <input type="number" pattern=".{6}" class="form-control" id="otp"  name="otp" required>
                            <div class="invalid-feedback">
                                Please provide a valid OTP
                            </div>
                        <div>
                        <?php echo $msg;?>
                    </div>
                </div>
            </div>
        </div>

        <div style="margin-top: 1em;">
            <button type="Submit" class="btn btn-primary btn-lg btn-block" id="reg" >Register</button>
        </div>
    </form>
    <hr>
</div>
<?php
	/**
    * Include footer template of HTML
    */
	include("footer.php"); 
?> 		
<script src="assets/js/reg.js"></script>
<script src="assets/js/validate.js"></script>