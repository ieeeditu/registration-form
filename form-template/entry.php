<!-- 
	PHP Module/HTML Template which return a HTML page with list participants registered for event 
-->
<?php
	require_once("assets/conn/common_config.php");

	/**
	 * A query parameter which will be using which we can filter the participant on the basis of PAID and UNPAID
	 * 1: PAID
	 * 2: UNPAID
	 * undefined: ALL
	 */
	$type = $_REQUEST['type'];

	$sql ="SELECT  * FROM ".TABLE;
	if(!empty($type)) {

		if($type==1) {
			sql.=" where txn is NOT NULL";
		} else if($type==2) {
			$sql.=" where txn is NULL";
		}
	}
	
	$rows=[];
	 
	/**
	 * Query DB to get list of participant according to the type provided
	 */
   	$details = $conn->query($sql);
   	if($details){
		if ($details->num_rows > 0){ 
		   	while ($row=mysqli_fetch_array($details)) {
		        $rows[] = array( 
				'fname1' => $row['fname1'],
				'lname1' => $row['lname1'],
				'branch1' => $row['branch1'],
				'year1' => $row['year1'],
				'fname2' => $row['fname2'],
				'lname2' => $row['lname2'],
				'branch2' => $row['branch2'],
				'year2' => $row['year2'],
				'txn' => $row['txn'],
				'phn1' => $row['phn1'],
				'fee' => $row['fee'],
				'id' => $row['id']					
				);
			}
		}	
	} else {
		echo mysqli_error($conn);
	}

    /**
     * Create a dynamic Title for the page. Used in header.php file.
     */
    $title ="-Participants List"; 

    /**
     * Include header template of HTML
     */
    include("header.php");
?>

<div class="container" style="margin-top: 1em; ">
	<div class="row" style="margin-top: 0em;">
		<div class="col-sm-12 col-md-12 col-lg-12">
			<div class="card">
				<div class="card-body">
					<div class="container table-responsive">          
						<table class="table table-striped ">
							<thead class="thead-dark">
								<tr>
								    <th>S.No.</th>
								    <th>Name-1</th>
								    <th>Branch-1</th>
								    <th>Year-1</th>
								    <th>Name-2</th>
								    <th>Branch-2</th>
								    <th>Year-2</th>
								    <th>Phone No.</th>
								    <th>Txn</th>
								    <th>Fee</th>
								    <th>Ord ID</th>
								</tr>
							</thead>
							<tbody>
								<?php 
									/**
									 * To generate list of participants dynamically
									 */
									$i=1;
								    foreach($rows as $key=>$value){			
								?>					      
								<tr>
								    <td><?php echo $i++;?></td>
									<td><?php echo $value['fname1']." ".$value['lname1'];?></td>
									<td><?php echo $value['branch1'];?></td>
									<td><?php echo $value['year1'];?></td>
									<td><?php echo $value['fname2']." ".$value['lname2'];?></td>
									<td><?php echo $value['branch2'];?></td>
									<td><?php echo $value['year2'];?></td>
									<td><?php echo $value['phn1'];?></td>
									<td><?php echo $value['txn'];?></td>
									<td><?php echo $value['fee'];?></td>
									<td><?php echo $value['id'];?></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>	
				</div>
			</div>
		</div>
	</div>
</div>	
<hr>	
<?php
	
    /**
     * Include footer template of HTML
     */
	include("footer.php"); 
?>