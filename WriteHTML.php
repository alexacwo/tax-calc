<?php
require('fpdf.php');

class PDF_HTML extends FPDF
{
	
	function printHeader($name)
	{
		$this->Cell(120,10,'POST TO THE ADDRESS BELOW',1);		
		$this->Cell(40,10,'National insurance number',1, 1);
		
		$this->Cell(120);	
		$this->Cell(40,10,'NX435694F',1, 1);	
		
		$this->Cell(120,40,'URGENT - UNIFORM TAX REBATE',1);
		$this->Cell(40,40,'Claim Reference',1, 1);	
		
		
		$this->Ln(2);
		$this->Cell(40,10,'Name of Claimant',0);	
		$this->Cell(120,10, $name, 0);	
		
		$this->Ln();
		
		$this->Cell(40);	
		$x = $this->GetX();
		$y = $this->GetY();
		$this->SetLineWidth(0.4);
		$this->Line($x,$y,$x+100,$y);
		
		$this->Ln(2);
	}
	
	function printFirstTable($job, $occupation, $deduction) {	
		$this->SetFontSize(9);
		$this->Cell(180,8, 'Flat rate expense for laundry / maintenance of protective clothing / tools under EIM32485 or EIM32712 Section 367 ITEPA 2003', 1,1);	
		
		$this->Cell(40,8, 'Industry', 1);	
		$this->Cell(90,8, 'Occupation Type', 1);			
		$this->Cell(50,8, 'Decuction', 1,1);

		$this->Cell(40,8, $job, 1);	
		$this->Cell(90,8, $occupation, 1);			
		$this->Cell(50,8, $deduction, 1,1);			
		
		$this->Ln();		
	}

	var $B=0;
	var $I=0;
	var $U=0;
	var $HREF='';
	var $ALIGN='';

	
	function WriteHTML($html)
	{
		//HTML parser
		$html=str_replace("\n",' ',$html);
		$a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
		foreach($a as $i=>$e)
		{
			if($i%2==0)
			{
				//Text
				if($this->HREF)
					$this->PutLink($this->HREF,$e);
				elseif($this->ALIGN=='center')
					$this->Cell(0,5,$e,0,1,'C');
				else
					$this->Write(5,$e);
			}
			else
			{
				//Tag
				if($e[0]=='/')
					$this->CloseTag(strtoupper(substr($e,1)));
				else
				{
					//Extract properties
					$a2=explode(' ',$e);
					$tag=strtoupper(array_shift($a2));
					$prop=array();
					foreach($a2 as $v)
					{
						if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
							$prop[strtoupper($a3[1])]=$a3[2];
					}
					$this->OpenTag($tag,$prop);
				}
			}
		}
	}

	function OpenTag($tag,$prop)
	{
		//Opening tag
		if($tag=='B' || $tag=='I' || $tag=='U')
			$this->SetStyle($tag,true);
		if($tag=='A')
			$this->HREF=$prop['HREF'];
		if($tag=='BR')
			$this->Ln(5);
		if($tag=='P')
			$this->ALIGN=$prop['ALIGN'];
		if($tag=='HR')
		{
			if( !empty($prop['WIDTH']) )
				$Width = $prop['WIDTH'];
			else
				$Width = $this->w - $this->lMargin-$this->rMargin;
			$this->Ln(2);
			$x = $this->GetX();
			$y = $this->GetY();
			$this->SetLineWidth(0.4);
			$this->Line($x,$y,$x+$Width,$y);
			$this->SetLineWidth(0.2);
			$this->Ln(2);
		}
	}

	function CloseTag($tag)
	{
		//Closing tag
		if($tag=='B' || $tag=='I' || $tag=='U')
			$this->SetStyle($tag,false);
		if($tag=='A')
			$this->HREF='';
		if($tag=='P')
			$this->ALIGN='';
	}

	function SetStyle($tag,$enable)
	{
		//Modify style and select corresponding font
		$this->$tag+=($enable ? 1 : -1);
		$style='';
		foreach(array('B','I','U') as $s)
			if($this->$s>0)
				$style.=$s;
		$this->SetFont('',$style);
	}

	function PutLink($URL,$txt)
	{
		//Put a hyperlink
		$this->SetTextColor(0,0,255);
		$this->SetStyle('U',true);
		$this->Write(5,$txt,$URL);
		$this->SetStyle('U',false);
		$this->SetTextColor(0);
	}
	
	// Simple table
	function TwoCellTable ($leftColumn, $rightColumn)
	{
		$this->Cell(90,40,$leftColumn,1);
		$this->Cell(90,40,$rightColumn,1);
		$this->Ln();
	}

}
?>
