<?php
	class PDF extends FPDF
		{
			public $link;
			public $nav;
			
			function Header()
			{
				if($this->PageNo() == 1){
					$this->link=array(
						1 => $this->AddLink(),
						2 => $this->AddLink(),
						3 => $this->AddLink(),
						4 => $this->AddLink(),
						5 => $this->AddLink(),
						6 => $this->AddLink(),
						7 => $this->AddLink(),
						8 => $this->AddLink(),
						9 => $this->AddLink(),
						10 => $this->AddLink(),
						11 => $this->AddLink(),
						12 => $this->AddLink(),
						13 => $this->AddLink(),
						14 => $this->AddLink()
					);
					$this->nav=array(
						1 => $this->AddLink(),
						2 => $this->AddLink(),
						3 => $this->AddLink(),
						4 => $this->AddLink(),
						5 => $this->AddLink(),
						6 => $this->AddLink(),
						7 => $this->AddLink(),
						8 => $this->AddLink(),
						9 => $this->AddLink(),
						10 => $this->AddLink(),
						11 => $this->AddLink(),
						12 => $this->AddLink(),
						13 => $this->AddLink(),
						14 => $this->AddLink(),
						15 => $this->AddLink()
					);
				}
				$this->Image('image/a4.jpg', 0, 0, 600, 850); 
				// Select Arial bold 15
				$this->SetTextColor(0,100,0);
				$this->SetFont('Arial','B',13);
				$this->Cell(500);
				// Framed title
				$this->setY(20);
				$this->setX(-50);
				if($this->PageNo() != 15){
					$this->Cell(0,1,'Next',0,0,'L',false,$this->nav[($this->PageNo()+1)] );
				}
				$this->setX(270);
				$this->Cell(0,1,'Home',0,0,'L',false,$this->nav[1] );
				$this->setX(20);
				if($this->PageNo() != 1){
					$this->Cell(0,1,'Prev',0,0,'L',false,$this->nav[($this->PageNo()-1)]);
				}
				// Line break
				$this->Ln(20);
			}
			
			function Footer()
			{
				// Go to 1.5 cm from bottom
				$this->SetY(-15);
				$this->setX(-50);
				// Select Arial italic 8
				$this->SetFont('Arial','I',8);		
				$this->SetTextColor(0,100,0);
				// Print centered page number
				$this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
				
				$this->SetFont('Courier','I',12);
				$this->setY(-15);
				$this->setX(10);
				$this->Cell(0,0,"copy right 2013 Fajar Muhammad F");
		
			}
			var $col = 0;

			function SetCol($col)
			{
				// Move position to a column
				$this->col = $col;
				$x = 10+$col*65;
				$this->SetLeftMargin($x);
				$this->SetX($x);
			}

			function AcceptPageBreak()
			{
				if($this->col<2)
				{
					// Go to next column
					//$this->AddPage();
					$this->SetCol($this->col+1);
					$this->SetY(30);
					return false;
				}
				else
				{
					// Go back to first column and issue page break
					//$this->AddPage();
					$this->SetCol(0);
					return true;
				}
			}
			
			var $B;
			var $I;
			var $U;
			var $HREF;

			function PDF($orientation='P', $unit='mm', $size='A4')
			{
				// Call parent constructor
				$this->FPDF($orientation,$unit,$size);
				// Initialization
				$this->B = 0;
				$this->I = 0;
				$this->U = 0;
				$this->HREF = '';
			}

			function WriteHTML($html)
			{
				// HTML parser
				$html = str_replace("\n",' ',$html);
				$a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
				foreach($a as $i=>$e)
				{
					if($i%2==0)
					{
						// Text
						if($this->HREF)
							$this->PutLink($this->HREF,$e);
						else
							$this->Write(5,$e);
					}
					else
					{
						// Tag
						if($e[0]=='/')
							$this->CloseTag(strtoupper(substr($e,1)));
						else
						{
							// Extract attributes
							$a2 = explode(' ',$e);
							$tag = strtoupper(array_shift($a2));
							$attr = array();
							foreach($a2 as $v)
							{
								if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
									$attr[strtoupper($a3[1])] = $a3[2];
							}
							$this->OpenTag($tag,$attr);
						}
					}
				}
			}

			function OpenTag($tag, $attr)
			{
				// Opening tag
				if($tag=='B' || $tag=='I' || $tag=='U')
					$this->SetStyle($tag,true);
				if($tag=='A')
					$this->HREF = $attr['HREF'];
				if($tag=='BR')
					$this->Ln(5);
			}

			function CloseTag($tag)
			{
				// Closing tag
				if($tag=='B' || $tag=='I' || $tag=='U')
					$this->SetStyle($tag,false);
				if($tag=='A')
					$this->HREF = '';
			}

			function SetStyle($tag, $enable)
			{
				// Modify style and select corresponding font
				$this->$tag += ($enable ? 1 : -1);
				$style = '';
				foreach(array('B', 'I', 'U') as $s)
				{
					if($this->$s>0)
						$style .= $s;
				}
				$this->SetFont('',$style);
			}

			function PutLink($URL, $txt)
			{
				// Put a hyperlink
				$this->SetTextColor(0,0,255);
				$this->SetStyle('U',true);
				$this->Write(5,$txt,$URL);
				$this->SetStyle('U',false);
				$this->SetTextColor(0);
			}
			
			// Load data
			function LoadData($file)
			{
				// Read file lines
				$lines = file($file);
				$data = array();
				foreach($lines as $line)
					$data[] = explode(';',trim($line));
				return $data;
			}

			// Simple table
			function BasicTable($header, $data)
			{
				// Header
				foreach($header as $col)
					$this->Cell(40,7,$col,1);
				$this->Ln();
				// Data
				foreach($data as $row)
				{
					foreach($row as $col)
						$this->Cell(40,6,$col,1);
					$this->Ln();
				}
			}

			// Better table
			function ImprovedTable($header, $data)
			{
				// Column widths
				$w = array(40, 35, 40, 45);
				// Header
				for($i=0;$i<count($header);$i++)
					$this->Cell($w[$i],7,$header[$i],1,0,'C');
				$this->Ln();
				// Data
				foreach($data as $row)
				{
					$this->Cell($w[0],6,$row[0],'LR');
					$this->Cell($w[1],6,$row[1],'LR');
					$this->Cell($w[2],6,number_format($row[2]),'LR',0,'R');
					$this->Cell($w[3],6,number_format($row[3]),'LR',0,'R');
					$this->Ln();
				}
				// Closing line
				$this->Cell(array_sum($w),0,'','T');
			}

			// Colored table
			function FancyTable($header, $data)
			{
				
				
				// Colors, line width and bold font
				$this->SetFillColor(139,0,0);
				$this->SetTextColor(255);
				$this->SetDrawColor(128,0,0);
				$this->SetLineWidth(.3);
				$this->SetFont('Courier','B',5);
				// Header
				$w = array();
				for($i=0;$i<count($header);$i++)
				array_push($w,(545/count($header)));
				
				$this->setMargins(20,0,0);
				$this->setY($this->getY());
				for($i=0;$i<count($header);$i++)
					$this->Cell($w[$i],37,$header[$i],1,0,'C',true);
				$this->Ln();
				// Color and font restoration
				$this->SetFillColor(224,235,255);
				$this->SetTextColor(0);
				// Data
				$fill = true;
				$lo=1;
				foreach($data as $row)
				{
					if($lo % 2 ){
						$this->SetFillColor(230,230,250);
					}
					else{
						$this->SetFillColor(224,235,255);
					}
					for($i=0;$i<count($header);$i++)
					{
						if(strlen($row[$i]) > 0){
							if(3*15/strlen($row[$i]) < 20){
								$this->SetFont('Courier','B',8*9/strlen($row[$i]));
							}
							else{
								$this->SetFont('Courier','B',20);	
							}
						}
						else{
							$this->SetFont('Courier','B',5);	
						}
						$this->Cell($w[$i],36,$row[$i],'LR',0,'L',$fill);
					}
					$this->Ln();
					//$fill = !$fill;
					$lo++;
				}
				// Closing line
				$this->Cell(array_sum($w),0,'','T');
			}
			
		}
?>
