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
    $this->Cell(0,0, "Rep My Block",0,0,'C');
    $this->Ln(4);
		$this->Cell(0,0, "Voter List Prepared for " . $this->county . ' County',0,0,'C');
    $this->Ln(3);    
     			
  	$MyTop = $YLocation = $this->GetY();

   	$this->SetFont('Arial','B',11);
		$this->SetXY($this->Col3, $YLocation + 0.3 );
		$this->MultiCell($this->SizeCol1, 3.5, $this->Candidate[$i], 0, 'C', 0);
		if ( $YLocation_new < $this->GetY()) { $YLocation_new = $this->GetY(); }

		$this->SetFont('Arial','', 9);   	   		
		$this->SetXY($this->Col3, $YLocation );
		$this->MultiCell($this->SizeCol3, 3.5, $this->Residence[$i], 0, 'C', 0);
		if ( $YLocation_new < $this->GetY()) { $YLocation_new = $this->GetY(); } 	
	}

	// Page footer
	function Footer()	{
		
		$this->SetY(-10);
   	$YLocation = $this->GetY() - 1.9;
		$this->Line($this->Line_Left, $YLocation, $this->Line_Right, $YLocation);
	
		$this->SetFont('Arial','B',8);
		$this->Cell(0,0, "Page", 0, 1, 'C');		
		

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