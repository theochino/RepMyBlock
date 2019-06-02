<?php
require($_SERVER["DOCUMENT_ROOT"] . '/../libs/utils/fpdf181/fpdf.php');

class PDF extends FPDF {
	
	var $angle=0;
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
    
    $this->SetFont('Arial','B',8);
    $this->Cell(63,0, "NAME" . strtoupper($this->PluralCandidates) . " OF CANDIDATE" . 
    									strtoupper($this->PluralCandidates),0, 0, 'C');
   	$this->Cell(70,0, $this->RunningForHeading, 0, 0, 'C');
    $this->Cell(0,0, "PLACE" . strtoupper($this->PluralCandidates) . " OF RESIDENCE", 0, 1, 'C');
    $this->SetFont('Arial','',8);
    
    $this->Ln(1);   
    $Top_Corner_Y = $this->GetY() - 3;
       
    for ($i = 0; $i < $this->NumberOfCandidates; $i++) {
    	$YLocation = $this->GetY() + 1.2;
    	
    	$this->SetFont('Arial','B',10);
			$this->MultiCell(61, 2.8, "\n  " . $this->Candidate[0], 0, 'L', 0);
			$this->SetFont('Arial','', 8);
			$this->SetXY(70, $YLocation );
   		$this->MultiCell(69, 2.8, $this->RunningFor[0], 0, 'L', 0);
			$this->SetXY(140, $YLocation );
   		$this->MultiCell(62, 2.8, $this->Residence[0], 0, 'L', 0);
   		
   		if ( $i < $this->NumberOfCandidates ) {
   			 $this->Line(5, $YLocation - 0.3, 212, $YLocation - 0.3);
   		}

   		$this->SetY($YLocation + 10.2);
  	}
   
    $Botton_Corner_Y = $this->GetY();
    
    $this->Rect(5, $Top_Corner_Y, 207, ($Botton_Corner_Y - $Top_Corner_Y) + 1, 1);
    $this->Line(70, $Top_Corner_Y, 70, $Botton_Corner_Y + 1);
    $this->Line(140, $Top_Corner_Y, 140, $Botton_Corner_Y + 1);
    $this->Ln(1.5);
      	
   	$this->SetFont('Arial','',6);
    $this->MultiCell(0, 2, 
    	"I do hereby appoint " . $this->Appointments . " all of whom are enrolled voters of the " . $this->party . 
    	" Party, as a committee to fill vacancies in accordance with the provisions of the Election Law.");
   	$this->Ln(1.5);
   	 
   	$this->SetX(5);
   	$this->SetFont('Arial','B',8);
    $this->Cell(0, 0, "In witness whereof, I have hereunto set my hand, the day and year placed opposite my signature.");
    
    $this->Ln(1);
    
    $this->SetFont('Arial','B',13);
		$this->Cell(35, 8, "Date" ,0, 0, 'C', 0);
		$this->Cell(75, 8, "Signature / Name of Signer", 0, 0, 'C', 0);
		$this->Cell(83, 8, "Residence", 0, 0, 'C', 0);
		$this->Cell(12, 8, "County", 0, 1, 'C', 0);
		$this->Ln(4.5);
   
   	
    $Botton_Corner_Y += 9.1;
		
		$this->Line(5, $Botton_Corner_Y, 212.5, $Botton_Corner_Y - 0.3);
		$this->Line(5,	 $Botton_Corner_Y + 6.1, 212.5, $Botton_Corner_Y + 6.1);

 		$this->Line(5,   $Botton_Corner_Y, 5,   $this->BottonPt);
 		$this->Line(40,  $Botton_Corner_Y, 40,  $this->BottonPt);
 		$this->Line(120, $Botton_Corner_Y, 120, $this->BottonPt);
 		$this->Line(195, $Botton_Corner_Y, 195, $this->BottonPt);
 		$this->Line(212.5, $Botton_Corner_Y, 212.5, $this->BottonPt);
 		 
	}

	// Page footer
	function Footer()	{
		$this->SetY(-40);

		$this->SetFont('Arial','B',8);
		$this->Cell(0,0, "STATEMENT OF WITNESS", 0, 1, 'C');		
		$this->SetFont('Arial','',8);
		$this->Ln(1);
		$this->MultiCell(0, 2.8, 
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
		$this->Cell(40, 10, $this->City, 0, 'L', 0);
		$this->Cell(40, 10, $this->County, 0, 'L', 0);
		
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