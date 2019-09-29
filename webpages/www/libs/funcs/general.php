<?php

function ordinal($number) {
  $ends = array('th','st','nd','rd','th','th','th','th','th','th');
  if ((($number % 100) >= 11) && (($number%100) <= 13))
      return $number. 'th';
  else
      return $number. $ends[$number % 10];
}

function WriteStderr($Data) {
	// Need to save the information
	$STDERR = fopen('php://stderr', 'w+');

	fwrite($STDERR, "\n");
	fwrite($STDERR, print_r($Data, 1));
	fwrite($STDERR, "\n");
	
	fclose($STDERR);		
}

function PrintRandomText($length = 9) {
  
  $alpha = "abcdefghijklmnopqrstuvwxyz";
	$alpha_upper = strtoupper($alpha);
	$numeric = "0123456789";
	$special = ".-+=_,!@$#*%<>[]{}";
	$chars = "";
 
	if (isset($_POST['length'])){
    // if you want a form like above
    if (isset($_POST['alpha']) && $_POST['alpha'] == 'on') $chars .= $alpha;
    if (isset($_POST['alpha_upper']) && $_POST['alpha_upper'] == 'on') $chars .= $alpha_upper;
    if (isset($_POST['numeric']) && $_POST['numeric'] == 'on') $chars .= $numeric;
    if (isset($_POST['special']) && $_POST['special'] == 'on') $chars .= $special;
    $length = $_POST['length'];
	} else {
    // default [a-zA-Z0-9]{9}
    $chars = $alpha . $alpha_upper . $numeric;
	}
 
	$len = strlen($chars);
	$pw = '';
 
	for ($i=0;$i<$length;$i++)
  	$pw .= substr($chars, rand(0, $len-1), 1);
 
	// the finished password
	return str_shuffle($pw); 
}

function PrintShortDate($Date) {
	if ( ! empty ($Date)) {
		return date("F jS, Y", strtotime( $Date ));
	}
}

function PrintShortTime($Date) {
	if ( ! empty ($Date)) {
		return date("h:i a", strtotime( $Date ));
	}
}

function NewYork_PrintParty($Party) {
	switch($Party) {
		case 'DEM': return "Democrat"; break;
		case 'REP': return "Republican"; break;
		case 'BLK': return "No party"; break;
		case 'CON': return "Conservatives"; break;
		case 'IND': return "Independence Party"; break;
		case 'WOR': return "Working Families"; break;
		case 'GRE': return "Green"; break;
		case 'LBT': return "Libertarian"; break;
		case 'OTH': return "Other"; break;
		case 'WEP': return "Women\'s Equality Party"; break;
		case 'REF': return "Reform"; break;
		case 'SAM': return "Serve America"; break;
	}
}

?>
