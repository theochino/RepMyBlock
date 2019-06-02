<?php
	$BigMenu = "represent";
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_voterlist.php";	
	$r = new voterlist();
	
	if ( ! empty ($_POST)) {
		
		
		$PetitionSetID = $r->CreatePetitionSet($Candidate_ID, $_POST["CandidatePetition"]);
		
		$EncryptURL = EncryptURL("SystemUser_ID=" . $SystemUser_ID . "&RawVoterID=" . $RawVoterID . 
									"&DatedFiles=" . $DatedFiles . 
									"&ElectionDistrict=" . $ElectionDistrict . "&AssemblyDistrict=" . $AssemblyDistrict . 
									"&FirstName=" . $FirstName . "&LastName=" . $LastName .
									"&Candidate_ID=" . $Candidate_ID . "&CandidatePetitionSet_ID=" . $PetitionSetID);
									
		header("Location: /get-involved/list/printpetitionset/?k=" . $EncryptURL);
		exit();
	}
	
	
	$result = $r->GetPetitionsForCandidate($Candidate_ID, "DEM", "Active");	
	include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/headers.php";
?>
<meta name="viewport" content="width=device-width, initial-scale=1">

		<STYLE>
.accordion {
  background-color: #007399;
  
	color: white;
  display:inline-block;
  cursor: pointer;
  padding: 15px;
  width: 96%;
  border: 2px;
  text-align: left;
  outline: none;
  font-size: 15px;
  transition: 0.4s;  
}



.active, .accordion:hover {
  background-color: #ccc;
  color: black;
}

.panel {
  padding: 0 18px;
  background-color: red; /* white; */
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.2s ease-out;
   width: 96%;
}

.divTable {
    display:  table;
    width:96%;
    background-color:#eee;
    border:1px solid  #666666;
    border-spacing:5px;/*cellspacing:poor IE support for  this*/
   /* border-collapse:separate;*/
}

.divRow {
   display:table-row;
   width:auto;
}

.divCell {
    float:left;/*fix for  buggy browsers*/
    display:table-column;  
}

		</STYLE>
		
<div class="row">
  <div class="side">
  	
 			
 				<h1>Election District <?= $ElectionDistrict ?>, Assembly District <?= $AssemblyDistrict ?></H1>
  			
			  <div class="column" style="background-color:#fff;">
			   
					<P>
						<B><?= $ResultVoter["Raw_Voter_FirstName"] ?>
							 <?= $ResultVoter["Raw_Voter_MiddleName"] ?>
							 <?= $ResultVoter["Raw_Voter_LastName"] ?>
							 <?= $ResultVoter["Raw_Voter_Suffix"] ?></B>
					<BR>
						<?= $ResultVoter["Raw_Voter_ResHouseNumber"] ?>
						<?= $ResultVoter["Raw_Voter_ResFracAddress"] ?>
						<?= $ResultVoter["Raw_Voter_ResPreStreet"] ?>
						<?= $ResultVoter["Raw_Voter_ResStreetName"] ?>
						<?= $ResultVoter["Raw_Voter_ResPostStDir"] ?>
						<?= $ResultVoter["Raw_Voter_ResApartment"] ?><BR>
						<?= $ResultVoter["Raw_Voter_ResCity"] ?>, NY
						<?= $ResultVoter["Raw_Voter_ResZip"] ?>
					</P>
	</div>
<div class="main">

		<h1>Election District <?= $ElectionDistrict ?>, Assembly District <?= $AssemblyDistrict ?></H1>
		
		<H2>There are <?= count ($result) ?> democratic voters in this district</H2>

	  <P>
	  	Select all the voters you would like to include in your petition set.<BR>
	  	Once you selected the voters you are going to petition, click on the "Create the petition set" button.
	  </P>

		<P>
			<input type="text" id="myInput" onkeyup="SearchInformation()" SIZE=50 placeholder="Search for names ...">
		</P>
		
	  
	  	<FORM ACTION="" METHOD="POST" ID="form-id">
	  		
			<P ID="resultprintarea"></P>
	  
	  <p>
	  	<label for="submit">
	  		<button class="btn success">Create the petition set.</button>
	  	</LABEL>
	  </P>

	  <?php
	 
	  	$prev_datastreet_id = null;
	  	$counter = 0; $limit = 25;
	  	
			if (! empty ($result)) {
				foreach ($result as $var) {
					if (! empty ($var)) {
						
						if ( ($counter % $limit) == 0 ) {
							if ( $counter > 0 != null) { 
								echo "</DIV>\n";
								echo "</DIV>\n";
								echo "<P><A HREF=\"/get-involved/list/?k=" . $k ."\">Return to previous screen</A></P>\n";
							}		

							echo "\t<A class=\"accordion\" onClick=\"runAccordion();\">";									
							echo "<span style=\"text-shadow:1px 1px 0 #444;font-weight: bold;font-size: large;\">Registered voter group from " . ($counter+1) . " to " . ($counter + $limit + 1) . "</SPAN>";
							echo "</A>\n";
							echo "<div class=\"panel\">\n";
							echo "\t<div class=\"divTable\">\n";
							echo "<input type=\"checkbox\" onClick=\"toggle(this," . $counter . "," .  $limit . ")\" /> Toggle this group<br/>\n";
						}	 ?>
			
						<DIV class="divRow" id="Voter">
							<DIV class="divCell" align="center"><INPUT CLASS="CheckBoxed" OnClick="checkFormList(<?= $var["CandidatePetition_Order"] ?>, this.checked)" ID="original" TYPE="CHECKBOX" NAME="CandidatePetition[]" VALUE="<?= $var["CandidatePetition_ID"] ?>"></DIV>
							<DIV class="divCell" align="center"><SPAN CLASS="Order"><?= $var["CandidatePetition_Order"] ?></SPAN>&nbsp;</DIV>
							<DIV class="divCell" name="FullName"><B><SPAN CLASS="FullName"><?= $var["CandidatePetition_VoterFullName"] ?></SPAN></B>&nbsp;</DIV>
							<DIV class="divCell"><SPAN CLASS="ResLine1"><?= $var["CandidatePetition_VoterResidenceLine1"] ?></SPAN>&nbsp;</DIV>
							<DIV class="divCell"><SPAN CLASS="ResLine2"><?= $var["CandidatePetition_VoterResidenceLine2"] ?></SPAN>&nbsp;</DIV>
							<DIV class="divCell"><SPAN CLASS="SignedDate"><?= $var["CandidatePetition_SignedDate"] ?></SPAN>&nbsp;</DIV>
						</DIV>
			
						<?php	
							$counter++;	
						?>
		<?php 		
					}	
				}
			}
		?>	
		
	</DIV>
</DIV>
</div>
<P><A HREF="/get-involved/list/?k=<?= $k ?>">Return to previous screen</A></P>
			
			</FORM>	
	</DIV>

		
		<script>
			
			function runAccordion() {
				var acc = document.getElementsByClassName("accordion");
				var i;

				for (i = 0; i < acc.length; i++) {
				  acc[i].addEventListener("click", function() {
				    this.classList.toggle("active");
				    var panel = this.nextElementSibling;
				    if (panel.style.maxHeight){
				      panel.style.maxHeight = null;
				    } else {
				      panel.style.maxHeight = panel.scrollHeight + "px";
				    } 
				  });
				}
			}
		
			function toggle(source, counter, limit) {
			  checkboxes = document.getElementsByName('CandidatePetition[]');
			  for(var i = counter; i < (counter + limit); i++) {
			    checkboxes[i].checked = source.checked;
			  }
			}
			
			function checkFormList(CheckedID, MyCheckStatus) {
				checkbox = document.getElementById("duplicateform-" + CheckedID);			
				if(checkbox == null ) return;
				//alert("CheckQueryForm: " + MyCheckStatus);			
				checkbox.checked = MyCheckStatus;
			}
			
			function checkMasterList(CheckedID) {
				checkboxes = document.getElementsByName('CandidatePetition[]');
				if ( 	checkboxes[CheckedID].checked == true ) {
					checkboxes[CheckedID].checked = false;
				} else {
					checkboxes[CheckedID].checked = true;
				}			
			}

			function SearchInformation() {
				
				var filter, i, myvalue = "";
				
				filter = document.getElementById('myInput').value.toUpperCase();
			
				if(filter.length == 0 ) {
					document.getElementById("resultprintarea").innerHTML = "";
					return;
				} 
				
				var votercount = document.getElementsByName("FullName");

				var checkbox = document.getElementsByClassName("CheckBoxed");
				var order = document.getElementsByClassName("Order");
				var resline1 = document.getElementsByClassName("ResLine1");
				var resline2 = document.getElementsByClassName("ResLine2");
				var signeddate = document.getElementsByClassName("SignedDate");			
			
				//myvalue = "<DIV class=\"divRow\" id=\"Voter\">";
			
				for (i = 0; i < votercount.length; i++) {					
					if ( votercount[i].outerHTML.toUpperCase().indexOf(filter) > -1) {
						var idtoprint = order[i].innerHTML.trim();
						myvalue += "<DIV class=\"divCell\" align=\"center\"><INPUT FORM=\"form-id\" ";
						if ( checkbox[i].checked == true) {	myvalue += "CHECKED "; }
						myvalue += "onclick=\"checkMasterList(" + idtoprint + ")\" ID=\"duplicateform-" + idtoprint + 
												"\" TYPE=\"CHECKBOX\" NAME=\"CandidatePetition_Duplicate[]\" VALUE=\"" 
												+ checkbox[i].value + "\"></DIV>" +
							"<DIV class=\"divCell\" align=\"center\">" + idtoprint + "&nbsp;</DIV>" + 
							"<DIV class=\"divCell\"><B>" + votercount[i].innerHTML + "</B>&nbsp;</DIV>" +
							"<DIV class=\"divCell\"><SPAN CLASS=\"ResLine1\">" + resline1[i].innerHTML + "</SPAN>&nbsp;</DIV>" +
							"<DIV class=\"divCell\"><SPAN CLASS=\"ResLine2\">" + resline2[i].innerHTML + "</SPAN>&nbsp;</DIV>" + 
							"<DIV class=\"divCell\"><SPAN CLASS=\"SignedDate\">" + signeddate[i].innerHTML + "</SPAN>&nbsp;</DIV>" + 
							"<P><BR></P>";
						 ;
					}
				}
				//myvalue += "</DIV>";
			
				document.getElementById("resultprintarea").innerHTML = myvalue;
			}
		</script>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/footer.php"; ?>