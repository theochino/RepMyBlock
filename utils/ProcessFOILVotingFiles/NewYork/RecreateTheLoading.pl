#!/usr/bin/perl

### Need to document what this file is about.

use strict;
use DBI;
use Text::CSV;

print "Start the program\n";

# Read the Table Directory in the file
my $filename = '/home/usracct/.voter_file';
open(my $fh, '<:encoding(UTF-8)', $filename) or die "Could not open file '$filename' $!";
my $tabledate = <$fh>;
chomp($tabledate);
close($fh);

my $DateTable = $tabledate;
#my $DateTable = "20151215";


### NEED TO FIND THE ID of that table.
my $dbname = "NYSVoters";
my $dbhost = "192.168.199.217";
my $dbport = "3306";
my $dbuser = "root";
my $dbpass = "root";

my $dsn = "dbi:mysql:dbname=$dbname;host=$dbhost;port=$dbport;";
my $dbh = DBI->connect($dsn, $dbuser, $dbpass) or die "Connection error: $DBI::errstr";

my $stmtFindDatesID = $dbh->prepare("SELECT Raw_Voter_Dates_ID FROM NYSVoters.Raw_Voter_Dates WHERE Raw_Voter_Dates_Date = ?");
$stmtFindDatesID->execute($DateTable);
my @row = $stmtFindDatesID->fetchrow_array;
my $DateTableID = $row[0];

print "DateTableID: $DateTableID\n";

my $TableDated = "Raw_Voter_" . $DateTable;

print "Start Program\n";
my $start = time();
print "Set Variables\t";
### Cache variables.
my %Cache_FirstName = (); my %Cache_MiddleName = (); my %Cache_LastName = (); my %Cache_DataCity = (); my %Cache_DataCounty = ();
my %Cache_DataState = (); my %Cache_DataStreet = (); my %Cache_Elections = (); my %Cache_VoterIndex = (); my %Cache_DataAddress = ();
my %Cache_DataHouse = (); my %Cache_RawVoter = (); my %Cache_RawVoterByID = (); my %Cache_ComplementInfo = (); my %Cache_MailingAddress = (); 

### RawVoterFromDOEFile.
my %Cache_OrigFile_Raw_Voter_LastName = (); my %Cache_OrigFile_Raw_Voter_FirstName = ();
my %Cache_OrigFile_Raw_Voter_MiddleName = (); my %Cache_OrigFile_Raw_Voter_Suffix =(); my %Cache_OrigFile_Raw_Voter_ResHouseNumber = ();
my %Cache_OrigFile_Raw_Voter_ResFracAddress = (); my %Cache_OrigFile_Raw_Voter_ResApartment = (); my %Cache_OrigFile_Raw_Voter_ResPreStreet = (); 
my %Cache_OrigFile_Raw_Voter_ResStreetName = (); my %Cache_OrigFile_Raw_Voter_ResPostStDir = (); my %Cache_OrigFile_Raw_Voter_ResCity = ();
my %Cache_OrigFile_Raw_Voter_ResZip = (); my %Cache_OrigFile_Raw_Voter_ResZip4 = (); my %Cache_OrigFile_Raw_Voter_ResMail1 = (); 
my %Cache_OrigFile_Raw_Voter_ResMail2 = (); my %Cache_OrigFile_Raw_Voter_ResMail3 = (); my %Cache_OrigFile_Raw_Voter_ResMail4 = (); 
my %Cache_OrigFile_Raw_Voter_DOB = (); my %Cache_OrigFile_Raw_Voter_Gender = (); my %Cache_OrigFile_Raw_Voter_EnrollPolParty = (); 
my %Cache_OrigFile_Raw_Voter_OtherParty = (); my %Cache_OrigFile_Raw_Voter_CountyCode = (); my %Cache_OrigFile_Raw_Voter_ElectDistr = (); 
my %Cache_OrigFile_Raw_Voter_LegisDistr = (); my %Cache_OrigFile_Raw_Voter_TownCity = (); my %Cache_OrigFile_Raw_Voter_Ward = (); 
my %Cache_OrigFile_Raw_Voter_CongressDistr = (); my %Cache_OrigFile_Raw_Voter_SenateDistr = (); my %Cache_OrigFile_Raw_Voter_AssemblyDistr = (); 
my %Cache_OrigFile_Raw_Voter_LastDateVoted = (); my %Cache_OrigFile_Raw_Voter_PrevYearVoted = (); my %Cache_OrigFile_Raw_Voter_PrevCounty = (); 
my %Cache_OrigFile_Raw_Voter_PrevAddress = (); my %Cache_OrigFile_Raw_Voter_PrevName = (); my %Cache_OrigFile_Raw_Voter_CountyVoterNumber = (); 
my %Cache_OrigFile_Raw_Voter_RegistrationCharacter = (); my %Cache_OrigFile_Raw_Voter_ApplicationSource = (); my %Cache_OrigFile_Raw_Voter_IDRequired = (); 
my %Cache_OrigFile_Raw_Voter_IDMet = (); my %Cache_OrigFile_Raw_Voter_Status = (); my %Cache_OrigFile_Raw_Voter_ReasonCode = (); 
my %Cache_OrigFile_Raw_Voter_VoterMadeInactive = (); my %Cache_OrigFile_Raw_Voter_VoterPurged = (); my %Cache_OrigFile_Raw_Voter_UniqNYSVoterID = (); 
my %Cache_OrigFile_Raw_Voter_VoterHistory = ();
my @Cache_OrigFile_Raw_Voter_ID = ();
		
my $end = time();
printf("Time: %.2f\n", $end - $start);

### Load Cache
%Cache_FirstName = LoadCaches("SELECT * FROM VotersFirstName");
%Cache_MiddleName = LoadCaches("SELECT * FROM VotersMiddleName");
%Cache_LastName = LoadCaches("SELECT * FROM VotersLastName");
%Cache_DataCity = LoadCaches("SELECT * FROM DataCity");
#%Cache_DataCounty = LoadCaches("SELECT * FROM DataCounty");
#%Cache_DataState = LoadCaches("SELECT * FROM DataState");
%Cache_DataStreet = LoadCaches("SELECT * FROM DataStreet");
%Cache_Elections = LoadCaches("SELECT * FROM Elections");

### Prep the queries Statements to the DB
my $stmtFirstName = $dbh->prepare("SELECT * FROM VotersFirstName WHERE VotersFirstName_Text = ?");
my $stmtMiddleName = $dbh->prepare("SELECT * FROM VotersMiddleName WHERE VotersMiddleName_Text = ?");
my $stmtLastName = $dbh->prepare("SELECT * FROM VotersLastName WHERE VotersLastName_Text = ?");
my $stmtDataCity = $dbh->prepare("SELECT * FROM DataCity WHERE DataCityName_Text = ?");
my $stmtDataCounty = $dbh->prepare("SELECT * FROM DataCounty WHERE DataCountyName_Text = ?");
my $stmtDataState = $dbh->prepare("SELECT * FROM DataState WHERE DateStateName_Text = ?");
my $stmtDataStreet = $dbh->prepare("SELECT * FROM DataStreet WHERE DataStreet_Text = ?");
my $stmtElections = $dbh->prepare("SELECT * FROM Elections WHERE Elections_Text = ?");


### Preparenet
my $stmtRawVoter = $dbh->prepare("SELECT * FROM " . $TableDated . " WHERE Raw_Voter_UniqNYSVoterID = ?");

### LOAD IN THE CACHE THE INDEX
my $starttot = time();
print "Starting Voter Index\n";
my $sth_query = $dbh->prepare("SELECT VotersIndexes_UniqNYSVoterID, VotersIndexes_ID, VotersLastName_ID, VotersFirstName_ID, VotersMiddleName_ID, " . 
														"VotersIndexes_Suffix, VotersIndexes_DOB FROM VotersIndexes LIMIT 5000");	
$sth_query->execute();
for (my $i = 0; $i < $sth_query->rows; $i++) {
	my @row = $sth_query->fetchrow_array;	
	$row[6] =~ s/-//g;
	$Cache_VoterIndex { $row[0] } = $row[1] . "|" . $row[2] . "|" . $row[3] . "|" . $row[4] . "|" . $row[5] . "|" . $row[6]; 
}

### LOAD IN THE CACHE THE DATAADDRESS
print "Starting Data Address\n";
$sth_query = $dbh->prepare("SELECT DataAddress_ID, DataAddress_HouseNumber, DataAddress_FracAddress, DataAddress_PreStreet, DataStreet_ID, DataAddress_PostStreet, " . 
														"DataCity_ID, DataState_ID, DataAddress_zipcode, DataAddress_zip4, Cordinate_ID, PG_OSM_osmid FROM DataAddress LIMIT 5000");
$sth_query->execute();
for (my $i = 0; $i < $sth_query->rows; $i++) {
	my @row = $sth_query->fetchrow_array;	
	$Cache_DataAddress { $row[0] } = $row[1] . "|" . $row[2] . "|" . $row[3] . "|" . $row[4] . "|" . $row[5] . "|" . 
																		$row[6] . "|" . $row[7] . "|" . $row[8]. "|" . $row[9]. "|" . $row[10] . "|" . $row[11];
}

### LOAD IN THE CACHE THE DATAHOUSES
print "Starting House Index\n";
$sth_query = $dbh->prepare("SELECT DataHouse_ID, DataAddress_ID, DataHouse_Apt, DataHouse_BIN FROM DataHouse LIMIT 5000");
$sth_query->execute();
for (my $i = 0; $i < $sth_query->rows; $i++) {
	my @row = $sth_query->fetchrow_array;	
	$Cache_DataHouse { $row[0] } = $row[1] . "|" . $row[2] . "|" . $row[3];
}

### LOAD IN THE CACHE THE VoterComplement
print "Starting VoterComplement Index\n";
$sth_query = $dbh->prepare("SELECT Raw_VoterComplementInfo_ID, Raw_VoterComplementInfo_PrevName, Raw_VoterComplementInfo_PrevAddress, Raw_VoterComplementInfo_PrevCounty, Raw_VoterComplementInfo_LastYearVoted, Raw_VoterComplementInfo_OtherParty FROM Raw_VoterComplementInfo LIMIT 5000");
$sth_query->execute();
for (my $i = 0; $i < $sth_query->rows; $i++) {
	my @row = $sth_query->fetchrow_array;	
	$Cache_ComplementInfo { $row[1] . "|" . $row[2] . "|" . $row[3] . "|" . $row[4] . "|" . $row[5] } = $row[0];
}

### LOAD IN THE CACHE THE Mailing ID
print "Starting Raw_VoterMailingAddress Index\n";
$sth_query = $dbh->prepare("SELECT Raw_VoterMailingAddress_ID, Raw_VoterMailingAddress_Line1, Raw_VoterMailingAddress_Line2, Raw_VoterMailingAddress_Line3, Raw_VoterMailingAddress_Line4 FROM Raw_VoterMailingAddress LIMIT 5000");
$sth_query->execute();
for (my $i = 0; $i < $sth_query->rows; $i++) {
	my @row = $sth_query->fetchrow_array;	
	$Cache_MailingAddress { $row[1] . "|" . $row[2] . "|" . $row[3] . "|" . $row[4] } = $row[0];
}

### LOAD RAW DATA IN THE CACHE THE DATAHOUSES
print "Starting Raw Voter\n";
$start = time();
$sth_query = $dbh->prepare("SELECT Raw_Voter_TableDate_ID, Raw_Voter_UniqNYSVoterID, Raw_Voter_Dates_ID, Raw_Voter_Gender, Raw_VoterComplementInfo_ID, " . 
																	"Raw_Voter_RegParty, Raw_Voter_ReasonCode, Raw_Voter_Status, Raw_VoterMailingAddress_ID, Raw_Voter_IDRequired, " . 
																	"Raw_Voter_IDMet, Raw_Voter_ApplyDate, Raw_Voter_RegSource, Raw_Voter_DateInactive, Raw_Voter_DatePurged, " . 
																	"Raw_Voter_LastVoted, Raw_Voter_CountyVoterNumber, PG_OSM_osmid, VotersIndexes_ID " .
																	"FROM Raw_Voter WHERE Raw_Voter_Dates_ID = " . $dbh->quote($DateTableID) . " ORDER BY Raw_Voter_TableDate_ID LIMIT 5000");														
$sth_query->execute();
for (my $i = 0; $i < $sth_query->rows; $i++) {
	my @row = $sth_query->fetchrow_array;	
	$Cache_RawVoter { $row[0] } = $row[1] . "|" . $row[2] . "|" . $row[3] . "|" . $row[4] . "|" . $row[5] . "|" . $row[6] . "|" . $row[7] . "|" . $row[8]. "|" . $row[9]. "|" . 
																$row[10] . "|" . $row[11] . "|" . $row[12] . "|" . $row[13] . "|" . $row[14] . "|" . $row[15] . "|" . $row[16] . "|" . $row[17];
	$Cache_RawVoterByID { $row[1] } = $row[18];
}
$end = time();
printf("Time: %.2f\n", $end - $start);
print "ROWS FOUND: " . $sth_query->rows . "\n";

### LOAD RAW ORIGINAL FROM DOE DATA IN THE CACHE THE DATAHOUSES
print "Starting DOE Raw Voter Index\n";
$start = time();
$sth_query = $dbh->prepare("SELECT Raw_Voter_ID, Raw_Voter_LastName, Raw_Voter_FirstName, Raw_Voter_MiddleName, Raw_Voter_Suffix, " .
																	"Raw_Voter_ResHouseNumber, Raw_Voter_ResFracAddress, Raw_Voter_ResApartment, Raw_Voter_ResPreStreet, " . 
																	"Raw_Voter_ResStreetName, Raw_Voter_ResPostStDir, Raw_Voter_ResCity, Raw_Voter_ResZip, Raw_Voter_ResZip4, " . 
																	"Raw_Voter_ResMail1, Raw_Voter_ResMail2, Raw_Voter_ResMail3, Raw_Voter_ResMail4, Raw_Voter_DOB, Raw_Voter_Gender, " . 
																	"Raw_Voter_EnrollPolParty, Raw_Voter_OtherParty, Raw_Voter_CountyCode, Raw_Voter_ElectDistr, Raw_Voter_LegisDistr, " . 
																	"Raw_Voter_TownCity, Raw_Voter_Ward, Raw_Voter_CongressDistr, Raw_Voter_SenateDistr, Raw_Voter_AssemblyDistr, " . 
																	"Raw_Voter_LastDateVoted, Raw_Voter_PrevYearVoted, Raw_Voter_PrevCounty, Raw_Voter_PrevAddress, Raw_Voter_PrevName, " . 
																	"Raw_Voter_CountyVoterNumber, Raw_Voter_RegistrationCharacter, Raw_Voter_ApplicationSource, Raw_Voter_IDRequired, " . 
																	"Raw_Voter_IDMet, Raw_Voter_Status, Raw_Voter_ReasonCode, Raw_Voter_VoterMadeInactive, Raw_Voter_VoterPurged, " . 
																	"Raw_Voter_UniqNYSVoterID, Raw_Voter_VoterHistory FROM " . $TableDated .  " LIMIT 2000"); # LIMIT 500000");
$sth_query->execute();
my $TotalOriginalFile = $sth_query->rows;

for (my $i = 0; $i < $TotalOriginalFile; $i++) {
	my @row = $sth_query->fetchrow_array;	
	$Cache_OrigFile_Raw_Voter_ID[$i] 														= $row[0];
	$Cache_OrigFile_Raw_Voter_LastName 							{ $row[0] } = $row[1]; 
	$Cache_OrigFile_Raw_Voter_FirstName 						{ $row[0] } = $row[2]; 
	$Cache_OrigFile_Raw_Voter_MiddleName 						{ $row[0] } = $row[3]; 
	$Cache_OrigFile_Raw_Voter_Suffix 								{ $row[0] } = $row[4]; 
	$Cache_OrigFile_Raw_Voter_ResHouseNumber 				{ $row[0] }	= $row[5]; 
	$Cache_OrigFile_Raw_Voter_ResFracAddress 				{ $row[0] }	= $row[6]; 
	$Cache_OrigFile_Raw_Voter_ResApartment 					{ $row[0] } = $row[7]; 
	$Cache_OrigFile_Raw_Voter_ResPreStreet 					{ $row[0] } = $row[8]; 
	$Cache_OrigFile_Raw_Voter_ResStreetName 				{ $row[0] } = $row[9]; 
	$Cache_OrigFile_Raw_Voter_ResPostStDir 					{ $row[0] } = $row[10]; 
	$Cache_OrigFile_Raw_Voter_ResCity 							{ $row[0] } = $row[11]; 
	$Cache_OrigFile_Raw_Voter_ResZip 								{ $row[0] } = $row[12]; 
	$Cache_OrigFile_Raw_Voter_ResZip4 							{ $row[0] } = $row[13]; 
	$Cache_OrigFile_Raw_Voter_ResMail1 							{ $row[0] } = $row[14]; 
	$Cache_OrigFile_Raw_Voter_ResMail2 							{ $row[0] } = $row[15]; 
	$Cache_OrigFile_Raw_Voter_ResMail3 							{ $row[0] } = $row[16]; 
	$Cache_OrigFile_Raw_Voter_ResMail4 							{ $row[0] } = $row[17]; 
	$Cache_OrigFile_Raw_Voter_DOB 									{ $row[0] } = $row[18]; 
	$Cache_OrigFile_Raw_Voter_Gender 								{ $row[0] } = $row[19]; 
	$Cache_OrigFile_Raw_Voter_EnrollPolParty 				{ $row[0] } = $row[20]; 
	$Cache_OrigFile_Raw_Voter_OtherParty 						{ $row[0] }	= $row[21]; 
	$Cache_OrigFile_Raw_Voter_CountyCode 						{ $row[0] } = $row[22]; 
	$Cache_OrigFile_Raw_Voter_ElectDistr 						{ $row[0] } = $row[23]; 
	$Cache_OrigFile_Raw_Voter_LegisDistr 						{ $row[0] } = $row[24]; 
	$Cache_OrigFile_Raw_Voter_TownCity 							{ $row[0] } = $row[25]; 
	$Cache_OrigFile_Raw_Voter_Ward 									{ $row[0] } = $row[26]; 
	$Cache_OrigFile_Raw_Voter_CongressDistr 				{ $row[0] } = $row[27]; 
	$Cache_OrigFile_Raw_Voter_SenateDistr 					{ $row[0] } = $row[28]; 
	$Cache_OrigFile_Raw_Voter_AssemblyDistr 				{ $row[0] } = $row[29]; 
	$Cache_OrigFile_Raw_Voter_LastDateVoted 				{ $row[0] } = $row[30]; 
	$Cache_OrigFile_Raw_Voter_PrevYearVoted 				{ $row[0] } = $row[31]; 
	$Cache_OrigFile_Raw_Voter_PrevCounty 						{ $row[0] } = $row[32]; 
	$Cache_OrigFile_Raw_Voter_PrevAddress 					{ $row[0] } = $row[33]; 
	$Cache_OrigFile_Raw_Voter_PrevName 							{ $row[0] } = $row[34]; 
	$Cache_OrigFile_Raw_Voter_CountyVoterNumber 		{ $row[0] } = $row[35]; 
	$Cache_OrigFile_Raw_Voter_RegistrationCharacter { $row[0] } = $row[36]; 	
	$Cache_OrigFile_Raw_Voter_ApplicationSource 		{ $row[0] } = $row[37]; 
	$Cache_OrigFile_Raw_Voter_IDRequired 						{ $row[0] } = $row[38]; 
	$Cache_OrigFile_Raw_Voter_IDMet 								{ $row[0] } = $row[39]; 
	$Cache_OrigFile_Raw_Voter_Status 								{ $row[0] } = $row[40]; 
	$Cache_OrigFile_Raw_Voter_ReasonCode 						{ $row[0] } = $row[41]; 
	$Cache_OrigFile_Raw_Voter_VoterMadeInactive 		{ $row[0] } = $row[42]; 
	$Cache_OrigFile_Raw_Voter_VoterPurged 					{ $row[0] } = $row[43]; 
	$Cache_OrigFile_Raw_Voter_UniqNYSVoterID 				{ $row[0] } = $row[44]; 
	$Cache_OrigFile_Raw_Voter_VoterHistory 					{ $row[0] } = $row[45];
}
$end = time();
printf("Time: %.2f\n", $end - $start);
print "ROWS FOUND: " . $sth_query->rows . "\n";

if ( $sth_query->rows < 0) {
	print "Exiting ...\n";
	exit();
}

my $endtot = time();
printf("Time: %.2f\n", $endtot - $starttot);

############# Going trought the file
for (my $i = 0; $i < $TotalOriginalFile; $i++) {

	print "\nFrom the Cache File:\n";	
	print "\tRaw_Voter_ID: " . 								$Cache_OrigFile_Raw_Voter_ID[$i] . "\n";
	print "\tRaw_Voter_UniqNYSVoterID: " . 		$Cache_OrigFile_Raw_Voter_UniqNYSVoterID  	{ $Cache_OrigFile_Raw_Voter_ID[$i] } . 
				"\tCache: " . $Cache_VoterIndex 	{ $Cache_OrigFile_Raw_Voter_UniqNYSVoterID  	{ $Cache_OrigFile_Raw_Voter_ID[$i] } } . "\n";
	print "\tRaw_Voter_LastName: " .					$Cache_OrigFile_Raw_Voter_LastName 					{ $Cache_OrigFile_Raw_Voter_ID[$i] } . 
				"\tCache: " . $Cache_LastName 		{ $Cache_OrigFile_Raw_Voter_LastName 					{ $Cache_OrigFile_Raw_Voter_ID[$i] } } . "\n";
	print "\tRaw_Voter_FirstName: " . 				$Cache_OrigFile_Raw_Voter_FirstName 				{ $Cache_OrigFile_Raw_Voter_ID[$i] } . 
				"\tCache: " . $Cache_FirstName 	{ $Cache_OrigFile_Raw_Voter_FirstName 					{ $Cache_OrigFile_Raw_Voter_ID[$i] } } . "\n";
	print "\tRaw_Voter_MiddleName: " . 				$Cache_OrigFile_Raw_Voter_MiddleName 				{ $Cache_OrigFile_Raw_Voter_ID[$i] } . 
				"\tCache: " . $Cache_MiddleName	{ $Cache_OrigFile_Raw_Voter_MiddleName 					{ $Cache_OrigFile_Raw_Voter_ID[$i] } } . "\n";
	print "\tRaw_Voter_ResStreetName: " . 		$Cache_OrigFile_Raw_Voter_ResStreetName 		{ $Cache_OrigFile_Raw_Voter_ID[$i] } . 
				"\tCache: " . $Cache_DataStreet 	{ $Cache_OrigFile_Raw_Voter_ResStreetName 		{ $Cache_OrigFile_Raw_Voter_ID[$i] } } . "\n";
	print "\tRaw_Voter_ResCity: " . 					$Cache_OrigFile_Raw_Voter_ResCity 					{ $Cache_OrigFile_Raw_Voter_ID[$i] } . 
				"\tCache: " . $Cache_DataCity 		{ $Cache_OrigFile_Raw_Voter_ResCity 					{ $Cache_OrigFile_Raw_Voter_ID[$i] } } . "\n";
	print "\tRaw_Voter_Gender: " . 						$Cache_OrigFile_Raw_Voter_Gender 						{ $Cache_OrigFile_Raw_Voter_ID[$i] } . 
				"\tTransfer: " . ReturnGender($Cache_OrigFile_Raw_Voter_Gender 									{ $Cache_OrigFile_Raw_Voter_ID[$i] }) . "\n";
	print "\tRaw_Voter_ApplicationSource: " . $Cache_OrigFile_Raw_Voter_ApplicationSource { $Cache_OrigFile_Raw_Voter_ID[$i] } . 
				"\tTransfer: " . ReturnRegistrationSource($Cache_OrigFile_Raw_Voter_ApplicationSource	{ $Cache_OrigFile_Raw_Voter_ID[$i] }) . "\n";
	print "\tRaw_Voter_IDRequired: " . 				$Cache_OrigFile_Raw_Voter_IDRequired 				{ $Cache_OrigFile_Raw_Voter_ID[$i] } . 
				"\tTransfer: " . ReturnYesNo($Cache_OrigFile_Raw_Voter_IDRequired 							{ $Cache_OrigFile_Raw_Voter_ID[$i] }) . "\n";
	print "\tRaw_Voter_IDMet: " . 						$Cache_OrigFile_Raw_Voter_IDMet 						{ $Cache_OrigFile_Raw_Voter_ID[$i] } . 
				"\tTransfer: " . ReturnYesNo($Cache_OrigFile_Raw_Voter_IDMet 										{ $Cache_OrigFile_Raw_Voter_ID[$i] }) . "\n";
	print "\tRaw_Voter_Status: " . 						$Cache_OrigFile_Raw_Voter_Status						{ $Cache_OrigFile_Raw_Voter_ID[$i] } . 
				"\tTransfer: " . ReturnStatusCode($Cache_OrigFile_Raw_Voter_Status 							{ $Cache_OrigFile_Raw_Voter_ID[$i] }) . "\n";

	print "From the Cache:\n";	
	# print "\tCache_Voter_LastName: " .				$Cache_OrigFile_Raw_Voter_LastName { $row[0] } . 				
	#      	"\t" . $Cache_LastName { $Cache_OrigFile_Raw_Voter_LastName { $row[0] } } . "\n";
	# print "\tCache_Voter_FirstName: " . 			$Cache_OrigFile_Raw_Voter_FirstName { $row[0] } . 			
	#				"\t" . $Cache_FirstName { $Cache_OrigFile_Raw_Voter_FirstName { $row[0] } } . "\n";
	# print "\tCache_Voter_MiddleName: " . 		$Cache_OrigFile_Raw_Voter_MiddleName { $row[0] } . 			
	# 			"\t" . $Cache_MiddleName { $Cache_OrigFile_Raw_Voter_MiddleName { $row[0] } } . "\n";
	# print "\tCache_Voter_ResStreetName: " . 	$Cache_OrigFile_Raw_Voter_ResStreetName { $row[0] } . 	
	# 			"\t" . $Cache_DataStreet {$Cache_OrigFile_Raw_Voter_ResStreetName { $row[0] } } . "\n";
	# print "\tCache_Voter_ResCity: " . 				$Cache_OrigFile_Raw_Voter_ResCity { $row[0] } .					
	#				"\t" . $Cache_DataCity { $Cache_OrigFile_Raw_Voter_ResCity { $row[0] } } . "\n";
	# print "\tCache_Voter_UniqNYSVoterID: " . $Cache_OrigFile_Raw_Voter_UniqNYSVoterID { $row[0] } .	
	#				"\t" . $Cache_VoterIndex { $Cache_OrigFile_Raw_Voter_UniqNYSVoterID { $row[0] } } . "\n";
	# print "\tCache_RawVoter: " . 						$Cache_RawVoter { $row[0] } . "\n";
	# print "\tCache_VoterIndex: " . 					$Cache_VoterIndex { $Cache_OrigFile_Raw_Voter_UniqNYSVoterID { $row[0] } } . "\n";
	
	print "\nClocking the Check\n";
	$start = time();
	&CheckFieldReturn ($Cache_OrigFile_Raw_Voter_LastName { $Cache_OrigFile_Raw_Voter_ID[$i] }, \%Cache_LastName, "VotersLastName");
	&CheckFieldReturn ($Cache_OrigFile_Raw_Voter_FirstName { $Cache_OrigFile_Raw_Voter_ID[$i] }, \%Cache_FirstName, "VotersFirstName");
	&CheckFieldReturn ($Cache_OrigFile_Raw_Voter_MiddleName { $Cache_OrigFile_Raw_Voter_ID[$i] }, \%Cache_MiddleName, "VotersMiddleName");
	&CheckFieldReturn ($Cache_OrigFile_Raw_Voter_ResStreetName { $Cache_OrigFile_Raw_Voter_ID[$i] }, \%Cache_DataStreet, "DataStreet");
	&CheckFieldReturn ($Cache_OrigFile_Raw_Voter_ResCity { $Cache_OrigFile_Raw_Voter_ID[$i] }, \%Cache_DataCity, "DataCity");
	my $end = time();
	printf("Time: %.2f\n", $end - $start);
	
	print "I: $i\n";
	print "Cache_OrigFile_Raw_Voter_ID[$i]: " . $Cache_OrigFile_Raw_Voter_ID[$i] . "\n";
	print "Cache_OrigFile_Raw_Voter_UniqNYSVoterID{" . $Cache_OrigFile_Raw_Voter_ID[$i] . "}}: " . $Cache_OrigFile_Raw_Voter_UniqNYSVoterID{$Cache_OrigFile_Raw_Voter_ID[$i]} . "\n";
	print "Cache_RawVoter {" . $Cache_OrigFile_Raw_Voter_UniqNYSVoterID{$Cache_OrigFile_Raw_Voter_ID[$i]} . "}: " . $Cache_RawVoter{$Cache_OrigFile_Raw_Voter_UniqNYSVoterID{$Cache_OrigFile_Raw_Voter_ID[$i]}} . "\n";
	print "Cache_VoterIndex {" . $Cache_OrigFile_Raw_Voter_UniqNYSVoterID{$Cache_OrigFile_Raw_Voter_ID[$i]} . "}: " . $Cache_VoterIndex {$Cache_OrigFile_Raw_Voter_UniqNYSVoterID{$Cache_OrigFile_Raw_Voter_ID[$i]}} . "\n";
	CheckRawVoter( $i, $Cache_RawVoter{$Cache_OrigFile_Raw_Voter_UniqNYSVoterID{$Cache_OrigFile_Raw_Voter_ID[$i]}});
	
	### If Cache RawVoter is empty ...
	# $Cache_RawVoter { $row[0] } = "blahblabh";
	#if ( ! $Cache_RawVoter { $row[0] } ) {
		print "This is empty ....\n";
		#CreateRawVoterIndex();
		
		
		#VotersIndexes_ID, 
		#Raw_Voter_Dates_ID,  ### This is the file
		#Raw_Voter_TableDate_ID, 
		#Raw_Voter_Gender,  ReturnGender($row[19])  . "\n";
		#Raw_VoterComplementInfo_ID, 
		#Raw_Voter_UniqNYSVoterID, 
		#Raw_Voter_RegParty, 
		#Raw_Voter_ReasonCode, 
		#Raw_Voter_Status, 
		#Raw_VoterMailingAddress_ID, 
		#Raw_Voter_IDRequired, 
		#Raw_Voter_IDMet, 
		#Raw_Voter_ApplyDate, 
		#Raw_Voter_RegSource, 
		#Raw_Voter_DateInactive, 
		#Raw_Voter_DatePurged, 
		#Raw_Voter_LastVoted, 
		#Raw_Voter_CountyVoterNumber, 
		#PG_OSM_osmid
		
		#exit();
	#}
}

exit();

sub LoadCaches() {
 	my ($Query) = @_;
 	
  my $QueryDB = $dbh->prepare($Query);
	$QueryDB->execute();
	
	my %rhOptions;
	for (my $i = 0; $i < $QueryDB->rows; $i++) {
		my @row = $QueryDB->fetchrow_array;	
		$rhOptions { $row[1] } = $row[0];
	}
	return %rhOptions;
}

sub CheckFieldReturn() {
	my $FieldContent = $_[0];
	my $FieldVariable = $_[1];
	my $DataBaseName = $_[2];
	
	print "Field Variable:  $FieldContent -> " . $FieldVariable -> { $FieldContent } . "\n";
	
	if ( ! $FieldVariable -> { $FieldContent } && ! $FieldContent =~ /^\s*$/ ) {
		my $sql = "";
		my $CompressFieldName = $FieldContent;
		$CompressFieldName =~ tr/a-zA-Z//dc;
		
		if ( $DataBaseName eq "VotersLastName" || $DataBaseName eq "VotersMiddleName" || $DataBaseName eq "VotersFirstName") {
			$sql = "INSERT INTO " . $DataBaseName . " SET " . $DataBaseName . "_Text = " . $dbh->quote($FieldContent) . 	", " .
																	$DataBaseName . "_Compress = " . $dbh->quote($CompressFieldName);
		} elsif ($DataBaseName eq "DataStreet" || $DataBaseName eq "DataCity" ) {
			$sql = "INSERT INTO " . $DataBaseName . " SET " . $DataBaseName . "_Name = " . $dbh->quote($FieldContent);
		}
		
		$sth_query = $dbh->prepare($sql);
		$sth_query->execute();
		$FieldVariable -> { $FieldContent } = $sth_query->{'mysql_insertid'};	
		print "Inserting\n";
		exit();
	}
	
	return $FieldVariable -> { $FieldContent };
}

sub CheckRawVoter() {
	my $NbrIdx = $_[0];
	my $FieldVariable = $_[1];
		
	### Find voter Index.
	my $LocalVoterIndex = $Cache_VoterIndex {$Cache_OrigFile_Raw_Voter_UniqNYSVoterID{$Cache_OrigFile_Raw_Voter_ID[$NbrIdx]}};
	
	print "LocalVoterIndex: $LocalVoterIndex\n";
	print "UNIQNYS: " . $Cache_OrigFile_Raw_Voter_UniqNYSVoterID{$Cache_OrigFile_Raw_Voter_ID[$NbrIdx]} . "\n";
	print "Cache RawVoter By ID: " . $Cache_RawVoterByID { $Cache_OrigFile_Raw_Voter_UniqNYSVoterID{$Cache_OrigFile_Raw_Voter_ID[$NbrIdx]} } . "\n";	
	
	if ( ! $Cache_RawVoterByID { $Cache_OrigFile_Raw_Voter_UniqNYSVoterID{$Cache_OrigFile_Raw_Voter_ID[$NbrIdx]} } ) {
	
		my ($LocalVotersIndexes_ID, $LocalVotersLastName_ID, $LocalVotersFirstName_ID, $LocalVotersMiddleName_ID, 
				$LocalVotersIndexes_Suffix, $LocalVotersIndexes_DOB) =	$LocalVoterIndex =~ /([^\|]*)\|([^\|]*)\|([^\|]*)\|([^\|]*)\|([^\|]*)\|(.*)/;									

		### This is to build the RawVoterTable
		
		CheckIndexFields($Cache_OrigFile_Raw_Voter_ID[$NbrIdx], $LocalVotersLastName_ID, $LocalVotersFirstName_ID, 
											$LocalVotersMiddleName_ID, $LocalVotersIndexes_Suffix, $LocalVotersIndexes_DOB);
		
		#### If I passed all the tests above, that means I have 
		#### This is the test.
		
		my ($LocalVoterComplementInfo_PrevName, $LocalVoterComplementInfo_PrevAddress, $LocalVoterComplementInfo_PrevCounty, $LocalVoterComplementInfo_LastYearVoted, 
				$LocalVoterComplementInfo_OtherParty) =	$LocalVoterIndex =~ /([^\|]*)\|([^\|]*)\|([^\|]*)\|([^\|]*)\|(.*)/;
		
		my $ComplementInfo = 	$Cache_OrigFile_Raw_Voter_PrevName			{ $Cache_OrigFile_Raw_Voter_ID[$NbrIdx] } . "|" . 
													$Cache_OrigFile_Raw_Voter_PrevAddress		{ $Cache_OrigFile_Raw_Voter_ID[$NbrIdx] } . "|" . 
													$Cache_OrigFile_Raw_Voter_PrevCounty		{ $Cache_OrigFile_Raw_Voter_ID[$NbrIdx] } . "|" . 
													$Cache_OrigFile_Raw_Voter_PrevYearVoted	{ $Cache_OrigFile_Raw_Voter_ID[$NbrIdx] } . "|" . 
													$Cache_OrigFile_Raw_Voter_OtherParty		{ $Cache_OrigFile_Raw_Voter_ID[$NbrIdx] };
		print "Cache Complement: " . $Cache_ComplementInfo { $ComplementInfo } . "\tComplementInfo: " . $ComplementInfo . "\n";
		if ( $ComplementInfo eq "||||") {	
			undef $ComplementInfo; 
		} else {
			print "We need to find the complement of address.\n";
			if ( ! $Cache_ComplementInfo { $ComplementInfo } ) {
				$Cache_ComplementInfo { $ComplementInfo } = 
					AddComplementInfoToDB ( 	$Cache_OrigFile_Raw_Voter_PrevName			{ $Cache_OrigFile_Raw_Voter_ID[$NbrIdx] } ,
																		$Cache_OrigFile_Raw_Voter_PrevAddress		{ $Cache_OrigFile_Raw_Voter_ID[$NbrIdx] } ,
																		$Cache_OrigFile_Raw_Voter_PrevCounty		{ $Cache_OrigFile_Raw_Voter_ID[$NbrIdx] } ,
																		$Cache_OrigFile_Raw_Voter_PrevYearVoted	{ $Cache_OrigFile_Raw_Voter_ID[$NbrIdx] } ,
																		$Cache_OrigFile_Raw_Voter_OtherParty		{ $Cache_OrigFile_Raw_Voter_ID[$NbrIdx] });
			}
		}
		
		my $MailingAddress = 	$Cache_OrigFile_Raw_Voter_ResMail1 { $Cache_OrigFile_Raw_Voter_ID[$NbrIdx] } . "|" . 
													$Cache_OrigFile_Raw_Voter_ResMail2 { $Cache_OrigFile_Raw_Voter_ID[$NbrIdx] } . "|" . 
													$Cache_OrigFile_Raw_Voter_ResMail3 { $Cache_OrigFile_Raw_Voter_ID[$NbrIdx] } . "|" . 
													$Cache_OrigFile_Raw_Voter_ResMail4 { $Cache_OrigFile_Raw_Voter_ID[$NbrIdx] };
		print "Cache Mailaddress: " . $Cache_MailingAddress { $MailingAddress } . "\tMailingAddress: " . $MailingAddress . "\n";
		if ( $MailingAddress eq "|||") {	
			undef $MailingAddress; 
		} else {
			if ( ! $Cache_MailingAddress { $MailingAddress } ) {
				$Cache_MailingAddress { $MailingAddress } = 
					AddMailingAddressToDB ($Cache_OrigFile_Raw_Voter_ResMail1 { $Cache_OrigFile_Raw_Voter_ID[$NbrIdx] }, 
																	$Cache_OrigFile_Raw_Voter_ResMail2 { $Cache_OrigFile_Raw_Voter_ID[$NbrIdx] }, 
																	$Cache_OrigFile_Raw_Voter_ResMail3 { $Cache_OrigFile_Raw_Voter_ID[$NbrIdx] },
																	$Cache_OrigFile_Raw_Voter_ResMail4 { $Cache_OrigFile_Raw_Voter_ID[$NbrIdx] });
			}
		}

		my $sql = "INSERT INTO Raw_Voter SET " .
							"VotersIndexes_ID = " . $dbh->quote($LocalVotersIndexes_ID) . ", " .
							"Raw_Voter_Dates_ID = " . $dbh->quote($DateTableID) . ", " .
							"Raw_Voter_TableDate_ID = " . $dbh->quote($Cache_OrigFile_Raw_Voter_ID[$NbrIdx]) . ", " .
							"Raw_Voter_Gender = " . $dbh->quote(ReturnGender($Cache_OrigFile_Raw_Voter_Gender{$Cache_OrigFile_Raw_Voter_ID[$NbrIdx]})) . ", " .
							"Raw_VoterComplementInfo_ID = " . $dbh->quote($Cache_ComplementInfo { $ComplementInfo }) . ", " .
							"Raw_Voter_UniqNYSVoterID = " . $dbh->quote($Cache_OrigFile_Raw_Voter_UniqNYSVoterID{$Cache_OrigFile_Raw_Voter_ID[$NbrIdx]}) . ", " .
							"Raw_Voter_RegParty = " . $dbh->quote($Cache_OrigFile_Raw_Voter_EnrollPolParty{$Cache_OrigFile_Raw_Voter_ID[$NbrIdx]}) . ", " .
							"Raw_Voter_ReasonCode = " . $dbh->quote(ReturnReasonCode($Cache_OrigFile_Raw_Voter_ReasonCode{$Cache_OrigFile_Raw_Voter_ID[$NbrIdx]})) . ", " .
							"Raw_Voter_Status = " . $dbh->quote(ReturnStatusCode($Cache_OrigFile_Raw_Voter_Status{$Cache_OrigFile_Raw_Voter_ID[$NbrIdx]})) . ", " .
							"Raw_VoterMailingAddress_ID = " . $dbh->quote($Cache_MailingAddress { $MailingAddress }) . ", " .
							"Raw_Voter_IDRequired = " . $dbh->quote(ReturnYesNo($Cache_OrigFile_Raw_Voter_IDRequired{$Cache_OrigFile_Raw_Voter_ID[$NbrIdx]})) . ", " .
							"Raw_Voter_IDMet = " . $dbh->quote(ReturnYesNo($Cache_OrigFile_Raw_Voter_IDMet{$Cache_OrigFile_Raw_Voter_ID[$NbrIdx]})) . ", " .
							"Raw_Voter_ApplyDate = " . $dbh->quote($Cache_OrigFile_Raw_Voter_RegistrationCharacter{$Cache_OrigFile_Raw_Voter_ID[$NbrIdx]}) . ", " .
							"Raw_Voter_RegSource = " . $dbh->quote(ReturnRegistrationSource($Cache_OrigFile_Raw_Voter_ApplicationSource{$Cache_OrigFile_Raw_Voter_ID[$NbrIdx]})) . ", " .
							"Raw_Voter_DateInactive = " . $dbh->quote($Cache_OrigFile_Raw_Voter_VoterMadeInactive{$Cache_OrigFile_Raw_Voter_ID[$NbrIdx]}) . ", " .
							"Raw_Voter_DatePurged = " . $dbh->quote($Cache_OrigFile_Raw_Voter_VoterPurged{$Cache_OrigFile_Raw_Voter_ID[$NbrIdx]}) . ", " .
							"Raw_Voter_LastVoted = " . $dbh->quote($Cache_OrigFile_Raw_Voter_LastDateVoted{$Cache_OrigFile_Raw_Voter_ID[$NbrIdx]}) . ", " .
							"Raw_Voter_CountyVoterNumber = " . $dbh->quote($Cache_OrigFile_Raw_Voter_CountyVoterNumber{$Cache_OrigFile_Raw_Voter_ID[$NbrIdx]});
							# . ", " .	"PG_OSM_osmid  = ";
			
		print "SQL: $sql\n";
		$sth_query = $dbh->prepare($sql);
		$sth_query->execute();
	}
}

sub CheckIndexFields() {
	my ($NbrIdx, $LocalVotersLastName_ID, $LocalVotersFirstName_ID, 
			$LocalVotersMiddleName_ID, $LocalVotersIndexes_Suffix, $LocalVotersIndexes_DOB) = @_;
		
	print "CheckIndexField:\n";
	print "\tNbrIDX: " . $NbrIdx . "\n";
	print "\tLocalVotersLastName_ID: " . $LocalVotersLastName_ID . "\n";
	print "\tLocalVotersFirstName_ID: " . $LocalVotersFirstName_ID . "\n";
	print "\tLocalVotersMiddleName_ID: " . $LocalVotersMiddleName_ID . "\n";
	print "\tLocalVotersIndexes_Suffix: " . $LocalVotersIndexes_Suffix . "\n";
	print "\tLocalVotersIndexes_DOB: " . $LocalVotersIndexes_DOB . "\n";
		
	if ( $LocalVotersLastName_ID != $Cache_LastName { $Cache_OrigFile_Raw_Voter_LastName {$NbrIdx} } ) {
		print "Last Name ID => " . $Cache_LastName { $Cache_OrigFile_Raw_Voter_LastName {$NbrIdx} } . "\n";
		print "Last NameID Not Equal: " . $LocalVotersLastName_ID . "\n";
		exit();
	}
	
	if ( $LocalVotersFirstName_ID != $Cache_FirstName { $Cache_OrigFile_Raw_Voter_FirstName {$NbrIdx} } ) {
		print "First NameID Not Equal: " . $LocalVotersFirstName_ID . "\n";
		exit();
	}

	if ( $LocalVotersMiddleName_ID != $Cache_MiddleName { $Cache_OrigFile_Raw_Voter_MiddleName {$NbrIdx} } ) {
		print "Middle NameID Not Equal: " . $LocalVotersMiddleName_ID . "\n";
		print "Middle name should be: " . $Cache_MiddleName { $Cache_OrigFile_Raw_Voter_MiddleName {$NbrIdx} } . "\n";
		### We need to auto fix it.
		exit();
	}
	
	if ( $LocalVotersIndexes_Suffix ne $Cache_OrigFile_Raw_Voter_Suffix {$NbrIdx} ) {
		print "JR: " . $Cache_OrigFile_Raw_Voter_Suffix {$NbrIdx} . "\n";
		exit();
	}

	if ( $LocalVotersIndexes_DOB !=  $Cache_OrigFile_Raw_Voter_DOB {$NbrIdx} ) {
		print "Voter DOB: " . $Cache_OrigFile_Raw_Voter_DOB {$NbrIdx} . "\n";
		exit();
	}
	
	print "\n";
}

sub AddMailingAddressToDB () {
	my ($Add1, $Add2, $Add3, $Add4) = @_;
		
	my $sql = "INSERT INTO Raw_VoterMailingAddress SET " .
							"Raw_VoterMailingAddress_Line1 = " . $dbh->quote($Add1) . ", Raw_VoterMailingAddress_Line2 = " . $dbh->quote($Add2) . ", " .
							"Raw_VoterMailingAddress_Line3 = " . $dbh->quote($Add3) . ", Raw_VoterMailingAddress_Line4 = " . $dbh->quote($Add4);
	$sth_query = $dbh->prepare($sql);
	$sth_query->execute();
	
	my $ID = $sth_query->{'mysql_insertid'};	
	$Cache_MailingAddress { $Add1 . "|" . $Add2 . "|" . $Add3 . "|" . $Add4 } = $ID;
	return $ID;
}
sub AddComplementInfoToDB () {
	my ($Raw_Voter_ID, $PrevAddress, $PrevCounty, $PrevYearVoted, $OtherParty) = @_;
		
	my $sql = "INSERT INTO Raw_VoterMailingAddress SET " .
							"Raw_VoterMailingAddress_Line1 = " . $dbh->quote($Raw_Voter_ID) . ", Raw_VoterMailingAddress_Line2 = " . $dbh->quote($PrevAddress) . ", " .
							"Raw_VoterMailingAddress_Line3 = " . $dbh->quote($PrevCounty) . ", Raw_VoterMailingAddress_Line4 = " . $dbh->quote($PrevYearVoted) . ", " .
							"Raw_VoterMailingAddress_Line4 = " . $dbh->quote($OtherParty);
	$sth_query = $dbh->prepare($sql);
	$sth_query->execute();
	
	my $ID = $sth_query->{'mysql_insertid'};	
	$Cache_MailingAddress { $Raw_Voter_ID . "|" . $PrevAddress . "|" . $PrevCounty . "|" . $PrevYearVoted . "|" . $OtherParty } = $ID;
	return $ID;
}
	
sub ReturnYesNo() {
	my ($Question) = @_;
	if ($Question eq 'Y') { return 'yes';	}	
	elsif ($Question eq 'N') { return 'no'; }
	return undef;
}

sub	ReturnReasonCode() {
	my ($Question) = @_;
		
	if ( ! defined $Question ) { return undef; }
	if ($Question eq "ADJ-INCOMP") { return "AdjudgedIncompetent" }
	elsif ($Question eq "DEATH") {  return "Death" }
	elsif ($Question eq "DUPLICATE") {  return "Duplicate" }
	elsif ($Question eq "FELON") {  return "Felon" }
	elsif ($Question eq "MAIL-CHECK") { return "MailCheck" }
	elsif ($Question eq "MAILCHECK") { return "MailCheck" }
	elsif ($Question eq "MOVED") { return "MouvedOutCounty" }
	elsif ($Question eq "NCOA") {  return "NCOA" }
	elsif ($Question eq "NVRA") {  return "NVRA" }
	elsif ($Question eq "RETURN-MAIL") {  return "ReturnMail" }
	elsif ($Question eq "VOTER-REQ") {  return "VoterRequest" }
	elsif ($Question eq "OTHER") {  return "Other" }
	elsif ($Question eq "COURT") {  return "Court" }
	elsif ($Question eq "INACTIVE") {  return "Inactive" }
	
	print "Catastrophic ReturnReasonCode problem as $Question\n";
	exit();
	
	return undef;
}

sub ReturnRegistrationSource() {
	my ($Question) = @_;
	
	if ( ! defined $Question ) { return undef; }
	if ($Question eq "AGCY") { return "Agency"; }
	elsif ($Question eq "CBOE") { return "CBOE"; }
	elsif ($Question eq "DMV") { return "DMV"; }
	elsif ($Question eq "LOCALREG") { return "LocalRegistrar"; }
	elsif ($Question eq "MAIL") { return "MailIn"; }
	elsif ($Question eq "SCHOOL") { return "School"; }

	print "Catastrophic ReturnRegistrationSource problem as it is empty\n";
	exit();
	
	return undef;
}
	
sub	ReturnStatusCode() {
	my ($Question) = @_;				

	if ( ! defined $Question ) { return undef; }
	if ($Question eq "ACTIVE") { return "Active"; }
	elsif ($Question eq "AM") { return "ActiveMilitary"; }
	elsif ($Question eq "AF") { return "ActiveSpecialFederal"; }
	elsif ($Question eq "AP") { return "ActiveSpecialPresidential"; }
	elsif ($Question eq "AU") { return "ActiveUOCAVA"; }
	elsif ($Question eq "INACTIVE") { return "Inactive"; }
	elsif ($Question eq "PURGED") { return "Purged"; }
	elsif ($Question eq "PREREG") { return "Prereg17YearOlds"; }
	elsif ($Question eq "RETURN-MAIL") { return "ReturnMail"; }
	elsif ($Question eq "VOTER-REQ") { return "VoterRequest"; }
	
	print "Catastrophic ReturnStatusCode problem as it is empty\n";
	exit();
	
	return undef;
}

sub ReturnGender {
	my ($Gender) = @_;
	if ( $Gender eq 'M') { return "male"; } 
	if ( $Gender eq 'F') { return "Female";	}
	if ($Gender eq 'U') { return 'undetermined'; }	
	return undef;
}