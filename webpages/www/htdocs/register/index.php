<?php 
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";

	if ( ! empty ($_POST)) {
		
		// Save the information into the database.
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_outrageddems.php";	

		$r = new OutragedDems();
		
		// Before saving, we must check it doesn't exit.
		
		$result = $r->CheckRegisterEmail($_POST["Email"]);
		if ( empty ($result["SystemUser_email"])) {
			$result = $r->InsertEmail($_POST["Email"]);
		}			
		
		
		
		$URL = "saved_email.php?k=" . EncryptURL("email=" . $_POST["ED"] . "&AD=" . $_POST["AD"] . "&Email=" . $_POST["Email"] .
								 "&FirstName=" . $_POST["FN"] . "&LastName=" . $_POST["LN"] . "&DOB=" . $_POST["DOB"]);						 
								 
		$URL = "/word/?page_id=35";
		header("Location: $URL");	
		exit();
	}
	
?>


<link rel="stylesheet" type="text/css" href="../maps/maps.css">

<div class="header">
  <a href="/" class="logo"><IMG SRC="/pics/OutragedDemLogo.png"></a>
  <div class="header-right">
    <a class="active" href="/">Home</a>
    <a href="/contact">Contact</a>
    <a href="/about">About</a>
  </div>
</div> 


<UL>


	<P>
		OutragedDems will help organize the logistic, all you need to do is ask your neirboors to sign the petitions.
	</P>

	<P>
		<FORM ACTION="" METHOD="POST">
			<INPUT TYPE="TEXT" NAME="Email" SIZE=40>
			<INPUT TYPE="SUBMIT" VALUE="Notify me by email when the system is ready">
		</FORM>
	</P>

</UL>
