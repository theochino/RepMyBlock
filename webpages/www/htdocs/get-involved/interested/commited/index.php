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

		Before we can start we need to check a few things, to make sure you are aware.
		
		<BR><BR>
		
		First thing we suggest is that you familiarize yourself with the County Committee.<BR>
		This 14 minutes video presentation 
		will explain the County Committee.
		
		<P>
		<iframe width="560" height="315" src="https://www.youtube.com/embed/MgAY-Ipyk1Q?feature=oembed" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
		</P>
		
		<A HREF="checkinfo.php?k=<?= $k ?>">I want to continue to the next step</A>
				
		</UL>
		
	</BODY>
</HTML>
