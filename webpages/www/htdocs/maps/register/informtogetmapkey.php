<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";

	if ( $SystemUser_ID > 0) {

		if ( ! empty ($_POST["googlemap"])) {
		
			require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
			require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_login.php";	
			
			$r = new login();

			// First thing we need to check is the vadility of the email address.	
			// Then we need to check the database for the existance of that email.	
			$r->UpdateSystemGoogleMapsApiKey($SystemUser_ID , $_POST["googlemap"]);
			
			header("Location: registrationdone.php?k=" . EncryptURL($URLToEncrypt));
			exit();
				
			} else  {			
					// That mean we found an error in the user input so we give them the same screen
						
			}
		
	} else {
		
		// The userid is ZERO and we need to check why.
		// We should never be here so we'll need to send meail to admin.
		
		
	}
?>
<HTML>
	<BODY>
		
		<link rel="stylesheet" type="text/css" href="../maps.css">

		<div class="header">
		  <a href="#default" class="logo"><IMG SRC="/pics/OutragedDemLogo.png"></a>
		  <div class="header-right">
		    <a class="active" href="#home">Home</a>
		    <a href="#contact">Contact</a>
		    <a href="#about">About</a>
		  </div>
		</div> 

		<h1>Election District <?= $ElectionDistrict ?>, Assembly District <?= $AssemblyDistrict ?></H1>
			
		<UL>
		<H3><?= $FirstName ?></H3>

		<P>
			This is the most complicated piece of the signup.<BR>
		</P>
		
		<P>
			In order to help everyone with the petition we use the Google Map API.<BR>
			Each individual get a 25'000 free map load per day so we ask each individual to get a free API key by following these instructions.
		</P>
		
		<P>
			Go to <A HREF="https://developers.google.com/maps/documentation/javascript/usage" TARGET="GOOGLEAPI">https://developers.google.com/maps/documentation/javascript/usage</A> and 
			click on the "GET A KEY" button on the upper right corner of the screen.
			
		</P>
		
		<FORM ACTION="" METHOD="POST">
			
			Enter your google MAP API Key: <INPUT TYPE="TEXT" NAME="googlemap" SIZE=60><BR>
			<INPUT TYPE="submit" VALUE="Save your google map API key" NAME="saveapikey"> 
			
		</FORM>
		
		
		<BR><BR>
	
		You can have access to your API Credential here.
		<A HREF="https://console.developers.google.com/apis/credentials">https://console.developers.google.com/apis/credentials</A>
	
	
		</UL>
		
	</BODY>
</HTML>
