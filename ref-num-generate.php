<?php

	require('db-settings.php');
	
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	if ($conn->connect_error) {
		die("Connection to database failed: " . $conn->connect_error);
	} 

	$sql = "SELECT * FROM claims_info ORDER BY id DESC LIMIT 1";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$claim_number = $row["reference_num"];
		}
	} 	

	if (!empty($claim_number)) {
		$digit = substr($claim_number,3);
		$new_claim_digit = intval($digit)+1;		
		$new_claim_number = 'UTR'.str_pad($new_claim_digit, 7, '0', STR_PAD_LEFT);
		
		echo $new_claim_number;
		// Populating database with the new database
		
		$insert_sql = "INSERT INTO claims_info (id, reference_num, date, ni_num)
				VALUES ('','".$new_claim_number."','cjd','ddfdfd')";
		$conn->query($insert_sql);
	}
	
	$conn->close();
?>