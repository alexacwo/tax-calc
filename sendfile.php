<?php

	// Saving new PDF file
	
	require('writeHTML.php');

	require('pdf-generate.php');
	
	$pdf->Output('F','doc'.$new_claim_number.'.pdf');
	
	// Sending file to specified e-mail
	
	$filename = 'doc'.$new_claim_number.'.pdf';
	$mailto = 'motoparts.spb@gmail.com';
	$subject = 'Message from Uniform Taxrebate Calculator website';
	$message = 'PDF file sent from Uniform Taxrebate Calculator website';
	
	$file = $filename;
	$file_size = filesize($file);
	$handle = fopen($file, "r");
	$content = fread($handle, $file_size);
	fclose($handle);
	$content = chunk_split(base64_encode($content));
	$uid = md5(uniqid(time()));
	$name = basename($file);

	// headers
	$headers = "From: Alex <spacerebels@gmail.com>\r\n";
	$headers .= "Reply-To:  spacerebels@gmail.com\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";

	// message & attachment
	$nmessage = "--".$uid."\r\n";
	$nmessage .= "Content-type:text/plain; charset=iso-8859-1\r\n";
	$nmessage .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
	$nmessage .= $message."\r\n\r\n";
	$nmessage .= "--".$uid."\r\n";
	$nmessage .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n";
	$nmessage .= "Content-Transfer-Encoding: base64\r\n";
	$nmessage .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
	$nmessage .= $content."\r\n\r\n";
	$nmessage .= "--".$uid."--";

	if (mail($mailto, $subject, $nmessage, $headers)) {
		echo "OK"; // Or do something here
	} else {
		echo "NOT OK"; 
	}
	
?>
