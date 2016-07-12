<?php
	require('writeHTML.php');

	$pdf=new PDF_HTML();
	$pdf->AddPage();
	$pdf->SetFont('Arial');
	
	if ($_POST['selectedJob']) {$pdf->WriteHTML('<br>Selected Job: '.$_POST['selectedJob'].'<br>');}
	if ($_POST['selectedOccupation']) {$pdf->WriteHTML('<br>Selected Occupation: '.$_POST['selectedOccupation'].'<br>');}
	if ($_POST['otherExpenses']) {$pdf->WriteHTML('<br>Are you claiming for other expenses of your employment: '.$_POST['otherExpenses'].'<br>');}
	if ($_POST['estimatedExpenses']) {$pdf->WriteHTML('<br>Estimated expenses: '.$_POST['estimatedExpenses'].'<br>');}
	if ($_POST['prepare']) {$pdf->WriteHTML('<br>Do you or your accountant already prepare a self assessment tax return?: '.$_POST['prepare'].'<br>');}
	if ($_POST['taxYears']) {$pdf->WriteHTML('<br>Select your tax years: '.$_POST['taxYears'].'<br>');}
	if ($_POST['selectedTitle']) {$pdf->WriteHTML('<br>Title: '.$_POST['selectedTitle'].'<br>');}
	if ($_POST['selectedFirstName']) {$pdf->WriteHTML('<br>Firstname(s): '.$_POST['selectedFirstName'].'<br>');}
	if ($_POST['selectedSurname']) {$pdf->WriteHTML('<br>Surname: '.$_POST['selectedSurname'].'<br>');}
	if ($_POST['selectedEmail']) {$pdf->WriteHTML('<br>E-mail: '.$_POST['selectedEmail'].'<br>');}
	if ($_POST['cashbackBonus']) {$pdf->WriteHTML('<br>CashbackBonus: '.$_POST['cashbackBonus'].'<br>');}
	
	$pdf->Output('D');
?>
