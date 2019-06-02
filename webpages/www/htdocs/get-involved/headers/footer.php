		<div class="footer">
			<P CLASS="footerclass1">
				<DIV CLASS="FooterTitle">REP MY BLOCK</DIV>
				<DIV CLASS="FooterInfo">Represent Community By Running For County Committee</DIV>
			</P>
			<P CLASS="footerclass2">
				<DIV CLASS="FooterLinks">
<?php if ( $MenuLogin == "logged") { ?>
  <a href="/about/?k=<?= $NewKToEncrypt ?>"<?php if ($BigMenu == "home") { echo " class=\"active\""; } ?>>ABOUT</a>
  <a href="/get-involved/list/?k=<?= $NewKToEncrypt ?>"<?php if ($BigMenu == "represent") { echo " class=\"active\""; } ?>>REPRESENT</a>
  <a href="/get-involved/nominate/?k=<?= $NewKToEncrypt ?>"<?php if ($BigMenu == "nominate") { echo " class=\"active\""; } ?>>NOMINATE</a>
<?php } else { ?>							
					<A HREF="/about/">ABOUT</A>
					<A HREF="/get-involved/interested/">REPRESENT</A>
					<A HREF="/get-involved/propose/">NOMINATE</A>
<?php } ?>  
					<A HREF="/where-to-file/prepare-to-file-your-petition-to-the-board-of-elections.html">HOWTO</A>
					<A HREF="/contact/">CONTACT</A>
<?php if ( $MenuLogin == "logged") { ?>
				  <a href="/get-involved/profile/?k=<?= $NewKToEncrypt ?>" class="right<?php if ($BigMenu == "profile") { echo " active"; } ?>">PROFILE</a>
<?php } else { ?>							
					<A HREF="/get-involved/login/">LOGIN</A>
<?php } ?>  
				</DIV>
				<DIV CLASS="FooterSocial">
					<A TARGET="twitter" CLASS="FooterSocial" HREF="https://twitter.com/RepMyBlock">Twitter</A>
					<A TARGET="facebook" CLASS="FooterSocial" HREF="https://www.facebook.com/RepMyBlock">Facebook</A>
					<A TARGET="instagram" CLASS="FooterSocial"  HREF="https://www.instagram.com/RepMyBlockNYC">Instagram</A>
				</DIV>
				<DIV CLASS="FooterStuff">
					<I>RepMyBlock is a <A HREF="https://OutragedDems.NYC">Outraged Dems</A> project.</I>
				</DIV>
			</P>
		</DIV>			
	<?php require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/GoogleAnalytics.php"; ?>
	</BODY>	
</HTML>