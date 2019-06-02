<?php 
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";

	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_stats.php";	
	
	$r = new stats();
	$result = $r->CandidatesStats();
	
	// print "Result: <PRE>" . print_r($result,1 ) . "</PRE>";

	
	include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/headers.php";
?>
<div class="main">
	
<P>
	<h2>Report on the number of candidates for each AD and ED</H2>
</P>

<P>
	If you would like to represent your block, <B><A HREF="/get-involved/interested">check the requirements for your area here</A></B>
</P>

<div class="container">
		
		<CENTER>
		<TABLE BORDER=1>
			<TR>
				<TH>Map</TH>
				<TH>Assembly<BR>District</TH>
				<TH>Election<BR>District</TH>
				<TH>Number of<BR>candidates</TH>
				<TH>Number of<BR>voters</TH>
				<TH>Number of<BR>signatures required</TH>
			</TR>
			
<?php	
		if ( ! empty ($result)) {
			foreach ($result as $var) {
				if ( ! empty ($var)) {
					
					$PictureID = $var["GeoDesc_ID"];
					$PictureDir = intval( $PictureID /100);
					$PicURL = $FrontEndStatic . "/maps/" . $PictureDir . "/Img-" . $PictureID . ".jpg";	
					
					preg_match('/(\d{2})(\d{3})/', $var["CandidateElection_DBTableValue"], $matches, PREG_OFFSET_CAPTURE);
					$ADMatch = intval($matches[1][0]);
					$EDMatch = intval($matches[2][0]);
					
	
?>					
					<TR ALIGN=CENTER>
<?php if ( ! empty ($PictureID)) { ?>						
						<TD><a target="_blank" class="district" href="/get-involved/interested/showdistrict.php?GeoCodeID=<?= $PictureID ?>"><img id="myimage" src="<?= $PicURL ?>" alt="District"></a></TD>
<?php } else { ?>
						<TD><a class="district"><img id="myimage" src="<?= $FrontEndStatic . "/maps/0/Img-0.jpg";	 ?>" alt="District"></A></TD>
<?php } ?>
						<TD><?= $ADMatch ?></TD>
						<TD><?= $EDMatch ?></TD>
						<TD>1</TD>
						<TD><?= $var["CandidateElection_CountVoter"] ?></TD>
						<TD><?= intval($var["CandidateElection_CountVoter"] * $SignaturesRequired) + 1 ?></TD>
					</TR>
				

<?php				
				}
			}
		}
?>
			
			
		</CENTER>
			
		</TABLE>

		
	
	
</div> 

</DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/footer.php"; ?>

