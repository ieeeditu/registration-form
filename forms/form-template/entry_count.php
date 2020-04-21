<?php
    /**
     * A module that can used incase of different registration fees depending upon number for participants. It can be imported in header.php to view effects.
     */
	require_once("assets/conn/common_config.php");
	$cost="<b>";
	$entry = EntryCount($conn); 
	if($entry>=$kitno[0]){
        $fee = 1000;
        $cost.= "No subsidized kit left !! ";
    }else if($entry>=$kitno[1]){ 
    	$fee = 850;
    	$cost.="1st slot of subsidized kit is over( ₹600/Kit )<br> Number of subsidized kit left: ".($kitno[0]-$entry);
    }else{
        $fee = 600;
       $cost.="Number of subsidized kit left: ".($kitno[1]-$entry);
   }
   echo $cost .="<br> Registration fee: ₹".$fee; 
?>


<script type="text/javascript">
    $("#cost").load('kit_cost.php');
    window.setInterval(function(){ 
        $("#cost").load('kit_cost.php');
    }, 30000);
</script>