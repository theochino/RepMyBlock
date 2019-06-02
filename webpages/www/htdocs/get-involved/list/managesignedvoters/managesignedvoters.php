<?php
	$BigMenu = "represent";
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_voterlist.php";	
	
	$r = new voterlist();
	$result = $r->GetSignedElectors($Candidate_ID);
	$EncryptURL = EncryptURL("CandidateID=" . $Candidate_ID . "&PetitionSetID=" . $CandidatePetitionSet_ID);
	
	include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/headers.php";		
?>

<div class="main">
		<h1>Election District <?= $ElectionDistrict ?>, Assembly District <?= $AssemblyDistrict ?></H1>
			
		<H2>Managed the electors that signed your petition</H2>
		
		<P>
			If you need to unmark a signed petition.
		</P>
		
		<TABLE BORDER=1>		
			<TR>
			  <TH>Order</TH>
			  <TH>Full Name</TH>
			  <TH>Residence Line 1</TH>
			  <TH>Residence Line 2</TH>
			  <TH>Residence Line 3</TH>
			  <TH>Petition Signed Date</TH>
			  <TH>&nbsp;</TH>
			</TR>
			<?php
				if (! empty ($result)) {
					foreach ($result as $var) {
						if (! empty ($var)) { ?>
						<TR>
	            <TD ALIGN=CENTER><?= $var["CandidatePetition_Order"] ?></TD>
	            <TD>&nbsp;<?= $var["CandidatePetition_VoterFullName"] ?></TD>
	            <TD>&nbsp;<?= $var["CandidatePetition_VoterResidenceLine1"] ?></TD>
	            <TD>&nbsp;<?= $var["CandidatePetition_VoterResidenceLine2"] ?></TD>
	            <TD>&nbsp;<?= $var["CandidatePetition_VoterResidenceLine3"] ?></TD>
	            <TD ALIGN=CENTER>&nbsp;<?= $var["CandidatePetition_SignedDate"] ?></TD>
	            <TD ALIGN=CENTER><?php
	            	if ( ! empty ($var["CandidatePetition_SignedDate"] )) {
	            		$NewK = EncryptURL("SystemUser_ID=" . $SystemUser_ID . "&RawVoterID=" . $RawVoterID . "&DatedFiles=" . $DatedFiles . 
	            												"&CandidatePetition_ID=" . $var["CandidatePetition_ID"] . "&Candidate_ID=" . $Candidate_ID);
	            		?>	            		
	            		<BUTTON type="button" id="demo-<?= $var["CandidatePetition_ID"] ?>" onclick="loadDoc(<?= $var["CandidatePetition_ID"] ?>, '<?= $NewK ?>')">Removed the signed date</BUTTON>
	            		<?php
	            	}
	            	?></TD> 
						</TR>						
			<?php 
						}	
					}
				}
			?>	
		</TABLE>
		</FORM>
			
		<P>
			<A HREF="/get-involved/list/?k=<?= $k ?>">Return to previous screen</A>	
		</P>
		
</DIV>

		<script>
		function loadDoc(IdToMark, k) {
		  var xhttp = new XMLHttpRequest();
		  xhttp.onreadystatechange = function() {
		    if (this.readyState == 4 && this.status == 200) {
		      document.getElementById("demo-"+IdToMark).innerHTML = this.responseText;
		    }
		  };
		  xhttp.open("GET", "unmarksigned.php?k=" + k, true);
		  xhttp.send();
		}
		</script>
	
<?php include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/footer.php";	?>