<?php

	$pdf=new PDF_HTML();
	$pdf->AddPage();
	$pdf->SetFont('Arial');
	
	if (!empty($_POST['selectedJob'])) {$pdf->WriteHTML('<br>Selected Job: '.$_POST['selectedJob'].'<br>');}
	if (!empty($_POST['selectedOccupation'])) {$pdf->WriteHTML('<br>Selected Occupation: '.$_POST['selectedOccupation'].'<br>');}
	if (!empty($_POST['otherExpenses'])) {$pdf->WriteHTML('<br>Are you claiming for other expenses of your employment: '.$_POST['otherExpenses'].'<br>');}
	if (!empty($_POST['estimatedExpenses'])) {$pdf->WriteHTML('<br>Estimated expenses: '.$_POST['estimatedExpenses'].'<br>');}
	if (!empty($_POST['prepare'])) {$pdf->WriteHTML('<br>Do you or your accountant already prepare a self assessment tax return?: '.$_POST['prepare'].'<br>');}
	if (!empty($_POST['taxYears'])) {
		foreach($_POST['taxYears'] as $taxyear) {
			$pdf->WriteHTML('<br>Tax year: '.$taxyear.'<br>');
		}
	}
	if (!empty($_POST['selectedTitle'])) {$pdf->WriteHTML('<br>Title: '.$_POST['selectedTitle'].'<br>');}
	if (!empty($_POST['selectedFirstName'])) {$pdf->WriteHTML('<br>Firstname(s): '.$_POST['selectedFirstName'].'<br>');}
	if (!empty($_POST['selectedSurname'])) {$pdf->WriteHTML('<br>Surname: '.$_POST['selectedSurname'].'<br>');}
	if (!empty($_POST['selectedEmail'])) {$pdf->WriteHTML('<br>E-mail: '.$_POST['selectedEmail'].'<br>');}
	if (!empty($_POST['cashbackBonus'])) {$pdf->WriteHTML('<br>CashbackBonus: '.$_POST['cashbackBonus'].'<br>');}
	
	//Generating Claim Reference Number 
	
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "taxrebate";
	
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
		
		$pdf->WriteHTML('<br><br><br>Generated Claim Reference Number: '.$new_claim_number.'<br>');
		
		// Populating database with the new database
		
		$insert_sql = "INSERT INTO claims_info (id, reference_num, date, ni_num)
				VALUES ('','".$new_claim_number."','cjd','ddfdfd')";
		$conn->query($insert_sql);
	}
	
	$conn->close();
	
	if (!empty($_POST['estimatedAmount'])) {$pdf->WriteHTML('<br><br><br>Estimated tax rebate amount: '.$_POST['estimatedAmount'].' pounds<br>');}

?>