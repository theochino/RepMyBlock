<?php
require($_SERVER["DOCUMENT_ROOT"] . '/../libs/utils/fpdf181/fpdf.php');

class PDF extends FPDF {
	
	var $angle=0;
	var $Col1 = 6; var $Col2 = 61; var $Col3 = 150;
	var $SizeCol1 = 55; var $SizeCol2 = 89; var $SizeCol3 = 59;
  var $Line_Left = 6; var $Line_Right = 209; var $Line_Col1 = 61; var $Line_Col2 = 150;
	//$Botton_Corner_Y = 0;
	 
	// Page header
	function Header()	{

		if (! empty ($this->Watermark)) {
			$this->SetFont('Arial','B',50);
    	$this->SetTextColor(255,192,203);
   		$this->RotatedText(35,190, $this->Watermark, 45);
   		$this->RotatedText(40,210, "Election will be held in 2019", 45);
   		$this->SetTextColor(0,0,0);
		}
		
    $this->SetFont('Arial','B',12);
    $this->Cell(0,0, strtoupper($this->party) . " PARTY",0,0,'C');
    $this->Ln(4);
		$this->Cell(0,0, "Designating Petition - " . $this->county . ' County',0,0,'C');
    $this->Ln(3);    
    
    $this->SetFont('Arial','B',8);
    $this->Cell(36,2.8, 'To the Board of Elections:');
    $this->SetFont('Arial','',8);
		$this->Cell(192,2.8, 
			"I, the undersigned, do hereby state that I am a duly " . 
			"enrolled voter of the " . $this->party . " Party " .
			"and entitled to vote at the next primary");
		$this->Ln(2.8);
		  
		$this->MultiCell(0,2.8, 
			"election of such party, to be held on " . 
			$this->ElectionDate . "; that my place of residence is truly " . 
			"stated opposite my signature hereto, and I do hereby designate " .
			"the following named person" . $this->PluralCandidates . " as " .
			$this->PluralAcandidates . " candidate" . $this->PluralCandidates . " for ". 
			"the " . $this->CandidateNomination);
    $this->Ln(2.8);
    
		$YLocation_new = $Top_Corner_Y = $this->GetY() - 1.5;   
	
 		$this->SetY($Top_Corner_Y);
  	 
    for ($i = 0; $i < $this->NumberOfCandidates; $i++) {
    			
    	$MyTop = $YLocation = $this->GetY();
    			
 			if ($this->PositionType[$i] != $Prev_PartyPosition) {
		  	$this->Line($this->Line_Left, $YLocation - 0.1,  $this->Line_Right, $YLocation - 0.1); 

		    $this->SetFont('Arial','B',8);
		    $this->SetXY($this->Col1, $YLocation );
		    $this->MultiCell($this->SizeCol1, 4, "NAME" . strtoupper($this->PluralCandidates) . " OF CANDIDATE" . strtoupper($this->PluralCandidates), 0, 'C');

		    $this->SetXY($this->Col2, $YLocation );
		    $this->MultiCell($this->SizeCol2, 4, $this->RunningForHeading[$this->PositionType[$i]], 0, 'C');

	  	 	$this->SetXY($this->Col3, $YLocation );
	  	 	$this->MultiCell($this->SizeCol3, 4, "PLACE" . strtoupper($this->PluralCandidates) . " OF RESIDENCE", 0, 'C');

	    	$this->SetFont('Arial','',8);
	    	$Prev_PartyPosition = $this->PositionType[$i];

    		$YLocation = $this->GetY() + 0.5;
	    }
	    			
	    $this->Line($this->Line_Left, $YLocation - 0.1, $this->Line_Right, $YLocation - 0.1); 
 			
     	$this->SetFont('Arial','B',11);
 			$this->SetXY($this->Col1, $YLocation + 0.3 );
			$this->MultiCell($this->SizeCol1, 3.5, $this->Candidate[$i], 0, 'C', 0);
  		if ( $YLocation_new < $this->GetY()) { $YLocation_new = $this->GetY(); }
	
			$this->SetFont('Arial','', 9);   	   		
			$this->SetXY($this->Col2, $YLocation );
   		$this->MultiCell($this->SizeCol2, 3.5, $this->RunningFor[$i], 0, 'C', 0);
  		if ( $YLocation_new < $this->GetY()) { $YLocation_new = $this->GetY(); }
									
			$this->SetXY($this->Col3, $YLocation );
  		$this->MultiCell($this->SizeCol3, 3.5, $this->Residence[$i], 0, 'C', 0);
  		if ( $YLocation_new < $this->GetY()) { $YLocation_new = $this->GetY(); }

									
			$YLocation = $YLocation_new + 0.7;   
			$this->Line($this->Line_Left, $YLocation - 0.1, $this->Line_Right, $YLocation - 0.1); 
			
		 	$this->SetY($YLocation);	
		 	
		 	// Here I need to put the pieces.
		 	$this->Line($this->Line_Left, $MyTop - 0.1, $this->Line_Left, $YLocation - 0.1); 
		 	$this->Line($this->Line_Col1, $MyTop - 0.1, $this->Line_Col1, $YLocation - 0.1); 
		 	$this->Line($this->Line_Col2, $MyTop - 0.1, $this->Line_Col2, $YLocation - 0.1); 
		 	$this->Line($this->Line_Right, $MyTop - 0.1, $this->Line_Right, $YLocation - 0.1); 
		 	
			
 	   	$this->SetFont('Times','I',7);
 	   	$this->SetXY($this->Line_Left + 0.5, $YLocation );
	    $this->MultiCell(0, 2.8, 
	    	"I do hereby appoint " . $this->Appointments[$i] . " all of whom are enrolled voters of the " . $this->party . 
	    	" Party, as a committee to fill vacancies in accordance with the provisions of the Election Law.", 0);
	    
	    $YLocation = $this->GetY() - 1.5 ;
	    
	    $Botton_Corner_Y = $this->GetY();

   	}
   	
   	$this->Ln(2);  	 
   	$this->SetX($this->Line_Left);
   	$this->SetFont('Arial','B',8);
    $this->Cell(0, 0, "In witness whereof, I have hereunto set my hand, the day and year placed opposite my signature.");
    
    $this->Ln(1);
    
    $this->SetFont('Arial','B',13);
		$this->Cell(35, 8, "Date" ,0, 0, 'C', 0);
		$this->Cell(75, 8, "Signature / Name of Signer", 0, 0, 'C', 0);
		$this->Cell(74, 8, "Residence", 0, 0, 'C', 0);
		$this->Cell(20, 8, "County", 0, 0, 'C', 0);
		$this->Ln(4.5);
   
   	$YLocation = $this->GetY() - 3.5;
   	$this->Line($this->Line_Left, $YLocation, $this->Line_Right, $YLocation);
		
		//$this->Line($this->Line_Left, $Botton_Corner_Y, $this->Line_Right, $Botton_Corner_Y - 0.3);
		//$this->Line($this->Line_Left,	 $Botton_Corner_Y + 6.1, $this->Line_Right, $Botton_Corner_Y + 6.1);

 		$this->Line($this->Line_Left,   $YLocation, $this->Line_Left, $this->BottonPt);
 		$this->Line(40,  $YLocation, 40,  $this->BottonPt);
 		$this->Line(120, $YLocation, 120, $this->BottonPt);
 		$this->Line(190, $YLocation, 190, $this->BottonPt);
 		$this->Line($this->Line_Right, $YLocation, $this->Line_Right, $this->BottonPt);
    
	}

	// Page footer
	function Footer()	{
		
		$this->SetY(-37);
   	$YLocation = $this->GetY() - 1.9;
		$this->Line($this->Line_Left, $YLocation, $this->Line_Right, $YLocation);
	
		$this->SetFont('Arial','B',8);
		$this->Cell(0,0, "STATEMENT OF WITNESS", 0, 1, 'C');		
		$this->SetFont('Arial','',8);
		$this->Ln(1);
		$this->MultiCell(0, 3.8, 
			"I, " . $this->WitnessName . " state: I am a duly qualified voter of the State of New York and am an " . 
			"enrolled voter of the Democratic Party. I now reside at " . $this->WitnessResidence . ". Each " . 
			"of the individuals whose names are subscribed to this petition sheet " . 
			"containing ____ signatures, subscribed the same in my presence on the dates above indicated " . 
			"and identified himself or herself to be the individual who signed this sheet. I understand that this " .
			"statement will be accepted for all purposes as the equivalent of an affidavit and, " .
			"if it contains a material false statement, shall subject me to the " . 
			"same penalties as if I had been duly sworn.", 0, 'L', 0);
			
		$this->SetY(-14);
		$this->SetFont('Arial','B',13);
		$this->Cell(0,0,	$this->TodayDateText);
		$this->SetFont('Arial','',8);
		$this->Cell(0,0, "_________________________________________________________", 0, 0, 0);
		
		$this->SetXY(40, -15);
		$this->Cell(40,10, "City", 0, 'L', 0);
		$this->Cell(40,10, "County", 0, 'L', 0);
		
		$this->SetXY(40, -12 );
		$this->SetFont('Arial','B',8);
		$this->Cell(40, 10, $this->City, 0, 'C', 0);
		$this->Cell(40, 10, $this->County, 0, 'C', 0);
		
		$this->SetXY(160, -7 );
		$this->SetFont('Arial','',13);
		$this->Cell(0, 0,	"SHEET No. ______ ");

	}
	
	function Rotate($angle,$x=-1,$y=-1) {
    if($x==-1) $x=$this->x;
    if($y==-1) $y=$this->y;
    if($this->angle!=0) $this->_out('Q');
    $this->angle=$angle;
    if($angle!=0) {
      $angle*=M_PI/180;
      $c=cos($angle);
      $s=sin($angle);
      $cx=$x*$this->k;
      $cy=($this->h-$y)*$this->k;
      $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
    }
  }
    
  function RotatedText($x, $y, $txt, $angle) {
	  //Text rotated around its origin
	  $this->Rotate($angle,$x,$y);
	  $this->Text($x,$y,$txt);
	  $this->Rotate(0);
	}
	
	function _endpage() {
    if($this->angle!=0) {
      $this->angle=0;
      $this->_out('Q');
    }
    parent::_endpage();
	}
	
}

?>