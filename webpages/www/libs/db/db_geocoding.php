<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/mysql/queries.php";
global $DB;

class geocoding extends queries {

  function geocoding ($debug = 0, $DBFile = "DB_OutragedDems") {
	  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/DBsLogins/" . $DBFile . ".php";
	  $DebugInfo["DBErrorsFilename"] = $DBErrorsFilename;
	  $DebugInfo["Flag"] = $debug;
	  $this->queries($databasename, $databaseserver, $databaseport, $databaseuser, $databasepassword, $sslkeys, $DebugInfo);
  }
  
 	function ExtractGeo($GeoDescID) {
 		$sql = "SELECT * FROM GeoDescCords LEFT JOIN GeoCord ON (GeoDescCords.GeoCord_ID = GeoCord.GeoCord_ID) " . 
 						"WHERE GeoDescCords.GeoDesc_ID = :GeoDesc_ID ORDER BY GeoDescCordsMajOrd, GeoDescCordsMinOrd";
		$sql_vars = array("GeoDesc_ID" => $GeoDescID);
		return $this->_return_multiple($sql, $sql_vars);
 	}  
 	
 	function ExtractGeoCenter($GeoDescID) {
 		$sql = "SELECT AVG(GeoCord_Lat) as latitude, AVG(GeoCord_Long) as longitude FROM GeoDescCords LEFT JOIN GeoCord ON (GeoDescCords.GeoCord_ID = GeoCord.GeoCord_ID) " . 
 						"WHERE GeoDescCords.GeoDesc_ID = :GeoDesc_ID";
		$sql_vars = array("GeoDesc_ID" => $GeoDescID);
		return $this->_return_simple($sql, $sql_vars);
 	}  
 	
 	
	
}

?>
