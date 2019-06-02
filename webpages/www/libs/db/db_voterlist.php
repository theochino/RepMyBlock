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
	
	function ReturnCandidateIDForCCElection($CandidateElection_ID, $EDAD, $SystemUser_ID, $UniqID, $DatedFilesID, $DatedFile) {
		$sql = "SELECT * FROM Raw_Voter_" . $DatedFile . " WHERE " . 
						"Raw_Voter_" . $DatedFile . ".Raw_Voter_UniqNYSVoterID = :Uniq AND " . 
						"Raw_Voter_" . $DatedFile . ".Raw_Voter_Status = 'ACTIVE'";
		$sql_vars = array(':Uniq' => $UniqID);					
		
		$RawVoter = null;
		
		$result = $this->_return_simple($sql,  $sql_vars);	
		
		$FullName = $this->DB_ReturnFullName($result);
    $Address_Line1 = $this->DB_ReturnAddressLine1($result);
    $Address_Line2 = $this->DB_ReturnAddressLine2($result);
	
   $sql = "INSERT INTO Candidate SET SystemUser_ID = :SystemID, Raw_Voter_ID = :RawVoter, " .
						"Raw_Voter_DatedTable_ID = :DatedTableID, Raw_Voter_Dates_ID = :DatedTableDateID, " . 
						"CandidateElection_ID = :CandidateElectionID, 	Candidate_DispName = :CandidateName, " . 
						"Candidate_DispResidence = :CandidateResidence, CandidateElection_DBTable = 'EDAD', " .
						"CandidateElection_DBTableValue = :EDAD, Candidate_Status = 'published'";
		$sql_vars = array(':SystemID' => $SystemUser_ID, ':RawVoter' => $RawVoter, ':DatedTableID' => $DatedFile, 
											':DatedTableDateID' => $DatedFilesID, ':CandidateElectionID' => $CandidateElection_ID,
											':CandidateName' => $FullName, ':CandidateResidence' => $Address_Line1 . ", " . $Address_Line2, 
											':EDAD' => $EDAD);
	 	$this->_return_nothing($sql,  $sql_vars);		
		
		$sql = "SELECT LAST_INSERT_ID() as Candidate_ID";
		return $this->_return_simple($sql);
		
		
		
	}
	
	function AddCandidateWitnessID($Candidate_ID, $CandidateWitness_ID) {
		$sql = "INSERT INTO CanWitnessSet SET Candidate_ID = :CandidateID, CandidateWitness_ID = :CandidateWitnessID";
		$sql_vars = array("CandidateID" => $Candidate_ID, "CandidateWitnessID" => $CandidateWitness_ID);
		return $this->_return_nothing($sql, $sql_vars);		
	}
	
	function FindSystemUser_ID($SystemUserVoterID) {
		$sql = "SELECT * FROM SystemUser " .
						"LEFT JOIN Candidate ON (Candidate.SystemUser_ID = SystemUser.SystemUser_ID) " . 
						"WHERE SystemUser.SystemUser_ID = :SystemUserVoter";
		$sql_vars = array(':SystemUserVoter' => $SystemUserVoterID);											
		return $this->_return_multiple($sql,  $sql_vars);
	}
	
	function PrepDisctictCCVoters($Candidate_ID, $System_ID, $DatedFiles, $ElectDistr,	$AssemblyDistr) {
	 	$sql = "INSERT INTO CandidatePetitionSet SET SystemUser_ID = :System_ID, CandidatePetitionSet_TimeStamp = NOW();";
    $sql_vars = array(':System_ID' => $System_ID);   
    $this->_return_nothing($sql, $sql_vars);
    
   	$sql = "SELECT LAST_INSERT_ID() as CandidatePetitionSetID";
		$result = $this->_return_simple($sql);	
		
    $sql = "INSERT INTO CanPetitionSet SET CandidatePetitionSet_ID = :CandidatePetitionSetID, Candidate_ID = :CandidateID";
    $sql_vars = array(':CandidatePetitionSetID' => $result["CandidatePetitionSetID"], ':CandidateID' => $Candidate_ID);   
    $this->_return_nothing($sql, $sql_vars);
     
 		$var = $this->FindRawVoterbyADED($DatedFiles, $ElectDistr,	$AssemblyDistr, "DEM", 1, 1);
    
    // This is the 
    $Counter = 0;
    foreach ($var as $vor) {
			if (! empty ($vor)) {
				$FullName = $this->DB_ReturnFullName($vor);
        $Address_Line1 = $this->DB_ReturnAddressLine1($vor);
        $Address_Line2 = $this->DB_ReturnAddressLine2($vor);
        
    		// This is awfull but we need to go trought the list to find the VotersIndexes_ID
        $VoterIndexesID = $this->GetVotersIndexesIDfromNYSCode($vor["Raw_Voter_UniqNYSVoterID"]);
        	
				$sql = "INSERT INTO CandidatePetition SET " .
								"Candidate_ID = :CandidateID, " .
								"CandidatePetition_Order = :Counter, " . 
								"VotersIndexes_ID = :VotersIndexesID, " .
								"Raw_Voter_DatedTable_ID = :RawVoterID, " .
								"Raw_Voter_Dates_ID = :RawVoterDatesID, " .
								"CandidatePetition_VoterFullName = :VoterFullName, " .
								"CandidatePetition_VoterResidenceLine1 = :Address1, " .
				 				"CandidatePetition_VoterResidenceLine2 = :Address2, " .
								"CandidatePetition_VoterResidenceLine3 = :Address3, " .
								"CandidatePetition_VoterCounty = :County";
	     	
	     	$sql_vars = array(":CandidateID" => $Candidate_ID,
														":Counter" => $Counter++, 
														":RawVoterID" => $vor["Raw_Voter_ID"],
														":VotersIndexesID" => $VoterIndexesID["VotersIndexes_ID"], 
														":RawVoterDatesID" => $DateID,
														":VoterFullName" => $this->DB_ReturnFullName($vor),
														":Address1" => $this->DB_ReturnAddressLine1($vor),
										 				":Address2" => $this->DB_ReturnAddressLine2($vor),
														":Address3" => "",
														":County" => $this->DB_WorkCounty($vor["Raw_Voter_CountyCode"]));
							    
				$this->_return_nothing($sql, $sql_vars); 	

    	}
    }	
  }
	
	function PrepDisctictVoterRoll($SystemUserID, $RawVoterID, $DatedFiles, $ElectionID = null) {
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
		
		// This is awfull but we need to go trought the list to find the VotersIndexes_ID
 		// Add this to CanPetitionSet.
 		
 		$sql = "INSERT INTO CandidatePetitionSet SET SystemUser_ID = :SystemUser_ID";
 		$sql_vars = array(':SystemUser_ID' => $SystemUserID);
		$this->_return_nothing($sql, $sql_vars);
		
 		$sql = "SELECT LAST_INSERT_ID() as CandidatePetitionSet_ID";
		$CandidatePetitionSet = $this->_return_simple($sql);
		 		
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
        $sql_vars = array(":SystemUserID" => $SystemUserID, ":RawVoterID" => $RawVoterID, ":RawVoterDatesID" => $DateID);
        $CandidateInfo = $this->_return_simple($sql, $sql_vars);
        

       	if ( empty ($CandidateInfo)) {        
	        $sql = "INSERT INTO Candidate SET SystemUser_ID = :SystemUserID, " .
	        				"Raw_Voter_DatedTable_ID = :RawVoterID, Raw_Voter_Dates_ID = :RawVoterDatesID, Candidate_Status = 'published', " .
	        				"Candidate_DispName = :FullName, Candidate_DispResidence = :FullAddress, CandidateElection_ID = :CandidateElectionID";
	        $sql_vars = array(':SystemUserID' => $SystemUserID,	":RawVoterID" => $RawVoterID, ":RawVoterDatesID" => $DateID, 
	        				":FullName" => $FullName, ":FullAddress" => $Address_Line1 . ", " . $Address_Line2, ":CandidateElectionID" => $ElectionID);   
	        $this->_return_nothing($sql, $sql_vars);
	      
	      	$sql = "SELECT LAST_INSERT_ID() AS Candidate_ID";
	      	$CandidateInfo = $this->_return_simple($sql);  
	      }
        break;     
      }      
    }
       
    /// Need to add 
    $sql = "INSERT INTO CanPetitionSet SET CandidatePetitionSet_ID = :CandidatePetitionSetID, Candidate_ID = :Candidate_ID";
    $sql_vars = array(':CandidatePetitionSetID' => $CandidatePetitionSet["CandidatePetitionSet_ID"],	":Candidate_ID" =>  $CandidateInfo["Candidate_ID"]);   
    $this->_return_nothing($sql, $sql_vars);
    
    // This is the 
    $Counter = 0;
    foreach ($var as $vor) {
			if (! empty ($vor)) {
				$FullName = $this->DB_ReturnFullName($vor);
        $Address_Line1 = $this->DB_ReturnAddressLine1($vor);
        $Address_Line2 = $this->DB_ReturnAddressLine2($vor);
        
    		// This is awfull but we need to go trought the list to find the VotersIndexes_ID
        $VoterIndexesID = $this->GetVotersIndexesIDfromNYSCode($vor["Raw_Voter_UniqNYSVoterID"]);
        	
				$sql = "INSERT INTO CandidatePetition SET " .
								"Candidate_ID = :CandidateID, " .
								"CandidatePetition_Order = :Counter, " . 
								"VotersIndexes_ID = :VotersIndexesID, " .
								"Raw_Voter_DatedTable_ID = :RawVoterID, " .
								"Raw_Voter_Dates_ID = :RawVoterDatesID, " .
								"CandidatePetition_VoterFullName = :VoterFullName, " .
								"CandidatePetition_VoterResidenceLine1 = :Address1, " .
				 				"CandidatePetition_VoterResidenceLine2 = :Address2, " .
								"CandidatePetition_VoterResidenceLine3 = :Address3, " .
								"CandidatePetition_VoterCounty = :County";
	     	
	     	$sql_vars = array(":CandidateID" => $CandidateInfo["Candidate_ID"],
														":Counter" => $Counter++, 
														":RawVoterID" => $vor["Raw_Voter_ID"],
														":VotersIndexesID" => $VoterIndexesID["VotersIndexes_ID"], 
														":RawVoterDatesID" => $DateID,
														":VoterFullName" => $this->DB_ReturnFullName($vor),
														":Address1" => $this->DB_ReturnAddressLine1($vor),
										 				":Address2" => $this->DB_ReturnAddressLine2($vor),
														":Address3" => "",
														":County" => $this->DB_WorkCounty($vor["Raw_Voter_CountyCode"]));
							    
				$this->_return_nothing($sql, $sql_vars); 	

    	}
    }	
    
    return $CandidateInfo;
	}
	
	function DB_WorkCounty($CountyID) {
		$County = $this->GetCountyFromNYSCodes($CountyID);
		return $County["DataCounty_Name"];	
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
	
	### This is going to be trouble.
	function GetPetitionsForCandidate($CandidateID, $RegParty = null, $Status = null) {
		$sql = "SELECT * FROM CandidatePetition " .
						"LEFT JOIN VotersIndexes ON (CandidatePetition.VotersIndexes_ID = VotersIndexes.VotersIndexes_ID) " .
		//			"LEFT JOIN Raw_Voter_TrnsTable ON (Raw_Voter_TrnsTable.VotersIndexes_ID =  CandidatePetition.VotersIndexes_ID AND Raw_Voter_TrnsTable.Raw_Voter_Dates_ID =  CandidatePetition.Raw_Voter_Dates_ID) " .
		//			"LEFT JOIN Raw_Voter ON (Raw_Voter.Raw_Voter_ID =  Raw_Voter_TrnsTable.Raw_Voter_ID) " .
		//			"LEFT JOIN DataHouse ON (DataHouse.DataHouse_ID = Raw_Voter_TrnsTable.DataHouse_ID ) " . 
		//			"LEFT JOIN DataAddress ON (DataHouse.DataAddress_ID = DataAddress.DataAddress_ID) " . 
		//			"LEFT JOIN DataStreet ON (DataAddress.DataStreet_ID = DataStreet.DataStreet_ID) " . 
		//			"LEFT JOIN Cordinate ON (DataAddress.Cordinate_ID = Cordinate.Cordinate_ID) " .
						"WHERE Candidate_ID = :CandidateID";
		$sql_vars = array("CandidateID" => $CandidateID);
						
		//	if ( ! empty ($Status)) {
		//		$sql .= " AND Raw_Voter_Status = :Status";
		//		$sql_vars["Status"] = $Status;
		//	} 
			
		//	if ( ! empty ($RegParty)) {
		//		$sql .= " AND Raw_Voter_RegParty = :Party";
		//		$sql_vars["Party"] = $RegParty;
		//	}
		
		$sql .= "	ORDER BY CandidatePetition_Order";
		
		# echo "SQL: $sql<BR>";
		# echo "<PRE>" . print_r($sql_vars, 1) . "</PRE>";
		
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function CreatePetitionSet($SystemUserID, $CandidatePetition) {
		
		if (! empty ($CandidatePetition)) {
			$sql = "INSERT INTO CandidatePetitionSet SET SystemUser_ID = :SystemUserID, CandidatePetitionSet_TimeStamp = NOW()";
			$sql_vars = array("SystemUserID" => $SystemUserID);
			$this->_return_nothing($sql,  $sql_vars);
		
			$sql = "SELECT LAST_INSERT_ID() as CandidatePetitionSet_ID";
			$result = $this->_return_simple($sql);
			$MyPetitionOrder = 0;
			
			foreach ($CandidatePetition as $var) {
				if ( ! empty ($var)) {
						$sql = "INSERT INTO PetitionSet SET CandidatePetitionSet_ID = :CandidateSETID, " .
										"CandidatePetition_ID = :CandidatePetitionID, " .
										"PetitionSet_Order = :MyOrder, PetitionSet_date = NOW()";
						$sql_vars = array("CandidateSETID" => $result["CandidatePetitionSet_ID"],
															"CandidatePetitionID" => $var, "MyOrder" => $MyPetitionOrder);
						$MyPetitionOrder++;					
						$this->_return_nothing($sql,  $sql_vars);
				}
			}
			return $result["CandidatePetitionSet_ID"];
		}		
	}
	
	function GetPetitionsSets($PetitionSetID) {
		$sql = "SELECT * FROM NYSVoters.PetitionSet " .
						"LEFT JOIN CandidatePetitionSet ON (PetitionSet.CandidatePetitionSet_ID = CandidatePetitionSet.CandidatePetitionSet_ID) " . 
						"LEFT JOIN CandidatePetition ON (CandidatePetition.CandidatePetition_ID = PetitionSet.CandidatePetition_ID) " .
						"WHERE CandidatePetitionSet.CandidatePetitionSet_ID = :CandPetitionSetID";
		$sql_vars = array("CandPetitionSetID" => $PetitionSetID);
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function GetCountyFromNYSCodes($CountyCode) {
		$sql = "SELECT * FROM DataCounty WHERE DataCounty_ID = :CountyCode";
		$sql_vars = array("CountyCode" => $CountyCode);
		return $this->_return_simple($sql, $sql_vars);
	}
	
	function GetVotersIndexesIDfromNYSCode($NYSCode) {
		$sql = "SELECT * FROM VotersIndexes WHERE VotersIndexes_UniqNYSVoterID = :NYSCode ORDER BY VotersIndexes_ID LIMIT 1";
		$sql_vars = array("NYSCode" => $NYSCode);
		return $this->_return_simple($sql, $sql_vars);
	}
	
	function GetSignedElectors($Candidate_ID) {
		$sql = "SELECT * FROM NYSVoters.CandidatePetition WHERE  Candidate_ID = :Candidate_ID AND CandidatePetition_SignedDate is not null";
		$sql_vars = array("Candidate_ID" => $Candidate_ID);
		return $this->_return_multiple($sql, $sql_vars);		
	}
	
	function MarkVoterAsSigned($CandidatePetition_ID, $Candidate_ID, $SystemUser_ID) {
		// This is just to verify that the user that is working the peition is who says it it.
		
		if ( $SystemUser_ID >  0 ) {
			if ($CandidatePetition_ID > 0 && $Candidate_ID > 0 ) {
				$sql = "SELECT * FROM Candidate WHERE Candidate_ID = :Candidate_ID AND SystemUser_ID = :SystemUser_ID";
				$sql_vars = array("Candidate_ID" => $Candidate_ID, "SystemUser_ID" => $SystemUser_ID);
	
				$result = $this->_return_simple($sql, $sql_vars);
				if ( ! empty ($result)) {
					$sql = "UPDATE CandidatePetition SET CandidatePetition_SignedDate = NOW() WHERE " .
									"CandidatePetition_ID = :CandidatePetition_ID AND Candidate_ID = :Candidate_ID";
					$sql_vars = array("Candidate_ID" => $Candidate_ID, "CandidatePetition_ID" => $CandidatePetition_ID);
					return $this->_return_nothing($sql, $sql_vars);
				}
			}
		}			
	}
	
	function UnMarkVoterAsSigned($CandidatePetition_ID, $Candidate_ID, $SystemUser_ID) {
		// This is just to verify that the user that is working the peition is who says it it.
		
		if ( $SystemUser_ID >  0 ) {
			if ($CandidatePetition_ID > 0 && $Candidate_ID > 0 ) {
				$sql = "SELECT * FROM Candidate WHERE Candidate_ID = :Candidate_ID AND SystemUser_ID = :SystemUser_ID";
				$sql_vars = array("Candidate_ID" => $Candidate_ID, "SystemUser_ID" => $SystemUser_ID);
	
				$result = $this->_return_simple($sql, $sql_vars);
				if ( ! empty ($result)) {
					$sql = "UPDATE CandidatePetition SET CandidatePetition_SignedDate = null WHERE " .
									"CandidatePetition_ID = :CandidatePetition_ID AND Candidate_ID = :Candidate_ID";
					$sql_vars = array("Candidate_ID" => $Candidate_ID, "CandidatePetition_ID" => $CandidatePetition_ID);
					return $this->_return_nothing($sql, $sql_vars);
				}
			}
		}			
	}
	
	function FindLocalRawVoterFromDatedFile($RawVoterID, $DatedFiles, $Status = "active") {
		$sql = "SELECT * FROM Raw_Voter_TrnsTable " . 
						"LEFT JOIN Raw_Voter_Dates ON (Raw_Voter_TrnsTable.Raw_Voter_Dates_ID = Raw_Voter_Dates.Raw_Voter_Dates_ID) " . 
						"LEFT JOIN Raw_Voter ON (Raw_Voter_TrnsTable.Raw_Voter_ID = Raw_Voter.Raw_Voter_ID) " .
						"WHERE Raw_Voter_TrnsTable.Raw_Voter_TrnsTable_ID = :RawVoter AND Raw_Voter_Dates_Date = :DatedFiles AND Raw_Voter_Status = :Status";
		$sql_vars = array("RawVoter" => $RawVoterID, "DatedFiles" => $DatedFiles, "Status" => $Status);
		return $this->_return_simple($sql, $sql_vars);				
	}
	
	function FindElectionIDforEDAD($EDAD) {
		$sql = "SELECT * FROM NYSVoters.CandidateElection " . 
			 		 "WHERE CandidateElection_DBTable = 'EDAD' AND CandidateElection_DBTableValue = :EDAD";
		$sql_vars = array('EDAD' => $EDAD);											
		return $this->_return_simple($sql,  $sql_vars);
	}

	function FindSystemUserDetails_ID($SystemUserVoterID, $DatedFiles) {
		$sql = "SELECT * FROM SystemUser " . 
						"LEFT JOIN Candidate ON (Candidate.SystemUser_ID = SystemUser.SystemUser_ID) " . 
						"LEFT JOIN Raw_Voter_" . $DatedFiles . " ON (Raw_Voter_" . $DatedFiles . ".Raw_Voter_UniqNYSVoterID = SystemUser.Raw_Voter_UniqNYSVoterID) " . 
						"WHERE SystemUser.SystemUser_ID = :SystemUserVoter AND Raw_Voter_" . $DatedFiles .".Raw_Voter_Status = 'ACTIVE'";
		$sql_vars = array(':SystemUserVoter' => $SystemUserVoterID);											
		return $this->_return_simple($sql,  $sql_vars);
	}
}


?>
