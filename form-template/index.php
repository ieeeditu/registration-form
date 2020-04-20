<!-- 
	PHP Module/HTML Template which return a HTML page with a registration form and also accept the post request to the user registered.
-->
<?php
    
    require_once("assets/conn/common_config.php");

    /**
     * Get List of volunteers
     */
    $vol = getUserAll($conn);

    
    $details = $_POST;

    /**
     * Check HTTP Method for the request. If the request methods is post then start the process of storing data of participants on the user.
     */
    if(!empty($details)){

        /**
         * A flag varibale to check if some error orrcured with registering the data
         */
        $error = false;

        /**
         * Defining default msg to show to the user in form of pop up.
         */
        $msg= "Some error occured... Please try again ! for furthur details contact XYZ";

        /**
         * Checking payment method opted by the participant exists or not. Incase of error in data, process terminated and error msg is displayed
         */
        if($details['payMeth']) {

            /**
             * Checking organizational memberhsip that participants have and set the registration fees accordingly
             */
            if($details['member']==1 || $details['member']==2) {
                $fee=0;
            } else if(strlen($details['fname2'])>0 && strlen($details['lname2'])) {
                $fee = 80;
            } else {
                $fee = 50;
            }
            
            
            $payMeth = $details['payMeth'];
            /**
             * Generating unique id for the participants against their registration
             */
            $cust_id = substr($details["fname1"], 0,2).substr($details["fname2"], 0,2).substr($details["phn1"], -4);
            $ord_id=$cust_id.$payMeth.time();
            
            /**
             * Setting Defualt value of 2nd phone number of the user incase of it's not provided being optional.
             */
            if(empty($details['phn2']))
                $details['phn2']=0;

            
            $sql = "INSERT INTO ".TABLE."(id,fname1,lname1,year1,branch1,fname2,lname2,year2,branch2,email,phn1,phn2,college1,college2,fee,otp)VALUES('".$ord_id."','".$details['fname1']."','".$details['lname1']."',".$details['year1'].",'".$details['branch1']."','".$details['fname2']."','".$details['lname2']."',".$details['year2'].",'".$details['branch2']."','".$details['email']."',".$details['phn1'].",".$details['phn2'].",'".$details['college1']."','".$details['college2']."',".$fee.",".$payMeth.")";

            /**
             * Query to add registration data to DB. Incase of error in adding data, process terminated and error msg is displayed
             */
            if ($conn->query($sql)){

                /**
                 * Check payment method selected by user and preceding according.
                 * 1: InstaMojo
                 * 2: Offline to Volunteer
                 * Incase of error in adding data, process terminated and error msg is displayed
                 */
                if( $payMeth == 1){
                    
                    /**
                     * Generating a object for to communicate with InstaMojo Payment Gateway
                     */
                    $api = new Instamojo\Instamojo(API_KEY,AUTH_TOKEN);

                    /**
                     * Generating a payment link request for InstaMojo and redirecting the page to the link. Incase of error in link, process terminated and error msg is displayed
                     */
                    try {   
                        $paramList = array();
                        $paramList["purpose"] = "Registration for ".NAME." OrderId: ".$ord_id;
                        $paramList["amount"] = $fee;
                        $paramList["buyer_name"] = $details['fname1']." ".$details['lname1'];
                        $paramList["allow_repeated_payments"] ='false';
                        $paramList["send_email"] = 'true';
                        $paramList["redirect_url"] = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}".'result.php';
                        $paramList["phone"] = $details['phn1'];
                        $paramList["email"] = $details['email'];
                        $response = $api->paymentRequestCreate($paramList);
                        if(!empty($response)){
                            header("Location: ".$response["longurl"]);
                        } else {
                            error = true;
                        }
                    } catch (Exception $e) {
                        error = true;
                    }
                } elseif ( $payMeth == 2) {

                    /**
                    * Checking volunteerId exists or not. Incase of error in data, process terminated and error msg is displayed
                    */
                    if($details['w2-pay']){
                        $pay_id = $details['w2-pay'];

                        /**
                         * Sending a OTP Mail to the volunteer with registration detail and redirecting the page to the OTP Verification Page. Incase of error in send mail, process terminated and error msg is displayed
                         */
                        if(mailOTP($conn,$pay_id,$ord_id)){
                            header('Location: '."otp.php?ord=".$ord_id);
                        }
                        else $error =true;                    
                    } else {
                         $error = true;
                    }
                }else $error = true;
            }else {
                $error = true;
            }            
        }else { 
            $error = true;
        }

        /**
         * Display a error use pop up trigerred via JS.
         */
        if($error){
            echo '<script >  window.onload = function() { document.getElementById("btn-modal").click();} </script>';
           
        }
    }

    /**
     * Get the current registration count
     */
    $entry = EntryCount($conn);

    /**
     * Redirecting user if all seats are full
     */
    if($entry > TOTAL_REG ){
        header("Location: "."http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"."seats.php");
    }

    /**
     * Create a dynamic Title for the page. Used in header.php file.
     */
    $title ="-Registration"; 

    /**
     * Include header template of HTML
     */
    include("header.php");
?>
    <button type="button" class="btn btn-info btn-lg" style="display: none;" id="btn-modal" data-toggle="modal" data-target="#myModal"></button>

    <div class="container" >
        <form class="needs-validation" novalidate  style="margin-top: 2em;" method='post'>
            <div class="row">
                <div class="form-group col-md-12">
                    <div class="card person-card " style="padding-top: 0px">
                        <div class="card-body">
                            <h2 id="who_message1" class="card-title">Team Member 1</h2>
                                <div class="row">
                                    <div class="form-group col-md-2">
                                        <select id="input_sex1" class="form-control">
                                            <option value="Mr.">Mr.</option>
                                            <option value="Ms.">Ms.</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-5">
                                        <input id="first_name1" name="fname1" type="text" class="form-control" placeholder="First name" required>
                                        <div id="first_name_feedback1" class="invalid-feedback">
                                            Please provide a valid First Name
                                        </div>
                                    </div>
                                    <div class="form-group col-md-5">
                                        <input id="last_name1" name="lname1" type="text" class="form-control" placeholder="Last name" required>
                                        <div id="last_name_feedback1" class="invalid-feedback">
                                            Please provide a valid Last Name
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <input type="text" class="form-control" pattern="[a-zA-Z].{1,}" id="college1"  name="college1" placeholder="College Name" required>
                                        <div class="invalid-feedback">
                                            Please provide a valid college name
                                        </div>
                                    </div> 
                                    <div class="form-group col-md-3">
                                        <select id="year1" name="year1" class="form-control">
                                            <option value=1>1<sup>st</sup> Year</option>
                                            <option value=2>2<sup>nd</sup> Year</option>
                                            <option value=3>3<sup>rd</sup> Year</option>
                                            <option value=4>4<sup>th</sup> Year</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <select id="branch1" name="branch1" class="form-control">
                                            <option value="CSE">CSE</option>
                                            <option value="IT">IT</option>
                                            <option value="EE">EE</option>
                                            <option value="ECE">ECE</option>
                                            <option value="Others">Others</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <div class="card person-card " style="padding-top: 0px; margin-top: 15px" >
                        <div class="card-body">
                            <h2 id="who_message2" class="card-title">Team Member 2 (Optional)</h2>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <select id="input_sex2" class="form-control">
                                        <option value="Mr.">Mr.</option>
                                        <option value="Ms.">Ms.</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-5">
                                    <input id="first_name2" name="fname2" type="text" class="form-control" placeholder="First name" >
                                    <div id="first_name_feedback2" class="invalid-feedback">
                                        Please provide a valid First Name
                                    </div>
                                </div>
                                <div class="form-group col-md-5">
                                    <input id="last_name2" name="lname2" type="text" class="form-control" placeholder="Last name" >
                                    <div id="last_name_feedback2" class="invalid-feedback">
                                        Please provide a valid Last Name
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control" pattern="[a-zA-Z].{1,}" id="college2"  name="college2" placeholder="College Name" >
                                    <div class="invalid-feedback">
                                        Please provide a valid college name
                                    </div>
                                </div> 
                                <div class="form-group col-md-3">
                                    <select id="year2" name="year2" class="form-control">
                                        <option value=1>1<sup>st</sup> Year</option>
                                        <option value=2>2<sup>nd</sup> Year</option>
                                        <option value=3>3<sup>rd</sup> Year</option>
                                        <option value=4>4<sup>th</sup> Year</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <select id="branch2" name="branch2" class="form-control">
                                        <option value="CSE">CSE</option>
                                        <option value="IT">IT</option>
                                        <option value="EE">EE</option>
                                        <option value="ECE">ECE</option>
                                        <option value="Others">Others</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" style="padding=0.5em;">
                    <div class="card">
                        <div class="card-body"> 
                            <h3 class="card-title">Membership Status</h3> 
                        <div class="row">
                            <div class="form-group col-md-5">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input workshop" id="member2" value="2" name="member" required="">
                                    <label class="custom-control-label" for="member2">IEEE CS Member (Membership Proof Needed)</label>
                                </div>
                            </div>
                            <div class="form-group col-md-5">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input workshop" id="member1" value="1" name="member" required="">
                                    <label class="custom-control-label" for="member1">IEEE Member (Membership Proof Needed)</label>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input workshop" id="member0" value="0" name="member" required="">
                                    <label class="custom-control-label" for="member0">No</label>
                                </div>
                            </div>
                        </div>   
                    </div>
                </div>
            </div> 
            <div class="row">
                <div class="col-md-6" style="padding=0.5em;">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title">How to contact you ?</h2>
                            <div class="form-group">
                                <label for="email" class="col-form-label">Email</label>
                                <input type="email" class="form-control" id="email"  name="email" placeholder="example@gmail.com" required>
                                <div class="invalid-feedback">
                                    Please provide a valid Email
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tel" class="col-form-label" >Phone number (Whatsapp No.)</label>
                                <input type="tel" pattern="[0-9]{10}" class="form-control" id="tel" name="phn1" pattern=".{10}" placeholder="" required>
                                <div class="invalid-feedback">
                                    Please provide a valid Phone No.
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tel" class="col-form-label">
                                    Phone number (Optional)
                                </label>
                                <input type="tel" pattern="[0-9]{10}" class="form-control" id="tel"  name="phn2"  placeholder="">
                                <div class="invalid-feedback">
                                    Please provide a valid Phone No.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card"> 
                        <div class="card-body">
                            <h2 class="card-title">Workshop</h2>
                            <div class="form-group ">
                                <label for="" class="col-form-label">Select Mode of payment</label>
                                <div class="custom-control custom-radio">
                                      <input type="radio" class="custom-control-input workshop" id="w1" value="1" name="payMeth" data-id='w1' onclick="payNow(this)" required="">
                                      <label class="custom-control-label" for="w1">Online (addtional gateway charges may apply)</label>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="custom-control custom-radio">
                                      <input type="radio" class="custom-control-input workshop" id="w2" value="2" data-id='w2' name="payMeth" onclick="payNow(this)" required=""/>
                                      <label class="custom-control-label" for="w2">Offline to our volunteers</label>
                                    </div>
                                    <div  id="div-w2-pay" style="display: none;">
                                        <hr>
                                        <?php 
                                            /**
                                             * To generate list of volunteers dynamically
                                             */
                                            $i=1; 
                                            foreach ($vol as $key => $value) {
                                        ?>
                                        <div class="custom-control custom-radio pay"  id="div-w2-pay-1">
                                          <input type="radio" class="custom-control-input pay" id="w2-pay-<?php echo $i;?>" value="<?php echo $value['id']?>" name="w2-pay" required <?php if($value['id']==9) echo "checked"; ?>/>
                                          <label class="custom-control-label" for="w2-pay-<?php echo $i;?>"><?php echo $value['fname']." ".$value['lname'];?> (<a href=<?php echo '"tel:'.$value['phn'].'"'?>><?php echo $value['phn']?></a>)</label> 
                                        </div>
                                        <?php 
                                            $i++;}
                                        ?>
                                        <hr>
                                        <label class="" for="">Please contact the selected volunteer before proceeding.</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="margin-top: 1em;">
                <button type="Submit" class="btn btn-primary btn-lg btn-block" id="reg" disabled="">Register</button>
            </div>
        </form>
        <hr>
        
        <!-- modal pop-up after registration incase of error -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <div class="modal-body">
                  <p><?php echo $msg;?></p>
                </div>
              </div>
            </div>
        </div> 
      
	</div>
    <?php
	
    /**
     * Include footer template of HTML
     */
	include("footer.php"); 
    ?>  		
    <script src="assets/js/reg.js"></script>
    <script src="<?php echo $DomainName?>/forms/assets/js/validate.js"></script>
    <script src="assets/js/payNow.js"></script>