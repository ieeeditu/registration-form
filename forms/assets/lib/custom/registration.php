<?php

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



?>