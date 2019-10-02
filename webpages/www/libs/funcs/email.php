<?php
// Petition Email.


function SendPetitionEmail2($to, $emailsubject, $message, $k) {
	include $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	$TextTime = time ();
	$FromAddress = "infos@RepMyBlock.NYC";
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
	$FromAddress = "infos@RepMyBlock.NYC";
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
	$FromAddress = "infos@RepMyBlock.NYC";
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
# final_send_mail($fullfrom, $from, $emailaddress, $emailsubject, $message, $attachements = "", $mimeready = 'no', $post_headers = "" ) {
}

function SendForgotLogin($to, $hashtable) {
	
		include $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	$TextTime = time ();
	$FromAddress = "infos@RepMyBlock.NYC";
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




function SendWelcomeEmail($to, $hashtable, $username, $infoarray = "") {	
	include $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	
	#$TextTime = time ();
	$FromAddress = "infos@RepMyBlock.NYC";
  $FullFrom = "RepMyBlock Automated Mail <" . $FromAddress . ">";
  $emailsubject= "=?utf-8?b?".base64_encode("Verify your email address on Rep My Block.")."?=";

	$BotArray["sendemail"] =  $to;

  $to = "\"" . $infoarray["FirstName"] . " " . $infoarray["LastName"] . "\" <" . $to . ">";	
	$linktoverify = $FrontEndWebsite . "/get-involved/login/verify/?hashkey=" . $hashtable . "&username=" . $_POST["username"];       
	
	$message = 
		"Content-Transfer-Encoding: base64\n" .
		"Content-Type: text/plain; charset=utf-8\n\n" . 
		chunk_split (
			base64_encode(
				utf8_encode(
					"\nWelcome " . $infoarray["FirstName"] . ",\n\n" . 
					"Before you can activate your account, we need to verify your email address.\n\n"  .
					"Please verify your email address by clicking on this link: " .
					$linktoverify . "\n\n" .
					
					"Once you validate your email, you can share this email with your friends interested to know more.\n" . 
					"This message was sent to: " . $BotArray["sendemail"] . "\n"
				)
			)
		) . 
	"\n";

	$html_message = 
		"Content-Transfer-Encoding: base64\n" .
		//"Content-Transfer-Encoding: utf-8\n" .
		"Content-Type: text/html; charset=utf-8\n\n" .	
		
		chunk_split (
			base64_encode(
				utf8_encode(
		
					TopEmail() . 
					
					"<P>\n" .
					"<FONT style=\"color:#16317D;font-size: 16px;font-weight: bold;\"><BR>Welcome " . $infoarray["FirstName"] .",</FONT><BR>\n" .
					"</P>\n" .
		
					"<P>\n" .
					"Before you can activate your account, we need to verify your email address.<BR>\n" .
					"</P>\n" .
		
							 
					// SUBURBAN BUTTON GROUP START 
							"<center>" .
							"<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\" align=\"center\" " . 
							       "class=\"responsive-table\" style=\"max-width: 100%\">\n" .
							 
							  "<tr>\n" . 
							    "<td align=\"center\" style=\"padding:5px\" class=\"responsive-table\">\n" . 
							
					// START BUTTON
										"<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"360\" height=\"59\" class=\"responsive-table\">\n" . 
										  "<tr>\n" . 
										    "<td class=\"responsive-table-button blue-red\" bgcolor=\"#EE2E62\" width=\"360\" height=\"59\" " . 
										      "style=\"-webkit-border-radius:4px;border-radius:4px;border:1px solid #00007f;" . 
										      "border-bottom:4px solid #EE2E62;min-width:360px; max-width:360px;\" " . 
										      "align=\"center\">\n" . 
													  "<a class=\"mobile-font-22 blue-btn\" height=\"59\" href=\"" . $linktoverify . "\" target=\"_blank\" " . 
												  	"style=\"padding:13px;display:block;font-size:26px;font-family:Avenir,Arial,sans-serif;font-weight:700;" .
													  "font-style:normal;color:#ffffff;letter-spacing:0em;text-decoration:none;line-height:33px;\">Verify my email address</a>\n" . 
										    "</td>\n" . 
										  "</tr>\n" . 
										"</table>\n" . 
					//  END BUTTON
		
									"</td>\n" . 
								"</tr>\n" . 
							
							"</table>" .
							"</center>\n" . 
					// SUBURBAN BUTTON GROUP END -->\n" .
				 
		
		
					AddCountiesSpecials($infoarray["County"], $infoarray["Party"]) . 
				 

		
			/*
					"<div>" . 
			   	"<!--[if mso]>" . 
			    "<v:roundrect xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:w=\"urn:schemas-microsoft-com:office:word\" href=\"" . $linktoverify  . "\" style=\"height:36px;v-text-anchor:middle;\" strokecolor=\"#EE2E62\" fillcolor=\"#EE2E62\">" . 
			    "<w:anchorlock/>" . 
			   	"<center style=\"color:#ffffff;font-family:Helvetica, Arial,sans-serif;font-size:16px;\">Verify my email address</center>" . 
			   	"</v:roundrect>" . 
			  	"<![endif]-->" . 
			  	"<a href=\"" . $linktoverify  . "\" style=\"padding: 8px 12px;background-color:#EE2E62;font-weight: bold;border:1px solid #EB7035;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:20px;line-height:44px;text-align:center;text-decoration:none;-webkit-text-size-adjust:none;mso-hide:all;\">Verify my email address</a>" . 
			 		" </div>" . 
			*/
		
					"<P><BR>\n" .
					"<FONT style=\"color:#16317D;font-size: 16px;font-weight: bold;\">Once you validate your email, " . 
					"you can share this email with your friends interested to know more.</FONT><BR>\n" . 
					"</P>\n" .
		
				
		
					
					BottomEmail($BotArray)
				)
			)
		) . 
	"\n";
	
	final_send_mail($FullFrom, $FromAddress, $to, $emailsubject, $message, $attach, "no", "", $html_message);	
	
}


function TopEmail() {
	
	include $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";

	return 
// HEADER
				"<!DOCTYPE html>\n" . 
				"<html lang=\"en\">\n" . 
				"<head>\n" . 
					"<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\n" . 
					"<meta name=\"x-apple-disable-message-reformatting\">\n" . 
					"<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\n" . 
					"<title></title>\n" . 
					"<style type=\"text/css\">\n" .
					
// CLIENT-SPECIFIC STYLES
						"body,table,td,a{-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;}\n" .
						"table,td{mso-table-lspace:0pt;mso-table-rspace:0pt;}\n" .
						"img{-ms-interpolation-mode:bicubic;}\n" .
						
// RESET STYLES */\n" . 
						"img{border:0;height:auto;line-height:100%;outline:none;text-decoration:none;}\n" .
						"body {height:100% !important;margin:0 !important;padding:0 !important;width:100% !important;}\n" .
						
// iOS BLUE LINKS
						"a[x-apple-data-detectors] {" . 
							"color: inherit !important;" . 
							"text-decoration: none !important;" . 
							"font-size: inherit !important;" . 
							"font-family: inherit !important;" . 
							"font-weight: inherit !important;" . 
							"line-height: inherit !important;" . 
						"}\n" .
						 
// Hover Toggle Classes
						".link-hover:hover{text-decoration:none;}\n" . 
						"a:hover{background-color:#EE2E62;}\n" . 
/*
						".btn-hover:hover{background-color:#a61f2f;-webkit-border-radius:inherit;border-radius:inherit;}\n" . 
						".btn-hover-2:hover{background-color:#434343;-webkit-border-radius:inherit;border-radius:inherit;}\n" . 
						".btn-hover-3:hover{background-color:#00007f;-webkit-border-radius:inherit;border-radius:inherit;}\n" . 
						".btn-hover-4:hover{background-color:#0088cb;-webkit-border-radius:inherit;border-radius:inherit;}\n" . 
						".btn-hover-5:hover{background-color:#23720F;-webkit-border-radius:inherit;border-radius:inherit;}\n" . 
						".btn-hover-6:hover{background-color:#f1c232;-webkit-border-radius:inherit;border-radius:inherit;}\n" . 
						".link-hover-class:hover,.link-hover-class > *:hover{ color: #a61f2f !important;}\n" .
*/	
						
// The RepMyBlockBottons.
						".red-btn:hover{background-color:#EE2E62;-webkit-border-radius:inherit;border-radius:inherit;}\n" . 
						".blue-btn:hover{background-color:#16317D;-webkit-border-radius:inherit;border-radius:inherit;}\n" . 
						".yellow-btn:hover{background-color:#FCED00;-webkit-border-radius:inherit;border-radius:inherit;}\n" . 
	
/*					
						".red-btn:hover{background-color:#a61f2f;-webkit-border-radius:inherit;border-radius:inherit;}\n" . 
						".grey-btn:hover{background-color:#434343;-webkit-border-radius:inherit;border-radius:inherit;}\n" . 
						".blue-btn:hover{background-color:#00007f;-webkit-border-radius:inherit;border-radius:inherit;}\n" . 
						".teal-btn:hover{background-color:#0088cb;-webkit-border-radius:inherit;border-radius:inherit;}\n" . 
						".green-btn:hover{background-color:#23720F;-webkit-border-radius:inherit;border-radius:inherit;}\n" . 
						".yellow-btn:hover{background-color:#f1c232;-webkit-border-radius:inherit;border-radius:inherit;}\n" . 
						".darkred-btn:hover{background-color:#731012;-webkit-border-radius:inherit;border-radius:inherit;}\n" . 
						".orange-btn:hover{background-color:#C43D00;-webkit-border-radius:inherit;border-radius:inherit;}\n" . 
						".pink-btn:hover{background-color:#9e0a72;-webkit-border-radius:inherit;border-radius:inherit;}\n" . 
*/

						".big-btn:hover{background-color:#a61f2f;transform:scale(1.1,1.1);-webkit-border-radius:inherit;border-radius:inherit;}\n" . 
            
// STYLES    
				  	".gmail-show{" . 
				     	"height:auto !important;" . 
				    	"width:auto !important;" . 
				    	"max-width:none !important;" . 
				   		"max-height:none !important;" . 
				    	"overflow:auto !important;" . 
				    	"visibility:visible !important;" . 
				    	"display:block !important;" . 
				  	"}\n" .
				    
				  	"* [lang~=\"x-gmail-show\"]{" . 
				    	"height:auto !important;" . 
				    	"width:auto !important;" . 
				    	"max-width:none !important;" . 
				    	"max-height:none !important;" . 
			  	  	"overflow:auto !important;" . 
				    	"visibility:visible !important;" . 
				    	"display:block !important;" . 
				  	"}\n" . 
				    
// WEBKIT TARGETING MEDIA QUERY / WEBKIT STYLES 
				  	"@media screen and (-webkit-min-device-pixel-ratio:0){\n" . 
            
// WEBKIT HIDE/SHOW MAGIC 
							".webkit-show{" . 
						  	"height:auto !important;" . 
						  	"width:auto !important;" . 
						  	"max-width:none !important;" . 
						  	"max-height:none !important;" . 
						  	"overflow:auto !important;" . 
						  	"visibility:visible !important;" . 
					  		"display:block !important;" . 
							"}\n" . 
						
					 		".webkit-hide{display:none !important;}\n" . 				
					  	".ptop50{padding-top:50px !important;}\n" . 
					  	"#font-weight-normal{font-weight: normal !important;}\n" . 
						"}\n" .

						"@media screen and (max-width: 800px){\n" . 
							".img-max{width:100% !important;max-width:100% !important;height:auto !important;}\n" .
							".full-width {max-width: 100% !important;}\n" .
						"}\n" .
				    
// RESPONSIVE STUFF
						"@media screen and (max-width:600px){\n" . 
				  		".responsive-topbox-item-600{width:100% !important;min-width:100% !important;}\n" . 
				  		".mobile-hide-topbox-item-600{display:none !important;}\n" . 
				  		".mobile-topbox-padding-0-600{padding:0px !important;}\n" . 
				  		".mobile-topbox-padding-5-600{padding:5px !important;}\n" . 
						  ".mobile-topbox-padding-10-600{padding:10px !important;}\n" . 
						  ".mobile-topbox-padding-15-600{padding:15px !important;}\n" . 
					 	  ".mobile-topbox-padding-20-600{padding:20px !important;}\n" . 
						  ".mobile-topbox-padding-5-top-item-600{padding:5px 5px 3px 5px !important;}\n" . 
						  ".mobile-topbox-padding-10-top-item-600{padding:10px 10px 5px 10px !important;}\n" . 
							".mobile-topbox-padding-15-top-item-600{padding:15px 15px 8px 15px !important;}\n" . 
							".mobile-topbox-padding-20-top-item-600{padding:20px 20px 10px 20px !important;}\n" . 
							".mobile-topbox-padding-5-bottom-item-600{padding:3px 5px 5px 5px !important;}\n" . 
							".mobile-topbox-padding-10-bottom-item-600{padding:5px 10px 10px 10px !important;}\n" . 
							".mobile-topbox-padding-15-bottom-item-600{padding:8px 15px 15px 15px !important;}\n" . 
							".mobile-topbox-padding-20-bottom-item-600{padding:10px 20px 20px 20px !important;}\n" . 
							".responsive-table{width:100% !important;}\n" . 
							".responsive-table-button{width:100% !important;min-width:100% !important;max-width:100% !important;}\n" . 
							".mobile-text{font-size:24px !important;line-height:26px !important;}\n" . 
							".mobile-font-14{font-size:14px !important;line-height:14px !important;}\n" . 
							".mobile-font-16{font-size:16px !important;line-height:16px !important;}\n" . 
							".mobile-font-18{font-size:18px !important;line-height:18px !important;}\n" . 
							".mobile-font-20{font-size:20px !important;line-height:20px !important;}\n" . 
							".mobile-font-22{font-size:22px !important;line-height:22px !important;}\n" . 
							".mobile-font-25{font-size:25px !important;line-height:25px !important;}\n" . 				    
							".mobile-font-30 {font-size: 30px !important;line-height: 30px !important;}\n" . 
							".mobile-font-35 {font-size: 35px !important;line-height: 35px !important;}\n" . 
							".mobile-font-40 {font-size: 40px !important;line-height: 40px !important;}\n" . 
							"#mobile{font-size: 13px !important;letter-spacing: 0px;padding: 10px !important;}\n" . 
							".mobile-footer-logo {max-width: 80% !important;}\n" . 
							".mobile{font-size: 13px !important;letter-spacing: 0px;padding: 10px !important;}\n" . 					
// Rating button fix
							".responsive-rating-table {width: inherit !important;}\n" . 
					  "}\n" . 
// Rating button fix
			      ".responsive-rating-btn{display: inline}\n" . 
         
					  "@media screen and (max-width:480px){\n" . 
// Rating button fix 
						  ".responsive-rating-btn{display:table-row;}\n" . 
						  ".responsive-rating-table{width:100% !important;}\n" . 
						  ".responsive-topbox-item-480{width:100% !important;min-width: 100% !important;}\n" . 
						  ".mobile-hide-topbox-item-480{display:none !important;}\n" . 
					  	".mobile-topbox-padding-0-480{padding:0px !important;}\n" . 
						  ".mobile-topbox-padding-5-480{padding:5px !important;}\n" . 
						  ".mobile-topbox-padding-10-480{padding:10px !important;}\n" . 
						  ".mobile-topbox-padding-15-480{padding:15px !important;}\n" . 
						  ".mobile-topbox-padding-20-480{padding:20px !important;}\n" . 
						  ".mobile-topbox-padding-5-top-item-480{padding: 5px 5px 3px 5px !important;}\n" . 
						  ".mobile-topbox-padding-10-top-item-480{padding: 10px 10px 5px 10px !important;}\n" . 
						  ".mobile-topbox-padding-15-top-item-480{padding: 15px 15px 8px 15px !important;}\n" . 
						  ".mobile-topbox-padding-20-top-item-480{padding: 20px 20px 10px 20px !important;}\n" . 
						  ".mobile-topbox-padding-5-bottom-item-480{padding: 3px 5px 5px 5px !important;}\n" . 
						  ".mobile-topbox-padding-10-bottom-item-480{padding: 5px 10px 10px 10px !important;}\n" . 
						  ".mobile-topbox-padding-15-bottom-item-480{padding: 8px 15px 15px 15px !important;}\n" . 
						  ".mobile-topbox-padding-20-bottom-item-480{padding: 10px 20px 20px 20px !important;}\n" . 
						  ".mobile-hide {display: none !important;}\n" . 
						  "#mobile-hide {display: none !important;}\n" . 
						  ".headline {font-size: 30px !important;line-height: 36px !important;}\n" . 
						  ".sup {font-size: 18px !important;line-height: 18px !important;}\n" . 
						  ".logo {width: 85px !important;height: auto !important;}\n" . 
						  ".bg{padding-top: 30px !important;}\n" . 
		 		 	  "}\n" .
		 		 	  
// ANDROID CENTER FIX
					  "div[style*=\"margin: 16px 0;\"] { margin: 0 !important; }\n" . 
				  "</style>\n" . 
				"</head>\n" . 
				
				"<body style=\"padding:0\">" .
// CONTAINER TABLE

				"<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\n" . 
				"<tbody>\n" . 
				"<tr>\n" . 
				"<td align=\"center\" bgcolor=\"#ffffff\" style=\"padding: 5px 5% 50px 5%;\"><!-- [if (gte mso 9)|(IE)]>\n" . 
				  "<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"700\">\n" . 
				    "<tr>\n" . 
				      "<td align=\"center\" valign=\"top\" width=\"700\">\n" . 
				"<![endif]-->\n" . 
				"<table style=\"max-width: 700px;\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\n" . 
				
				"<tbody>\n" . 
				  "<div style=\"display: none; max-height: 0px; overflow: hidden;\">\n" . 
				    "&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;\n" . 
				    "&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;\n" . 
				    "&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;\n" .
				    "&nbsp;&zwnj;&nbsp;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;\n" .
				    "&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&nbsp;&zwnj;&nbsp;&zwnj;\n" .
				    "&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;\n" .
				    "&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;\n" . 
				    "&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&nbsp;\n" .
				    "&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;\n" . 
				    "&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;\n" . 
				    "&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;\n" .
				    "&zwnj;&nbsp;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;\n" .
				    "&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;\n" .
				    "&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;\n" .
				    "&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;\n" .
				    "&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&nbsp;&zwnj;\n" .
				    "&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;\n" .
				    "&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;\n" .
				    "&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;\n" .
				    "&nbsp;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;\n" .
				    "&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;\n" .
				    "&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;\n" .
				    "&zwnj;&nbsp;&zwnj;&nbsp;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;\n" .
				    "&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&nbsp;&zwnj;&nbsp;\n" .
				    "&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;\n" .
				    "&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;\n" .
				    "&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;\n" . 
				    "&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;\n" .
				    "&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;\n" . 
				    "&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;\n" .
				    "&nbsp;&zwnj;&nbsp;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;\n" .
				    "&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;</div>\n" . 
				    "<tr>\n" . 
				      "<td align=\"left\" style=\"color: #000000; font-family: Verdana, Geneva, sans-serif; " . 
				           "font-size: 16px; line-height: 22px; padding: 0px 0px 0px 0px;\">" .
				
										"<A HREF=\"" . $FrontEndWebsite . "\">" .
											"<img src=\"cid:CID__Reg_Logo__CID\" " . 
											"srcset=\"data:image/png;base64," . Logo_RepMyBlock() . " 1x\" " .
											"alt=\"RepMyBlock Logo\" align=\"LEFT\">" .						
										"</A>\n" .
										
										"<DIV style=\"padding: 12px 20px 20px 10px ;text-align: center;background: #FCED00;color: #FCED00;\">\n" .
										"<FONT style=\"font-size: 24px;font-weight: bold;color:#16317D;\">Rep My Block</FONT><BR>\n" .
										"<FONT style=\"font-size: 14px;color:#16317D;\">Represent your community by running for the County Committee</FONT>\n" .
										"</DIV>\n";

// HEADER END
				
}
				
function BottomEmail($BotArray) {
	
	include $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	
	return				
// SUBURBAN BUTTON GROUP END
			"<TR><TD>" .
			"<BR>" . 
			"</TD></TR>" .

			"</TD></TR>" .
			"<TR>" . 
//			"<TD background=\"cid:CID__Footer_Logo__CID\" alt=\"RepMyBlockFooter.jpg\" style=\"padding: 20px;text-align: center;\">\n" .
			"<TD background=\"data:image/jpeg;base64," . Footer_RepMyBlock() . "\" alt=\"RepMyBlockFooter.jpg\" style=\"padding: 20px;text-align: center;\">\n" .
			"<div style=\"font-size: 18px;font-weight: 700;font-style: italic;\">REP MY BLOCK</div>\n" .
			"<div class=\"FooterInfo\">Represent your community by running for your County Committee</div>\n" .
			"<BR>" . 
			"<div class=\"FooterLinks\">\n" .
			"<a style=\"text-decoration: none;font-size: 12px;font-weight: 400;color:#16317D\" href=\"" . $FrontEndWebsite . "/about/\">ABOUT</a>&nbsp;&nbsp;|&nbsp;&nbsp;\n" .
			"<a style=\"text-decoration: none;font-size: 12px;font-weight: 400;color:#16317D\" href=\"" . $FrontEndWebsite . "/get-involved/list/\">REPRESENT</a>&nbsp;&nbsp;|&nbsp;&nbsp;\n" .
			"<a style=\"text-decoration: none;font-size: 12px;font-weight: 400;color:#16317D\" href=\"" . $FrontEndWebsite . "/get-involved/nominate/\">NOMINATE</a>&nbsp;&nbsp;|&nbsp;&nbsp;\n" .
			"<a style=\"text-decoration: none;font-size: 12px;font-weight: 400;color:#16317D\" href=\"" . $FrontEndWebsite . "/where-to-file/prepare-to-file-your-petition-to-the-board-of-elections.html\">HOWTO</a>&nbsp;&nbsp;|&nbsp;&nbsp;\n" .
			"<a style=\"text-decoration: none;font-size: 12px;font-weight: 400;color:#16317D\" href=\"" . $FrontEndWebsite . "/contact.html\">CONTACT</a>&nbsp;&nbsp;|&nbsp;&nbsp;\n" .
			"<a style=\"text-decoration: none;font-size: 12px;font-weight: 400;color:#16317D\" href=\"" . $FrontEndWebsite . "/get-involved/profile/\" class=\"right\">PROFILE</a>\n" .
			"</div>\n" .

			"<BR>" . 

			"<div class=\"FooterSocial\">\n" . 
			"<a style=\"text-decoration: none;font-size: 12px;font-weight: 400;color:#16317D\" target=\"twitter\" class=\"FooterSocial\" href=\"https://twitter.com/RepMyBlock\">Twitter</a>\n" . 
			"<a style=\"text-decoration: none;font-size: 12px;font-weight: 400;color:#16317D\" target=\"facebook\" class=\"FooterSocial\" href=\"https://www.facebook.com/RepMyBlock\">Facebook</a>\n" . 
			"<a style=\"text-decoration: none;font-size: 12px;font-weight: 400;color:#16317D\" target=\"instagram\" class=\"FooterSocial\" href=\"https://www.instagram.com/RepMyBlockNYC\">Instagram</a>\n" . 
			"</div>\n" . 

			"<div class=\"FooterStuff\">\n" . 
			"<i>RepMyBlock is a <a style=\"text-decoration: none;font-size: 12px;font-weight: 400;color:#16317D\" href=\"https://twitter.com/OutragedDems\">Outraged Dems</a> project.</i>\n" .
			"</div>\n" . 
			"</td>\n" . 
			"</tr>\n" .
			 
			"<tr>\n" . 
			"<td>\n" . 
			
			"<center>\n" . 
			"<table style=\"max-width: 700px;\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\n" . 
			"<tbody>\n" . 
			"<tr>\n" . 
			"<td width=\"700\" align=\"center\" valign=\"middle\" style=\"font-size: 14px; line-height: 18px; color: #000000; padding-top: 25px; " . 
			"padding-bottom: 30px; font-family: avenir, helvetica, sans-serif; width: 600px; max-width: 100%;\">\n" . 
			"This message was sent to: " . 
			$BotArray["sendemail"]  . 
			"<br /> " . 
			"</td>\n" . 
			"</tr>\n" . 
			"</tbody>\n" . 
			"</table>\n" . 
			"</center>\n" . 
			"</td>\n" . 
			"</tr>\n" .
			
// END BOTTOM TEXT 
			"</tbody>\n" . 
			"</table>\n" . 
			"<!-- [if (gte mso 9)|(IE)]>\n" . 
			"</td>\n" . 
			"</tr>\n" . 
			"</table>\n" . 
			"<![endif]--></td>\n" . 
			"</tr>\n" . 
			"</tbody>\n" . 
			"</table>\n" . 
			"</body>\n" . 
			"</html>\n";

}

### This will need to be added in the database to be locked up.
function AddCountiesSpecials($County, $Party) {
	
	$ParCoun = $Party . "-" . $County;
	
	switch($ParCoun) {	
		case "DEM-New York, NY":
		case "DEM-Richmond, NY":
			$txt = 
						"<P>\n" .
						"<FONT style=\"color:#16317D;font-size: 16px;font-weight: bold;\"><BR>Reference material about the County Committee</FONT><BR>\n" . 
						"</P>\n" .
						"<P>" . 
						"In Manhattan and Staten Island, the next petition window will be February 2021. We'll send you an email " . 
						"after the November election cycle 2020." .
						"</P>" .
						"<P><UL>" .
							"<A HREF=\"https://politicsreborn.org/new-york-county-committee\">What is the County Committee?</A> by Maxine Harrison Gallmon<BR>" .
							"<A HREF=\"https://youtu.be/Ln0PqasXmD8\">A 25 minutes video explaining how the New York County Committee works.</A><BR>".
						"</UL></P>";
			break;
			
		case "DEM-Queens, NY":
		case "DEM-Kings, NY":
		case "DEM-Bronx, NY":
				$txt = "<P>\n" .
						"<FONT style=\"color:#16317D;font-size: 16px;font-weight: bold;\"><BR>Reference material about the County Committee</FONT><BR>\n" . 
						"</P>\n" .
						"<P>" . 
						"In the Bronx, Queens and Brooklyn, the next petition window will be February 2020. We'll send you an email " . 
						"after the November election in 2019." .
						"</P>" .
						"<P><UL>" .
							"<A HREF=\"https://politicsreborn.org/new-york-county-committee\">What is the County Committee?</A> by Maxine Harrison Gallmon<BR>" .
							"<A HREF=\"https://youtu.be/Ln0PqasXmD8\">A 25 minutes video explaining how the New York County Committee works.</A><BR>".
						"</UL></P>";
			break;			
			
			
		case "REP-New York, NY";
			$txt = "<P>\n" .
						"<FONT style=\"color:#16317D;font-size: 16px;font-weight: bold;\"><BR>Reference material about the County Committee</FONT><BR>\n" . 
						"</P>\n" .
						"<P>" . 
						"In Manhattan and Staten Island, the next petition window will be February 2021. We'll send you an email " . 
						"after the November election cycle 2020." .
						"</P>" .
						"<P><UL>" .
							"<A HREF=\"https://www.thomhartmann.com/bigpicture/thom-hartmann-mystery-concord-project-you-need-know\">The Mystery of the Concord Project?</A> by Maxine Harrison Gallmon<BR>" .
						"</UL></P>";
			break;
	}
	
	return $txt;
		
	
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

	#"\n"="\n";
	$now = time();

	# Common Headers
	$headers .= 'From: ' . $fullfrom ."\n";
	$headers .= 'Reply-To: ' . $fullfrom ."\n";
	$headers .= 'Return-Path: ' . $fullfrom ."\n";     // these two to set reply address
	$headers .= "Message-ID: <". $now. "info@".$_SERVER['SERVER_NAME'].">"."\n";
	$headers .= "X-Mailer: RepMyBlock InHse v". phpversion(). "\n";           // These two to help avoid spam-filters

	if ( $mimeready == 'no' ) {

		if ( empty ($htmlmsg )) { 
	    $html_body = "$message";
		} else {
			$html_body = $htmlmsg;
		}

    # Boundry for marking the split & Multitype Headers
    $mime_boundary = md5(time());
    $mime_boundary_start = md5(time()+4);
    $mime_boundary_start = $mime_boundary;
    
    $headers .= 'MIME-Version: 1.0' . "\n";
    //$headers .= "Content-Type: multipart/mixed; boundary=\"".$mime_boundary_start."\"\n";
    //$headers .= "Content-Type: multipart/mixed; boundary=\"".$mime_boundary_start."\"\n";
    $headers .= "Content-Type: multipart/alternative; boundary=\"".$mime_boundary_start."\"\n";
    
    # Setup for text OR html
    #$msg .= "Content-Type: multipart/alternative; boundary=\"".$mime_boundary ."\""."\n";    
	 	$msg .=  MimeLogo_RepMyBlock("--" . $mime_boundary ) . "\n\n";
		
		# Text Version
    $msg .= "--" . $mime_boundary . "\n";
    $msg .= $message . "\n\n\n";
		
		# Add The logos
		#$msg .=  MimeFooter_RepMyBlock("--" . $mime_boundary ) . "\n\n";
		#$msg .= "--".$mime_boundary."--"."\n\n";   // finish with two eol's for better security. see Injection.

		# HTML Version
    $msg .= "--" . $mime_boundary_start . "\n";
    $msg .= $html_body . "\n\n\n";
 			
		###add the atachments
		if ( ! empty ($attachements)) {
	    foreach ($attachements as $attach) {
	      if ( ! empty ( $attach)) {
	        # Attachment
	        $msg .= "--" . $mime_boundary_start . "\n";

	        // sometimes i have to send MS Word, use 'msword' instead of 'pdf'
	        $msg .= "Content-Type: " . $attach["type"] . "; name=\"" . $attach["title"] . "\"n";
	        $msg .= "Content-Transfer-Encoding: base64"."\n";

	        // !! This line needs TWO end of lines !! IMPORTANT !!
	        $msg .= "Content-Disposition: attachment; filename=\"" . $attach["title"] . "\"\n\n";

	        if ( ! empty ($attach["enc64"]) ) {
	        	$msg .= chunk_split($attach["body"]);
	        } else {
	          $msg .= chunk_split(base64_encode($attach["body"]));
	        }

	        $msg .= "\n\n";
	      }
	    }
    }
		
		
		
    # Finished
    $msg .= "--".$mime_boundary_start."--"."\n\n";   // finish with two eol's for better security. see Injection.

	} else {
	  $headers .= $post_headers;
	  $msg = $message;
	  $msg .= "\n" . "\n";   // finish with two eol's for better security. see Injection.
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

function MimeLogo_RepMyBlock($boundary, $id = "CID__Reg_Logo__CID") {

	return $boundary . "\n" . 
		"Content-Type: image/png; name=\"RepMyBlock.png\"\n" .
		"Content-Disposition: inline; filename=\"RepMyBlock.png\"\n" .
		"Content-Transfer-Encoding: base64\n" .				
		"Content-ID: <" . $id . ">\n" .
		"X-Attachment-Id: $id\n" .
		"\n" . 
		chunk_split (Logo_RepMyBlock(),76 , "\n") . 
		"\n\n";
}

function MimeFooter_RepMyBlock($boundary, $id = "CID__Footer_Logo__CID") {
	
	return $boundary . "\n" . 
		"Content-Type: image/jpeg; name=\"RepMyBlockFooter.jpg\"\n" .
		"Content-Disposition: inline; filename=\"RepMyBlockFooter.jpg\"\n" .
		"Content-Transfer-Encoding: base64\n" .				
		"Content-ID: <" . $id . ">\n" .
		"X-Attachment-Id: $id\n" .
		"\n" .
		chunk_split (Footer_RepMyBlock(),76 ,"\n") . 
		"\n\n";
}

function Logo_RepMyBlock() {
		
	return 
		"iVBORw0KGgoAAAANSUhEUgAAAFwAAABGCAYAAABBovOlAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAcoUlEQVR42u1cB3hU5dLeJHQ" . 
		"REJDeQieBEJrK7xUUC3K96lXpoCGhIxpCgBAIASlRilIExYaCoihcFBDkImKF+yMIUlR6EZFkd7ObbMpmW95/Zk7Z3bBJFvASfX" . 
		"72eeY5m92Ts+e85/1m3plvvmNwmQ24YUGayQCntg1gvI/THELbULJyZBXJKpNV0L833ADS33TgAoGq7SNbDdgwFdxy6mc++xu9p" . 
		"n1uuAFsIJb6AhrqA2jY5QxnQDMMcGjgmkLJKsOR2RJOax+4bGPhyh6sf2f4/8xUf1DDVAsNzFIGNUP7/GY6Rm04LZ3hyhoMV04y" . 
		"3HkL4LZ/Ao/rGAo9GWS5KCyEvNz5K+V/Xebyf23ASwL1ckB9LSTgsPeCWg4OUx04M5sRS3sKS925Cwm4N+BxfAmP+yKByYC6oWJ" . 
		"62YvB9ngK6I2TGP6kHJuPa/irD39/X+oFNSCgvsOfWcrD3hINZ9ajcOekEKDvwFOwER7nQWJoNhjN4gD1IushcF2q0Q2QvwsJbG" . 
		"VbWFggI4F/01WWLqXEIa8Oe39f6vWjxbFU2KluBVRzXQK1C1zWu4llT9GwX0SA0rB3fEFD/4SAIZgVh6UgrgHqVM2lg+prCqu9W" . 
		"96HXx73JRotlfRrMpQF0L5gu4oFNXDE10CV9zREnZnNiUG9yJc+Tr50ArH0TQL0G2LpAbrY30tlqAAjALqLMNUfxCt9acfwFHyh" . 
		"qxRHWaoUHexAEV9jqjGMTrIqgRqlAGobSb70OQpOGwjUw+QeT6HQZQVdG0UmukiXYBdw2EMA8DXPNYNaPNjsUpyydeemqf47TK7" . 
		"JUBbs9gXYQb7UQUPfZelOwz6WWJpEQ38J3AU7iKVnCMR0wspOYxOKuVGqY2WWerJt9L/Oy4b99Xgpv+eS9y7bcIVA5rDrzHA/nx" . 
		"2qDLOcWQRKJvnTLNp6rghUT34+POlmuE5eQMHO/ch7cytyZq+G7ZllsD42A+auo+H+zajs6/Hger48nkJRKQy6M7Otcq2mkP8Cw" . 
		"/0SBx+AxVXQD6aTZYTK1mGsTyeUV/KJZ9ngPnMRzh9Pwr5pN3IXb4Bt0qvIip0Py4NJMHccAVPLITCFD4axUX+Y6veFqelAmBr2" . 
		"g6X3FPKfCsM9hdcXcCVg0u+6TcTqKl4RcC0MdxZVGr6gCrBqSptJZiPLJ3OQOenzAgMRebmwwJWeDufh03B8cwj5730uLM0etQj" . 
		"WfrOQ2XMCzO1iYGoyAKbGAxRQCUxTk4EwtxoKc8QwZHaIQ2bUcGQS+JnRZF1Gy77ZCSuUm+Z0XVd3ork0udGObYRBiAgAxzXXUj" . 
		"SwGVQLWS4ZAel2KaDyewbZcSkUBUeqwf51feStD0fO4ihkJ94N68AUYmkyMm8fKyw1NiB2EqACKgFsJtaaWz+JzPYqoFEjFFDZ+" . 
		"H2H4fKdOTJWNxPdAGE9HSNv+ceKL3W6rjPY7E4cSsAkGcrEc6kB03W1DNeHCB/ESqBeKAf7vprI39oUuavawjanK7JG3wvLPx6H" . 
		"+W/Exo7E0vBRMNYfRwwlgBuPoaFPgLYgaxOjgOoLpthwhb1FQNVM+1z+VzUGnP/PSDfMseeocvFu93VmOCsUl2xZ+8vI54BpvEa" . 
		"GS2KRbUDBoeowRz9FQ58Y1lQFtRGB2nQ0ATqSWDqChj4B0oHAiSZAOqomgCqgmgOAGgjQkqzo/2sBs9Bzvf23xnJQwGyjZpgh11" . 
		"aeFYZfovfkPmwzusNY52kCjoYzmQ5q1DAFZLb2ipkj43wsVoDOjIwLGtRSjW6gqcUQWB+ZLq6k0FN43RWKN8O8SH67ul/AvCrA+" . 
		"R+F3eS3Hb9WQGa3IcRu9qfDVHbFXQaswsA/EFhf8x0NHQnwxv2R/fTSMguY7E6UDHOLVw6avPhdFcMdl0KE3bmvR4hPziQfrQAb" . 
		"+98BtSRXohr7byPFgEukUGyvbKLzc8Npd8Ll9sh71sa+gU35vDhzw+32ePelv/2+d3v3KVpT0RSKO2+potS4hm66Sob7peDWEFI" . 
		"ZT5DCGKm4k8j/IouLZbfGcIoftC0g9+Vq0g84crqEhOSPzTq1Y3r/dqsBs68+6aAFzKtiuCOdtnYDKZLGojbMZc3uiFgYaZsTGY" . 
		"M32o/D9A7xSHt+E9Je2Yl5y3bg+RWfY9UHe3DuQqZf3WTlu99hzpLtSFv+Oea9vEPf8v5zX/oMb9L/8L4ZZhvSlv0b85Yr+2j7r" . 
		"Vj1NXbtPu6tKxZhujOz3WUB84oA150/Ae4kwK3DepNeHk3BkSRfmbA7VswYyWAPw4+RI1ApOgXlOqUiNHwiDE0mIKxZgpih4bOo" . 
		"23E6vt17SsDY9+N5+uwZhDWdgPLNJ6Ic7a9sE1C51WQYqo1C6qKtAuWilV/AcPNIVGyZiFDaP7RpguwbRsfnY0yc/YkEZjeZwm5" . 
		"iuesUBcxqRWaXrsalsE/KMcD+Q01yJcOJYf4y7rqzm373Em09EU8hkZhdvtMMNIxKRp1O09Hotpmo2SEZtTtOQ5M7ZiGkSTxGTl" . 
		"kngIxOWocKBFqT22fhpraTcXPbKahKdnO7KajYIhENuqXCkpUHO8WA6D4LUKN9Mup1SUEtOtatdON434Z0/Nr0vnpkEtKN2ao7U" . 
		"UsJBVuVhMdnIuTqGM7uxE1SMIWkIAdLYrdo7PZlYJGK384i+5VY3ix6GmoQAHUIlF27T+D8b5mybX7nbAGd2fvia7uQnWOXG1KT" . 
		"bgzfkNfW7sbGzw5hw9YfZbv+04P46j8nBcDPdv2MSsTs6pFTEf3gfOz54Sz2HjyH1Be30Y2aIsdt1WMurNl5esKjBMwX9ZKsr/8" . 
		"OGnBvoGQpWBHmrkNhbjtcYbYqBa832Oy70+l9IbF7YfvxKN91FioTqE/Gr9EDmNPpRtPuswjcaajSchIu/G7FK2u+FTdzU5spiJ" . 
		"n4Xokp+oBx78gICCH3sfDVnfp3H28/hEqtJsnNiJ24VinDshLSSrJZD3sVivEqXYpIQSdJwZWRuhQ0lRG7RQZqCoXkYMeOU1Gd3" . 
		"MnNbSZj154TcvGnzpnQd/Qq1CB2GhrHY3zKegEx6v75wthbyE10/+di9HlyJXoPfRX/iH0d9z62BB8Ty1n2/XTikoyCWlGKSzJl" . 
		"5giYP9PnbXrOQ+3o6bip9SR8T4zXpKMmC52WKH0O02W6QsD9pWAoLA+wFByhSsHYPzZTDJbdkcxuSt8jYrC2/ViEEdj1aXg3JN/" . 
		"b5aFF6PL3heRjU1GlNbGTwO5BQNoLnMLMEAp89bumilthX8w+m9kaSqxnH37mV7MAm7LgU3FDdTuloMVdc/Do8Ddw/+AV4qL4Zn" . 
		"HAnPrCZi+79YB5zL8kezVB05EeokjBLSQFG41WpGBEbJmxm1mdQTe6gLb3Rk1GZVIndQiY8m2TUJ5AqhaRJMzkADeMhnxOrl3Ae" . 
		"HDIqwJuXQL7FjWg3krv63edgZtIqSTN3ST7mS25aN1zLgXLqajbOUVGiSgTuil8Ayu1mIhJ6r6c/Hh8Eh5PwU41YKol2SthuM7u" . 
		"dKXcao3pLUUpCZZlJAXNIgVjYScp+Hn7UQJ2bQKlSdtJGNR/Ce7s/zJqEgNZUbS8a7bUU/h14MivqEYMZqAbEsBHj/2O3y5Zxa/" . 
		"/dikLv9OWbwyD9t7GfaJqGtB+HFgb0Whp9j/P4baHX8S45A8pqJ64LOlRZvTJteTNC5jwBM1w+SeWgvtqiitRpOCwMkl0NNAzaO" . 
		"ukYDkwaiJuip6Bil1mYl7TOODwcXxx5DeUJ7DYbbDL+JIUBwMxeuqHEuQqkAuZ+vyWEmrZhXhg0ArV3UzEK6u/hY2UjTUrX4Kw9" . 
		"tLSeu+ksRYw/+nT8naFgOvs9hiQPfVOCpZjpApoiigDZaJqfiNtc+mGH6RE5xYKXDXJlTTuMBVnu4yBx5KNDGseWpCfZVfBwXI5" . 
		"ZYR5+Q7cSvuyC2HG9hqwHP3HvI1HR7yBx0e9iUcpYA59erX4+R9oJFShYFhTDZaZ1ly/m8JAuz1Fayja33YKmB1VZocExNRQWlV" . 
		"QJhjOkRTs/CTM7eL0MmuZsJt8NktBELsnqIlOhc6piG8zDoV9JqNABeXvMStJ9k2WgBiTsBYr3vlGpF29LjMEeP6OmV6BGMx62l" . 
		"BzDKamKT55xOQPJKvkgJnw3EY9KBbX9ONXknWdJL9dPkAPY5AMFylIiU7Oig4w1R9XplVBrUCVTew+TTe8ZUfKKCnZaUAg7m88C" . 
		"I6k1+BQAVn61lekuxNFtXBi0vGB+QI0+2L+rPHtM9GY2MsMrkf+P7r3fHEbRpMNLbo/J1klB9Yff7qgJDLu4jutFNOafnZ4A6bR" . 
		"EDzD/aSgJQSZ9/aDqYUqBSPiyojhikuxkF0k+zlyOE7QeZyOHgVLvceR9852fQ7TQXaOMs2L6VlStDp93izB8fxFC2WginHAZOP" . 
		"3nMbzi12PfE/7/Z6R7eOfPQH9vbdC6JSpHnfuNK//vhLAWcroVcHNTUgKjoE5KkbPLMvEnfjIQguBn0PnYWPGd4iDscVQOL49rA" . 
		"DOdXCXO6jJXi9gHhQ4XHoN3Nuw5WUz+3f+3pZbIC7mMoZLwOynAh4WMGAWz3C1UMWAW4f2kblKveZdZmDH+pUSTFJLIbDbEhE6j" . 
		"YQr0yYgTEjdIBqaJRxvP//mmMg3h8p8BmhY4lq0uXueJEhdHloo9ZROfRai2z9eRCtKcjbvOCL/U+BwyjEnz9uE9ve/QBnmXAwZ" . 
		"vxo5eQV6d6yyhfSDc9NPSQEzIODiSrgOkEtScG8tcSVmdfpMfHdkXJky3HeGXlL8FkOQ+fdkufhT502UpCSJpKseMVWSHC7F8ks" . 
		"Db/Hru2CoP14SIwPJx3tItx89/jtlmUmS6Bjqjcdr7+3WZ4jSXt4hAZeTHo4HWibqnRFSJhw8rnMEdkiAduogGC7uxEVSMOlvPn" . 
		"WT2D8F0H4tER1HSD+LZfJKufjUBVtQjoDh0qxkkBRQeQJBcwu795/BTZTuc/bIgZP3ff+T/QIeg8nZKgO76LUvZP816/eiMgVfv" . 
		"oGtiN0cF/zB9s0w1TnMEgLm5YBrgTKLQD9TmYYqScG2vi0Ifx7A5XwI8Ix6T6Bg1WfIcnnQ5s7npM7B9Y9biK1c98ghn8uptzU7" . 
		"H5G90qT2zTeC92vdY46UVvl+sDvRaiSr1v0vDhy9gKokH6vRSGE188vJdLUC6fKLAZ5ChxIwc1L8umSDBlyXgi9HwVhfqXmXVVU" . 
		"wGL9+qelA4Ng5vLPlIEIaPSuTBww4s/J/HlsiwZBfQ55dI+zlukmDLqkyezNF1d4MXp8nXxVNziDHJLyHDvfPl/oJy8ZDv1zU9b" . 
		"g2nebHcAmYA/QuWZcpCMD92ogtobDc11dN5Yf9OdnNQZP7DjnNt+agR//lktBwFZBdRsWWk/DYiDcFmNff34NQ8tf8HRtrch4Bx" . 
		"06l6+CNm/6RANyga6qUb7kAVpsYv2ffGYXZujLxn0CGBE67sh5Im8M0B8lwh1qkytvYFMZGygTxn5Xd5g7DkUHsdj2Vhi+/O47K" . 
		"rRJluovVCbsHQ51xMi95+pwJN9F3DPIDQ16R9J4zySdGvyWgOdQRsHDlF8J6Tox436qU3m/f9ZMPs9UO6iLLSgolw/yV/HY5b3Z" . 
		"ZGsN1ZmtScNBD0gvIdZM/G7u9TT8jkF73cbjnrMbglH+hEqXi7EZ4Jr5TnwUIJV88Y9E2PBz7Ogw1RmPCzH/h4WGvq2n9RHy6U+" . 
		"k9zLcrVb4PN/8AA7mkRhRMWd2s2/SDzmxv+1rhZV2y4r/tH+nNmg5TycVAgx+780gK/qc2gT1S2tbKLo0vXaGYKOHJbTEYh+e+j" . 
		"5o90lCNGNn5wQXY9uVPMpHAioOVRVizCeg14GUBmGdoWP51Ic3tVDW5xt5nZmwQoHnq7ZG4171gC4cDge3TJZv7XLFTapcBrrFb" . 
		"C5bZk+6CqYHWTRVXjMWWrXERq90woNNwJMeuQMUO06RtYQG5hT37TsPQ4BnxxVz7rkasP3XWiNjE9wVQmUwmLc5AaYkQp/hc+2Z" . 
		"Xwt9v3PajVASlHFsYeA2QR2uL4JuW/YSaYYYEx3CHJgXPVlI6YZnZpE6kITOgxfm0FV9/M0cNh4V9ePRItL4tFbU6z0BNaVew4Q" . 
		"NyBayvecIgpOGzeO/jfVIr4YSIgymrFK6xaIDza/k730jA5FER0et5qakUV0MpWjuXOUxzY3UO0xAcwx1aJ+yc22CsOgHm5qOUr" . 
		"qomAazpWJiaKE2T2sqE62v9cYl+19W4L+Y2iYOh1RQYbh2LAWPfFiDiZ22kv8cRy8dj8NOr5bPxpEA4iBrqPS09KdqMPgNqy7Uj" . 
		"gtJ8ziYNtcZKDPAtyZa0LNBbkq0SVMAUwJVVuUo3LPebWOPuR9bYe5A1plcAuxeWUXchc9RAWMetgGXsYljGLdHNOm4psscvlYV" . 
		"NmvFn2vdZZDay7Ksw7Xh8/CzaFoxfgunPvo0h5CoGjXoL335/WkB8+e2v0Z/kILcvZFGywzqc6ytDSYcPHLMKB49cEDDt6vqf4y" . 
		"QNB415G0+R9h5IN41VTdFmzsCAq00/9g9UVoeKO3Gag2C4tlZSWzYi63HsRYw+c1JQBY0EYCPK+hVsO2bRCuCVLh8pdVmJvg6zn" . 
		"K5USvXh+nNA1IWpRdenu8gKLoXCk23Aoe9bIWXBTsxbuk2G39yl22U7f8Xn2PDJfpjNOWpDupKVvbvhe8xc8ClmLNuBzS9RZrdo" . 
		"HWyL1yPvpY/I1pdsizcgd8E65FPqrjTYk+5lALls6vbosHPNe9lbX2HI+DXoTRljnyGvYhgxlntGxD2o02IcPGfM3yKNmbPpnC3" . 
		"WPEn7+cUdVSwj5yz9NxJmf4xjpzNKXHLoncPsrS4rCS2xhhKQ4SWZnVSMh9j/SMwQGOpOQ5XWCSgfPlE0rRgFnfKN48Ufnv3VLC" . 
		"d66oxRikUVuKEyPBEfz/oAjmYDcIkXTnEMCMJnGxv2hZETnN+MCrO4cVIFu4DcwswXt6EBBUMuMvEkMevsyq25z2QCapA8ZBeiV" . 
		"f7iybUYao+V5s5uDy3Sk54PiCisUFjdcCXxBSIPB1TfieLAAdNNQIcH7JINujwbyOzE+kJyN/t210fVNrPQ6LYU1CQpxjULzty4" . 
		"rMkFoUbcNEmg7/jqZzmxRGIKzyvyxC030RS6XDD3iIe53TBZ4mfWlvsVY1ycyuw8StZe2td/pSQZqrJgdnJplYMdF5h44ldpylS" . 
		"qgeF3zpbMcdZL2wQcViYypUbnyTWVDVsPynGmzNtEWeVkUSltSbd/t/eUH6iB2a0FzCP+AdN8jYD7shsOA4aO70vsSSMQ40UNnC" . 
		"AG8/TVrJc+E4bXI3nGlmGyIdOSK1qYpRbLtLUb9ipAUQCUZYEk76SmXYLe1pcBNugH25SVSqJCgGfb8nHXE0tFM/MNb/m3OVi9f" . 
		"q9U9JaQa6lMepv7Ugy3jMbkuZ/I7y5b9bWcB5Mjqvd8OsdsDBz3jrQ1Myl69ntZptY0BVPSOny9JGvfoM5hKsu6/xCGFzC7bQYc" . 
		"+fFWOtlUYutUtPjbbIny2otPnJMKHo6arHqe/CRneVzob3/fC8jNUZps8t/fKTXsTNLQpbU5a9+beL1mzwlw2h1emdc4Xm5mo26" . 
		"pOHkmQz8X9ufh3Z/D7Y+8hIcGrZDRxstE7nj0JVSjLJNdTsyEd3FPv2XS7MPtEGOTP9Tdi+/0XPHuRM1Sc2frATMY/x0UwwvSFW" . 
		"UyduojNOzmka+bgqgH5iN+5r+kpeAOurDKNCRrRk7F+Gkfwe1StW2vNGEZg77kza+UAMMrj09dlEzR7MPuUpcC0vuM8MHAyQv48" . 
		"uB5VAxXJhnCmibgw80H9DlHbW4y22b3a9rZ+d1xKVjx6NNalbkiWD0iSdySN3P0lOpOfAOm09pLfYJQaKkJT1B9KQV0EA+x++zx" . 
		"6tJ8XidaKeyHNZsoSQIHHz7xSi0nISlts35CPFPCqwuYgeHdZ4m/5WDnUS/E8lCyMjUWxFpMkzbRUPdx2FdvR5/4tahC7ot/l+v" . 
		"dbjWIetQlglqA9O1oHfLMagns7OI4OHKvIL/nugkHT6e66CqY9T/egJkPZ2YrfZYnGHdSKsPz2Xd7DJg2936EhacR6FPQ7p403D" . 
		"dgOXoPfkXadpWbkCwTtpxa88Uz63nVAAei5Oc3ewtBUrsAcua8C2O9JxT/zFNlJTGcV6fR+1xyK/vvS0LVbrPQsLMyFfba2j0+3" . 
		"auBWxnOUIxht1ZHbeDk4lVbugZ2Jfx549tn4ay6/scdxJpOPWA6D5AbKe/NYa4laOpdV5R9Gs9XRpPbudt/JjF5IvYeOKf/+Doa" . 
		"zloNgn0pT2dt3fWTuBEevqxOuE9bWaZHoLiUoViwY58ETlmFXNqSFXWlQ3b7WJxuHYMmHZNRi6fQiKUcJB3kOjT/u47k3bQXtmA" . 
		"G6f6lb3wpKn0mBXSD2mtYg1wIl115QkJKsbfNFCn5jbr2x+V2B/UcFCVgblYrhKF6HeWaGC7sdhqwYMldBOoLNPwSEEdptO+PD3" . 
		"lmjfjBCqTHn6ZAxi+Wf1UoMPGFjJn2UZHGR6WLyWPNkdYGc9uYoNfyZJA5I2PwWMdEVOw0A7XJtZ08a/RblVCRbj4rFEPVEXhtz" . 
		"XfyW9zawDee25h5hRq/Ptl+WHw6175Zxmq1b44/JbsUtWmTb05Okj7DE2zALL5NwqQ8diM7vQK5igQaeqkU4SfJEg2e0V60cqfU" . 
		"jKtFTBH9y6VNo9mGHw6fR5VWidIqxmqG+z569luKHiTh7h24HJ1JjiWnbZKZEstTaZL88OphbWl4sRY5TBrwCyOfwsIO46Wf8Bb" . 
		"S3CzlFr36BQaTj65O51KXfjesaTwSZm4QeD7ccoCk4wRpW2M7/5uZboIbR49fpGtKlsph+eYJSH1xq5yT2+VSn39VgnkUt+i03q" . 
		"8+HS702l2KnZWJ24Blb9xB8ut5SiS4eZ1PjqVfPAz1nqWAmUCyKhHt7p6P/Yd/lwscPP5duuBEcjGppFB4IjeZ5OIUYl2SbENp/" . 
		"/98r7gk29JNMNbtC3OHkTC1i1Va6Ioz+t5I2zxKmPa0G4WbZZVaMgW/ifR74+m8Euk3pspvJ87eAo/y3DDcN3glKrdJIheXSKPz" . 
		"Q52n2TYnJWoz5RzLhU/C4yPfVksApT+4QOnI4oDZWg+YrmsBnAW8m9htM1ZAtz7P0EWlEoO59WAaGnZNIX8+A216pKJn/8XE9q2" . 
		"wZnH7QD5+OXEa9aJpv87TyH+zTaf/SyGbLv9To+0kAoNLo7kkD7PhPHoUplaDKQGKk4lq/UEIgSyKbkiHWGUWKioG7dumkA+eT0" . 
		"C+gPItFqBu9AzcN2gJtn/5vRyfIMX+Q8fJ7SShYbcUGZ3ffX+EgMqCx51FktGK7o8sRC0ahTVoZNzzxGJiN32nfs/PLAxkHreFQ" . 
		"LdRwNwjD0BzldAle0UuhQHPuVgOvxyqg+M/1cbxo75WC6Zz9ei62hIlIuG2NIcjMxzm8w3x86GaOHH01iL7K/bL4VrIy2hGzAhX" . 
		"rTkKjtRQ7HAN7/sSLP/ILfD8VA0HdjfCunVRWLM6Gus/jqCkrD7d8zYUjdvBbmxKw7050s81oPOpheNHauP0L3XkHLXfdtE5/3q" . 
		"yHp1TbRyjczv9861wmH3PrSRrQQA38O+w+iNUCoMO0uDIvtwKLcqj7vIvaU+5VD4rbn8xm8/j87QTzb5y42e0INcgpQbdbEpGzK" . 
		"5Q6/r1O5+sy4txsPqfbzAFvMseCmy68gdDGEp6YqbDGNiUfZRnOTm1rRqtSzLex+9/jIYrNpccKwT2DMUKMkJ8GiiLPx/tc80cv" . 
		"tdnuvz70uxqQTf8lR/yW9zff2a78cD2G4DfAPyG3QD8r2v/B9VUHt8EFQd1AAAAAElFTkSuQmCC";
}


function Footer_RepMyBlock() {
		
	return 
		"/9j/4AAQSkZJRgABAQEBLAEsAAD/2wBDAAoHCAkIBgoJCAkMCwoMDxoRDw4ODx8WGBMaJSEnJiQhJCMpLjsyKSw4LCMkM0Y0OD0" . 
		"/QkNCKDFITUhATTtBQj//2wBDAQsMDA8NDx4RER4/KiQqPz8/Pz8/Pz8/Pz8/Pz8/Pz8/Pz8/Pz8/Pz8/Pz8/Pz8/Pz8/Pz8/Pz" . 
		"8/Pz8/Pz8/Pz//wAARCACbA6QDASEAAhEBAxEB/8QAGQABAQEBAQEAAAAAAAAAAAAAAAIBAwQH/8QANxAAAgIBAgQEBAYDAAICA" . 
		"wEAAQIAEQMSIRMxQXEyM1GBImFykQQ0QkNSgiNEoRRiU7GSwfDR/8QAGQEAAwEBAQAAAAAAAAAAAAAAAAECAwQF/8QAOhEAAgEC" . 
		"BAMGBgAGAgICAwAAAAECAxESITFBBHHBEyIyUYGxFEJhcqHRIzNSkeHwgsJD8WLSJDSi/9oADAMBAAIRAxEAPwD7AMtqTp5GYMi" . 
		"lCSm04fiYytijs+pphYLYwotdjvU3/HqTY30gpUG7WtoK0ijjByB73k/4+IW17zSdOnDxO13cE29AqqEZQ43mcMaNIcc7mfYwkk" . 
		"oy0Vgu/IHESigMNobETkDWK2ifDS2fl+EPEgMbDIW2o3JGNgjCtzUh8PUW3n+UGJDQwxkaTdzCrDEBR5zJ0ppZrbqVdGODoTboZ" . 
		"0z+FRKs1CfKIt0X4QzTidAAOk7i+c1r4ErSV9/7sUb7F4dPxFQRt1nMDGSN2+0zl2ThDVajzuzrmAJFtXtOWlf/AJB9oV4QlUd5" . 
		"WfIIt20KyLbn4l9zMXGdQ3U79DJlRvUbTWvmCeRrI5ckevrOmEML1X95tRp1Y1bvTPcTaaOWRWOQkKYAIxNseY6TncJqcm15lXV" . 
		"jnLHkn6pjDfkxs1SBi3F23rNJThr8Jok9Z0KUFGzW3mTmG0aVsNy2lYdNtpvl1mkOy7VWvf8AwJ3sc18t/aP2T9U51ouT92WD5S" . 
		"9zDEjGlH1hdq9vJdBGs7BUpjynR3K41I5mdMKs0pO+iRLSyOfGf1H2jjP6j7TD4ur5lYEbkZtQFmqEz/Z/tKlJynm90JLIzH5h7" . 
		"GE8D9pnHb19hhfKf2lJ5Dy6eq+19QZI8pu4j9n+0zWnp1AHyl7mG8Ce8Ho+S6AMnJPpjJ4h2EJ6P09gRuTz/cR+/wD2ly8T+4Ng" . 
		"nn+5m/h/Ge0ql44830E9GB+YPcx+H8R7R0/5keb6A9DcPJ+0hfLf2k/JDlLqPdgeU3cR+yPqme3p1GG8pPedSpfCoHynRSi5uUV" . 
		"ul7IluxhxMUUWNrhsTFVFjYS3ws3fNaLoLEjcq3psgV6zMy2w+IDbrHVp+O7WdgT0OeTzj3lD8z7zn+d/d+ytjR+ZMxfzB7maPb" . 
		"7hfonHzP0mV+H8TdpnQ8UPUctGbi8t5C+U/tB+GPJ9RbsDyT9U6L+WMqlq/tYM5jym7iV/re8mno/tfuNh/wAusl/AnYwqb/aug" . 
		"IPyT6Yycx9Imc9Jeg0UfzA9pp/M+83/APsT+jD+Z95OPzh3Mj/yf8v0PYY/EexjH+r6TM4fL6gwngftLw+B+00o+KPJ9QejITwv" . 
		"9ML4H7CZx0XJ9RhfKf2geU3cQWi5PqA/Z/tB8pe5ht6dUIpvyy95P7I+qaVP+qBA+Uvcw3lp7yHo+S6AH8Cdoyck+mKWkuS6Ahk" . 
		"5j6RKz/p7TR+Gp6B5E5P0/SIy+P2Ezn83p1BDJ5x7iafzH9pUvE/u/YBfP95mLzR7wj4o/d+gYx+I9jCeF/pkw0j6+w2REwGddK" . 
		"8M03M9RBQ6AoIJuzvO3sk13HfLlqRfzMyI2rZTQFCVyyj/ANVjwSjNtrdBdWMxZdOzcv8A6m5cX6l9xBfx6Nt4h4WcYnCWW/gTt" . 
		"GUniHczok2ou309iUTqYfqP3lq7cNjqN2IU6tRPXZ+wNI3iMMd3vdTTlYIp2s3N1xFRLXb9Cwo05WGnYbi5WV9FbXc2+Ilhk2tL" . 
		"fknDmjcjhVFi76SGdBVp0uOrVgm1KN7WBJ7FIU0MQtDrIXhFhQN3tJcqDUbrkPvFZQhI1mjJCYydniqU6Epu8rME5JGtjVmJ1gG" . 
		"FxUwOoGjF8NFzxKW4YnbQk4WJJsTpiQopB9ZVHhpU6mJsTkmrHNkyaiR6+s2sgx9bv1map14tvqO8WTeX/wBvtKLPw7I3vqJMZ1" . 
		"1fF7DtHYwuRjUlRuT0hmGhbVd4nVyeKK0XQLB2UaQUvYdZWEqS2kEbesuEoOslhz5/QTTsc18t/aP2T9U51ouT92UbpLYlAF7mX" . 
		"w7RdRqptCi53byVln/YTdgzY0C7attp02ZRY2M6qbptuEV5epDvqQUxDnQ94KYvlv8AOS6PDf6x3kay4yRZF9404+Jd/FfrKwUL" . 
		"67+e4XkAuMNsRfeYFx0aIrrvEqdDz89/7heRoXHpNEV13mgJoIB+HrvHGFBaPbz2FeRIXHpIBFdd5unHoqxV+sXZ8P57eew7yGn" . 
		"HpG4q/WYVx0LIrpvDBw/nt5heQZcdCyOW281lxk7kX3g4cPnd/kLyBGPXuRq7xWPXdjVfrG4UL5+fnuF5ADHr2rVc1OHfwVfyjg" . 
		"qCaw63/IniAGPXtWqECWdFX8o4qjdWtfqHeC6KOmvnMAxaTVV1hahZab/5DvD/ABaTWmo/x6f01cVqH0DvBuFpF1XSUfL+AdNo4" . 
		"9mm+z1t/wCgz3PPpyf+0f5P/aea1XXmad09BClRrr3mPov46v5z1JKnZ4/UyV9jG4ererm/49fTVcj+Bfa9/wAj7w+DX01QOHr2" . 
		"rVK/g/TX8hmYvCv4a5TU0b6K+dSYdhdYbA8QXRpOmq6zBw9Jqq6x/wACy0/3UO8P8en9NXKGjRtWmEex2tp+A7xP+LSeVTfg0dN" . 
		"MF2G1tPwHeB0aBdaekHh0L010g+x3tp+A7wPD2vTy2g8Prp5QfYZ3sHeHwat61Tfg19NUq9L6a/kWZnwa+mqBw9W2m4r0b7Xv+R" . 
		"94A4720wDj3rTy3iToZWsHeAOOjWmusLoo6arrUcXRbWGwd4wcOjWn5zRw6Naa6yV2G1g7wHDo1prrH+PSfDUP4H0DvD/Hp/TVx" . 
		"/j0jw1C9D6B3gdGgXWmP8en9NXKbo720/Ad4f49I8NdIJx0L010ivQ+gd4E46F6a6QTj2vTy2g3Q+gd4E4+unlNYptqr5XHejZ6" . 
		"fUMzCce16eUE47303E5UM72DvAnHq303F49XTVceKjfbX8h3gDj1bVcA47203BSo5Wt/kLSAOO9tMA46NafnEp0NrBaRmrF/6xJ" . 
		"x8P8AQLSOdAEA8kFnvJT4supu5nG1aUY/X2y/Zexukk2HX7yyxDZN9gJUMVNXUr/+mDsyEKsfiUbb2J0xuLY6tudEcpdGpG6ejf" . 
		"8AZ/oTTGTECLXnOBUqaIqZcTRwSxRWQ4yudDppA13XSRl8xu8irhw5a5ew1e4VGbkJ1GKsZDMBZlUKEpJylkhSkOFaABhzuGxMV" . 
		"UAjabvhW08L2FiMbGxK0NgAJeRSzptsOcrsZpSTWrQYlkRnDMwoEgTHNUCgOw5zKrijOUnG6yGtEUpHBY6aHpchChcUpBv1hKVO" . 
		"8E4+W/1BJ5lZtOsaruukgBNQotz9JNXsnVd27gr2NcIXa3o36RjVdYpwd/SJQp9pdS38gu7aGaN9nX7zriBUkEg+8uhTcaiakmu" . 
		"YSeRmQZNZ0k13mMzqgskGzKm61NylfL/IlhdjOIwx3e9zeKwxg7WTJXE1F/YMKNOUhVNDeTxvVBHLi2nZq+gYDeKp5pLDKrMAtU" . 
		"L2lwr05PFhzBxa3JBxlWpSB1jVjCWFsXy+cFOhZNLYLSJOZuSgAQVZ0T13u5jjqcReK0/yh2UcyiqKF1nkOU3Mf8Yra5vJRhCST" . 
		"ztmTm2jk3lp7w/gTtOKW/JdDQZPGOwm/wCz/aX83/JC2GPzD2MALofSSduohBRw565+wO5i+U/cSk8h46eq+19QZI8pu4j9n+0h" . 
		"aLl1YA+Uvcw/gTsYno+S6AMnJPpjL4h2EJ6S9PYaNfz/AHEfv/2ly8T+4WwTz/czfw/jPaVS8ceb6CegX8we5j8P4j2jp/zI830" . 
		"B6G4fC8hfLf2k/JDlLqPdgeS3cQfJH1TPb06gG8pPedWYrgUg77TenJxxNf0r2QnscuK/r/ybxn9R9pmuLqrceBFZ/wBEz8R4x2" . 
		"mtZ/zPQS2JyeafaUPzPvM//I/u/Y9jR+ZmD8we8v8A+4v0Tj5n6TKwcn7SKHij6+w5bjF5TyV8p+4h8seT6hux+yfqnQfljKpav" . 
		"7WJnMeU3cSv9b3k09H9r9xsN+XWS/gTsYVf+q6Ahk5J9MZeY+kTOekvQaKP5gdxNP5kTfz+4n9GH8z7ycfnDuZH/kX3foewx+I9" . 
		"jGP9X0mZw+X1BhPA/aVh8D9ppR8UeT6g9GSnhf6YXy39pnHRcn1GF8p/aB5TdxBaLk+oD9n+0Hyl7mD09OqAo/lh3k/sj6ppU2+" . 
		"1CQPlL3MN5ae8ze/JdAD+FO0ZOSfTCWkuS6DQy8x9IlZ+a9po/DU9BeROT9P0iMvj9hM5/NzXUEMnnHuJp/Mf2lvxP7g2Cef7zM" . 
		"XmD3ij4o/d+gGLxH6TCeF/pkw0Xr7DZETC4zuzm1WhZ52JlqA50irrbrPRdRNtyV7fozt5EDhlhsw3lkKeJ8XM9RymcFScXbLny" . 
		"Y3ckjRjqwS3p6TD8OMDq28zksN15L3/APYz0qKUD0EMaUk71PW8MORlqzk2XGSLW5SsjbrWr5zlhWpTlZLMpxaQIynqo7STj+Ci" . 
		"293cJUqk23OSSBNLQHF8CjUNpnBPR5nLhbu6l5Dx/Qsqxaw+3pLo6rvap1QhJN96+ZLaJPEs1pqaS97KCO8L1lfJMMhZ07rv6TB" . 
		"V+D/6lPO14+wvU0qrHdbkHEgN3Uzq0Kcu88hqTRjHEGNgk3C5QXChQAZh2tKnPDBZt6lWbWYVyzVw/eWpOvwV85rTqOdm4biatu" . 
		"H0WNde8hmxhR8NjpCpKjFu6u9wWIFsegfDsYLY9C2po8pljoZ3jsug7SDcKluxttJ04T+oyZLhpPN2BYhoxnk8vRe6sD8NSoUaf" . 
		"ySuDb3RK4mCMNt/nNGMDHTtQu4o8O0ljdkl1DF5AsiKCq3fWS7sUU3V+kU6qjFwp5K36BK+bJfwp2nXKQMa6hfvJg0lNvPJDexD" . 
		"FNC/Btv1hmXStp09YnOnn3dlvyCz8w5XWLW9h1m2vGrTvfO5eKni8O63FZ+ZilSxpaNHe5OOtL2LFcplii2mlZZ+xWZQK8Nvg2s" . 
		"dZSMvCY6dvSbU507ru7PfmS0/MB00E6Nr5TOIlVo2g69JJdwML8zS6aAdG18oLoFW02PKN1qWfc2XQLPzDOgC2l2Nod0B3S9oSr" . 
		"Ule8PILPzDOgyUUs3zjWnErRvfOU6tK77u4WfmaroclBN75xjZWYhVqOFWm5JKO7E0/MBl4tad/WMbKxOlajjVpuSSjuwadtTUZ" . 
		"SrUtVzkh0KsQmw6RdrTtF4dmFn5gOmgnRtfKNacO9G18pPbUreDYeF+YLpoU6Nj0lMyjECVsekuNWm793YVn5kl0Cg6BvBdAAdA" . 
		"3Ezdakr9zZeQ7PzKyMq6bW7mZHVWAK3NZ1YLFeOlhJPIxnUPRSz6zQ68XTp3vnJ7anith3t/kLO2poKHLWn4h1mB1OWtO/rH2lN" . 
		"aR1dvXzCzMTIpJpK2m43Vg1LVRU60JNWjbUGn5mo6lGIWgOkkZF0E6BQ6Q7aFk8OzDC/McRdF6Nr5Sgw4WrTt6RwrQekdr/4Bp+" . 
		"ZIyLoJ0Cr5StY4WrTt6RRrwd+7tcML8wXAxBtO3pJORQqnQN4TrwXy7IFF+YbIoAtAbFw+RQRaA7SZcRBX7vkPC/M0uOIF07+s0" . 
		"uOKF07+s07aP9O9v8iszC44unTvfOYuQF6CAfOT28cVsO9gwu2oTICdkA2hcgN/ABQuTHiIO3dHhfmFyAqx0DYSkcMrELVSoV4y" . 
		"aSjrfqJx+pK5AQx0AUIGQFWOgbSVxEXbu7MeF+YGQFGOgbdIGQaCdA2PKHxEcu7t+ww/UcQaL0DnVQcg0A6BueUPiI/07Bh+pWs" . 
		"cINp29JPEGi9A51UqVeK+Xa4sIOQaAdA36QcgCqdA3kviI593ZdB4fqGyABToG4hsoAX4AbFwfExV+75Bh+ofIAR8AO1ysjha+E" . 
		"G5Trq0nh0sLDoS2QCvhBsXD5ArVoBky4lK/dHh+obIBk06Qd+c3iDiadI51cb4hJtYd7CwmLkByadI584TIGatIEFxCbXd3t7Dw" . 
		"hMoJPwgbXC5QQ3wjYSVxKaXd8ww/UnjD+AiZ/GL+geD6mq+piSosC7mFhwxajc3tDtVKLbit+iC2epiBC4okG+RlabBAYG2vnCM" . 
		"ISj3H56g275mMpbIBRC8vaXiIZ2P2lU42q95av2QnodZzyvpFdTynbWn2cGyErs81GrraJ4bTRuXlJ11fIAQfJXuZvJ96f8Au5O" . 
		"yNZCUSq5dTM4Z9V+8qVCUndW23+gYrAJR8a/eeljSk3U6uGiqcZZr0Ik72OGPTq2cn2mWo/W857wjFd976ehWd9DpqHBv4q77yR" . 
		"lPRWPvNpVsLikm8luJRuWNXG3Pw95DheLZbf0AjqRvD+I9wWuRLlQ7fDZvqZuNyXAAAF9BMFUSqWgt+bHbLMwrkPMmvmZuNayAl" . 
		"hfoIKE8alUds9/0F1bIvNpoFr9pzJBxfCKo+s0r4MclbOwo3sjG8CdjD+BO05pfNyXQo11JIoE0ok8N/wCJjnSqSk2kCaK0Kppi" . 
		"SfQCVjNE6UrbrNYRjTmrK789hPNGBnKNd9JlHhcjeqJupNXl5P3YZIxgeEux5mawPDTY9ZDjLPLZdB3Dg6U2PKX+I5KJrZqnO/0" . 
		"FuiGB4abHrMcHQmx5ekylGWeWy6Dua4OsbHkOk2j/AORdGrl4ZYtN0K+RmMEZCaPI9JoLFHBXp6QhjUcNvPb6A7GBTw22PMdJSg" . 
		"8BhRuOnCWWWz6g2SAeE2x5jpI0t6H7TGcJWWT06spNFkHhLseZhgdCbHl6S3CVnlsugroxwaXY+H0m5AdQ2PIdIThKzy8gTQcHj" . 
		"XR5iKPHujWr0lOEsTy+YV0agPGujVmbgBDmwRtKpQkpxy3fQG8jFB45NGrM3ACGNgjaOnGSqLLd9AbyGIEK9giSqnhvsenSTglh" . 
		"jls+oXV2Ap4RFHmOkFTwgKPi9JGCdtNuo7oMp4a7Hr0luDwAKN7TWMJWll8q9kJvQhlPDXY9ekOraE2PL0mUqc7PLZdB3RWYE6K" . 
		"BMZwS4oE7TerCTx2XkSnoTkUnKSAav0lAH/yLo1chQlj0+Yd1Y1Qf/IJo1JCnjk0asy8EssvmFf2MxqwJtTyPSVhBAawRtM6MJK" . 
		"Ubrz9htoYlIxuCDJCNw2Gk2SI+zm4xy2YXVzdDcIjSbuWFP/jkVv6SqdKavdfKJtHPS3CI0m79JWk/+OBRu+UmFOaTy+UbaDKeA" . 
		"oo3JZWKJ8J5QqU5vRbLoCaDqxC0p8MZFYsKU8hIlSm08vIaaKKtxgaNWN5pU/8AkA0a9Zsqc88vmJujCrf+RdGr5zMasMgJU1J7" . 
		"OeNO3zfod1YzGjBjankYRGGq1PhMzhSqLDl5g2gqMFf4TuJeJSEewd5pSpzUo3Wz6g2rEIjBXtTuIVG0P8J3qRGlUyy2fULoKjc" . 
		"NhpPSAjcIjSbsQVKpZZbPqF0NDcKtJvVBRuGo0m7MOyqW026oLosq3AAo3fKRobhAaTdy50pu2XyoE0CjcNRpN2YZG4aDSdrkOl" . 
		"Uzy2XQLoMjFU+E7CHRiFpTssJUqlnl5BdDIjEilPIS8ysStAnaW6U8M8tbBdZEZEY6aU+ETciMX2U8hInSqPFluuoJoOrHLYBq4" . 
		"0Nxro1qlOlPE8twugqMM1lTVxjRg9lTUUaVS6y3/QXRmNGBNqeRmqjBWtTuIo0aiSy8wuiOG/8AExMfh6v9JWJFhg9rVFuoh2Kt" . 
		"VWtbA9Zu6l4dpFfRr/fMm2djPhVda3vsAek5zCrhVlHTX+5SNDMORInbC7MxB325zXhqs1NRvkKSVrnacPxBBIHUTu4ppUmZx1I" . 
		"R9Ox3U8xN4fxit1PWefFdrFLde3+DR5Mhjbk+pl/CMS6hfOhFBxcpSen+UD2MpshutvsJSrSsCw5dN5UISk8cmle4N2yROlP5/w" . 
		"DJ2cg4QSTXymtFU4xmlK+XkJ3ujmmjWK1X85NoD4Ce5mV6Sgsm8/0PO50Vv8LFQBXTnIvK3K6+01nKpJRVNWutv2JJbl6az2WHP" . 
		"lGTSMgJu/lLlGKhLE99hb5EOwDmkF3zO8pDkLCwdPaplGc3UtTVs/8Acx2VsyCm/wATgf8AZq6AwosTfaQowhK83d/T9ju2sjtl" . 
		"uhpUE36SQjspD0L5TtnCpOo0ll/ghNJG8JSBZOwqaeGtXWw2j7KlSWKQrt6GNlAYLRuZxf8AJp09ailxKTslvYeEoMdXIV3kLmL" . 
		"XtyFwlxEotJrX6hhNGW0JrcdJnGOjVXWpPxTsmltcMAOYhAa5wcpCqa5yXxbzy2T9v2PAGzEBTQ3Fy3fSoaruWuJupNrSwsJBzE" . 
		"Kp084bMQFNDcXIfFtXy2X5sPAa2UhgKG9RxTxdFDnUr4l3tbewsJi5SWIodYXMSrGhsJK4qTtl5/geADKShahtKGQnEWrlKjxMp" . 
		"bbNicSRmOgmhsY4x0aqHOpK4uVtNrjwA5iEDUNzBykKpobwfFyzy2T9gwBsxULsNxcPmKmqHKEuLkr5aWDAa2UjJpoc44p4mmhz" . 
		"qN8VJNq29hYQuUnJpqMeQuxBFbSocS5SStq2gcSgz6607esIzEnUtTWM6jaTiKy8wjMwNrVSBmJVjXKZuvKKTa1v+B4UOMdBauR" . 
		"qOMdGqutTP4t202uPADmIRTQ3lM5GMNXOWuIbTy0VxYSTlIRTQ3hsxAU0NxIfFyV8tl+bDwFZMhTTQ5zMmQowAANzSfEOOLLS35" . 
		"Eo6GNlIfTQ5zRkPF0UKuT8TLFa29gwmjITlKVtMGQnKVoSviJZZb2DCYmYsTsOVzceQuGsDaRT4mU2k1rcHGwTIWRjQ2mDKxQmh" . 
		"sRB8TKydtU3/YMKAzHRqoc6lazwtYG8qHEOV8trg42MGQ8IvQsRxDwddC4fEStp8twwoHIRiDULMxsrBVNDeTPiZR0WyYKKDZWA" . 
		"XYbi4fKykAAcrkS4qavkth4Uach4umhU0ueNo2qa9vL82FhRnEPG0UKuYmVmeiBJ+Jnitbew8KsYmVmJBA5XCZWa7A2FyI8VN2y" . 
		"WYYUFysVY0NhKTIWVia2lU+JnJpPdPqDikSuViGNDYXAysUY0NpK4qbtktH1DCgMrFGO21QMraCdrBh8VPLTRv3DChxW4era7qD" . 
		"lbQp23uHxU7baXDCijkbghtrk8VuGG2u6lS4ia/tcFFA5WCKdrNwcrBFO29yXxU89NE/YMKDZWAU7biHysNNVuLg+Kmr6bBhQfK" . 
		"ykVXK5WXIUIqtxKfETtJ+VgwrIl8rLVVuLh8rK1CpMuKmr/AEsCijWysMmkVVzHysGIFbGE+KnG9rZOwKKCZWZwDW8JlZmo1CPF" . 
		"TeH6v9A4oJlYk3XK4XKxDHbYRR4qo0vUMKJ47/L7RM/jKn0HgR1BQjVWknbfaYMZGwNqehnVgjUtKGX05k3a1IyI5Oy7DYTmQRz" . 
		"BE4K1OcZNyWRaaMnowCkv1mnCK9XkE9C3bShM8hNmzzmvGyzUSYLcS0fTYO6nmJx054JXLauY66Ttup5GX8IRNVnblNYxjCUlLT" . 
		"/KFe9rBkZ25gL0hAo1DVe3pNez7+Kb10FfKyJ/x+rGdfh4HIkQo9l3rXeTB3OasgcUnX1hmUMRoXnM+0pqGUd92OzvqXjYlGoAe" . 
		"lCQVc+I13M1mqlSEbZL+yErJlNpGWy2+2wE3KQHW1sy3gjGe+Ys7oxuIXOkUL51NXG+oMx5fOJU61SeeSTC8UjeCo3JM28Scq/+" . 
		"5qqdGhnLUV3Ip20rdXOT5Wpa2sQ4itKF1Hy6hGKZGQkhbP6Yyfp+kThm28Tf0LRr+aPaP9j+0p+J/cGwTzT7zMf6vpMUdVzfQDc" . 
		"Z0o5HymuAMVryLWJazpW8k/d/4FuS3lJ3MN5ae8ze/JdBh/CnadM3lLNY+GfJC8iCpbGlV15may2qjUtgesTpNpu6zS35BczJ5g" . 
		"7CP9n+0T8f/JD2Mx+M9jCeB+0iOi9fYAPKbuJSfl2l0/8Aq+oMkeU3cR+z/aQtFy6sAfKXuYfwJ2iej5LoAyck+mMvi9hCekvT2" . 
		"GjX873EH8x/aXLxP7hBPP8Aczfw/jPaVS8ceb6CejLRycrKaoTceQszAgbTrhWk2k92/wAEuJZO1zguRijG9xXSFepKMko+T9gi" . 
		"rgZG4ZN73HEbhA3vc5e3qW126lYUY5LY1J57y8n5dfaNNyxt+S9g8jm3lJ7w/gTtMJaPkugy836JmfxjtOir/wCT0EticnnHvKH" . 
		"5n3ma/mf8h7Gr+ZMxfPPcy/L7hfonHzP0mVg5P2kUPFH19hy3GLynkjym7iD8MeT6hux+z/adB+WMqlv9omYPyx7zD+WHeVt/xD" . 
		"9h/wAukl/AnaZ1d+S6DQyck+mMviHYTOekvQEUfzA7iafzInQt/uF+jD+Z95OPzR7zP/yL7n0HsMXiPYxj/V9JmcPl9QYTwP2l4" . 
		"fA/aaUfFHk+oPRkJ4X7Qvlv7TOO3J9QC+U/tA8pu4gtFyfUB+z/AGg+Uvcwej5dUBR/LDvJPkj6ppU2+1AgfKTuYby095D35LoA" . 
		"fwp2jJyX6YpaS9AQyeIdhK/Ec17TR+Gp6BuicnNfpEZfM9hIn83NdQRr+ce8nJ5jd4qnzc/2CNxeasYvM9jHT+Xn+ge4x8z9JhP" . 
		"C/aKGi9fYGREwKOmYnUATdCQrMvIkTepOUaraeYksjsrvo3I1HkDNGQlgrJuZ2qtNYVJXT9zPCjP8TmuR+06qAqgDpNqMaTbnTE" . 
		"76MnImsVdTmcHo3/JnW4btZYrjUrIk4W6UZhxuP0mcc+Fqx2uWpJmoaGhwdJ/5OjY6ANaqFVNqcO0hms1t57oluzOYJJ1uSNJ5A" . 
		"TQKzkdDczjnZvW6/wB/AydSdE/7OqHViNKNukuhODk1GNsgkn5nMO3RB/8AjKc5NZ0ja/STGdVx7sfwFlfMrGHptfXlJGA9Wmzo" . 
		"VKsY42LEk8imXHqtjv3luwUWZvHs6eJr1Jzdjmc4vZfvJyZHDkA0BOWpxUpRbhkUoeZKksrgm9rkhGPJT9pzNTqJNZv/ACXkj1F" . 
		"dWOjtYkNiBAGrkKnpVKCqZt2yMlKwbECB8XIVDYga+LkKmb4VO/e1HjDYgXvVHCHE1aut1G+GV733uGIDEA96oXEBfxcxUFwqVs" . 
		"/MMQGIBWGrnHCGjTq63F8KrWxbWDEDiBUDVyg4gVUauUHwsc+9sl7BiBxAgDVyFSnQMoBNVKXDpKSvrYMRJxAqo1cpnAX+Uzlwk" . 
		"ZO+IeNmtiBYHVN4Y4mrVvd1NPho3vfe4sRi4gGvVAxAAjVzkrhYr5vP8hiAxDSRq5zRjAxlb2PWVHh4x32sGIwYl0kauccJdGnV" . 
		"tdxfDQ89gxMHEukDVsIONSANXKJ8PT/q2DEw2NTXxchUNjVju3SD4em794MTNbGpfUWozOGuvVq3u43Qp38W9wxM0Y1D6g0Y8YQ" . 
		"2DcqFCEWmnowcmaqAOWvc9IRApJBu5UaMU1no2K5RFrU5jEoUjVzjqUozabfmCdhwl0EatruOEuitW13Mfhof1bDxMHEpUDVylM" . 
		"gOMKTsOstUIJPPVWFiZJxqVA1bCDiUgAtyEl8NTd8/IeJmuitVmqh0ViCTUuVGEsV3rYSbMbGpey280IvE1XvfKT2FPFe+9x4ma" . 
		"EXiFr39JgRdZbVv6Suxh5739RXZi40BNN09ZqIqg0buTChTi009BuTCooVgDYPOYMaaSNWx+cOwp2SvomGJjhporVtd85WleHpv" . 
		"b1jjRpq9ntb0E2wEXh6b29Y0KcYW7EpUYaX2t6BdhkXQFJoD5yWxppW22HLeTOhTd7vYFJhkQ1bchtvDY0J3bp6yHQou/e/I8TN" . 
		"KJxNWrf0uaVXiar+L0uadlT897+orszQvE1avivlcxUQNYaz3k9jSxXvvf1HdhUQHZunrCogum6esmNCirWl+QxMBECkBtjz3mo" . 
		"qhWANg895UKNJNNMG2YEQA03Mb7wETSwDbHnvEqFFW73nuGJgImkgNsee8aE0katr9YdjRy723mGJjQmitW1+sHGmkDVt3i7Cj/" . 
		"Vt5hiZpReGFv4fW5mhNFatr9ZUqNJ6va2uwXYKJpA1bDlvBRCoBbYct4nRo557efIMTBTGQLbkNt4ZMZq25DbeDo0c7v8hikGTG" . 
		"Tu3T1muqNWo17x9lStLPXXMLsxkxmrbp6wyYy1lt+8To0Xe7/IXkGRC9lt79YKYyxttyfWEqNF3u9/PcMUgqYwwpt+8KmMNYbfv" . 
		"CNGirWe/mF5BUxg7N09YCYwDTcxvvEqVBJWfnuF5GcPF/L/sSPh+H/q/I8UvI6kKw3oiczhW9jQ9J0VaEKue5Kk0Q9E/GpX0Il7" . 
		"pi3+Kc8VaUp2s1qvYp6WJxKpcMp5dDO834WMVC8dGTJ5nnztb16TnZHImebWk3VbRrFZFLkYEbkj0M7M9JrG4rlOnh68sMru9sy" . 
		"JRVzEyM12uw5mUmQOTXSb0+IcsKkrXE42NBVrHOucniY/8A+EuValHN/wC2EkwuRC1Af8nSXSqRqK8RNNanFs9EhRcPkYNSjp6T" . 
		"kfFyd8C0LwLc3GzlviFCvSRw8hO5+5hKNerBbfgFhTKbFbltQFzo4BQ6jQ9ZrCioKeJ6icr2ONYR1JmnJju9Fmc/acPTVkrlWkw" . 
		"MrfpxzdWY9AJXbVpruRshWitS1s49zvXScH8Kdo+JvgTfl+gjqH5J9MZP0/SJyS0l6FIZPN+03/Y/tLfif3BsE80+8zH+r6Yo7c" . 
		"30AL5b+0fs/wBolouT92Abyk7mG8tPeD35LoAfwp9M6ZvKWaR8M+SF5EEKcaamrn0mFEAFvz+UmVOnLNytktvoh3ZuTzB2Ef7H9" . 
		"o34/wDkg2Mx+M9jCeB+0iOi9fYAPKbuJS/l2l0/+r6gyARw2HWxN/Z/tM0016dRg+UvcyJFTVcl7AhOjeavtHDwvmuoMZ/M9pzj" . 
		"r/zZBHQvF5g95X4fxntNaHihzfshS3OgbHxKA+LtGNkJIQV7TthUpYkorO72/uZtMs7gicFVeG3xitukXERi5Jt2yfsOLAVeGRr" . 
		"2vnUxgBiFG/inHKEFHKV8vL6l3ZjeUnvOmT8uvtKjpP7V7IT2ObeUnvMfwp2mMtHyXQpHTN+iZn8Y7Toq/wDk9CVsS/nHvKH5n3" . 
		"ma8f8AyHsav5kyV88+8vy+4X6Mx8z9JlYOT9pFDxR9fYctxi8l5I8pu4g/DHk+oeY/Z/tOqVwBq5TShbFnphFLQoFAlAjTylKAB" . 
		"8PKdsOzdsOy/Bm77mOmtaupjYwygXyinRU223qNSsYcQNWTsKnPOoBG/SctehGEHK/kVGV2D+YHcTT+ZElb/cP9Gf7PvJx+aPeZ" . 
		"/OvufQewxeI/SYx/q+kzOHy+oMJ4H7CVh8DzSj4o8n1B6MlPC/aF8t/aZx0XJ9RhfKf2geS3cQWi5PqA/Z/tB8pe5g9Hy/Qij+W" . 
		"HeSfJH1TSp/1QIN5SdzDeWnvIe/JdAD+FO0ZP0/SIpaS9AQyeIdhKz817TR+Gp6e4bonJzX6RGXzPtIn83NdQRr+ee8f7H9pT8T" . 
		"+4NjE84d4xeZ7GKOsef6BjHzP0mE8D9pMdF6+wMiJgUarFT8JqdVz/AMh7idVDiHSyehMo3OoZWGxuY6k7q1GenJdrC8GZaPM1F" . 
		"ocgCedTSaFyorDEHmzyE2xPrMngt3dzcTpifSabwma0Z4JpsTV0UyuHGnZRy9JjMEo4wKJ3P/6nVLFTu3qtOX+2IWZTGqypy6iT" . 
		"lUeNeRhVipRlb7l66gtTfw6829hOx5bzp4aOGkrky1OJyqPCggZMjeFf+Tm+Jk3hpRKw+bKQ5NY11Uh71G8lb8pU3UdPvytn/ug" . 
		"K18jCqCrYm/QTsKOL1FQoRhFyind2CVzhrA5IvvvKLNpUrtY6Cc8auTwJL31Kt5hOIXBOqrknG1myB3Mbp1akO9+Quk8jthFJVg" . 
		"79JyyitI+U2rK1Fcv0THxGP4U+mMn6fpE5ZaS9CkMnm/aafzH9pb8T+4Ngnmn3mY+TfTFHbm+gBfLf2j9n+0S0XJ+7AN5Se8P5a" . 
		"djB78l0AP4U+mdM3lLNI+GfJC8jm3lp7w/hTtMpb8l0GH8wdhN/2f7S/n/5INjMfjPYwngftJjovX2ADym7iWv5dpdP/q+oM5gD" . 
		"hseoIm/s/wBpmkkvTqM3UVxLVczzmcQ9Qp9pTquNlZWstvoKxmQAUQKsXKfzV9omkm7eaAZ/M9pzk1/5suY46F4vM9jK/D+M9pp" . 
		"Q8UOb6CluYv5g9zN/D+I9pdL+ZHm+gnoeicOGyo4q7qp18RTcrNbX9iIuxIRuERpN3N0HhAH4d+onGqUt1bLqXdAoDjUah13qW4" . 
		"HBAJrlvNo00lLPZewr6HJ6CKAb5w/hTtOWdu9Z3yXQpF5v0TM/mDtN6vz+glsY4PGJo1c0fmfeRhandr5g2NX8yZK+efeV5fcH6" . 
		"Mx8z9JlYPC/aRQ8UfX2HLcYvJeSPKbuIPwx5PqHmP2f7ToPy0qlv9omc/2T9U74zqQGa8LLv2+gpaE5yQgo1vJyk8NN468neeey" . 
		"9wjsRkOy7/pjL4h2E5Ju6lf6FIo/mB3E0/mRN1v9wv0Z/s+8nH5v3mfzr7n0HsMXiPYxj5t9JmcPl9QYXwP2ErD5b9ppR8UeT6g" . 
		"9GSnhftC+W/tM47cn1AL5T+0Dym7iC0XJ9Rj9n+0Hyl7mD0fL9CKb8sO8k+SPqM0qf9UCDeUnvDeWnvIe/JdAD+FO0ZP0/SIpaS" . 
		"9AQyeIdhK/Ec17TR+Gp6e4bonJzH0iMvmfaRP5ua6gjX8894/2P7Sn4n9wbGJ5w7xi8z7xQ1jz/QMY+Z+kwngftJjovX2BkRMCh" . 
		"EYAEg2DU7LmI2YX8xOihXdJ/QmUbnYGxYgiwQeRnsZSXMxPK6lGoyZ4M4uEnF7G6dxLRC252EdODnKwN2OiOHBQih0nMfAxR+R5" . 
		"/wD+zpnJSUam2j/3kSlbIpDw3KtyMtVKsUq0M0optKPk7PkxM6bKvoBITIHYgCp1SqRpyjDzJSvmcCGLHYk/ISyjnGoAO13PNpw" . 
		"qSxWX+3Ro2jEQq4JKjf1m5VXiElq+VTRU0qVpy35ivnkG0aFJ1HoJ1xEHGKFD5zeg4dpaN9P0TK9jnT9EUe0rTkKDejcmEK7TSS" . 
		"iNuJgxNYJeVwVLEmzcuPC3X8R3Fj8i1VV2UVIcoCNQ37TafZwhmshK7ZjPjAFr022hnxirXpttMXVoK91+B2kGfGG3XftAfGWFL" . 
		"uT6Qdahiw2zv5BaVgHQsQBv2hXxm6XpvtGqtHLLz2C0gHx6WIXYc9o149F6dr9Iu1oW028gtIF8ekHTseW0F8YVbXY8to3VoZ5b" . 
		"LbkFpAvjAFrzG20p2UKCwsdpSq0rSy01yCzI4mP+P/JrPjFWvTbaZ9vQabt+AwyHExkj4d+0HJjDG13B51H29C2K34DDIK+MnZe" . 
		"npMGTFXh/5F29CydvwGGRofHpJ07XvtNDJwyQPh9KlxqUdlt5bBZk8XHy0/8AJvETRena/SQuIovSP4DCwciaQdO3aZxcf8f+Ql" . 
		"xFFax/CDCzTkTTqK7XXKGyIDuu/aU69JK+HyDCw+RAxBWyPlM4uP8Aj/yTLiKKk04+wKLHFT+P/JWN1Y0or2lU+IpSkopA4tIB1" . 
		"OTTp39ajG6sTpFSo1qbkkluxWZSOHBI6TQykWCKm0asZJPzE00NQ9R95spSi9GKwmMQq2eUJNRTbA58ZPQ/aOMnoftOT4ul5F4G" . 
		"OMnoftAzJfX7RrjKQYGWrqxoG4LLr09Zv2sGk75MmzJ1qMmmt/WYuRWagu8x7eCla29isLC5VN0vS5qOGBIFVCFeEmklrcHFowZ" . 
		"VKk6dhAyLpJ07CT8TTdstgwscVdF6drqbxBw9VbekqPEQei2uGFmcVdGrTtdS0IZQQKl0q0ZyslsJpozIwRbIuYzhVUkXcJ1Yxc" . 
		"k1oCVzGyKKteYuGyqp3XpMnxMFfujwsNlAetO805RxNOne6uN8TFNq29gwsDKC+nTvdXMXKGagsFxMW0rb2DCwuUMTS9LhcoN/D" . 
		"yFxR4mLt3dQws1XDKxrlCZAysQKqaRrxeHLUWEwZQQTp5C4GUFSdPKZriou3d8x4WBlBUnTyjijQW08jD4qOXd2uGFjijRq09ag" . 
		"5RpB08zD4qP9O1wwmnIBjDVsekzijQG09alS4mK22uGEHKAoOnnBygKp085L4qOeWyft+wwhsoAHw8xcNlC18PMXB8VFX7oYQ2U" . 
		"Ka09JuTIEIsXcp8SkpO2gYTGyhSPh6XDZQrVpuS+KSvloGEHKA+nT1jijiadPWrj+JV7W3sGELlBfTp6wuUM1aYLik7ZauwYTOO" . 
		"P4wM17BCZmuMTyUR4PqWGY/t/9idGOo/k/KJsvM8sTxjYTVGpgPWOKxNID1k0pPpOKZuj/AHnrVq3ZTitjFRujqyh1ozyspRqMw" . 
		"4ynpURUHsWqUuph7SS5LA8q5fKcsk6UUt3mUszW3GtdvX5GWf8ALjseITWCxOUP6ldCfmYi60AbauR9Z3AoACdfDQssb1ZMnsQS" . 
		"HDCtx0MnHr1AlQB2g3KU4yiufnkGSWZrJkLH46HeOESmkt1uT8PUk3jlkGJLQDCo6mWyKTbAXNIcPThGzzE5Ni1A6VNBB5TWMoX" . 
		"woWZhYj9P3NSdfwk2or53IlVadtOb6DsScv8A7/ZZmRxYvUbF86nNKunF535ZFKJuFgWIC1t6yfxHjHaTKSlw2StmC8RL+FPpjJ" . 
		"+n6ROaWkvQpDL4/YTMfmL3if8AO9eo9ik80+8zHyb6ZcdubEF8t/aP2f7RLRcn7sA3lJ7w/gTsYPfkugB/Cn0zpm8pZrHwz5IXk" . 
		"cJ0YFlUqLoUZzwTkmlqUzFRtQJFAdTJY2xI6mOUXCFpbhe7Kx+I/SZEl+BevQNy+WLf9RlL+XbvN6eTt/8AF/sTOUv9n+0whvyG" . 
		"wfKXuZEJ6rkvYEWfJH1Rk8Y7CXLw/wBhbjL5rSOcipnUfMa0LGJz0rvOuLGUJJN7Ts4fhpqSnLIiUlaxoxU5a5qYwhJBJnTHh1G" . 
		"Sd9G3/clyNVAoIBO8gYQFIB5wfDppJPS/5DEQcDdCDMGPIp2H/ZxvhasHeJeNPU9CkkAkUZOUE4yALnoVLuk8s7Ga1PNpPoftMo" . 
		"+k8RxktUbiJIHX8P4z2m/7P/8Aek74fyofcQ9WaVPH1bVfrJRGD2arfrG6Usd/q37CurE4+bfSZeHwP2mVDWPr7FSITy37CB5Td" . 
		"xM1ouT6gP2f7Sh+WPeaQ3+0GSPJP1Tvh8oTbhf5i5dSZaE/iPAO8nL5aR19Z8l7hHYjJyT6YyeIdhOSfzehSGTzvcTT5/8AaXLx" . 
		"P7v2GwXz/wC0zF5v3ij4o/d+gGPxH6TGP9X0mTD5fUGVi8p4w+W86IfJyfUT3JTwv2hfLf2nPHbk+owvlP7QPKbuILRcn1GP2R9" . 
		"UHyl7mD0fJdBFN+WXvJPkj6jNKn/VAg3lJ7w/lp7yHvyXQA/hT6Yyfp+kRS0l6Ahk8Q7CV+I8S9po/DU5oN0Tk5j6RGXzPtIn83" . 
		"NdQRr+f7x/sf2lPxP7g2MTzh3jH5v3kw1jz/QMrHhvdth6TuAFGwoTv4aiqccT1IlK5hyIP1CJo+IpLLELCzyRPFNhOuAWxPpNu" . 
		"HV6sSZaHTOaSvWeaa8Y71beQoaHXFk0nSeX/wBTsyhqsCxynTw0lVpYXt/qJlk7nJjbFlsMvMHrIYAjUvLqPSctVYr/AN/3+y0Z" . 
		"jJDUBYPMTptibqSYUnaON/KD1sdQo1FupnNyXI4ZujO2rdQww1Zmtbs60LsgXUzWDyoi6u5s2oZbsWpLvpatQHtMGQEN8RNC9hU" . 
		"wlXSk4389F1KUciDlHoT3aXkY6FIUG/lcwjWxxlZf3zHazJXiFG2o9Nql4tW+o37zSl2rlFyyX9vPYTtY55VXiElq+VQujSwBJ2" . 
		"mLjTVV3eeZV3Ym06IT3Ms6iqlUHL05SYSTT7OHUH9WVj4mr4hQmZcbMwK+k6HTq1KLjLUm6TMbExC1WwqHxMaqthUzlw1R39B4k" . 
		"HxMzWK5esxcTBwTWxifC1HUxfUeJWKXGwck1W8xMTANdbipS4aoreosSAxMEYbWY4TcPTtd3F8NUsuXUMSBxMUUbWLhsTFVG20H" . 
		"w1TPkugYkGxMQoFbCpWVScYAFkS+wnGMvqkGJZHnIINGASORqednFmhpJPMkzINuTzA6ojCyRQozmotgD1M1lBxUYyyJTNyElzY" . 
		"qtgJa/lm7y4O9Sd/Jg9Ecpf7P9pjDfkNg+Uvcxk8XsJcvD/b2BA+SO5mhHcg1XzlKEptRj9BXSzOpxAuWJ59JaqF8IqelToRhJy" . 
		"3M3JvIxnVeZnM5x0WRV4qNN2WbGotmpkLmthOhIrmBKpVXUhieQmrOxxOZgSBREcc/xH3nJ8bJPS5eBFDOOoImjKnr/wAnRDjKc" . 
		"tciXBlKwbwm5pIHM1OlTi44k8ibPQah6j7xcFKL0YrGzKHoIOKeqAAAcgBGkatVb+sWCOlh3ZJxqX1dZIw0bViD2mEuGi3dOzvc" . 
		"akYuEqTvzFSsePSpBN3Jp8M4NXelxuVyBjYKwrnymDGwxsK3JHWc/wAPUVstn1KxIaG4VVvfrLCMcOnrcuFGd/SwnJE8JuHp2u7" . 
		"nXGpVADzm1GjKnK78rClJNGZFLAUaINyciMyqLFjnKq0pTxWethJpEtiY6arYVD4mYgiuQE55cLN3+tisSNbExyagRUHE3F1WKu" . 
		"5T4abbf1uGJAYmGTVYq7hMTK9kiC4aaad97+wYkExMpNkcqhcTDVuNxUUeFmrZrK4YkamMqjA1vGPGVVga3mkaElh+iYnJEriYK" . 
		"wsbiauJgrCxvMlws1bNaPqPGgMTBGFjeoGJtBWxubjXCzyzWlvcMaHCPD02OdwcTaALGxh8LPz2sGNGnGTiC2LEw4m0BbF3cqXD" . 
		"SlvtYSkgcTFFFjaDiJVRY2kvhZu+eyXt+h40GxEhRY2FQ2JmrcbCoPhZu+etgxoPiLGwRym5cZcggjaU+Gk1JX1FiWRj4ixG42F" . 
		"Q+Is9giTLhZO+erHiQbETk1WKu44R4uqxV3K+Fle997hiQXEQ4axzuUmIK1k2Y6fC4WnJ6O4nI3JkCD1PpPOzsx3PtMuLrXeCPq" . 
		"OC3JicBoIgAnpwisY+e86+DV6l/oRPQ5Zzb16TnMa7xVZMqOgnfDk/S3tL4apgqL6ikrorIhPxL4hIAHj2CnmDOurC077a9H/ch" . 
		"PIlzpUaNlPX1l4VOm25XYmVJOVbCvCvYb0Op3sVtUn4ca+gndLCv4ktiM9CGykOP4zGARtQ3RpxyqOd2/lf4ZaVjc2nUCwJsdJK" . 
		"MtkBKsdTFOVONa1sxq9iQ7fpUDsJ1Os4RVhvtFSnUmpJK2W2QNJEqrfEGI3HrGEAMaYEkdI6cGpxcpZ/3E3k7FuMeq35zFbHqpR" . 
		"uflN3KhCpp3hd5ozjD9KzdblLC73M1xMp3UIjwpamKcuoaqAm5yQAQSN43Kr2MnPUWV1Y5uxpNz4fWMjN8NE+EdZyyqT72fkWkj" . 
		"XY8QbnpFnj1ZrVKc5YnnuKyCMeIdz16znqb+R+8zlUnhWb1fQaSGpv5H7y7PBuzer1ihUnnm9BtIMTw03PXrDk6E3PL1lucs89l" . 
		"0FZGOTpTc8p0zeWs0Um4zu9kLyOYOtSp5gWDInNN4kpMpCXehAR4m6+ghTdry8gYx+I/SZEUvCvUNzpZOI6t96EvGC2AgdTOmle" . 
		"crbuJLyRq4VHi3lhVAoAVO2lw8Ka0uyHJs3StVQ+0FVPMD7TXs4PYV2KA5CphdRzYRSnCms8gSbObZx+kX3nNsjNzO3ynnVuKc8" . 
		"oZI0ULakROMsREAiMBEAPR+HHwE/OPxB+AD5z09OF9DL5jzxPLNRZ9Zuph+o/eWpyWjCxvEf+RmjK/r/yax4mrHcnCihnbqBN4/" . 
		"8A6/8AZvHjZboWBG8f/wBf+zeOvoZouNjuhYChlQ9a7ytiOhnVCrCqsmQ00YVUiioqNC1QFD5QdKDd7BdmaBVb/eUqhRQv3hGlG" . 
		"LugvcMurqR2MxkDVZO3oY5U1K93qCdiWxXVMRQqTmUgArfpOWrQajJpspSzRxs+piz6mebifmaiz6mViP8AkEum3jjzE9CLPqZa" . 
		"HZ/phTbxA9C8XlvIQnQ+/Sb3eGHJ9SfMvD4H36SEJ0Pv0ELvDDk+obsKTwn39IB/xN3EzTdlyfUY/ZH1QfKXuYNuz5LoBbfll7y" . 
		"Cf8Q36mXUb/8A5QkG8tPeG8tPeQ28+S6DD+FPpjJ+n6RCTdpegIZPGOwlfiPEO0tt4anNBuicnMfSIyeZ9pE2+9zXUFsa3n+8l/" . 
		"MbvCo/FzBHbClfE3PoJuXJoFDxTuj/APj0LvUjxSPMSSbPOJ5Td82aiIAIgBoFkD1nr5D5CehwSspSM5nkJtifWZPPbu7mgiAHp" . 
		"xPrXfmJOdCfiHvPUqXrcPdGS7sicKlrB8M9ErhI/wAO7CepzyZQuw3M5XxBv4hy+cxr1u0l2a06jirK5iHUNB9jLxWVKMNplR70" . 
		"l9cmNm5mC6RpBNdZz4jdAB2Edaq4VGopc9wirrMw5HP6jOqDXhonrzhQlKrJxk9UwlZLI1caK3i3hOGGpTvOmNOjTtd53/JLcmM" . 
		"xAolbnNH+MUqjfoJjVqKFayir5ZjSvEE5LIF+wlaXOMhru+pkrt5t30z+iH3UQEo2XUe87Z98d/OVThhpTV0xN5o45OSfTGT9P0" . 
		"ic8/m9Ckbk837R/sf2lPxP7g2Ceafec5lPwrm+g0Jf7P8AaKG/IGG8pPeH8Cdpo9+S6CD+FPpnTN5SzWPhnyQnsc8exLdAJE5pZ" . 
		"QXqVuJbb40PtCOkv93QMY/EfpMiD8C9Q3O3DLMF5Kv/AGdtkX0AnqUaag3OX+pGTd8ji+Y8l2+c5FmPNjOGtxEqjydkaKKQs+p+" . 
		"8WfU/ec+OXmVYyz6xE23qAiACIAIgAiACIAerEKxicvxB+ID0E9Ot3eHS5GUfEconmGoiACIAIgAiACIAbqb+R+83W/8j95oqtR" . 
		"aSYrIcR/5GdsLFlOo3vOnhqtSVRJsmSSRmZmUjSanMZXHW+8davUhVaTyBRTR0XOP1Cp0V1bkROqlxMKmTyZDi0CqnmoMk4UPKx" . 
		"KqcPTqaoFJog4PRv8AkLhZXBsbTl+DlGScWVjJbE9kgbd5qIwDWp5TJcPUjO9isSsbjBGN7BEhfC9+kJRaULrZ9ReZWHy3kp4H7" . 
		"RfLDk+o92F8p+4geU3cTNaLk+ozAy6NLA872lPXDXTdWecalGUHlnbqhZ3Nb8sO8k+Svcy6n/VAg3lp7w3lp7yHvyXQA/hT6Yyf" . 
		"p+kRS0l6Ahk8Y7CdM6sSCBYqbYXKNRLzQr2sc8vMfSIy+YfaZT+bmuo1sa/n+86Lj/yFm9dhN6VPtJvyTE3ZFZH0L8+k8pJJsxc" . 
		"ZUvLAtggsriJxFiIAIgB0wC3v0nXMaxn57T0aPd4aT5mbzkeaJ5xoIgBqkqbE9SMHWxO/gqmbgzOa3NACihsJzbKpOkHY9Z1Vak" . 
		"aUVElJs4MCpozASDY5zx2nGVt0banVlAGtgRfT5zGY5Fsc15idclhvBavP/HuQs8yvNx/+wnGZ1+9hqefuhxyyE74d8TCPhf5lv" . 
		"oEtCF0BgbJN+koaRmoKbvncuHZRStd58hO5eU0lgA9xOQdzy/4JrxE5xqWgvxmKKTWZTrkLmrrvMVDpYEjceszdKo6jcnlnqx3V" . 
		"sidK9X+wnc0ce/Kppw8YJSWK+QpNkNwvhu+W0NwttV8to5fD536h3g/C1/FdwDiLgi7Jg3w+K29/rqHesF4es1d7zAMRur2FxYe" . 
		"Hdlz8w7wAwkE70Jv+LR103BLhlp5fUO8DwtC3ddIbhaVu66Rv4fPkvPTIO8G4VLd1W03Lp0C7rpUb7HDK30uLPI4s1igKX0kzzp" . 
		"yxO5olYSlbTYqweYhCWF3G8y00WdIINGMeK925ek6oUo1XHDpuQ3Y7MwRbM8+Ry535ek24yrZdmhQW5ETzTQRABEAEQARABEAEQ" . 
		"ARAD2AUKnmym8hnp8ZlTSMoakRPMNREAEQARABEAEQARABO/wCH8J7zp4T+aiZ6GfiOazjJ4n+awjoImBRoZhyJEsZnHW5tCvUp" . 
		"6MTimUM/qv8A2bxx1Uzrjxq+ZEYDRmT5/aVxU9ZtHi6T3sTgZodD+oTbB6ibRqQloxWaNmUPQSnFPYRmharSKMcNarTtIdGm9h3" . 
		"ZJxJ6QcSlQN6EzfC087ZDxM3hjhhCTUw4hpA32+cHw0WvSwYmS2MBQNLGvQyW0BVBDTnqQhC+JPRdCk2w+ilsNyh9Hw2G8Mzk6W" . 
		"eT2HmYzITZDfea7o53Dcou1o2krPMLMxmRjuG5VBZGayGuS50XfJ5jszqEBOsrR57mbkcIPn6T0O7Rg52M85Ox5mJY2ecyeO25O" . 
		"7NhEQCIgKxgM4BlZVVSAoNzojCHYub1Ju72OmAUl+sjObYD0nVU7nCpedv2Ss5HKJ5xoIgAAJNDnPUijGm/uZ28HDvOb2Im9igQ" . 
		"6+oM82RCjfLpNeLipwVRCg7OxqgulHpyP/6lUuIb7vMoxSSrS299hvyRAyEtbbg8xKC6G1Fvh9fWZxbqd5vR/j/fcbyyBYrpKbL" . 
		"GRdQDp15zSX8SMoLbNchaZk6K8bBfl1nXDp3CknuIUIRhUWJ5+X7CTujkSgJ+EmvnOoI49aRv1hTlBO0Y7rUGmdGvSa51PP8A5T" . 
		"/Kb8T2raULkxtuZlvWL9BNxKL8Q3FVORRvXzdsy/lMrGOrH2ndKOIVyqt5vwyp4mo3eRMr7nDJyT6Yyfp+kTmn83oUhl8w+00gD" . 
		"8QAPUSmu+3/APJdQ2CeafeZj5P9MUdvUAvlv7R+z/aJaLk/dgG8pPeH8CdoS35LoBj+FO065vLWaR8M+SFujhLAUKC178gJzwUX" . 
		"dy0RTACMaAIJ+cmjddY5qLScAV9zvix6fibn6SncIN+fpPTglw9G7Mn3meZmLGzMnkyk5NyZsshEQCIAIgAiACIAIgAiACVjF5F" . 
		"HzlU1eaX1E9D1zxE2bndxz8KIgInnmgiACIAIgAiACIgEQAT0fh/Ae86uE/momehP4jxL2nGTxP8ANkEdBEwKEQARABEAERALm2" . 
		"fUyrtbgbrYfqP3jW/8jLVaovmYrI3iv/KaMz/I+01jxVVb3FhRQznqomjOOqmdEeN/qROAoZUPWu8ugw6ETqhUp1lZENNEtjVq+" . 
		"XpMbEGrc7CpnLhYSvbK41JkcD0b/kzgN6icz4KWzKxmjAerCdExqnLn6zajwqg8Undic76GZMoXYbmeckk2TZnPxdbHLCtEVBWz" . 
		"MicZYiACIAdlwuCDYsTMxYtp6Gd0qdSjSa8yLps7gUoHpPIx1MT6y+MdoxiKGtzInnGgiAHow49I1Hmf+SM2TUdI5CehP+Dw6ju" . 
		"zNZyuTiyaDvyM9JAYb7iXwslUpuEthSVnc82TVqpunKoPxrq/UOfznG8TlKMtf1/gv6kS1+IaDz6GZ0/FbzyGzUBpg2y9SehlKw" . 
		"R9FbdSZ1Un2ajOWunp/tyXnkRkQo3yPKVgPxntM4R7PiEvqNu8SMgrI3eX+5jPqBCOU5c+obHonlKP1P3M6+KhKdrEQaRTKNK24" . 
		"G1esxNAcfESb9JzOMIzTlLPLQq7toYdAYjSTXznbCQU2FUZrw8qaq4YoUr2OWYUQK6TMgNrt+kTCpFpy9ClsbkH+Xl6TT+Y/tG0" . 
		"8T+79hsYnmn3mY7p/pkxTy9QCg8N/aK/w8v1QSdly6sAwPDTb1hwdCbdINPPkugE0fQ/ad8oLY1oXKowk4TVtgbzRx0P/EynRiF" . 
		"pTykxo1ML7rC6MXG+ofCec9CoAxbqZ08NRazmtCZS8icmQLsNzPOSSbO5mXF1ccsK0Q4KyuZE4yxEAEQARABEAEQARABEAE64B8" . 
		"ZPoJtQV6sRS0OuQ1jbtPLN+NffS+hMNBE4ixEAEQARABNUWwHqY4q7SAtsh1HlV9RM4h6BftN5cRK7yX9icKHEPVVPtGpeqD2i7" . 
		"ZPxRT/AW+pq6GYDSRfoZ1xBQp03z6zp4ZU3PFFNMmV7GZVDOoJo16TlWP8Ak32kV408bcm/9sOLdhoB8DA/I7TDjcfpMwdGTV4Z" . 
		"r/dh4vMnlziY6FGhSeQJjSR0P2lYJWvYV0ZEkYiACIAIgAiACIAJoJHI1BNp3QFDK4633lcdvQTqjxdWOuZLgjRnPVf+zeOP4mb" . 
		"LjvOJOAw5/Rf+yGys3Wh8pnU4uU1aKsNQSIicZYiACIAIgB6ABVbnS3UyjfEA6VZnrwVl3foZMZGCoSZ5Zy8bJOaRUNBE4ixOuH" . 
		"HZ1Hl0m3Dwx1EiZOyLzZKGkc+s88vip46lvIIqyE7YclHSeXSTw88FRMJK6OmRNa/Mcp5gSrX1E34uLhUU0KGasa4GzL4T/wAmh" . 
		"Qu7+w6znwLE2/DqO+Rrk5Ev05iYPjWv1Dl8xLk8cvuX5/8AYaI6KDkxU3sZGJWXKLBmrhJunO3lcV1mhmB4hoc5vxjGmkH5ybTV" . 
		"Sbin/rQZWVz0TzNjOo7qN+pnTxcMcV1Jg7AhdABcbHoJg4YPNjON9kmm3fkXmVkKhz8Fn5mXha7FAdptTnFV8Kj5ktd0ZchRqAH" . 
		"KY+VlqgNxcupxM4uSS0BRTDZSMmmhUcU8XTQq6g+JmpNW3sGFBcrFyKG1wuViGsDYXEuKm7ZeYYUBlYoxobVHFbh6qF3UPip20W" . 
		"lwwInjt6COO3oJl8bU8kPAjWysAtVuLhsrBVNDcTR8VNX+n+BYUa2VgqmhvMbKwC7DcXB8VNXyWi/NgworE7Pd1QlZH0JfU8p0R" . 
		"qvsO0epNu9Y8sTxzYRABEAEQARABEAEQARABEAE7/hx8JPznTwivVRM9Dc5+AD1M88fFu9UIaCJylCIAIgAiACah0uCekcXaSYM" . 
		"rSp8Ljsdo4bdBfYzbsXLOm7+5N7amFGH6T9pNVzEylCUfEh3TLxeYJ1weA9518JqvXoTMP56Tmce50EH5XvHWp427PO/RAnYgqR" . 
		"zBEwEjkanE1KDzyZepYyN1+Iehltr5ruPStxOqFSrOLtqQ0kcy73uxjW38j95i61W/iZVkbxH/lHEPUA9xK+Iqb58xYUPgPQr23" . 
		"ik/mftC1GWd7fkMxpT+f8AyNK//IPtDs6e0/wwu/IaB/NY0ejr94dinpNBf6Dht0o9jAxNvYqh1guHqN/QMSImgEiwDMEm8kUZE" . 
		"AEQARABEAEQARABEAEQA7PzfuJ26z2KK70v93Zi9Dl+I8A7zhOHi/5rNIaCJyFAc57OQ26T0eCWUmZzPGTZsxPPvfM0EQA9aEnG" . 
		"pPpOOcAOPmJ6nEZ0E39DKPiGHwOfScrvc85xVG+zgufuWtWVj8xfmal4lHFbblyl0EpON/MJbnomE7ierJ2Ricc7MrAAkbTkWb+" . 
		"R+88niKk+0avkbRSseseEdp5svmtOrjP5S5kQ1IieWal5PH7CV+H8R7Trp/8A7HqS/CPxHjHaTk/T9IireKYR2NfzvtH+x/aEvE" . 
		"/uDYJ5je8zHyf6Yo7eoBfKf2j9n+0S0XJ+7AiJzlFvyT6YfwJ2m8vm5LoSH8CdjD8k+mEt+S6AdcHlnvI/EeIdp1zy4VehK8Ryi" . 
		"ecaCIAIgAiACIAIgAiACIgEQAT04PKE7OD/AJnoRPQj8R+mcZnxP81jjoInOUIjARABEAEQARADQxHIn7zRlf8AkZarVIaMVkzs" . 
		"nxY9RAuucfh/L956UPHB+afQzejD+evaeecnE+L1fsi4m63HJjOuNi5pqPtFRqzc1Bu6CSVrnUoo3Ci55bJN3vNeLioYVHIUM9T" . 
		"phJckPuPnMyKBkoDaS0p0VOWtw0djquNK8MPjTQTpE63w9JQeRGJ3PNE8c2O2BVZWsXvOhxJXhnq0aFOdJNoycmmedwA1CTPNmk" . 
		"pNI1QlISHG/WEG1JWEzH2du8qyuJaNbmXFuLk1/uYHXEBkS3AJnHIAHIHKb14p0oz3ZMdWiYnGWIgAiIBEAERgIgAiAH//2Q==";
}



?>


