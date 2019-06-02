#!/usr/bin/perl

$filename = "/home/usracct/LoadVoterFile/20190408/AllNYSVoters_04082019.txt";

open(my $fh, $filename ) or die "cannot open input.txt: $!";

$FileCounter = 0;
$Counter = 0;

$PATH = "../WorkingFiles/";

$FILENAME =  $PATH . "CVSVOTER_" . $FileCounter . ".csv";
open ( $out, '>', $FILENAME);


while (my $row = <$fh>) {
  chomp $row;

	if ( $Counter > 100000 ) {
		$FileCounter++;
		$Counter = 0;
		
		close ($out);
		$FILENAME =  $PATH . "CVSVOTER_" . $FileCounter . ".csv";
		open ( $out, '>', $FILENAME);
	}

  print $out "$row\n";
  $Counter++;
}

close ($out);
print "done\n";
