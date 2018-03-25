<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/mysql/queries.php";
global $DB;

class voterlist extends queries {

  function voterlist ($debug = 0, $DBFile = "DB_OutragedDems") {
	  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/DBsLogins/" . $DBFile . ".php";
	  $DebugInfo["DBErrorsFilename"] = $DBErrorsFilename;
	  $DebugInfo["Flag"] = $debug;
	 	$this->queries($databasename, $databaseserver, $databaseport, $databaseuser, $databasepassword, $sslkeys, $DebugInfo);
  }
  
	function CheckRawVoterID($SystemUserVoterID) {
		$sql = "SELECT * FROM SystemUserVoter WHERE SystemUser_ID = :SystemUserVoter";
		$sql_vars = array(':SystemUserVoter' => $SystemUserVoterID);											
		return $this->_return_simple($sql,  $sql_vars);
	}
	
	function AddVoterRawVoterID($SystemUser_ID, $RawVoterID) {
		$sql = "INSERT INTO SystemUserVoter SET SystemUser_ID = :SystemUserVoter, Raw_Voter_ID = :Raw_Voter_ID";
		$sql_vars = array(':SystemUserVoter' => $SystemUser_ID, ":Raw_Voter_ID" => $RawVoterID);							
		return $this->_return_nothing($sql,  $sql_vars);
	}
	
	function PrepDisctictVoterRoll($SystemUserID, $RawVoterID, $DatedFiles) {
		// We are checking the files
		$sql = "SELECT * FROM Raw_Voter_Dates WHERE Raw_Voter_Dates_Date = :DatedFile";
		$sql_vars = array(':DatedFile' => $DatedFiles);
		$var = $this->_return_simple($sql, $sql_vars);
		$DateID = $var["Raw_Voter_Dates_ID"];
		
		// Before we start check the candidate file.
		$var = $this->GetPetitionSignNames($SystemUserID, $DateID);
		$Candidate["Candidate_ID"] = $var[0]["Candidate_ID"];
		if ( count($var) > 0) return $Candidate;
				
		// We are getting the RawVoter file
		$var = $this->FindRawVoterbyRawVoterID($DatedFiles, $RawVoterID);
		$var = $this->FindRawVoterbyADED($DatedFiles, $var["Raw_Voter_ElectDistr"],	$var["Raw_Voter_AssemblyDistr"], "DEM", 1, 1);
		
		// Now prep the file to put it in.
		// Create A Candidate ID ...
		
		// Find the information 
		foreach ($var as $vor) {
			
			if ($vor["Raw_Voter_ID"] == $RawVoterID) {
				
        // Fix address
        $FullName = $this->DB_ReturnFullName($vor);
        $Address_Line1 = $this->DB_ReturnAddressLine1($vor);
        $Address_Line2 = $this->DB_ReturnAddressLine2($vor);
        
        // Check that the candidate is there only once
        $sql = "SELECT * FROM Candidate WHERE SystemUser_ID = :SystemUserID AND " .
        				"Raw_Voter_ID = :RawVoterID AND Raw_Voter_Dates_ID = :RawVoterDatesID";
        $sql_vars = array(":SystemUserID" => $SystemUserID, ":RawVoterID" => $RawVoterID, 
        				":RawVoterDatesID" => $DateID);
        $CandidateInfo = $this->_return_simple($sql, $sql_vars);
       	
       	if ( empty ($CandidateInfo)) {        
	        $sql = "INSERT INTO Candidate SET SystemUser_ID = :SystemUserID, " .
	        				"Raw_Voter_ID = :RawVoterID, Raw_Voter_Dates_ID = :RawVoterDatesID, " .
	        				"Candidate_DispName = :FullName, Candidate_DispResidence = :FullAddress";
	        $sql_vars = array(':SystemUserID' => $SystemUserID,
	        				":RawVoterID" => $RawVoterID, ":RawVoterDatesID" => $DateID, 
	        				":FullName" => $FullName, ":FullAddress" => $Address_Line1 . ", " . $Address_Line2);   
	        $this->_return_nothing($sql, $sql_vars);
	      
	      	$sql = "SELECT LAST_INSERT_ID() AS Candidate_ID";
	      	$CandidateInfo = $this->_return_simple($sql);  
	      }
        break;     
      }      
    }
    
    // This is the 
    $Counter = 0;
    foreach ($var as $vor) {
			if (! empty ($vor)) {
				$FullName = $this->DB_ReturnFullName($vor);
        $Address_Line1 = $this->DB_ReturnAddressLine1($vor);
        $Address_Line2 = $this->DB_ReturnAddressLine2($vor);
	
				$sql = "INSERT INTO CandidatePetition SET " .
								"Candidate_ID = :CandidateID, " .
								"CandidatePetition_Order = :Counter, " . 
								"Raw_Voter_ID = :RawVoterID, " .
								"Raw_Voter_Dates_ID = :RawVoterDatesID, " .
								"CandidatePetition_VoterFullName = :VoterFullName, " .
								"CandidatePetition_VoterResidenceLine1 = :Address1, " .
				 				"CandidatePetition_VoterResidenceLine2 = :Address2, " .
								"CandidatePetition_VoterResidenceLine3 = :Address3, " .
								"CandidatePetition_VoterCounty = :County";
	     	
	     	$sql_vars = array(":CandidateID" => $CandidateInfo["Candidate_ID"],
														":Counter" => $Counter++, 
														":RawVoterID" => $vor["Raw_Voter_ID"],
														":RawVoterDatesID" => $DateID,
														":VoterFullName" => $this->DB_ReturnFullName($vor),
														":Address1" => $this->DB_ReturnAddressLine1($vor),
										 				":Address2" => $this->DB_ReturnAddressLine2($vor),
														":Address3" => "",
														":County" => $this->DB_WorkCounty($vor));
							    
				$this->_return_nothing($sql, $sql_vars); 	

    	}
    }	
	}
	
	function DB_WorkCounty($zip) {
		return $zip["Raw_Voter_ResZip"];
	}

	function DB_ReturnAddressLine1($vor) {
		$Address_Line1 = "";
		if ( ! empty ($vor["Raw_Voter_ResHouseNumber"])) { $Address_Line1 .= $vor["Raw_Voter_ResHouseNumber"] . " "; }		
		if ( ! empty ($vor["Raw_Voter_ResFracAddress"])) { $Address_Line1 .= $vor["Raw_Voter_ResFracAddress"] . " "; }		
		if ( ! empty ($vor["Raw_Voter_ResPreStreet"])) { $Address_Line1 .= $vor["Raw_Voter_ResPreStreet"] . " "; }		
		$Address_Line1 .= $vor["Raw_Voter_ResStreetName"] . " ";
		if ( ! empty ($vor["Raw_Voter_ResPostStDir"])) { $Address_Line1 .= $vor["Raw_Voter_ResPostStDir"] . " "; }		
		if ( ! empty ($vor["Raw_Voter_ResApartment"])) { $Address_Line1 .= "- Apt. " . $vor["Raw_Voter_ResApartment"]; }
		$Address_Line1 = preg_replace('!\s+!', ' ', $Address_Line1 );
		return $Address_Line1;
  }
  
  function DB_ReturnAddressLine2($vor) {
  	$Address_Line2 = $vor["Raw_Voter_ResCity"] . ", NY " . $vor["Raw_Voter_ResZip"];
    return $Address_Line2;
  }
	
	function DB_ReturnFullName($vor) {
		$FullName = $vor["Raw_Voter_FirstName"] . " ";
		if ( ! empty ($vor["Raw_Voter_MiddleName"])) { $FullName .= substr($vor["Raw_Voter_MiddleName"], 0, 1) . ". "; }
		$FullName .= $vor["Raw_Voter_LastName"] ." ";
		if ( ! empty ($vor["Raw_Voter_Suffix"])) { $FullName .= $vor["Raw_Voter_Suffix"]; }				
		$FullName = ucwords(strtolower($FullName));
		return $FullName;
	}	
	
	function FindRawVoterbyADED($DatedFiles, $EDist, $ADist, $Party = "", $Active = 1, $order = 0) {
		
		$TableVoter = "Raw_Voter_" . $DatedFiles;
		$sql = "SELECT * FROM " . $TableVoter . " WHERE " . 
						"Raw_Voter_AssemblyDistr = :AssDist AND Raw_Voter_ElectDistr = :ElectDist ";
		$sql_vars = array('AssDist' => $ADist, 'ElectDist' => $EDist);				
		
		if ( $Active == 1) {
			$sql .= "AND Raw_Voter_Status = 'ACTIVE' ";
		}
		
		if ( ! empty ($Party)) {
			$sql .= "AND Raw_Voter_EnrollPolParty = :Party ";
			$sql_vars[":Party"] = $Party;
		}
		
		if ( $order > 0) {
			$sql .= "ORDER BY Raw_Voter_ResStreetName, Raw_Voter_ResHouseNumber, Raw_Voter_ResApartment";
		}
		
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function FindRawVoterbyRawVoterID($DatedFiles, $RawVoterID) {
		$TableVoter = "Raw_Voter_" . $DatedFiles;
		$sql = "SELECT * FROM " . $TableVoter . " WHERE Raw_Voter_ID = :RawVoterID";
		$sql_vars = array('RawVoterID' => $RawVoterID);							
		return $this->_return_simple($sql, $sql_vars);
	}
	
	function GetPetitionSignNames($SystemID, $DateID) {
		$sql = "SELECT * FROM Candidate LEFT JOIN CandidatePetition " .
						"ON (Candidate.Candidate_ID = CandidatePetition.Candidate_ID) " .
						"WHERE SystemUser_ID = :SystemUserID AND " . 
						"CandidatePetition.Raw_Voter_Dates_ID = :DateID";
		$sql_vars = array(":SystemUserID" => $SystemID, ":DateID" => $DateID);
		return $this->_return_multiple($sql, $sql_vars);
	}
	
}


?>
