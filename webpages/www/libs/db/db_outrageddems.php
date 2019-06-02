<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/mysql/queries.php";
global $DB;

class OutragedDems extends queries {

  function OutragedDems ($debug = 0, $DBFile = "DB_OutragedDems") {
	  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/DBsLogins/" . $DBFile . ".php";
	  $DebugInfo["DBErrorsFilename"] = $DBErrorsFilename;
	  $DebugInfo["Flag"] = $debug;
	  	  $this->queries($databasename, $databaseserver, $databaseport, $databaseuser, $databasepassword, $sslkeys, $DebugInfo);
  }
  
	function InsertEmail($email) {
		$sql = "INSERT INTO SystemUser SET SystemUser_email = :Email";	
		$sql_vars = array(':Email' => $email);											
		return $this->_return_nothing($sql,  $sql_vars);
	}
	
	function CheckRegisterEmail ($email) {
		$sql = "SELECT * FROM SystemUser WHERE SystemUser_email = :Email";
		$sql_vars = array(':Email' => $email);											
		return $this->_return_simple($sql,  $sql_vars);
	}

	function SearchVoterDBbyID($DatedFiles, $RawVoterID) {
		$TableVoter = "Raw_Voter_" . $DatedFiles;
		$sql = "SELECT * FROM " . $TableVoter . " WHERE " . 
		"Raw_Voter_ID = :RawVoterID";
		$sql_vars = array('RawVoterID' => $RawVoterID);							
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function FindSystemUserVoter($RawVoterID) {
		$sql = "SELECT * FROM SystemUserVoter WHERE Raw_Voter_ID = :RawVoterID";
		$sql_vars = array('RawVoterID' => $RawVoterID);							
		return $this->_return_multiple($sql, $sql_vars);
	}
		
	function FindGeoDiscID($GeoDescAbbrev) {
		$sql = "SELECT * FROM GeoDesc WHERE GeoGroup_ID = '3' AND GeoDesc_Abbrev = :Abbrev";
		$sql_vars = array('Abbrev' => $GeoDescAbbrev);							
		return $this->_return_simple($sql, $sql_vars);
	}
	
	function SearchCandidateInArea($DatedFiles, $RawVoterID) {
		$TableVoter = "Raw_Voter_" . $DatedFiles;
		$sql = "SELECT * FROM " . $TableVoter . " " .
						"LEFT JOIN Raw_Voter ON (Raw_Voter.Raw_Voter_TableDate_ID = " . $TableVoter . ".Raw_Voter_ID) " .
						"LEFT JOIN CandidatePetition ON (CandidatePetition.Raw_Voter_ID = Raw_Voter.Raw_Voter_ID) " . 
						"LEFT JOIN Candidate ON (Candidate.Candidate_ID = CandidatePetition.Candidate_ID) " .		
						"WHERE " . 
						"Raw_Voter.Raw_Voter_ID = :RawVoterID";
		$sql_vars = array('RawVoterID' => $RawVoterID);									
		return $this->_return_multiple($sql, $sql_vars);
	}

	function SearchVoter_Dated_DB($DatedFiles, $FirstName, $LastName, $DOB) {
		$TableVoter = "Raw_Voter_" . $DatedFiles;
		$sql = "SELECT * FROM " . $TableVoter . " WHERE Raw_Voter_LastName= :LastName AND Raw_Voter_FirstName = :FirstName AND Raw_Voter_DOB = :DOB";
		$sql_vars = array('FirstName' => $FirstName, 'LastName' => $LastName, 'DOB' => $DOB);							
		return $this->_return_multiple($sql, $sql_vars);
	}

	function SaveVoterRequest($FirstName, $LastName, $DateOfBirth, $DatedFilesID, $Email, $UniqNYSVoterID, $IP) {
		$sql = "INSERT INTO SaveVoterRequest SET SaveVoterRequest_FirstName = :FirstName, " .
		 				"SaveVoterRequest_LastName = :LastName, SaveVoterRequest_DateOfBirth = :DateOfBirth, " .
    				"SaveVoterRequest_DatedFileID = :DatedFilesID, SaveVoterRequest_Email = :Email, " .
    				"SaveVoterRequest_UniqNYSVoterID = :UniqNYSVoterID, SaveVoterRequest_IP = :IP, SaveVoterRequest_Date = NOW()";

		$sql_vars = array("FirstName" => $FirstName, "LastName" => $LastName, 
											"DateOfBirth" => $DateOfBirth, "DatedFilesID" => $DatedFilesID,
    									"Email" => $Email, "UniqNYSVoterID" => $UniqNYSVoterID,
    									"IP" => $IP);
		return $this->_return_nothing($sql, $sql_vars);
	}

	function SearchVoterDB($FirstName, $LastName, $DOB, $TableID, $Status = "Active") {

		$CompressedFirstName = preg_replace("/[^a-zA-Z]+/", "", $FirstName);
		$CompressedLastName = preg_replace("/[^a-zA-Z]+/", "", $LastName);
		
		$sql = "SELECT * FROM VotersIndexes " .
						"LEFT JOIN VotersFirstName ON (VotersFirstName.VotersFirstName_ID = VotersIndexes.VotersFirstName_ID ) " . 
						"LEFT JOIN VotersLastName ON (VotersLastName.VotersLastName_ID = VotersIndexes.VotersLastName_ID ) " .
						"LEFT JOIN Raw_Voter ON (Raw_Voter.Raw_Voter_UniqNYSVoterID = VotersIndexes.VotersIndexes_UniqNYSVoterID) " . 
						"WHERE VotersFirstName_Compress = :FirstName AND " . 
						"VotersLastName_Compress = :LastName " . #AND Raw_Voter_Dates_ID = :TableID " .
						"AND VotersIndexes_DOB = :DOB AND Raw_Voter_Status = :Status"
						;
		$sql_vars = array('FirstName' => $CompressedFirstName, 
											'LastName' => $CompressedLastName, 
											'DOB' => $DOB,
											'Status' => $Status); 
											#,'TableID' => $TableID);
		
		return $this->_return_multiple($sql, $sql_vars);		
	}

	function SearchVoterDBbyNYSID($ID, $DatedFiles, $Status = "Active") {
		$TableVoter = "Raw_Voter_" . $DatedFiles;
		$sql = "SELECT * FROM " . $TableVoter . " " .
						"LEFT JOIN DataCounty ON (Raw_Voter_" . $DatedFiles . ".Raw_Voter_CountyCode = DataCounty.DataCounty_ID) " .
						"WHERE Raw_Voter_UniqNYSVoterID = :ID AND Raw_Voter_Status = :Status";
		$sql_vars = array('ID' => $ID, 'Status' => $Status);							
		
		// $result = $this->_return_multiple($sql, $sql_vars);
		// return $result;
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function SearchLocalRawDBbyNYSID($UniqNYSID, $DatedFilesID, $Status = "Active") {
		$sql = "SELECT * FROM Raw_Voter WHERE Raw_Voter_UniqNYSVoterID = :ID " . #AND Raw_Voter_Dates_ID = :Dates " .
						"AND Raw_Voter_Status = :Status";
		
		$sql_vars = array('ID' => $UniqNYSID,  'Status' => $Status);		# ,'Dates' => $DatedFilesID);
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function ListElections($SomeVariable) {
		$sql = "SELECT * FROM CandidateElection " . 
						"LEFT JOIN Candidate ON (CandidateElection.CandidateElection_ID = Candidate.CandidateElection_ID)";
					
		return $this->_return_multiple($sql);
	}

	function ListCandidateNomination($SystemUserID) {
		$sql = "SELECT * FROM CanNomination WHERE SystemUser_ID = :SystemUserID";
		$sql_vars = array('SystemUserID' => $SystemUserID);
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function CandidateNomination($SystemUserID, $ElectionID, $CandidateID) {
		$sql = "INSERT INTO CanNomination SET Candidate_ID = :CandidateID, SystemUser_ID = :SystemUserID, CandidateElection_ID = :CandidateElectionID";
		$sql_vars = array('CandidateID' => $CandidateID, 'SystemUserID' => $SystemUserID, 'CandidateElectionID' => $ElectionID);
		return $this->_return_nothing($sql, $sql_vars);
	}

	function ListOnlyElections() {
		$sql = "SELECT * FROM CandidateElection";
		return $this->_return_multiple($sql);
	}
	
	function ListNominations($SystemUserID) {
		$sql = "SELECT * FROM CanNomination " .
						"LEFT JOIN CandidateElection ON (CandidateElection.CandidateElection_ID = CanNomination.CandidateElection_ID) " .
						"WHERE SystemUser_ID = :SystemUserID";
		$sql_vars = array("SystemUserID" => $SystemUserID);				
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function InsertNewNomination($CandidateElection, $SystemUser, $FirstName, $LastName, $Email, $Phone) {
		$sql = "INSERT INTO CanNomination SET CandidateElection_ID = :CandidateElection_ID, SystemUser_ID = :SystemUserID, " . 
						"CanNomination_FirstName = :FirstName, CanNomination_LastName = :LastName, CanNomination_Email = :Email, "  .
						"CanNomination_Phone = :Phone";
		$sql_vars = array('CandidateElection_ID' => $CandidateElection, 'SystemUserID' => $SystemUser, 'FirstName' =>  $FirstName, 
		 									'LastName'=> $LastName, 'Email'=> $Email, 'Phone'=> $Phone);
		return $this->_return_nothing($sql, $sql_vars);
	}
	
	function ListCandidatePetition($SystemUserID) {
		$sql = "SELECT * FROM CandidatePetitionSet " .
						"LEFT JOIN CanPetitionSet ON (CanPetitionSet.CandidatePetitionSet_ID = CandidatePetitionSet.CandidatePetitionSet_ID) " .
						"LEFT JOIN Candidate ON (CanPetitionSet.Candidate_ID = Candidate.Candidate_ID) " .
						"LEFT JOIN CanWitnessSet ON (CanWitnessSet.Candidate_ID = Candidate.Candidate_ID) " .
						"LEFT JOIN CandidateWitness ON (CanWitnessSet.CandidateWitness_ID = CandidateWitness.CandidateWitness_ID) " .
						"LEFT JOIN CandidateElection ON (CandidateElection.CandidateElection_ID = Candidate.CandidateElection_ID) " .
						"WHERE CandidatePetitionSet.SystemUser_ID = :SystemUserID";
		$sql_vars = array("SystemUserID" => $SystemUserID);				
		return $this->_return_multiple($sql, $sql_vars);
	}

	
	function ListCandidateNominatedForPetition($SystemUserID) {
		$sql = "SELECT * FROM CanNomination " .
						"LEFT JOIN CandidateElection ON (CandidateElection.CandidateElection_ID = CanNomination.CandidateElection_ID) " .
						"LEFT JOIN Candidate ON (CanNomination.Candidate_ID = Candidate.Candidate_ID) " .
						"LEFT JOIN CanWitnessSet ON (CanWitnessSet.Candidate_ID = Candidate.Candidate_ID) " .
						"LEFT JOIN CandidateWitness ON (CanWitnessSet.CandidateWitness_ID = CandidateWitness.CandidateWitness_ID) " .
						"WHERE CanNomination.SystemUser_ID = :SystemUserID";
		$sql_vars = array("SystemUserID" => $SystemUserID);				
		return $this->_return_multiple($sql, $sql_vars);
	}
	
}

?>

