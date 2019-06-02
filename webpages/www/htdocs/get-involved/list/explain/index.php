<?php
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	$BigMenu = "represent";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_login.php";  
  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";

	$r = new login();
	$result = $r->FindSystemUser_ID($SystemUser_ID) ;
	$result = $result[0];
	
//	$ResultVoter = $r->FindRawVoterInfoFromSystemID($SystemUser_ID, $DatedFilesID, $DatedFiles);
//	$resultcandidates = $r->FindCandidatesInDistrict($result["SystemUser_EDAD"]);
	include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/headers.php";
?>

<div class="row">
  <div class="main">
		<h2>Election District <?= $ElectionDistrict ?>, Assembly District <?= $AssemblyDistrict ?></H2>

<?php
		if ( ! empty ($successmsg)) {
			echo "<P><B><FONT SIZE=+1 COLOR=GREEN>" . $successmsg . "</FONT></B></P>";
		}
?>


<?php
		$NewKEncrypt = EncryptURL($NewK . "&Candidate_ID=" . $result[0]["Candidate_ID"]);
?>	

		<h2>List of voters in your area.</H2>	
		
		<P>
			<?php /*
			This is the information we found about you in the voter file and it should be correct.
			*/ ?>
			The first step is to create a petition for you.
		</P>


		<?php 
		/*
		<?php if ( ! empty($resultcandidates)) { ?>
		<P>
			We also found that another person is running in your district. We would highly suggest that 
			you reach out to that person and see if you can work together.
			
			<UL>
			<?php foreach ($resultcandidates as $var) { 
				if (! empty ($var)) { ?>
					<?= $var["Candidate_DispName"] ?> - <A HREF="SendEmail.php">Send and email to <?= $var["Candidate_DispName"] ?></A><BR>
			<?php }
			}  ?>
			</UL>
		
		</P>
		<?php } ?>
		*/ 
		?>
			
		<P>
			You will need to prepare the petition by clicking on the link below.
		</P>
		
		
		
		<P>	
			<FONT SIZE=+3><B><A HREF="/get-involved/list/prepvoters/?k=<?= EncryptURL("SystemUser_ID=" . $SystemUser_ID .
																																								"&ElectionDistrict=" . $ElectionDistrict .
																																								"&AssemblyDistrict=" . $AssemblyDistrict); ?>">Prepare the petitions</A></B></FONT>
		</P>
		
		<P>
			Knock on your neiboor door and ask them to sign your petition. It doesn't mean they 
			have to vote for you, simply that you are interested in the position and would like them to nominate you.
		</P>
	
	</div>
</DIV>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/footer.php";	?>