#!/usr/bin/perl

use strict;
use CAM::PDF;
use DBI;
use Text::Aspell;
use Term::ANSIColor;
use Term::TtyWrite;

my $VerbosePrint = 0; 
my $Verbose = $VerbosePrint;
my $GoDirectTo = 1090;
my $ErrorPTS = "/dev/pts/1";
my $tty;
my $PrintTTY;

if ( length($ErrorPTS) > 0 ) {
	open($tty, '>', $ErrorPTS) or die "Could not open file '$ErrorPTS' $!";
	$PrintTTY = 1;
}

my $DBPrivacy = "dbi:mysql:NYSVoters:192.168.199.157:3306", my $DBUsername = "root", my $DBPassword = "root";	
my $dbhPrim = DBI->connect($DBPrivacy, $DBUsername, $DBPassword) or die "Connection Error: $DBI::errstr\n";

my $sth_FindLastDate = $dbhPrim->prepare("SELECT * FROM NYSVoters.Raw_Voter_Dates ORDER BY Raw_Voter_Dates_Date DESC LIMIT 1");
my @row = $sth_FindLastDate->fetchrow_array();
my $tabledate = $row[0];

my $sth_FirstName = $dbhPrim->prepare("SELECT VotersFirstName_ID FROM VotersFirstName WHERE VotersFirstName_Compress = ?");
my $sth_LastName = $dbhPrim->prepare("SELECT VotersLastName_ID FROM VotersLastName WHERE VotersLastName_Compress = ?");
my $sth_NameIndex = $dbhPrim->prepare("SELECT * FROM VotersIndexes WHERE VotersFirstName_ID = ? AND VotersLastName_ID = ?");

my $sql = "SELECT * FROM Raw_Voter_" . $tabledate . " WHERE Raw_Voter_UniqNYSVoterID = ?";
my $sth_FindRawTable = $dbhPrim->prepare($sql);

my $sth_AddCandidates = $dbhPrim->prepare("INSERT INTO BOECandidates SET " . 
																					"BOECandidates_Office = ?, BOECandidates_District = ?, " .
																					"BOECandidates_Party = ?, BOECandidates_FullName = ?, BOECandidates_Address = ?, " .
																					"BOECandidates_ZipCode = ?,	BOECandidates_PetitionID = ?, " .
																					"Raw_Voter_UniqNYSVoterID = ?");

my $file_name = shift;
my $pdf = CAM::PDF->new($file_name);

print "File: $file_name\n" if ($VerbosePrint > 2);
my $NumberOfPages = $pdf->numPages();

print "Number: " . $NumberOfPages . "\n" if ($VerbosePrint > 2);

my $LongString = "";

for my $page ( 1 .. $NumberOfPages ) {	
	my $text = $pdf->getPageText($page);
	my @lines = split (/\n/, $text);
	foreach my $string (@lines) {		
		$LongString .= $string . " ";
	}
}

#exit();
my @Words = split (/ /, $LongString);
$LongString = "";

my @WordType = ();
my %HashWordCount = ();
my %HashWordType = ();
my $TotalWords = 0;

### Prep each word and check for whether it's a first name of last name.
for (my $i = 0; $i < @Words; $i++) {
	my $WordLenght = length($Words[$i]);
	
	#Check for ZipCode.
	if ($WordLenght == 5 || $WordLenght == 9 || $WordLenght == 10) {
		 if ( $Words[$i] =~ m/\b(\d{5})(?:-(\d{4}))?/ ) {
		 		$WordType[$i] = "zipcode";
		 } elsif ( $Words[$i] =~ m/(([NY]|[KG]|[QN]|[BX]|[RH])\d{7})/ ) {
		 		$WordType[$i] = "petition";		 
		 }
	}
	
	$HashWordCount { $Words[$i] } += 1;	
	$HashWordType { $Words[$i] } = $WordType[$i];
	$TotalWords = $i;
}

print "Total Words: $TotalWords\n"  if ($VerbosePrint > 2);
print "\nforeach output:\n" if ($VerbosePrint > 2);
foreach my $key (keys %HashWordCount) {
  # do whatever you want with $key and $value here ...
  my $value = $HashWordCount{$key};
  # print "  $key ->:  $value ";
   
 	### Check the word against the First Name and Last Name database.
 	### Ignore if it start with a number.
 	
 	if ( ! $HashWordType { $key } ) {
		if (! (($key =~ /^\d/) || ($key =~ /^$/))) {
			$sth_FirstName->execute($key) or die "SQL Error: $DBI::errstr\n";
			my @row = $sth_FirstName->fetchrow_array();
			if ( @row > 0 ) {
				$HashWordType { $key } = "FN #" . $row[0] . " ";
			}
					
			$sth_LastName->execute($key) or die "SQL Error: $DBI::errstr\n";
			@row = $sth_LastName->fetchrow_array();
			if ( @row > 0 ) {
				$HashWordType { $key } .= "LN #" . $row[0];
			}
	 	}
 	}
	# print $HashWordType { $key } . "\n";
}

## Find the word to put them back;
my $MyOfficeParty = 0;
my $MyAddressStart = 0;
my $MyZipcodeStuff = 0;
my $MyTimeOffset = 0;
my $MyLastTime = 0;

for (my $j = 0; $j < $TotalWords; $j++) {
	if ( $HashWordType { $Words[$j] } =~ /^([FN]|[LN])/ ) {
		$WordType[$j] = $HashWordType { $Words[$j] };		 
		
		### HERE IS WHERE WE SAVE THE INFORMATION TO CHECK FULL NAME
				
	}
	
	if ( $Words[$j] eq "Republican" || $Words[$j] eq "Democratic" ) {
		$WordType[$j] = "office-party";
		$MyOfficeParty = 1;
	}

	### These are the offices	
	if ( $Words[$j] eq "County" && $Words[($j+1)] eq "Committee" && $Words[($j+2)] eq "-") {
		for (my $k = 0; $k < 2;$k++) { $WordType[($j+$k)] = "office";	}
		$WordType[($j+2)] = "ignore";
		$WordType[($j+3)] = "office-district";
		
	} elsif ( $Words[$j] eq "Public" && $Words[($j+1)] eq "Advocate" && $Words[($j+2)] eq "-") {
		for (my $k = 0; $k < 3;$k++) { $WordType[($j+$k)] = "office";	}
		$WordType[($j+3)] = "office-district";
		
	} elsif ( $Words[$j] eq "Judge" && $Words[($j+1)] eq "of" && $Words[($j+2)] eq "the" && $Words[($j+3)] eq "Civil" && $Words[($j+4)] eq "Court" && $Words[($j+5)] eq "-") {
		for (my $k = 0; $k < 6;$k++) { $WordType[($j+$k)] = "office";	}
		for (my $k = 6; $k < 13;$k++) { $WordType[($j+$k)] = "office-district";	}
			
	} elsif ( $Words[$j] eq "Female" && $Words[($j+1)] eq "District" && $Words[($j+2)] eq "Leader" && $Words[($j+3)] eq "-") {
		for (my $k = 0; $k < 4;$k++) { $WordType[($j+$k)] = "office";	}
		for (my $k = 5; $k < 10;$k++) { $WordType[($j+$k)] = "office-district"; }	
			
	} elsif ( $Words[$j] eq "Male" && $Words[($j+1)] eq "District" && $Words[($j+2)] eq "Leader" && $Words[($j+3)] eq "-") {
		for (my $k = 0; $k < 4;$k++) { $WordType[($j+$k)] = "office";	}
		for (my $k = 5; $k < 10;$k++) { $WordType[($j+$k)] = "office-district";	}

	} elsif ( $Words[$j] eq "Delegate" && $Words[($j+1)] eq "to" && $Words[($j+2)] eq "Judicial" && $Words[($j+3)] eq "Convention" && $Words[($j+4)] eq "-") {
		for (my $k = 0; $k < 5;$k++) { $WordType[($j+$k)] = "office";	}
		for (my $k = 5; $k < 9;$k++) { $WordType[($j+$k)] = "office-district";	}
			
	} elsif ( $Words[$j] eq "Alternate" && $Words[($j+1)] eq "Delegate" && $Words[($j+2)] eq "to" && $Words[($j+3)] eq "the" && $Words[($j+4)] eq "Judicial" && $Words[($j+5)] eq "Convention" && $Words[($j+6)] eq "-") {
		for (my $k = 0; $k < 7;$k++) { $WordType[($j+$k)] = "office";	}
		for (my $k = 8; $k < 10;$k++) { $WordType[($j+$k)] = "office-district";	}
	}	

	if ( $MyOfficeParty == 1) {
		if ( $Words[$j] =~ /^\d/ ) {
			$MyAddressStart = 1;
		}
	}
	
	if ( $WordType[$j] eq "zipcode") {
		$MyAddressStart = 0;
		$MyZipcodeStuff = 1;		
		$MyTimeOffset = 1;
	}

	if ( $Words[$j] eq "am" || $Words[$j] eq "pm") {
		if ( $Words[($j-1)] =~ m/^(1[0-2]|0?[1-9]):([0-5]?[0-9])$/) {
			$WordType[($j-1)] = "time";
			$WordType[$j] = "time";

			if ( $MyOfficeParty == 0 && $MyAddressStart == 0 && $MyZipcodeStuff == 0 && $MyTimeOffset == 0 ) {
				for (my $k = $MyLastTime; $k < $j; $k++) {
					if ( $WordType[$k] ne "time" && $WordType[$k] ne "date" && $WordType[$k] ne "petition") {
						$WordType[$k] = "description";					
					}
				}
			}

			$MyOfficeParty = 0;
			$MyAddressStart = 0;
			$MyZipcodeStuff = 0;
			$MyTimeOffset = 0;
			$MyLastTime = $j;
		}
	}
	
	if ( $MyOfficeParty == 1 && $MyAddressStart == 1 && $MyZipcodeStuff == 0 && $MyTimeOffset == 0) {
		$WordType[$j] = "address";
	}
	
	if ( $MyZipcodeStuff == 1 && $WordType[$j] ne "petition" && $WordType[$j] ne "zipcode") {
		$WordType[$j] = "description";
	}
	
	if ( $Words[$j] =~ m/^[01]?\d\/[0123]?\d\/\d{2}/ ) {
		$WordType[$j] = "date";
		$MyTimeOffset = 0;
	}
	
}


### Second cleaning
my $MyMarkerFound = 0;
for (my $j = 0; $j < $TotalWords; $j++) {
		
	if ( $WordType[$j] eq "office") {
		$MyMarkerFound = 1;
	}
	
	if ( $Words[$j] eq "Page" && $Words[$j+2] eq "of" && $Words[$j+3] == $NumberOfPages) {
		$MyMarkerFound = 0;
	}
	
	if ($MyMarkerFound == 0) {
		$WordType[$j] = "ignore";
	}
	
	if ( $Words[$j] eq "Petition-Designating") {
		### Try to find the next.
		### 41149       Word: Petition-Designating      Type: description
		### 41150       Word: NY19002   Type: description
		### 41151       Word: 11        Type: description
		my $WentTroughtTheLoop = 0;

		# This is a bad glue but it will work for 2019.
		for(my $k = $j; $j < $TotalWords && $WordType[$k] ne "date" && ! ($Words[$k] =~ m/(([NY]|[KG]|[QN]|[BX]|[RH])\d{7})/); $k++) {
			$WentTroughtTheLoop = 1;
			
			if ($Words[$k] =~ m/(([NY]|[KG]|[QN]|[BX]|[RH]))/) {
				$Words[$k] = $Words[$k] . $Words[($k+1)];
				$WordType[$k] = "petition";
				$Words[($k+1)] = "";
				$WordType[($k+1)] = "ignore";
			}
		}
	}
}
	

#for (my $j = 0; $j < $TotalWords; $j++) {	
#	if ( $WordType[$j] ne "ignore") {
#		print "Words: #" . $Words[$j] . "# Type: " . $WordType[$j]  . "\n";
#	}
#}

## Now try to indentify the addresses from the ZipCode limit.
my $FoundTop = 0;
my $FoundAddress = 0;
my $FoundDesc = 0;

my $OfficePositionString = "";
my $OfficeDistrict = "";
my $OfficeParty = "";
my $OfficeFullName = "";
my $OfficeAddress = "";
my $OfficeZipcode = "";
my $OfficePetitionID = "";
my $OfficeDescription = "";

my @FinalPostionString = "";
my @FinalDistrict = "";
my @FinalParty = "";
my @FinalFullName = "";
my @FinalAddress = "";
my @FinalZipcode = "";
my @FinalPetitionID = "";
my @FinalDescription = "";
my $FinalCandidateCounter = 0;
my $LocalCountToNext = 0;

my $PrevOffice = "";
my $PrevOfficePosition = "";
my $Prev_FinalCounter = -1;
my $jatstart = -1;

### This is the middle.


for (my $j = 0; $j < $TotalWords; $j++) {
	
	if ( $FinalCandidateCounter < $GoDirectTo - 100 ) { $VerbosePrint = 0; } else { $VerbosePrint = $Verbose; }
	
	if ( $WordType[$j] ne "ignore") {
		if ( $VerbosePrint > 5 ) {
			print "\n### FinalCandidateCounter: " . color("bright_cyan") . $FinalCandidateCounter . color("reset") . "\n";
			print "################# BEG Word " . color("bright_red") . $j .  color("reset") . " of $TotalWords #### Word: ". color("bright_green") . $Words[$j] . color("reset") . " Type: " . color("bright_green") . $WordType[$j] . color("reset") . " ##########\n";		
			print "FoundTop: " . color("bright_cyan") . $FoundTop . color("reset") . " FoundAddress: " . color("bright_cyan") . $FoundAddress . color("reset") . " FoundDesc: " . color("bright_cyan") . $FoundDesc . color("reset") . "\n";
		}
		
		
		if ($PrintTTY == 1 && $VerbosePrint > 8) {
			if ($Prev_FinalCounter != $FinalCandidateCounter) {	$jatstart= $j; } ### This is just so I can highlist.
			print $tty "### FinalCandidateCounter: " . color("bright_cyan") . $FinalCandidateCounter . color("reset") . "\n";
			print $tty color("bright_yellow") . "### J: " . color("reset") . color("bright_red") . $jatstart . color("reset") . " to " .  color("bright_red") . $LocalCountToNext . color("reset")   . "\n";

			for (my $k = $jatstart; $k < $LocalCountToNext + 50; $k++) {
				
				if ($k == $j) {
					print $tty  color("on_black") . "### " . color("bright_cyan") . $k . color("reset") .  color("on_black") . "\tWord: " . color("bright_cyan") . $Words[$k] . color("reset") . 
										color("on_black") .	"\tType: " . color("bright_cyan") . $WordType[$k] . color("reset")  ."\n";
				} else {
					print $tty "### " . color("bright_cyan") . $k . color("reset") . "\tWord: " . color("bright_cyan") . $Words[$k] . color("reset") . 
											"\tType: " . color("bright_cyan") . $WordType[$k] . color("reset") ."\n";
				}
			}
			print $tty "\n";
		}
		$Prev_FinalCounter = $FinalCandidateCounter;
		
		#print "PREV: $Prev_FinalCounter != FINAL: $FinalCandidateCounter\n";
		#<STDIN>;	 

		if ( length($FinalPostionString[$FinalCandidateCounter]) > 0 && length($FinalDistrict[$FinalCandidateCounter]) > 0 &&
					length($FinalParty[$FinalCandidateCounter]) > 0 && length($FinalFullName[$FinalCandidateCounter]) > 0 &&
					length($FinalAddress[$FinalCandidateCounter]) > 0 && length($FinalZipcode[$FinalCandidateCounter]) > 0 &&
					length($FinalPetitionID[$FinalCandidateCounter]) > 0 && length($FinalDescription[$FinalCandidateCounter]) > 0 &&
					length($WordType[$j] == "office-party")) {
			$FinalCandidateCounter++;
		}
		
		
		if ( $FoundTop == 0) {
			if ( length($OfficePositionString) > 0 && length($OfficeParty) > 0 ) { 
				## Before expanding, 
				my $BreakLoop = 0;
				for ( my $l = $j; $l <  $TotalWords && $BreakLoop == 0; $l++) {
					if ($WordType[$l] eq "office" || $WordType[$l] eq "office-party"  ) {						
						$LocalCountToNext = $l;
						$BreakLoop = 1;
					}
				}	
			}
			$OfficePositionString = ""; $OfficeDistrict = ""; $OfficeParty = ""; 
			$OfficeFullName = "";	$OfficeAddress = ""; 	$OfficePetitionID = ""; 
			$OfficeDescription = ""; $OfficeZipcode = "";
			$FoundAddress = 0; $FoundDesc = 0; $FoundTop = 1;
		}
		
		if ($LocalCountToNext == $j) { $FinalCandidateCounter++; }
		
		if ( $WordType[$j] eq "office" ) { $OfficePositionString .= $Words[$j] . " "; }
		if ( $WordType[$j] eq "address") { $OfficeAddress .=  $Words[$j] . " "; $FoundAddress = 0; }
		if ( $WordType[$j] eq "office-district") { $OfficeDistrict .= $Words[$j] . " "; }
		if ( $FoundAddress == 1) { $OfficeFullName .= $Words[$j] . " "; }
		if ( $WordType[$j] eq "office-party") { $OfficeParty .= $Words[$j] . " "; $FoundAddress = 1; }
		if ( $WordType[$j] eq "zipcode") { $OfficeZipcode = $Words[$j]; }
		if ( $WordType[$j] eq "petition") { $OfficeDescription .=  $Words[$j] . " ";  $OfficePetitionID = $Words[$j]; }

		if ( $WordType[$j] eq "date") {	$FoundDesc = 0; }
		if ( $WordType[$j] eq "time") {		

			if ( length($OfficePositionString) > 0) { $FinalPostionString[$FinalCandidateCounter] = $OfficePositionString; }
			if ( length($OfficeDistrict) > 0) { $FinalDistrict[$FinalCandidateCounter] = $OfficeDistrict; }
			if ( length($OfficeParty) > 0) { $FinalParty[$FinalCandidateCounter] = $OfficeParty; }
			if ( length($OfficeFullName) > 0) { $FinalFullName[$FinalCandidateCounter] = $OfficeFullName; }
			if ( length($OfficeAddress) > 0) { $FinalAddress[$FinalCandidateCounter] = $OfficeAddress; }
			if ( length($OfficeZipcode) > 0) { $FinalZipcode[$FinalCandidateCounter] = $OfficeZipcode; }
			if ( length($OfficePetitionID) > 0) { $FinalPetitionID[$FinalCandidateCounter] = $OfficePetitionID; }
			if ( length($OfficeDescription) > 0) { $FinalDescription[$FinalCandidateCounter] = $OfficeDescription; }
			
			if ( length($FinalPostionString[$FinalCandidateCounter]) == 0) { $FinalPostionString[$FinalCandidateCounter] = $PrevOfficePosition; }
			if ( length($FinalDistrict[$FinalCandidateCounter]) == 0) { $FinalDistrict[$FinalCandidateCounter] = $PrevOffice; }
			
			
			$FoundTop = 0;

		}
		
		if ( $FoundDesc == 1) { $OfficeDescription .= $Words[$j] . " "; }		
		if ( length($OfficePositionString) > 0) { $PrevOfficePosition = $OfficePositionString; }
		if ( length($OfficeDistrict) > 0 ) { $PrevOffice = $OfficeDistrict; }

		if ( $VerbosePrint > 5 ) {	
			print "\nFinalCandidateCounter: " . color("bright_cyan") . $FinalCandidateCounter . color("reset") . "\n";
			print "Office Position: " . color("bright_cyan") . $OfficePositionString . color("reset") . "\tFinal: " . color("bright_magenta") . $FinalPostionString[$FinalCandidateCounter] . color("reset") . "\n";
			print "Office District: " .  color("bright_cyan") . $OfficeDistrict . color("reset") . "\tFinal: " . color("bright_magenta") . $FinalDistrict[$FinalCandidateCounter] . color("reset") . "\n";
			print "Office Party: " . color("bright_cyan") . $OfficeParty . color("reset") . "\tFinal: " . color("bright_magenta") . $FinalParty[$FinalCandidateCounter] . color("reset") . "\n";
			print "Candidate Name: " . color("bright_cyan") . $OfficeFullName . color("reset") . "\tFinal: " . color("bright_magenta") . $FinalFullName[$FinalCandidateCounter] . color("reset") . "\n";
			print "Candidate Address: " . color("bright_cyan") . $OfficeAddress . color("reset") . "\tFinal: " . color("bright_magenta") . $FinalAddress[$FinalCandidateCounter] . color("reset") . "\n";
			print "Candidate Zipcode: " . color("bright_cyan") . $OfficeZipcode . color("reset") . "\tFinal: " . color("bright_magenta") . $FinalZipcode[$FinalCandidateCounter] . color("reset") . "\n";
			print "Petition ID: " . color("bright_cyan") . $OfficePetitionID . color("reset")  . "\tFinal: " . color("bright_magenta") . $FinalPetitionID[$FinalCandidateCounter] . color("reset") . "\n";
			print "Description: " . color("bright_cyan") . $OfficeDescription . color("reset") . "\tFinal: " . color("bright_magenta") . $FinalDescription[$FinalCandidateCounter] . color("reset") . "\n";
		
			print "\nOffice Prev Position: " . color("magenta") . $PrevOfficePosition . color("reset") . "\n";
			print "Office Prev Distict: " . color("magenta") . $PrevOffice . color("reset") . "\n";
			
			print "\n";
			print "FoundTop: " . color("bright_cyan") . $FoundTop . color("reset") . " FoundAddress: " . color("bright_cyan") . $FoundAddress . color("reset") . " FoundDesc: " . color("bright_cyan") . $FoundDesc . color("reset") . "\n";
			print "\n### FinalCandidateCounter: " . color("bright_cyan") . $FinalCandidateCounter . color("reset") . "\n";
			print "################# END Word $j of $TotalWords #### Word: " . $Words[$j] . " Type: " . $WordType[$j] . " ##########\n\n";
			
			
			### This is to jump directly to debug
			if ($VerbosePrint > 8) { 
				if ( $FinalCandidateCounter > $GoDirectTo) {
					<STDIN>;
				}
			}
			
			
		}
	}
}




print "Final Candidate Counter: $FinalCandidateCounter\n";

my $TotalFinal = 0;
for (my $i = 0; $i < $FinalCandidateCounter; $i++) {
	
	### Some cleanup required because it double.
	### This will need to be removed.
	if ($FinalPostionString[$i] =~ /County Committee County Committee/) {
		$FinalPostionString[$i] = "County Committee";		
		$FinalDistrict[$i] =~ /([^ ]*) .*/;
		$FinalDistrict[$i] = $1;
	}
	
	if ( length ($FinalParty[$i]) > 0) {
		$TotalFinal++;
		
		print $i . "\t";
		print $FinalPostionString[$i] . "\t";
		print $FinalDistrict[$i] . "\t";
		print uc(substr($FinalParty[$i], 0, 3)) . "\t";
		print $FinalFullName[$i] . "\t";
		print $FinalAddress[$i] . "\t";
		print $FinalZipcode[$i] . "\t";
		print $FinalPetitionID[$i] . "\n";
		#print $FinalDescription[$i] . "\n";
	}			
	### Here is the check of the Full Name and trying to find it.
	###	$sth_NameIndex 
	
	### Remove this DB call. Print to file then use another script.s
	#$sth_AddCandidates->execute($FinalPostionString[$i], 
	#														$FinalDistrict[$i], uc(substr($FinalParty[$i], 0, 3)),
	#														$FinalFullName[$i], $FinalAddress[$i], $FinalZipcode[$i], $FinalPetitionID[$i], "");
}
print "\nFinal Candidate Counter: $TotalFinal\n";

#my $str_AddCandidates = $dbhPrim->prepare("INSERT INTO BOECandidates SET " . 
#																					"BOECandidates_Office = ?, BOECandidates_District = ?, " .
#																					"BOECandidates_Party = ?, BOECandidates_FullName = ?, BOECandidates_Address = ?, " .
#																					"BOECandidates_ZipCode = ?,	BOECandidates_PetitionID = ?, " .
#																					"Raw_Voter_UniqNYSVoterID = ?");
