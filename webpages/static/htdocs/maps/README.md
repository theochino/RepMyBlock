In this directory are all the static maps and technically they are a match for the Geolocalisation ID from the 
database.

<PRE>
~/OutragedDems/webpages/static/htdocs/maps$ ls
1   11  13  15  17  19  20  22  24  26  28  3   31  33  35  37  39  40  42  44  46  48  5   51  53  55  57  6  8
10  12  14  16  18  2   21  23  25  27  29  30  32  34  36  38  4   41  43  45  47  49  50  52  54  56  58  7  9
</PRE>

The directory number 10 contains Img-1000.jpg which is ID 1000 in the DB.<BR>
<I>The reason for breaking the directory is to make sure we don't overload the inode count per directory and
it's easier on the eyes when troubleshooting.</I>
<PRE>
./10:
total 10084
drwxrwxr-x  2 usracct usracct   4096 Jan 28 23:48 .
drwxr-xr-x 60 usracct usracct   4096 Feb  2 09:47 ..
-rw-rw-r--  1 usracct usracct 105887 Jan 27 23:18 Img-1000.jpg
-rw-rw-r--  1 usracct usracct 103378 Jan 27 23:18 Img-1001.jpg
-rw-rw-r--  1 usracct usracct  94335 Jan 27 23:18 Img-1002.jpg
-rw-rw-r--  1 usracct usracct 113536 Jan 27 23:18 Img-1003.jpg
-rw-rw-r--  1 usracct usracct 115635 Jan 27 23:18 Img-1004.jpg
</PRE>

