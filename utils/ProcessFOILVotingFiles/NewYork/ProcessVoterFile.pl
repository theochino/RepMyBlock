#!/usr/bin/perl

local $| = 1; # activate autoflush to immediately show the prompt

use strict;
use DBI;
use Text::CSV;

# Read the Table Directory in the file
my $filename = '/home/usracct/.voter_file';
open(my $fh, '<:encoding(UTF-8)', $filename) or die "Could not open file '$filename' $!";
my $tabledate = <$fh>;
chomp($tabledate);
close($fh);

my $dbname = "NYSVoters";
my $dbhost = "192.168.199.217";
my $dbport = "3306";
my $dbuser = "root";
my $dbpass = "root";
my $table = "Raw_Voter_" . $tabledate;

my $dsn = "dbi:mysql:dbname=$dbname;host=$dbhost;port=$dbport;";
my $dbh = DBI->connect($dsn, $dbuser, $dbpass) or die "Connection error: $DBI::errstr";
my $sth;

print "Going to work with table $tabledate (y/N)\n";
chomp(my $answer = <STDIN>);
exit if ((lc($answer) eq 'y') != 1);

my $DropTable = "DROP TABLE IF EXISTS " . $table;
$sth = $dbh->prepare( $DropTable );
$sth->execute() or die "$! $DBI::errstr";

my $CreateTable = "CREATE TABLE " . $table . " (" . 
								  "`Raw_Voter_ID` int(10) unsigned NOT NULL AUTO_INCREMENT," . 
								  "`Raw_Voter_LastName` varchar(50) DEFAULT NULL," . 
								  "`Raw_Voter_FirstName` varchar(50) DEFAULT NULL," . 
								  "`Raw_Voter_MiddleName` varchar(50) DEFAULT NULL," . 
								  "`Raw_Voter_Suffix` varchar(10) DEFAULT NULL," . 
								  "`Raw_Voter_ResHouseNumber` varchar(10) DEFAULT NULL," . 
								  "`Raw_Voter_ResFracAddress` varchar(10) DEFAULT NULL," . 
								  "`Raw_Voter_ResApartment` varchar(15) DEFAULT NULL," . 
								  "`Raw_Voter_ResPreStreet` varchar(10) DEFAULT NULL," . 
								  "`Raw_Voter_ResStreetName` varchar(70) DEFAULT NULL," . 
								  "`Raw_Voter_ResPostStDir` varchar(10) DEFAULT NULL," . 
								  "`Raw_Voter_ResCity` varchar(50) DEFAULT NULL," . 
								  "`Raw_Voter_ResZip` char(5) DEFAULT NULL," . 
								  "`Raw_Voter_ResZip4` char(4) DEFAULT NULL," . 
								  "`Raw_Voter_ResMail1` varchar(100) DEFAULT NULL," . 
								  "`Raw_Voter_ResMail2` varchar(100) DEFAULT NULL," . 
								  "`Raw_Voter_ResMail3` varchar(100) DEFAULT NULL," . 
								  "`Raw_Voter_ResMail4` varchar(100) DEFAULT NULL," . 
								  "`Raw_Voter_DOB` char(8) DEFAULT NULL," . 
								  "`Raw_Voter_Gender` char(1) DEFAULT NULL," . 
								  "`Raw_Voter_EnrollPolParty` char(3) DEFAULT NULL," . 
								  "`Raw_Voter_OtherParty` varchar(30) DEFAULT NULL," . 
								  "`Raw_Voter_CountyCode` char(2) DEFAULT NULL," . 
								  "`Raw_Voter_ElectDistr` char(3) DEFAULT NULL," . 
								  "`Raw_Voter_LegisDistr` char(3) DEFAULT NULL," . 
								  "`Raw_Voter_TownCity` varchar(30) DEFAULT NULL," . 
								  "`Raw_Voter_Ward` char(3) DEFAULT NULL," . 
								  "`Raw_Voter_CongressDistr` char(3) DEFAULT NULL," . 
								  "`Raw_Voter_SenateDistr` char(3) DEFAULT NULL," . 
								  "`Raw_Voter_AssemblyDistr` char(3) DEFAULT NULL," . 
								  "`Raw_Voter_LastDateVoted` char(8) DEFAULT NULL," . 
								  "`Raw_Voter_PrevYearVoted` varchar(4) DEFAULT NULL," . 
								  "`Raw_Voter_PrevCounty` char(2) DEFAULT NULL," . 
								  "`Raw_Voter_PrevAddress` varchar(100) DEFAULT NULL," . 
								  "`Raw_Voter_PrevName` varchar(150) DEFAULT NULL," . 
								  "`Raw_Voter_CountyVoterNumber` varchar(50) DEFAULT NULL," . 
								  "`Raw_Voter_RegistrationCharacter` char(8) DEFAULT NULL," . 
								  "`Raw_Voter_ApplicationSource` varchar(10) DEFAULT NULL," . 
								  "`Raw_Voter_IDRequired` char(1) DEFAULT NULL," . 
								  "`Raw_Voter_IDMet` char(1) DEFAULT NULL," . 
								  "`Raw_Voter_Status` varchar(10) DEFAULT NULL," . 
								  "`Raw_Voter_ReasonCode` varchar(15) DEFAULT NULL," . 
								  "`Raw_Voter_VoterMadeInactive` char(8) DEFAULT NULL," . 
								  "`Raw_Voter_VoterPurged` char(8) DEFAULT NULL," . 
								  "`Raw_Voter_UniqNYSVoterID` varchar(50) DEFAULT NULL," . 
								  "`Raw_Voter_VoterHistory` text," . 
								  "PRIMARY KEY (`Raw_Voter_ID`)," . 
								  "KEY `" . $table . "_LastName_IDX` (`Raw_Voter_LastName`)," . 
								  "KEY `" . $table . "_UniqNYSVoterID_IDX` (`Raw_Voter_UniqNYSVoterID`)," . 
								  "KEY `" . $table . "_Raw_Voter_CountyCode` (`Raw_Voter_CountyCode`)," . 
								  "KEY `" . $table . "_Raw_Voter_ADED` (`Raw_Voter_AssemblyDistr`,`Raw_Voter_ElectDistr`)" . 
									") ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPRESSED KEY_BLOCK_SIZE=8"; 

$sth = $dbh->prepare( $CreateTable );
$sth->execute() or die "$! $DBI::errstr";

my $file; # = shift or die "Usage: $0 file.csv";
my $i = 0;

my $PATH = "../WorkingFiles/";
opendir my $dh, $PATH  or die "Can't open $PATH: $!";

my $cnt_gfs = 0;
my $filename = "";

while (my $filename = readdir($dh)) {
  
  if ($filename =~ /.csv/) {
  
	  $cnt_gfs++;
		$file = $PATH . $filename;
		
		print "$cnt_gfs: Opening file : $file \n";
		
		
		open CSV, $file or die $!;
		my @csv_content = <CSV>;
		close CSV;
		
	
		
		#my $field_line = "null, " . shift(@csv_content);
		#chomp($field_line);
		
		my @values;
		my $status;
		my $line;
		
		my $csv = Text::CSV->new();
		$csv->always_quote(1);
		
		my $Statement = "INSERT INTO $table VALUES";
		my $first_time = 0;
		
		foreach(@csv_content){
			if($csv->parse($_)){
				
				if ($first_time == 1) {
					$Statement .= ",";
				} else {
					$first_time = 1;
				}
		
				#print $_ . "\n";
		    @values = $csv->fields();
		    $status = $csv->combine(@values);
		     
		    $line = "null," . $csv->string();
		    $line =~  s/\\//;
				$line =~ s/\"\s*\"/null/g;
		    #chomp($line);
		
		    $Statement .= "($line)";
		    
		    
			}
		}
		#print $Statement ."\n";
		$sth = $dbh->prepare( $Statement );
		$sth->execute() or die "$! $DBI::errstr";
	}

}

 
