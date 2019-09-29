<?php 
	date_default_timezone_set('America/New_York'); 
	require $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_outrageddems.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	
	include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/headers.php";		
?>

<div class="row">	
  <div class="main">
<P>
	<H2>Sorry, we did not find you in the Voter Database.</H2>
	Our database is current as of <B></B><?= date('F j<\S\U\P>S</\S\U\P>, Y', strtotime( $DatedFiles )) ?>.<BR></B>
</P>

<P>
	Did you register with the Board of Election after <?= date('d/m/Y', strtotime( $DatedFiles )) ?>?<BR>
	Are you a New York State Registered voter in one of <B>the recognized parties</B>?
</P>

<P>
	<h3><A HREF="<?= $NYVoterRegistration ?>" TARGET="BOS">Check the New York State Board of Election website</A>.</H3>
</P>

<P>
	You can go back to <A HREF="../?k=<?= $k ?>">the previous page</A> and try a different spelling of your name.<BR>
</P>

<P>
	<A HREF="../index.php?k=<?= $k ?>">Return to the previous page</A></B>
</P>
</DIV>
</DIV>

<?php	include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/footer.php";	?>
