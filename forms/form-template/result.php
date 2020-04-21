<?php

	require_once("assets/conn/common_config.php");

	/**
	 * Check request object for data
	 */
	if(!empty($_REQUEST)) {

        /**
         * A flag varibale to check to payment status
         */
		$status=false;
		/**
		 * Differentiate between the request forwarded by OTP Validation or Instamojo  portal
		 * If Query parameter have attribite:
		 * ord: OTP Validation
		 * payment_request_id: Instamojo
		 */
		if(!empty($_REQUEST['ord'])) {
			
			$id=$_REQUEST['ord'];
			/**
			 * Checking wether the given id's payment has been completed or not
			 */
			$sql ="SELECT txn FROM ".TABLE." WHERE id = '".$id."' AND TXN IS NOT NULL";
			$details = $conn->query($sql);
			/**
			 * Set payment status as complete if record exist.
			 */
			if ($details->num_rows == 1){
				$status=true;
			}else {
				header('Location: '."/".FORM_PATH_R);
			}
		}
		else if(!empty($_REQUEST['payment_request_id'])) {
			/**
			 * Getting payment update from instamojo
			 */
			$api = new Instamojo\Instamojo(API_KEY,AUTH_TOKEN);
			$response = $api->paymentRequestStatus($_REQUEST["payment_request_id"]);
			$msg="";

			$purpose = $response["purpose"];
			$id = substr($purpose, 27+strlen(NAME),strlen($purpose)-1);
			/**
			 * Checking payment status. If true then update database else set status to false
			 */
			if ($response["status"] == "Completed") {
				$status = true;
				$sql ="UPDATE ".TABLE." SET txn='".$response["payments"][0]["payment_id"]."' where id ='".$id."'";
				if ($conn->query($sql)){
					$status = true;
				}else {
					false;
				}
			}
		} else {
			header('Location: '."/".FORM_PATH_R);
		}

		/**
		 * Checking the payment status. If  true then retriving the data from DB and render template. Else deleting the complete record of registration corresponding to provided id from database
		 */
		if($status){
			$sql ="SELECT * FROM ".TABLE." WHERE id = '".$id."'";
					$rows=[];
					$details = $conn->query($sql);
					if($details){
						if ($details->num_rows > 0){ 
							while ($row=mysqli_fetch_array($details)) {
							$rows[] = array( 
								'fname1' => $row['fname1'],
								'lname1' => $row['lname1'],
								'branch1' => $row['branch1'],
								'college1' => $row['college1'],
								'year1' => $row['year1'],
								'fname2' => $row['fname2'],
								'lname2' => $row['lname2'],
								'branch2' => $row['branch2'],
								'college2' => $row['college2'],
								'year2' => $row['year2'],
								'email' => $row['email']								
								);
							}
						}
					cnfrmMail($conn,$id);
					}else false;
		}
		else { 
				$sql ="SELECT email FROM ".TABLE." WHERE id = '".$id."'";
					$rows=[];
					$details = $conn->query($sql);

					if ($details->num_rows > 0) { 
						while ($row=mysqli_fetch_array($details)) {
						$rows[] = array( 
							'email' => $row['email'],
										
							);
						}
					}
				$sql = "DELETE FROM ".TABLE." WHERE id='".$id."'";
				$conn->query($sql);
			} 

	}
	else {
		header('Location: '."/".FORM_PATH_R);
	}

    /**
     * Create a dynamic Title for the page. Used in header.php file.
     */
	$title ="-Payment Status";

    /**
     * Include header template of HTML
     */
	include("header.php");
?>
<div class="container" style="margin-top: 1em; ">
	<?php if(!$status) { ?>
	<div class="row" >
		<div class="col-sm-12 col-md-12 col-lg-12">
			<div class="card">
				<div class="card-body">
					Payment failed for email : '<?php echo $rows[0]['email']?>. Plz try again... <a href="<?php FORM_LINK ?>"><?php FORM_LINK ?></a>
				</div>
			</div>
		</div>
	</div>
	<?php } else {?>
	<div class="row" >
		<div class="col-sm-8 col-md-8 col-lg-8">
			<div class="card">
				<div class="card-body">
					Payment successful for registered email : <?php echo $rows[0]['email']; ?>
				</div>
			</div>
		</div>
		<div class="col-sm-4 col-md-4 col-lg-4">
			<div class="card">
				<div class="card-body">
					<b>Order ID: </b><?php echo $id;?>
				</div>
			</div>
		</div>
	</div>
	<hr>
	<div class="row" style="">
		<div class="col-sm-4 col-md-4 col-lg-4">
			<div class="card">
				<div class="card-body">
					<b>Name: </b><?php echo $rows[0]['fname1']." ".$rows[0]['lname1'];?>
				</div>
			</div>
		</div>
		<div class="col-sm-4 col-md-4 col-lg-4">
			<div class="card">
				<div class="card-body">
					<b>College: </b><?php echo $rows[0]['college1'];?>
		        </div>
			</div>
		</div>
		<div class="col-sm-2 col-md-2 col-lg-2">
			<div class="card">
				<div class="card-body">
					<b>Year: </b><?php echo $rows[0]['year1'];?>
		        </div>
			</div>
		</div>
		<div class="col-sm-2 col-md-2 col-lg-2">
			<div class="card">
				<div class="card-body">
					<b>Branch: </b><?php echo $rows[0]['branch1'];?>
		        </div>
			</div>
		</div>
	</div>
	<?php if(strlen($rows[0]['fname2'])>0 && strlen($rows[0]['lname2'])) {?>
		<div class="row" style="" >
			<div class="col-sm-4 col-md-4 col-lg-4">
				<div class="card">
					<div class="card-body">
						<b>Name: </b><?php echo $rows[0]['fname2']." ".$rows[0]['lname2'];?>
		            </div>
				</div>
			</div>
			<div class="col-sm-4 col-md-4 col-lg-4">
				<div class="card">
					<div class="card-body">
						<b>College: </b><?php echo $rows[0]['college2'];?>
			        </div>
				</div>
			</div>
			<div class="col-sm-2 col-md-2 col-lg-2">
				<div class="card">
					<div class="card-body">
						<b>Year: </b><?php echo $rows[0]['year2'];?>
				    </div>
				</div>
			</div>
			<div class="col-sm-2 col-md-2 col-lg-2">
				<div class="card">
					<div class="card-body">
						<b>Branch: </b><?php echo $rows[0]['branch2'];?>
			        </div>
				</div>
			</div>
		</div>
		<?php } ?>
		<div class="row" style="margin-top: 0em;">
			<div class="col-sm-12 col-md-12 col-lg-12">
				<div class="card">
					<div class="card-body">
						<div class="container">          
					  		<table class="table table-striped">
							    <thead>
								    <tr>
								    	<th>Workshop</th>
								        <th>Payment Status</th>
								    </tr>
								</thead>
								<tbody>
								    <tr>
									    <td><?php echo NAME; ?></td>
								        <?php 	
								        	if(!$status)
									        	echo "<td>Not Paid</td>" ;
									        else
									        	echo "<td>Paid</td>" ;
									    ?>
								    </tr>
								</tbody>
							</table>
						</div>	
					</div>
				</div>
			</div>
		</div>	
		<hr>
		<div class="row" style="">
			<div class="col-sm-12 col-md-12 col-lg-12">
				<div class="card">
					<div class="card-body">
						<b>Please find the receipt on your mail</b>
		            </div>
				</div>
			</div>
		</div>
		<hr>
	</div>	
<?php 
	} 

    /**
     * Include footer template of HTML
     */
	include("footer.php"); 
?>
	