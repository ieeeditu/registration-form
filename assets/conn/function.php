<?php
/**
 * A module with all utility functions
 */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


/**
 * @param DB Connection Object
 * @return {number} Number for registration successfull paid
 */
function EntryCount($conn){
	$sql ="SELECT id FROM ".TABLE." WHERE txn IS NOT NULL";
   	if($details = $conn->query($sql))
		return $details->num_rows;
	else{
        echo"Error: " . $sql . "<br>" . $conn->error;
		return false;
	}
}

/**
 * Create a mail object
 */
function mailOBj(){

    $mail = new PHPMailer(true);                      // Passing `true` enables exceptions
	try {
	    //Server settings
	    $mail->SMTPDebug = 0;                        // Enable verbose debug output
	    $mail->isSMTP();                            // Set mailer to use SMTP
	    $mail->Host = MAIL_HOST;  					// Specify main and backup SMTP servers
	    $mail->SMTPAuth = true;                    // Enable SMTP authentication
	    $mail->Username = MAIL_USERNAME;           // SMTP username
	    $mail->Password = MAIL_PASSWORD;           // SMTP password
	    $mail->SMTPSecure = 'ssl';                 // Enable TLS encryption, `ssl` also accepted
	    $mail->Port = MAIL_PORT; 
	    return $mail;
	} catch (Exception $e){
   		echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
		return false;
	}
}
/**
 * To generate a OTP and send mail with participant details and OTP to the mentioned volunteer
 * @param conn DB Connection Object
 * @param Mailid VolunteerId
 * @param id unique OrderId of the participant
 * @return boolean status of mail sent
 */
function mailOTP($conn,$Mailid,$id){
	$email=getVolMail($conn,$Mailid);
	$otp = $Mailid."".rand(100000,999999);	
	$sql ="UPDATE ".TABLE." SET otp=".$otp." WHERE id = '".$id."'";
//	die;
	if ($conn->query($sql)){	
	$sql ="SELECT * FROM ".TABLE." WHERE id = '".$id."'";
	$rows=[];
	$details = $conn->query($sql);
	if ($details->num_rows > 0){ 
		while ($row=mysqli_fetch_array($details)) {
		    $rows[] = array( 
				'fname1' => $row['fname1'],
				'lname1' => $row['lname1'],
				'phn1' => $row['phn1'],
				'email' => $row['email'],
				'fee' => $row['fee']
				);
		    }
		}
		//print_r($rows);
		//die;
	}else{ 
		//echo "fail"; 
		return false;
	}
		$message = "
		<html>
		<head>
		<title>".NAME."Payment OTP </title>
		</head>
		<body>
		<p>The following person has requested to share the OTP given bellow. Share it only if the person has paid the registration amount i.e. ₹".$rows[0]['fee']."</p>
		<table>
		<tr>
		<th>Name</th>
		<th>Email</th>
		<th>Phn</th>
		</tr>
		<tr>
		<td>".$rows[0]['fname1']." ".$rows[0]['lname1']."</td>
		<td>".$rows[0]['email']."</td>
		<td>".$rows[0]['phn1']."</td>
		<td></td>
		</tr>
		</table>
		<h1>OTP : ".$otp."</h1>
		</body>
		</html>
		";
		try{
			$mail = mailOBj();
		    $mail->setFrom('no-reply@ieeeditu.org', 'IEEE Student Branch DIT University');
		    $mail->addReplyTo('ieee.student.dit@gmail.com', 'Information');
		    $mail->addBCC('kotnala.himanshu99@gmail.com'); 
		    $mail->addAddress($email);  
		    $mail->isHTML(true);                                  // Set email format to HTML
		    $mail->Subject = NAME." Payment OTP "."Odr Id:".$id;
		    $mail->Body    = $message;
			$mail->send();
			//echo "string";
			return true;
		}catch (Exception $e) {
		    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
			return false;
		}
	}

/**
 * To send payment confirmation mail to participant withs details
 * @param conn DB Connection Object
 * @param id unique OrderId of the participant
 * @return boolean status of mail sent
 */
	function cnfrmMail($conn,$id){
		$sql ="SELECT * FROM ".TABLE." WHERE id = '".$id."'";
		$rows=[];
		$details = $conn->query($sql);
		if ($details->num_rows > 0){ 
			while ($row=mysqli_fetch_array($details)) {
			    $rows[] = array( 
					'fname' => $row['fname1'],
					'lname' => $row['lname1'],
					'phn1' => $row['phn1'],
					'email' => $row['email'],
					'txn' => $row['txn'],
					'year' => $row['year1'],
					'branch' => $row['branch1'],
					'fee' => $row['fee'],
					'college' => $row['college1']
				);
		    }
		}

      	if(strlen((string)$rows[0]['txn'])==1)
      		$paid = "Offline to ".getVolName($conn,$rows[0]['txn']);
      	else
      		$paid = "Online via Instamojo";


		$message = file_get_contents('assets/conn/mailTemplate1.html'); 
	    $message = str_replace('%name%', $rows[0]['fname']." ".$rows[0]['lname'], $message); 
	    $message = str_replace('%event%', NAME, $message); 
	    $message = str_replace('%college%', $rows[0]['college'], $message); 
	    $message = str_replace('%phone%', $rows[0]['phn1'], $message); 
	    $message = str_replace('%paid%', $paid, $message); 
	    $message = str_replace('%fee%', $rows[0]['fee'], $message); 
	    $message = str_replace('%order%', $id, $message); 
	    $message = str_replace('%eventstartdate%', EVENT_START_DATE, $message);
	    $message = str_replace('%eventenddate%', EVENT_END_DATE, $message);
	    $message = str_replace('%date%', date("M,d,Y H:i:s"), $message);
		try{
			$mail = mailOBj();
		    $mail->setFrom('no-reply@ieeeditu.org', 'IEEE Student Branch DIT University');
		    $mail->addReplyTo('ieee.student.dit@gmail.com', 'Information');
		  	//  $mail->addBCC('ieee.student.dit@gmail.com'); 
		    $mail->addAddress($rows[0]['email']);  
		    $mail->isHTML(true);                                  // Set email format to HTML
			$mail->Subject = NAME." Registration Confirmation";
		    $mail->MsgHTML($message);
		    //$mail->CharSet="utf-8";
			$mail->send();
			//echo "string";
			return true;
		}catch (Exception $e) {
		    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
			return false;
		}
	}
	function getUserAll($conn){
		$sql ="SELECT * FROM ".VOL." WHERE switch = 1";
		if ($conn->query($sql)){	
			$rows=[];
			$details = $conn->query($sql);
			if ($details->num_rows > 0){ 
				while ($row=mysqli_fetch_array($details)) {
				    $rows[] = array( 
						'fname' => $row['fname'],
						'lname' => $row['lname'],
						'phn' => $row['phn'],
						'id' => $row['id'],
						'switch' => $row['switch'],
						'email' => $row['email']								
						);
				    }
			}
			return $rows;
			//die;
		}
	}

	/**
	* Get email volunteer
	* @param conn DB Connection Object
	* @param id unique id of volunteer
	* @return string email of volunteer
	*/
	function getVolMail($conn,$id){
		$sql ="SELECT email FROM ".VOL." WHERE switch = 1 and id=".$id;
		if ($conn->query($sql)){	
			$rows=[];
			$details = $conn->query($sql);
			if ($details->num_rows > 0){ 
				while ($row=mysqli_fetch_array($details)) {
				    $rows[] = array( 
						'email' => $row['email']								
						);
				    }
			}
			return $rows[0]['email'];
			// $rows;
			//die;
		}
	}

	/**
	* Get phone number volunteer
	* @param conn DB Connection Object
	* @param id unique id of volunteer
	* @return string phone number of volunteer
	*/
	function getVolPhn($conn,$id){
		$sql ="SELECT phn FROM ".VOL." WHERE switch = 1 and id=".$id;
		if ($conn->query($sql)){	
			$rows=[];
			$details = $conn->query($sql);
			if ($details->num_rows > 0){ 
				while ($row=mysqli_fetch_array($details)) {
				    $rows[] = array( 
						'phn' => $row['phn']								
						);
				    }
			}
			return $rows[0]['phn'];
			// $rows;
			//die;
		}
	}


	/**
	* Get name volunteer
	* @param conn DB Connection Object
	* @param id unique id of volunteer
	* @return string name of volunteer
	*/
	function getVolName($conn,$id){
		$sql ="SELECT fname,lname FROM ".VOL." WHERE switch = 1 and id=".$id;
		if ($conn->query($sql)){	
			$rows=[];
			$details = $conn->query($sql);
			if ($details->num_rows > 0){ 
				while ($row=mysqli_fetch_array($details)) {
				    $rows[] = array( 
						'fname' => $row['fname'],
						'lname' => $row['lname']								
						);
				    }
			}
			return $rows[0]['fname']." ".$rows[0]['lname'];
			// $rows;
			//die;
		}
	}	
?>