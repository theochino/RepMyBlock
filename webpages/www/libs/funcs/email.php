<?php
// Petition Email.


function SendPetitionEmail2($to, $emailsubject, $message, $k) {
	include $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	$TextTime = time ();
	$FromAddress = "WebMinion@RepMyBlock.NYC";
  $FullFrom = "RepMyBlock Automated Mail <" . $FromAddress . ">";
	$emailsubject = "RepMyBlock Email verification";
                 
	$linktoverify = $FrontEndWebsite . "/get-involved/login/verify.php?hashkey=" . $hashtable . "&username=" . $_POST["username"];       
                           
  $message = "Please verify your email address by following this link: $linktoverify\n";
 	$htmlmessage = '<HTML><CENTER>Rep My Block</CENTER><BR>' .
 									'<p><strong>This is strong text</strong> while this is not. <A HREF="' . $linktoverify . '">Click here to verify</A></p>' .
 									'<p><strong>This is strong text</strong> while this is not. $linktoverify</p>' .
 									'<p><strong>This is strong text</strong> while this is not. $linktoverify</p>';

	final_send_mail($FullFrom, $FromAddress, $to, $emailsubject, $message, $attach, "no", "", $htmlmessage);
}

function SendPetitionEmail($to, $emailsubject, $message, $k) {
	include $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	$TextTime = time ();
	$FromAddress = "WebMinion@RepMyBlock.NYC";
  $FullFrom = "RepMyBlock Automated Mail <" . $FromAddress . ">";

	$attach[0]["type"] = "application/pdf";
	$attach[0]["title"] = "Petition.pdf";
	$attach[0]["body"] =  stream_get_contents(fopen($FrontEndPDF . "/petitions_blkwit/?k=" . $k, 'r'));
	
	$message .= "\n\n" . $LinkToAcceptance . "\n";
	$html_message = "<HTML>" . 
									"<BODY>" .
									"<P>" . $message . "</P>" .
									"<P>" . $LinkToAcceptance . "</P>" . 
									"</BODY>" . 
									"</HTML>";
	
	final_send_mail($FullFrom, $FromAddress, $to, $emailsubject, $message, $attach, "no", "", $htmlmessage);
}


// Nomination Email
function SendNominationEmail($to, $emailsubject, $message, $CanCominationID) {
	include $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";	
	$TextTime = time ();
	$FromAddress = "WebMinion@RepMyBlock.NYC";
  $FullFrom = "RepMyBlock Automated Mail <" . $FromAddress . ">";
  
  $LinkToAcceptance = $FrontEndWebsite . "/get-involved/acceptnomination/?k=" . EncryptURL("CanNomination=" . $CanCominationID);

	$message .= "\n\n" . $LinkToAcceptance . "\n";
	$html_message = "<HTML>" . 
									"<BODY>" .
									"<P>" . $message . "</P>" .
									"<P>" . $LinkToAcceptance . "</P>" . 
									"</BODY>" . 
									"</HTML>";
	
	final_send_mail($FullFrom, $FromAddress, $to, $emailsubject, $message, $attach, "no", "", $htmlmessage);
# final_send_mail($fullfrom, $from,         $emailaddress, $emailsubject, $message,           $attachements = "", $mimeready = 'no', $post_headers = "" ) {
}

function SendForgotLogin($to, $hashtable) {
	
		include $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	$TextTime = time ();
	$FromAddress = "WebMinion@RepMyBlock.NYC";
  $FullFrom = "RepMyBlock Automated Mail <" . $FromAddress . ">";
  $emailsubject = "Password Recovery Email.";
	
	$linktoverify = $FrontEndWebsite . "/get-involved/login/recover/?hashkey=" . $hashtable;       

	//$handleLogo = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/pics/email/RepMyBlock.png");	
	//attach[0] = base64_encode($handleLogo);
	//$message = "\n\n" . $LinkToAcceptance . "\n";
	
	$html_message = "<HTML>" . 
		"<HEAD>" . 
		"<TITLE>Rep My Block.</TITLE>" . 
		"</HEAD>" . 
		"<BODY style=line-height: 1;background: #fff;font:21px;font-family:Arial,Helvetica,sans-serif;\">" . 
		"<img src=\"" . $FrontEndWebsite . "/pics/email/RepMyBlock.png\" align=\"LEFT\">" . 
		"<DIV>" . 
		"<FONT style=\"font-size: 24px;color:#16317D;\">Rep My Block</FONT><BR>" . 
		"<FONT style=\"font-size: 14px;color:#16317D;\">Represent Community By Running For County Committee</FONT>" . 
		"</DIV>" . 
		"<P>" .
		"<FONT style=\"color:#16317D;font-size: 16px;font-weight: bold;\"><BR>Hello,</FONT><BR>" . 
		"</P>" . 

		"<P>" .
		"<FONT style=\"color:#16317D;font-size: 12px;font-weight: normal;\">Here is the link to recover your password.</FONT><BR>" . 
		"</P>" . 

		"<P>" .
		"<FONT style=\"color:#16317D;font-size: 12px;font-weight: bold;\"><A HREF=\"" . $linktoverify . "\">Verify my email address</A></FONT><BR>" . 
		"</P>" . 
		
		"</HTML>";
		
	$msg = "Hello,\n" . 
					"Attached is the email to recoved your password.\n" . 
					"Verify your email by clicking here: " . $linktoverify . "\n\n";

		final_send_mail($FullFrom, $FromAddress, $to, $emailsubject, $message, $attach, "no", "", $html_message);
}




function SendWelcomeEmail($to, $hashtable, $username) {
	
	include $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	$TextTime = time ();
	$FromAddress = "WebMinion@RepMyBlock.NYC";
  $FullFrom = "RepMyBlock Automated Mail <" . $FromAddress . ">";
  $emailsubject = "Verify your email address on Rep My Block.";
	
	$linktoverify = $FrontEndWebsite . "/get-involved/login/verify/?hashkey=" . $hashtable . "&username=" . $_POST["username"];       

	//$handleLogo = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/pics/email/RepMyBlock.png");	
	//attach[0] = base64_encode($handleLogo);
	//$message = "\n\n" . $LinkToAcceptance . "\n";
	
	$html_message = "<HTML>" . 
		"<HEAD>" . 
		"<TITLE>Rep My Block.</TITLE>" . 
		"</HEAD>" . 
		"<BODY style=line-height: 1;background: #fff;font:21px;font-family:Arial,Helvetica,sans-serif;\">" . 
		"<img src=\"" . $FrontEndWebsite . "/pics/email/RepMyBlock.png\" align=\"LEFT\">" . 
		"<DIV>" . 
		"<FONT style=\"font-size: 24px;color:#16317D;\">Rep My Block</FONT><BR>" . 
		"<FONT style=\"font-size: 14px;color:#16317D;\">Represent Community By Running For County Committee</FONT>" . 
		"</DIV>" . 
		"<P>" .
		"<FONT style=\"color:#16317D;font-size: 16px;font-weight: bold;\"><BR>Hello,</FONT><BR>" . 
		"</P>" . 

		"<P>" .
		"<FONT style=\"color:#16317D;font-size: 12px;font-weight: normal;\">Before you can activate your account, we need to verify your email address.</FONT><BR>" . 
		"</P>" . 

		"<P>" .
		"<FONT style=\"color:#16317D;font-size: 12px;font-weight: bold;\"><A HREF=\"" . $linktoverify . "\">Verify my email address</A></FONT><BR>" . 
		"</P>" . 
		
		"</HTML>";
		
	$msg = "Hello,\n" . 
					"Before you can activate your account, we need to verify your email address.\n" . 
					"Verify your email by clicking here: " . $linktoverify . "\n\n";
		
	
	final_send_mail($FullFrom, $FromAddress, $to, $emailsubject, $message, $attach, "no", "", $html_message);
}


function final_send_mail($fullfrom, $from, $emailaddress, $emailsubject, $message, $attachements = "", $mimeready = 'no', $post_headers = "", $htmlmsg = "" ) {

	/*
    File for Attachment
    La variable Attachements contient les fields suivants :
    -> title : Le filename du document.
    -> type : Le type du document (msword, pdf, etc ... au format mime : application/pdf, image/gif, etc ..
    -> body : Le corps du message (soit en binaire ou en enc64.
    -> enc64 : Est ce que le corps est encode 64 deja ?
	*/
	date_default_timezone_set('UTC');

	$eol="\n";
	$now = time();

	# Common Headers
	$headers .= 'From: ' . $fullfrom .$eol;
	$headers .= 'Reply-To: ' . $fullfrom .$eol;
	$headers .= 'Return-Path: ' . $fullfrom .$eol;     // these two to set reply address
	$headers .= "Message-ID: <". $now. "info@".$_SERVER['SERVER_NAME'].">".$eol;
	$headers .= "X-Mailer: Chino Cust InHse v". phpversion(). $eol;           // These two to help avoid spam-filters

	if ( $mimeready == 'no' ) {

		if ( empty ($htmlmsg )) { 
	    $html_body = "$message";
		} else {
			$html_body = $htmlmsg;
		}

    # Boundry for marking the split & Multitype Headers
    $mime_boundary=md5(time());
    $headers .= 'MIME-Version: 1.0'.$eol;
    $headers .= "Content-Type: multipart/mixed; boundary=\"".$mime_boundary."\"".$eol;
    $msg = "";

    if ( ! empty ($attachements)) {
	    foreach ($attachements as $attach) {
	      if ( ! empty ( $attach)) {
	        # Attachment
	        $msg .= "--".$mime_boundary.$eol;

	        // sometimes i have to send MS Word, use 'msword' instead of 'pdf'
	        $msg .= "Content-Type: " . $attach["type"] . "; name=\"" . $attach["title"] . "\"".$eol;
	        $msg .= "Content-Transfer-Encoding: base64".$eol;

	        // !! This line needs TWO end of lines !! IMPORTANT !!
	        $msg .= "Content-Disposition: attachment; filename=\"" . $attach["title"] . "\"".$eol.$eol;

	        if ( ! empty ($attach["enc64"]) ) {
	        	$msg .= chunk_split($attach["body"]);
	        } else {
	          $msg .= chunk_split(base64_encode($attach["body"]));
	        }

	        $msg .= $eol.$eol;
	      }
	    }
    }

    # Setup for text OR html
    $msg .= "Content-Type: multipart/alternative".$eol;

    # Text Version
    $msg .= "--".$mime_boundary.$eol;
    $msg .= "Content-Type: text/plain; charset=iso-8859-1".$eol;
    $msg .= "Content-Transfer-Encoding: 7bit".$eol;
    $msg .= $message.$eol.$eol;

    # HTML Version
    $msg .= "--".$mime_boundary.$eol;
    $msg .= "Content-Type: text/html; charset=iso-8859-1".$eol;
    $msg .= "Content-Transfer-Encoding: 7bit".$eol.$eol;
    $msg .= $html_body.$eol.$eol;

    # Finished
    $msg .= "--".$mime_boundary."--".$eol.$eol;   // finish with two eol's for better security. see Injection.

	} else {
	  $headers .= $post_headers;
	  $msg = $message;
	  $msg .= $eol.$eol;   // finish with two eol's for better security. see Injection.
	}

	# SEND THE EMAIL
	ini_set("sendmail_from", $from);  // the INI lines are to force the From Address to be used !
	$MailResult = mail($emailaddress, $emailsubject, $msg, $headers, '-f' . $from);

	#print "MailResult: $MailResult<BR>";

	### Will need to add debug to file.
	#echo "<pre>";
	#echo "MAILSENT : \nmail($emailaddress, \n$emailsubject, \n$headers);";
	#echo "</PRE>";
	ini_restore(sendmail_from);

}


?>


