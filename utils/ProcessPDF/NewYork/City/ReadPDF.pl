#!/usr/bin/perl

use strict;
use CAM::PDF;
use DBI;
use Text::Aspell;

my $DBPrivacy = "dbi:mysql:NYSVoters:192.168.199.217:3306", my $DBUsername = "root", my $DBPassword = "root";	
my $dbhPrim = DBI->connect($DBPrivacy, $DBUsername, $DBPassword) or die "Connection Error: $DBI::errstr\n";

my $sth_FirstName = $dbhPrim->prepare("SELECT VotersFirstName_ID FROM VotersFirstName WHERE VotersFirstName_Compress = ?");
my $sth_LastName = $dbhPrim->prepare("SELECT VotersLastName_ID FROM VotersLastName WHERE VotersLastName_Compress = ?");

my $file_name = shift;
my $pdf = CAM::PDF->new($file_name);

print "File: $file_name\n";
my $NumberOfPages = $pdf->numPages();

print "Number: " . $NumberOfPages . "\n";

my $LongString = "";

for my $page ( 1 .. $NumberOfPages ) {	
	my $text = $pdf->getPageText($page);
	my @lines = split (/\n/, $text);

	foreach my $string (@lines) {		
		$LongString .= $string . " ";
	}
}

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

print "Total Words: $TotalWords\n";


print "\nforeach output:\n";
foreach my $key (keys %HashWordCount) {
  # do whatever you want with $key and $value here ...
  my $value = $HashWordCount{$key};
#  print "  $key ->:  $value ";
   
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
# 	print $HashWordType { $key } . "\n";
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
	}
	
	if ( $Words[$j] eq "Republican" || $Words[$j] eq "Democratic" ) {
		$WordType[$j] = "office-party";
		$MyOfficeParty = 1;
	}
	
	if ( $Words[$j] eq "County" && $Words[($j+1)] eq "Committee" && $Words[($j+2)] eq "-") {
		for (my $k= 0; $k< 3;$k++) { $WordType[($j+$k)] = "office";	}
		$WordType[($j+3)] = "office-district";
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
	
	if ( $Words[$j] =~ m/^[01]?\d\/[0123]?\d\/\d{2}/ ) {
		$WordType[$j] = "date";
		$MyTimeOffset = 0;
	}
	
	if ( $Words[$j] eq "am" || $Words[$j] eq "pm") {
		if ( $Words[($j-1)] =~ m/^(1[0-2]|0?[1-9]):([0-5]?[0-9])$/) {
			$WordType[($j-1)] = "time";
			$WordType[$j] = "time";
			
			
			if ( $MyOfficeParty == 0 && $MyAddressStart == 0 && $MyZipcodeStuff == 0 && $MyTimeOffset == 0 ) {
				for (my $k = $MyLastTime; $k < $MyLastTime; $k++) {
					$WordType[$k] = "description";
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
	
	if ( $MyOfficeParty == 1 && $MyAddressStart == 1 && $MyZipcodeStuff == 0 && $MyTimeOffset == 1 && $WordType[$j] ne "petition") {
		$WordType[$j] = "description";
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

}

#$TotalWords = 1000;

## Now try to indentify the addresses from the ZipCode limit.
for (my $j = 0; $j < $TotalWords; $j++) {
	if ( $WordType[$j] ne "ignore") {
		print "Words: #" . $Words[$j] . "# Type: " . $WordType[$j]  . "\n";
	}
}
