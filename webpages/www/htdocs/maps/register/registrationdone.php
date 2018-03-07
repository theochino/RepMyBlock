<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
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

		We are done with the registration ....<BR> 
		
		
		Check that the API key is there .... if not send it to the menu
		We couldn't find the GoogleMapAPI so send to to the API menu.<BR>
		
		<A HREF="informtogetmapkey.php?k=<?= $k ?>">Get an google map api key</A>
		
		<P>
			Tell them to check their email to verify to unlock the stuff
		</P>

		<P>
			Click here to finish the registration.
			<A HREF="../list/?k=<?= $k ?>">Go to the area where you can organize your voters</A>
		</P>
		
				
		</UL>
		
	</BODY>
</HTML>
