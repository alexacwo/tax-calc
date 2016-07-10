<?php
	require('writeHTML.php');

	require('pdf-generate.php');
	
	$pdf->Output('D','doc'.$new_claim_number.'.pdf');	
	
?>
