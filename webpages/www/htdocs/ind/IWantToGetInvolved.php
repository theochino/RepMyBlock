<?php
$SavedEmail = "";	
	date_default_timezone_set('America/New_York'); 
		
	if (! empty ($_POST["email"])) {
		$SavedEmail = "ok";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_OutragedDems.php";
		$r = new OutragedDems();
		$r->InsertEmail($_POST["email"]);
		header ("location: /wp/index.php/thanks/");
	}
?>
<HTML>
	<HEAD>
		<TITLE>New York County Committee - Outraged Democrats</TITLE>
	</HEAD>
	
	<BODY>
		<TABLE BORDER=0 WIDTH=100%>
			<TR>
				<TD ROWSPAN=2><A HREF="/wp"><IMG SRC="/pics/OutragedDemocratSM.png"></A></TD>
				<TD><H1>OutragedDems.NYC</H1></TD>
			</TR>
			<TR>
			</TR>
		</TABLE>
		
		

<?php if ($SavedEmail == "ok") { ?>
		<P>
			<FONT COLOR=BROWN><B>Your email address <FONT COLOR=BLACK><?= $_POST["email"] ?></FONT> has been saved.</B></FONT><BR>
			We'll contact shortly with all the info.	
		</P>
<?php } else { ?>		
		<P><h1>
			<FORM ACTION="" METHOD="POST">
				<B>Please leave your email address and once the website is ready, we'll contact you so you can register.</B><BR>
				<INPUT TYPE="TEXT" NAME="email" SIZE=40> 
				<INPUT TYPE="SUBMIT" VALUE="submit">
			</FORM>
		</H1>
		</P>
<?php } ?>
		
	<A HREF="/wp">Return to main page</A>
		
	</BODY>
</HTML>
