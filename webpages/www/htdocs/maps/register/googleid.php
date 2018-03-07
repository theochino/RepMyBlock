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

		Let's start with some contact info.
		
		<P>

			<A HREF="facebook.php?k=<?= $k ?>">Click here if you prefer to use your facebook information</A><BR>
			<A HREF="googleid.php?k=<?= $k ?>">Click here if you prefer to use your googleID information</A><BR>
		

			<FORM METHOD="POST" ACTION="">
			Enter your email address: <INPUT TYPE="text" SIZE=30><BR>
			
			<INPUT TYPE="checkbox" VALUE="email">Do you prefer to login with a link sent to your email ?<BR>
			<INPUT TYPE="checkbox" VALUE="password">Do you prefer to login with a traditional password ?<BR>
			<BR>
			
			</FORM>
		</P>
		
		
		
		<A HREF="informtogetmapkey.php?k=<?= $k ?>">I want to continue to the next step</A>
				
		</UL>
		
	</BODY>
</HTML>
