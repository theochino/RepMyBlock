<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/headers.php";		
	
	$EncryptURL = EncryptURL("SystemUser_ID=" . $SystemUser_ID . "&ElectionDistrict=" . $ElectionDistrict . 
								"&AssemblyDistrict=" . $AssemblyDistrict . "&FirstName=" . $FirstName . 
								"&LastName=" . $LastName);
	
?>
<div class="row">
	<div class="main">

		<h1>Election District <?= $ElectionDistrict ?>, Assembly District <?= $AssemblyDistrict ?></H1>
			
		<H3><?= $FirstName ?></H3>

		<P>
			We are done with the registration.<BR>
			Please don't forget to verify your email.<BR>
		</P>
		
			<?php /*
		<P>
			<A TARGET="FORUM" HREF="https://forum.outrageddems.nyc">Don't forget to check out the forum to discuss issues.</A>
		</P>
		
	
		Check that the API key is there .... if not send it to the menu
		We couldn't find the GoogleMapAPI so send to to the API menu.<BR>
		
		<A HREF="informtogetmapkey.php?k=<?= $k ?>">Get an google map api key</A>
		
		<P>
			Tell them to check their email to verify to unlock the stuff
		</P>
		
		*/ ?>
	
		<P>
			<FONT SIZE=+3><B><A HREF="/get-involved/list/?k=<?= $EncryptURL ?>">Organize your voter list.</A></B></FONT>
		</P>
	</DIV>
</DIV>		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/footer.php"; ?>