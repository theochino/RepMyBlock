#!/usr/bin/perl

local $| = 1; # activate autoflush to immediately show the prompt

use strict;
use DBI;
use Text::CSV;

my @ElectDates = LoadElectionsDates();


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

my %ElectionsListByID = ();
my %ElectionsListText = ();
my %ElectionsListDate = ();
my %ElectionsListType = ();

# Save in the memory the voter history
$sth = $dbh->prepare("SELECT * FROM NYSVoters.Elections");
$sth->execute() or die "$! $DBI::errstr";

my $Counter = 0;
print "Loading elections date data: ";
while (my $OtherRow = $sth->fetchrow_hashref) {
	$ElectionsListByID { $OtherRow->{Elections_Text} } = $OtherRow->{Elections_ID};
	$ElectionsListText { $OtherRow->{Elections_ID} } = $OtherRow->{Elections_Text};
	$ElectionsListDate { $OtherRow->{Elections_ID} } = $OtherRow->{Elections_Date};
	$ElectionsListType { $OtherRow->{Elections_ID} } = $OtherRow->{Elections_Type};	
	#print "Row: " . $OtherRow->{Elections_Text} . "\n";
	print "." if ($Counter++ % 100 == 0);
}

print " Done\n";

my $sth_addelection = $dbh->prepare( "INSERT Elections SET Elections_Text = ?, Elections_Date = ?, Elections_Type = ?");

my $VoterHistory = "SELECT DISTINCT Raw_Voter_VoterHistory FROM NYSVoters." . $table ;
$sth = $dbh->prepare( $VoterHistory );
$sth->execute() or die "$! $DBI::errstr";

while (my @row = $sth->fetchrow_array) {	
	my @chars = split /;/, $row[0];
	foreach my $var (@chars) {
    if ( ! $ElectionsListByID { $var } && length ($var) > 1 ) {
    	#print "Row: " . $row[0] . "\n";
    	#print "$var -> " . $ElectionsListByID { $var } . "\n";
    	print "We need to add \e[1;33m$var\e[0m to the database\n";

    	my $MostLikelyDate = FindMostLikellyDate($var);
    	my $MostLikelyType = FindMostLikellyType($var);			
    	
    	my $FinalDate = $MostLikelyDate;
    	my $FinalType = $MostLikelyType;
    	
    	print "\tAccept \e[1;36m" . $FinalDate . "\e[0m and \e[1;36m" . $FinalType . "\e[0m [N]o/[S]kip but add/[J]ump: ";
    	chomp(my $acceptallline = <STDIN>);

    	if ((lc($acceptallline) eq 's') == 1) {
    		
    		undef $FinalDate;
    		undef $FinalType;
    		
    	} elsif ((lc($acceptallline) eq 'n') == 1) {

				# Enter the type
	     	print "\tEnter type of election ([P]rimary/[G]eneral/[S]pecial/[O]ther/[N]ull): \e[1;36m$MostLikelyType\e[0m ";
	    	chomp(my $answertype = <STDIN>);

	      if (length($answertype) == 0) { $FinalType = $MostLikelyType; }
	 	    if ((lc($answertype) eq 'n') == 1) { undef $FinalType; };
	    	if ((lc($answertype) eq 'p') == 1) { $FinalType = "primary"; };
	    	if ((lc($answertype) eq 'g') == 1) { $FinalType = "general"; };
	    	if ((lc($answertype) eq 's') == 1) { $FinalType = "special"; };
	    	if ((lc($answertype) eq 'o') == 1) { $FinalType = "other"; };
	    	
	 			# Enter the Date   	
	    	print "\tEnter date last election: YYYY-MM-DD or [N]ull: \e[1;36m$MostLikelyDate\e[0m ";
	    	chomp(my $answerdate = <STDIN>);
	    	$FinalDate = $MostLikelyDate;
	    	
	    	if ((lc($answerdate) eq 'n') == 1) { undef $FinalDate; };
	    	if ($answerdate ne $FinalDate && length($answerdate) > 4) {
	    		$FinalDate = $answerdate;
	    	}
    	} 
    	
    	if ((lc($acceptallline) eq 'j') == 0) {
	    	$sth_addelection->execute($var, $FinalDate, $FinalType);    			    	
				$ElectionsListByID { $var } = $sth_addelection->{mysql_insertid};
				$ElectionsListText { $sth_addelection->{mysql_insertid} } = $var;
				$ElectionsListDate { $sth_addelection->{mysql_insertid} } = $FinalDate;;
				$ElectionsListType { $sth_addelection->{mysql_insertid} } = $FinalType;	
			}
			
			print "\n";
    }
    
	}
}

sub FindMostLikellyType() {
	
	my ($line) = (@_);
 	
	my $TypeFound;
	if ( $line =~ /pr/i) { $TypeFound = "primary"};  	
	if ( $line =~ /ge/i) { $TypeFound = "general"};  
	if ( $line =~ /co/i) { $TypeFound = "primary"};  
	if ( $line =~ /pp/i) { $TypeFound = "primary"};  
	if ( $line =~ /run/i) { $TypeFound = "primary"};  
	if ( $line =~ /ro/i) { $TypeFound = "primary"};  
	if ( $line =~ /sp/i){ $TypeFound = "special"};  
	if ( $line =~ /fe/i){ $TypeFound = "primary"};  

	
	return $TypeFound;
}

sub FindMostLikellyDate() {
	my ($line) = (@_);
 	
 	# Find a either 2, 4, or 8 digit number
 	my $NumberFound;
 	if ($line =~ /((\d{2}))\b/) { $NumberFound = "20" . $1 };
 	if ($line =~ /((\d{4}))\b/) { $NumberFound = $1 };
	if ($line =~ /((\d{8}))\b/) { return $1 };

	my $TypeFound;
	if ( $line =~ /pr/i) { $TypeFound = "pri"};  	
	if ( $line =~ /ge/i) { $TypeFound = "ge"};  
	if ( $line =~ /con/i) { $TypeFound = "fed"};  
	if ( $line =~ /run/i) { $TypeFound = "run"};  
	if ( $line =~ /sp/i){ $TypeFound = "sp"};  
	if ( $line =~ /pri/i) { $TypeFound = "pri"};  
	if ( $line =~ /pre/i){ $TypeFound = "pre"};  
	if ( $line =~ /fed/i){ $TypeFound = "fed"};  
	if ( $line =~ /ro/i){ $TypeFound = "pri"};  
	
	
	foreach my $element (@ElectDates) {  
    if ($element =~ /$NumberFound/) {
    	if ($element =~ /$TypeFound/i) {
    		print "\t       \e[1;30m$element\e[0m\n";
    		return substr $element, 0, 8;
    	}
    }
	}	

	return;	
}

sub LoadElectionsDates() {
	my @ElectDates = (
	
										"20190122 - Special Sewer Election - January 22, 2019" ,
										"20190319 - Special Election March 19, 2019", 
										"20190625 - State and Local Primary Election - June 25, 2019", 
										"20191105 - General Election November 5, 2019",	
										"20190226 - Special Election Public Advocate - February 26, 2019",
										"20181106 - General - November 6, 2018", 
										"20180913 - Primary - September 13, 2018", 
										"20180626 - Federal Primary - June 26, 2018", 
										"20180424 - Special Election - April 24, 2018", 
										"20171107 - General Election - November 7, 2017", 
										"20170912 - Primary Election - September 12, 2017", 
										"20170523 - Special Election - May 23, 2017", 
										"20170214 - Special Election - February 14, 2017", 
										"20161108 - General Election - November 8, 2016", 
										"20160913 - Primary Election - September 13, 2016", 
										"20160628 - Federal Primary Election - June 28, 2016", 
										"20160419 - Presidential Primary Election 2016 - April 19, 2016", 
										"20160419 - Special Election 59 62 and 65 Assembly - April 19, 2016", 
										"20160223 - Special Election 17th Council - February 23, 2016", 
										"20151103 - General Election - November 3, 2015", 
										"20150910 - Primary Election - September 10, 2015", 
										"20150505 - Special Election - May 5, 2015", 
										"20141104 - General Election - November 4, 2014", 
										"20140909 - PRIMARY ELECTION - SEPTEMBER 9, 2014", 
										"20140624 - FEDERAL PRIMARY - JUNE 24, 2014", 
										"20131105 - GENERAL ELECTION - NOVEMBER 5, 2013", 
										"20130910 - PRIMARY ELECTION - SEPTEMBER 10, 2013", 
										"20131001 - RUN-OFF PRIMARY 2013 - OCTOBER 1, 2013", 
										"20130219 - Special Election 31st Council - February 19, 2013", 
										"20121106 - GENERAL ELECTION - NOVEMBER 6, 2012", 
										"20120913 - PRIMARY ELECTION - SEPTEMBER 13, 2012", 
										"20120626 - Federal Primary Election - June 26, 2012", 
										"20120320 - Special Election 27th State Senate - March 20, 2012", 
										"20120424 - Presidential Primary Election April 24, 2012", 
										"20111108 - General Election November 8, 2011", 
										"20110913 - Primary Election September 13, 2011", 
										"20110913 - Special Election September 13, 2011", 
										"20101102 - General Election November 2, 2010", 
										"20100914 - Primary Election September 14,2010", 
										"20100323 - Special Election March 23,2010", 
										"20100316 - Special Election March 16,2010", 
										"20100209 - Special Election February 9,2010", 
										"20091103 - General Election 2009 - November 3, 2009", 
										"20090915 - Primary Election September 15, 2009", 
										"20090929 - Runoff Primary Election 2009 - September 29, 2009", 
										"20090915 - Special Election September 15, 2009", 
										"20090606 - Special Election June 6, 2009", 
										"20090421 - Special Election April 21, 2009", 
										"20090224 - Special Election February 24, 2009", 
										"20081104 - General Election November 4, 2008", 
										"20080909 - Primary Election September 9, 2008", 
										"20080603 - Special Election June 3, 2008", 
										"20080205 - Presidential Primary Election February 5, 2008", 
										"20071106 - General Election November 6, 2007", 
										"20070918 - Primary Election September 18, 2007",  
										"20070605 - Special Election June 5, 2007", 
										"20070424 - Special Election April 24, 2007", 
										"20070327 - Special Election March 27, 2007", 
										"20070220 - Special Election February 20, 2007", 
										"20061107 - General Election November 7, 2006", 
										"20060912 - Primary Election September 12, 2006", 
										"20060228 - Special Election February 28, 2006", 
										"20051108 - General Election November 8, 2005", 
										"20050913 - Primary Election September 13, 2005", 
										"20050505 - Special Election May 5, 2005", 
										"20050215 - Special Election February 15, 2005", 
										"20041102 - General Election November 2, 2004", 
										"20040914 - Primary Election September 14, 2004", 
										"20040302 - Presidential Primary Election March 2, 2004", 
										"20031104 - General Election November 4, 2003", 
										"20030909 - Primary Election September 9, 2003", 
										"20030225 - Special Election February 25, 2003", 
										"20021105 - General Election November 5, 2002", 
										"20020910 - Primary Election September 10, 2002", 
										"20020416 - Special Election April 16, 2002", 
										"20020212 - Special Election February 12, 2002", 
										"20011106 - General Elections November 6, 2001", 
										"20010925 - Primary Elections September 25, 2001", 
										"20011022 - Run-Off Elections October 22, 2001", 
										"20010220 - Special Election February 20, 2001", 
										"20001107 - General Election November 7, 2000", 
										"20000912 - Primary Election September 12, 2000", 
										"19991102 - General Election November 2, 1999");
										
	return @ElectDates;
}