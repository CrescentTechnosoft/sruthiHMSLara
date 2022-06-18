<?php
namespace App\Libraries\Fpdf\Scripts;

use App\ThirdParty\Fpdf\Fpdf;

class McTable extends Fpdf
{
    public array $widths;
    public array $aligns;

    public function setWidths(array $w):void
    {
        //Set the array of column widths
        $this->widths=$w;
    }

    public function setAligns(array $a):void
    {
        //Set the array of column alignments
        $this->aligns=$a;
    }

    /**
    * Added Height , Rect Parameters additionally
    */

    public function createRow(array $data, int $height = 5, bool $rect = true):void
    {
        //Calculate the height of the row
        $nb=0;
        for ($i=0; $i<count($data); $i++) {
            $nb=max($nb, $this->nbLines($this->widths[$i], $data[$i]));
        }
        $h=$height*$nb;
        //Issue a page break first if needed
        $this->checkPageBreak($h);
        //Draw the cells of the row
        for ($i=0; $i<count($data); $i++) {
            $w=$this->widths[$i];
            $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x=$this->getX();
            $y=$this->getY();
            //Draw the border
            if ($rect) {
                $this->rect($x, $y, $w, $h);
            }
            //Print the text
            $this->multiCell($w, 5, $data[$i], 0, $a);
            //Put the position to the right of the cell
            $this->setXY($x+$w, $y);
        }
        //Go to the next line
        $this->ln($h);
    }

    public function checkPageBreak(int $h):void
    {
        //If the height h would cause an overflow, add a new page immediately
        if ($this->getY()+$h>$this->pageBreakTrigger) {
            $this->addPage($this->curOrientation);
        }
    }

    public function nbLines(int $w, string $txt = null):int
    {
        //Computes the number of lines a MultiCell of width w will take
        $cw=&$this->currentFont['cw'];
        if ($w==0) {
            $w=$this->w-$this->rMargin-$this->x;
        }
        $wmax=($w-2*$this->cMargin)*1000/$this->fontSize;
        $s=str_replace("\r", '', $txt);
        $nb=strlen($s);
        if ($nb>0 and $s[$nb-1]=="\n") {
            $nb--;
        }
        $sep=-1;
        $i=0;
        $j=0;
        $l=0;
        $nl=1;
        while ($i<$nb) {
            $c=$s[$i];
            if ($c=="\n") {
                $i++;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
                continue;
            }
            if ($c==' ') {
                $sep=$i;
            }
            $l+=$cw[$c];
            if ($l>$wmax) {
                if ($sep==-1) {
                    if ($i==$j) {
                        $i++;
                    }
                } else {
                    $i=$sep+1;
                }
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
            } else {
                $i++;
            }
        }
        return $nl;
    }
}
