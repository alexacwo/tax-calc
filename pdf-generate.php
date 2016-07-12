<?php

	require('db-settings.php');
	
	$pdf=new PDF_HTML();
	$pdf->AddPage();
	$pdf->SetFont('Arial');	
	
	$claimant = '';
	
	if (!empty($_POST['selectedTitle'])) {$claimant .= $_POST['selectedTitle'].' ';}
	if (!empty($_POST['selectedFirstName'])) {$claimant .= $_POST['selectedFirstName'].' ';}
	if (!empty($_POST['selectedSurname'])) {$claimant .= $_POST['selectedSurname'];}
	
	$pdf->printHeader($claimant);
	
	$pdf->SetFontSize(9);
	
	$pdf->WriteHTML('Dear Sir/Madam,<br>I would like to claim tax relief on the expenses of my employment as detailed below.<br>');
	
	$job = '';
	$occupation = '';
	$deduction = '';	
	
	if (!empty($_POST['selectedJob'])) {$job = $_POST['selectedJob'];}
	if (!empty($_POST['selectedOccupation'])) {$occupation = $_POST['selectedOccupation'];}
	if (!empty($_POST['estimatedAmount'])) {$deduction = '£'.$_POST['estimatedAmount'];}
	
	$pdf->printFirstTable($job, $occupation, $deduction);
	
	if (!empty($_POST['otherExpenses'])) {$pdf->WriteHTML('<br>Are you claiming for other expenses of your employment: '.$_POST['otherExpenses'].'<br>');}
	if (!empty($_POST['estimatedExpenses'])) {$pdf->WriteHTML('<br>Estimated expenses: '.$_POST['estimatedExpenses'].'<br>');}
	if (!empty($_POST['prepare'])) {$pdf->WriteHTML('<br>Do you or your accountant already prepare a self assessment tax return?: '.$_POST['prepare'].'<br>');}
	if (!empty($_POST['taxYears'])) {
		foreach($_POST['taxYears'] as $taxyear) {
			$pdf->WriteHTML('<br>Tax year: '.$taxyear.'<br>');
		}
	}
	
	$pdf->WriteHTML('<hr><br><br>Contact details:<br><br><hr><br>');
	
	if (!empty($_POST['selectedEmail'])) {$pdf->WriteHTML('<br>E-mail: '.$_POST['selectedEmail'].'<br>');}
	if (!empty($_POST['cashbackBonus'])) {$pdf->WriteHTML('<br>CashbackBonus: '.$_POST['cashbackBonus'].'<br>');}
	
	if (!empty($_POST['selectedPostcode'])) {$pdf->WriteHTML('<br>Postcode: '.$_POST['selectedPostcode'].'<br>');}
	if (!empty($_POST['selectedAddressFirstline'])) {$pdf->WriteHTML('<br>Address (first line): '.$_POST['selectedAddressFirstline'].'<br>');}
	if (!empty($_POST['selectedAddressSecondline'])) {$pdf->WriteHTML('<br>Address (second line): '.$_POST['selectedAddressSecondline'].'<br>');}
	if (!empty($_POST['selectedCity'])) {$pdf->WriteHTML('<br>City: '.$_POST['selectedCity'].'<br>');}
	if (!empty($_POST['selectedCounty'])) {$pdf->WriteHTML('<br>County: '.$_POST['selectedCounty'].'<br>');}
	
	if (!empty($_POST['selectedEmployer'])) {$pdf->WriteHTML('<br><br>Employer: '.$_POST['selectedEmployer'].'<br>');}
	if (!empty($_POST['selectedJobTitle'])) {$pdf->WriteHTML('<br>Job title: '.$_POST['selectedJobTitle'].'<br>');}
	
	
	$pdf->WriteHTML('<hr><br><br>National insurance number:<br><br><hr><br>');
	
	if (!empty($_POST['selectedNINumber'])) {$pdf->WriteHTML('<br>National insurance number: '.$_POST['selectedNINumber'].'<br>');}
	if (!empty($_POST['selectedPhone'])) {$pdf->WriteHTML('<br>Phone: '.$_POST['selectedPhone'].'<br>');}
	
	
	//Generating Claim Reference Number 	
	
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
	

?>