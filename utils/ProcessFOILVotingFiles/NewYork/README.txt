The first thing to do is to put the data in a dated directory.
Set the ~usracct/.voter_file to the name of the dated directory

Before Running BreakFiles.pl, edit it to change the directory and run it.

Look for this line: NY000000000037663250 and fix the entry.

ProcessVoterFile.pl -> Load the file into the Database

Once you are done, you can add the voter history by running
./PrepVoterHistory.pl -> This will loop the voter history and prompt for historical dates that don't exist.
 		It does a long time to load since he load the whole historical file.
		5 minutes could be the time it takes.
													
													
Then go to the directory ~/FixDBprogs
and run ./RunFixScript.sh 
