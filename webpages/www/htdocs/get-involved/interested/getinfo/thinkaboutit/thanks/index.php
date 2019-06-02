<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/headers.php";
?>
<div class="row">
	<div class="main">
			<h1>Election District <?= $ElectionDistrict ?>, Assembly District <?= $AssemblyDistrict ?></H1>
			
		<UL>
		<H3><?= $FirstName ?></H3>
		
		<H1>Thanks, we'll contact you soon.</H1>
	
		<P>
			First thing we suggest is that you familiarize yourself with the County Committee.<BR>
			This 14 minutes video presentation 
			will explain the County Committee.
		</P>
		
		<P>
		<iframe width="560" height="315" src="https://www.youtube.com/embed/MgAY-Ipyk1Q?feature=oembed" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
		</P>
		
		<P>
			<FONT SIZE=+2><B><A HREF="https://forum.outrageddems.nyc">Please participate in the forum</A></B></FONT>
		</P>
		
		<P>
			<B><A HREF="/get-involved/interested/getinfo/?k=<?= EncryptURL("UniqNYSID=" . $UniqNYSID) ?>">Return to the district page</A></B>
		</P>

		</UL>
	</DIV>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/footer.php"; ?>