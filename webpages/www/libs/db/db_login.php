<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/mysql/queries.php";
global $DB;

class login extends queries {

  function login ($debug = 0, $DBFile = "DB_OutragedDems") {
	  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/DBsLogins/" . $DBFile . ".php";
	  $DebugInfo["DBErrorsFilename"] = $DBErrorsFilename;
	  $DebugInfo["Flag"] = $debug;
	 	$this->queries($databasename, $databaseserver, $databaseport, $databaseuser, $databasepassword, $sslkeys, $DebugInfo);
  }
  
	function CheckEmail($email) {
		$sql = "SELECT * FROM SystemUser WHERE SystemUser_email = :Email";
		$sql_vars = array(':Email' => $email);											
		return $this->_return_simple($sql,  $sql_vars);
	}
	
	function CheckUsername($Username) {
		$sql = "SELECT * FROM SystemUser WHERE SystemUser_username = :Username";
		$sql_vars = array(':Username' => $Username);											
		return $this->_return_simple($sql,  $sql_vars);
	}

	function AddEmail($email, $login_type = "password", $firstname = null, $lastname = null, $RawVoterID = null, $reason = null) {
		
		$IDEmail = $this->CheckEmail($email);
	
		if (empty ($IDEmail)) {
			$IDEmail = $this->SaveEmail($email, $login_type, $firstname, $lastname, $RawVoterID);
		}
		
		$sql = "INSERT INTO SystemUserVoter SET SystemUser_ID = :IDEmail, Raw_Voter_ID = :RawVoterID, SystemUserVoter_Action = :Action, SystemUserVoter_Date = NOW()";
		$sql_vars = array('IDEmail' => $IDEmail["SystemUser_ID"], 'RawVoterID' => $RawVoterID, 'Action' => $reason);
		
		$this->_return_nothing($sql,  $sql_vars);
		return $IDEmail;
	}

	function SaveEmail($email, $login_type = "password", $firstname = null, $lastname = null, $RawVoterID = null) {
		$sql = "INSERT INTO SystemUser SET SystemUser_email = :Email, SystemUser_loginmethod = :Type, Raw_Voter_ID = :RawVoterID, SystemUser_createtime = NOW()";	
		$sql_vars = array(':Email' => $email, ':Type' => $login_type, 'RawVoterID' => $RawVoterID);
		
		if ( ! empty ($firstname)) { $sql .= ", SystemUser_FirstName = :FirstName";	$sql_vars[":FirstName"] = $firstname;	}
		if ( ! empty ($lastname)) {	$sql .= ", SystemUser_LastName = :LastName"; $sql_vars[":LastName"] = $lastname;	}
		
		$this->_return_nothing($sql,  $sql_vars);
		
		$sql = "SELECT LAST_INSERT_ID() as SystemUser_ID";
		return $this->_return_simple($sql);
	}
	
	function SaveEmailNYSID($email, $NYSID, $reason = "interested") {
		$sql = "INSERT SystemUserVoter SET Raw_Voter_UniqNYSVoterID = :NYSID, SystemUserVoter_Email = :email, SystemUserVoter_Action = :action, SystemUserVoter_Date = NOW()";
		$sql_vars = array('email' => $email, 'NYSID' => $NYSID, 'action' => $reason);
		return $this->_return_nothing($sql,  $sql_vars);
	}
	
	function AddEmailWithNYSID($email, $login_type = "password", $firstname = null, $lastname = null, $NYSID = null, $reason = null, $EDAD = null) {
		$IDEmail = $this->CheckEmail($email);
			
		if (empty ($IDEmail)) {
			$IDEmail = $this->SaveEmailWithNYSID($email, $login_type, $firstname, $lastname, $NYSID, $EDAD);
		}
		
		$sql = "INSERT INTO SystemUserVoter SET SystemUser_ID = :IDEmail, Raw_Voter_UniqNYSVoterID = :NYSID, " . 
						"SystemUserVoter_Action = :Action, SystemUserVoter_Date = NOW()";
		$sql_vars = array('IDEmail' => $IDEmail["SystemUser_ID"], 'NYSID' => $NYSID, 'Action' => $reason);
		
		$this->_return_nothing($sql,  $sql_vars);
		return $IDEmail;
	}
	
	function SaveEmailWithNYSID($email, $login_type = "password", $firstname = null, $lastname = null, $NYSID = null, $EDAD = null) {
		$sql = "INSERT INTO SystemUser SET SystemUser_email = :Email, SystemUser_EDAD = :EDAD, SystemUser_loginmethod = :Type, Raw_Voter_UniqNYSVoterID = :NYSID, SystemUser_createtime = NOW()";	
		$sql_vars = array(':Email' => $email, ':Type' => $login_type, 'NYSID' => $NYSID, 'EDAD' => $EDAD);
		
		if ( ! empty ($firstname)) { $sql .= ", SystemUser_FirstName = :FirstName";	$sql_vars[":FirstName"] = $firstname;	}
		if ( ! empty ($lastname)) {	$sql .= ", SystemUser_LastName = :LastName"; $sql_vars[":LastName"] = $lastname;	}
		
		$this->_return_nothing($sql,  $sql_vars);
		
		$sql = "SELECT LAST_INSERT_ID() as SystemUser_ID";
		return $this->_return_simple($sql);
	}
		
	function UpdateSystemGoogleMapsApiKey($SystemUser_ID, $apikey) {
		$sql = "UPDATE SystemUser SET SystemUser_googleapimapid = :apikey WHERE SystemUser_ID = :ID";
		$sql_vars = array(':apikey' => $apikey, ':ID' => $SystemUser_ID);
		return $this->_return_nothing($sql,  $sql_vars);
	}
	
	function UpdateUsernamePassword($SystemUser_ID, $username, $password, $hashtable = "") {
		
		$HashPass = password_hash($password, PASSWORD_DEFAULT);
		
		$sql = "UPDATE SystemUser SET SystemUser_username = :username, SystemUser_password = :password ";
		$sql_vars = array(':username' => $username, ':password' => $HashPass, ':ID' => $SystemUser_ID);
		
		if ( ! empty ($hashtable)) {
			$sql .= ", SystemUser_emaillinkid = :Hash ";
			$sql_vars["Hash"] = $hashtable;
		}		
	
		$sql .= "WHERE SystemUser_ID = :ID";	
		return $this->_return_nothing($sql,  $sql_vars);
	}
	
	function ReturnPetitionSet($SystemUser_ID) {
		$sql = "SELECT * FROM CandidatePetitionSet WHERE SystemUser_ID = :SystemUserID";
		$sql_vars = array("SystemUserID" => $SystemUser_ID);		
		return $this->_return_multiple($sql, $sql_vars);
	}
	
	function UpdateHash($SystemEmail, $HashLink) {
		$sql = "UPDATE SystemUser SET SystemUser_emaillinkid = :Hash WHERE SystemUser_email = :Email";
		$sql_vars = array(':Email' => $SystemEmail, ':Hash' => $HashLink);
		return $this->_return_nothing($sql,  $sql_vars);
	}
	
	function VerifyAccount($SystemUser_ID) {
		$sql = "UPDATE SystemUser SET SystemUser_emailverified = 'yes', SystemUser_emaillinkid = null " . 
						"WHERE SystemUser_ID = :ID";
		$sql_vars = array("ID" => $SystemUser_ID);
		return $this->_return_nothing($sql, $sql_vars);
	}
	
	function FindRawVoterInfoFromSystemID($SystemUser_ID, $DateFileID, $DateFileName) {
		$sql = "SELECT * FROM SystemUserVoter " .
						"LEFT JOIN Raw_Voter_TrnsTable ON (Raw_Voter_TrnsTable.Raw_Voter_TrnsTable_ID = SystemUserVoter.Raw_Voter_ID) " .
						"LEFT JOIN Raw_Voter_" . $DateFileName . 
						" ON (Raw_Voter_" . $DateFileName . ".Raw_Voter_ID = Raw_Voter_TrnsTable.Raw_Voter_TableDate_ID) " .
						"WHERE SystemUser_ID = :ID AND Raw_Voter_Dates_ID = :DatedID";
		$sql_vars = array("ID" => $SystemUser_ID, "DatedID" => $DateFileID);
		return $this->_return_simple($sql, $sql_vars);				
	}
	
	function FindLocalRawVoterFromDatedFile($RawVoterID, $DatedFiles) {
		$sql = "SELECT * FROM NYSVoters.Raw_Voter " . 
						"LEFT JOIN Raw_Voter_Dates ON (Raw_Voter.Raw_Voter_Dates_ID = Raw_Voter_Dates.Raw_Voter_Dates_ID) " . 
						"WHERE Raw_Voter.Raw_Voter_TableDate_ID = :RawVoter AND Raw_Voter_Dates_Date = :DatedFiles";
		$sql_vars = array("RawVoter" => $RawVoterID, "DatedFiles" => $DatedFiles);
		return $this->_return_simple($sql, $sql_vars);				
	}
	
	function FindCandidateInfo($SystemUserID) {
		$sql = "SELECT * FROM Candidate WHERE SystemUser_ID = :SystemUserID";
		$sql_vars = array("SystemUserID" => $SystemUserID);
		return $this->_return_simple($sql, $sql_vars);	
	} 
	
	function CheckUsernamePassword($Username, $Password) {
		$sql = "SELECT * FROM SystemUser WHERE SystemUser_username = :Username";
		$sql_vars = array("Username" => $Username);
		$result = $this->_return_simple($sql, $sql_vars);	
		$ResultPasswordCheck = password_verify ($Password , $result["SystemUser_password"]);
		
		if ( $ResultPasswordCheck == 1) {
			return $result;
		}
		return null;
	}
	
	function FindSystemUser_ID($SystemUserVoterID) {
		$sql = "SELECT * FROM SystemUser " . 
						"LEFT JOIN Raw_Voter ON (SystemUser.Raw_Voter_ID = Raw_Voter.Raw_Voter_ID) " .
						"LEFT JOIN Candidate ON (Candidate.SystemUser_ID = SystemUser.SystemUser_ID) " . 
						"WHERE SystemUser.SystemUser_ID = :SystemUserVoter";
		$sql_vars = array(':SystemUserVoter' => $SystemUserVoterID);											
		return $this->_return_multiple($sql,  $sql_vars);
	}
	
	function FindSystemUserDetails_ID($SystemUserVoterID, $DatedFiles) {
		$sql = "SELECT * FROM SystemUser " . 
						"LEFT JOIN Raw_Voter ON (SystemUser.Raw_Voter_ID = Raw_Voter.Raw_Voter_ID) " .
						"LEFT JOIN Candidate ON (Candidate.SystemUser_ID = SystemUser.SystemUser_ID) " . 
						"LEFT JOIN Raw_Voter_" . $DatedFiles . " ON (Raw_Voter_" . $DatedFiles . ".Raw_Voter_UniqNYSVoterID = Raw_Voter.Raw_Voter_UniqNYSVoterID) " . 
						"WHERE SystemUser.SystemUser_ID = :SystemUserVoter AND Raw_Voter_" . $DatedFiles .".Raw_Voter_Status = 'ACTIVE'";
		$sql_vars = array(':SystemUserVoter' => $SystemUserVoterID);											
		return $this->_return_simple($sql,  $sql_vars);
		
	}
	
	function FindCandidatesInDistrict($Value, $TableName = "EDAD") {
		$sql = "SELECT * FROM Candidate WHERE CandidateElection_DBTable = :TableName AND CandidateElection_DBTableValue = :Value";
		$sql_vars = array("TableName" => $TableName, "Value" => $Value);
		return $this->_return_multiple($sql,  $sql_vars);
	}
	
	
}


?>
