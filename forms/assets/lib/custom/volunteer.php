<?php 

function getVolunteers($conn){
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