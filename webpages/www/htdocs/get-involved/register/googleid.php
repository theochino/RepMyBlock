<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";

?>
<HTML>
	<BODY>
		
		<link rel="stylesheet" type="text/css" href="../../maps.css">

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
			This if for the Google login
		</P>
			
		<A HREF="index.php?k=<?= $k ?>">I want to continue to the next step</A>
				
		</UL>
		
	</BODY>
</HTML>
