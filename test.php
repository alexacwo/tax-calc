<?php

	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "taxrebate";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

	$sql = "SELECT * FROM claims_info ORDER BY id DESC LIMIT 1";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$claim_number = $row["reference_num"];
		}
	} 

	$digit = substr($claim_number,3);
	$new_claim_digit = intval($digit)+1;
	
	$new_claim_number = 'UTR'.str_pad($new_claim_digit, 7, '0', STR_PAD_LEFT);
	echo $new_claim_number;
	
	
	
?>