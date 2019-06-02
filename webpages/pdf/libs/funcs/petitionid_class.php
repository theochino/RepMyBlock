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
		
    $this->SetFont('Arial','B',10);
 		
    
    $this->MultiCell(0,4, "Candidate Records Unit");
    $this->MultiCell(0,4, "New York City\nBoard of Elections\n32 Broadway 7th Floor\nNew York, NY 10004");
    
    $this->MultiCell(0,4, "Petition-Pre Assigned Identification Number Application");
    $this->MultiCell(0,4, "PLEASE FILL OUT ENTIRE FORM");
    
    $this->MultiCell(0,4, "EVENT");
    $this->MultiCell(0,4, "Name of Party or Independent Body");
    
    $this->MultiCell(0,4, "Petition Type:");
    $this->MultiCell(0,4, "Designating");
    $this->MultiCell(0,4, "Independent Nominating");
    $this->MultiCell(0,4, "Opportunity to Ballot");
    
    $this->MultiCell(0,4, "Date of Event:");
    $this->MultiCell(0,4, "Quantity");
    $this->MultiCell(0,4, "Bronx");
    $this->MultiCell(0,4, "New York");
    $this->MultiCell(0,4, "Kings");
    $this->MultiCell(0,4, "Queens");
    $this->MultiCell(0,4, "Richmond");
    $this->MultiCell(0,4, "Total");
    
    $this->MultiCell(0,4, "Applicant");
    $this->MultiCell(0,4, "Name:");
    $this->MultiCell(0,4, "Address:");
    $this->MultiCell(0,4, "Representing");
    $this->MultiCell(0,4, "Applicant Signature");
    
    $this->MultiCell(0,4, "Check here if petition is filed without a Petition ID Sticker");
    $this->MultiCell(0,4, "Prorcessed by");
    $this->MultiCell(0,4, "Pre Assigned Identification Numbers");
 
    
    
    
    
   
	}

	// Page footer
	function Footer()	{
		
		$this->SetY(-37);
   	$YLocation = $this->GetY() - 1.9;
   	$this->SetFont('Arial','B',11);
		$this->MultiCell(0,4, "Pursant to NYC Board of Elections Petition Rules: A pre assigned petition volume indentification" .
											    	"number shall be used only be the candidate or application named in the application. Petition" .
												   	"volume identification numbers are not transferable or assignable");

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