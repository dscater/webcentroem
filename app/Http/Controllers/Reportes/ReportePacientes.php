<?php
namespace App\Http\Controllers\Reportes;

use App\Models\Configuracion;
//echo base_path('app');
//require_once base_path('app/library/fpdf/fpdf.php');
require_once base_path('app/Library/fpdf/fpdf.php');

class ReportePacientes extends \FPDF {

    public function Header() {
        $this->SetY(15);
        $this->Image('../public/img/'.$this->configuracion->logo, 15, 5, 30,20);
        /*$this->SetFont("Arial", "B", 9);
        $this->Cell(249, 4, utf8_decode($this->configuracion->actividad_economica), 0, 1, 'R');*/
        $this->SetFont("Arial", "B", 9);
        $this->Cell(300, 4, utf8_decode($this->configuracion->razon_social), 0, 1, 'R');

        $this->SetFont("Arial", "B", 15);
        $this->Cell(300, 5, "LISTA DE PACIENTES", 0, 1, "C");


        $this->Ln(5);

        $this->SetFillColor(215,215,215);
        $this->SetDrawColor(255,255,255);

        $this->SetFont("Arial", "B", 9);
        $this->Cell(10, 5, "Nro", 1, 0, "L", 1);
        $this->Cell(20, 5, "Usuario", 1, 0, "C", 1);
        $this->Cell(40, 5, "Nombre completo", 1, 0, "C", 1);
        $this->Cell(40, 5, "Lugar Nac.", 1, 0, "C", 1);
        
        $this->Cell(20, 5, utf8_decode("Fec. Nac"), 1, 0, "C", 1);
        $this->Cell(10, 5, "Edad", 1, 0, "C", 1);
        $this->Cell(15, 5, "Sexo", 1, 0, "C", 1);
        $this->Cell(20, 5, "Estado civil", 1, 0, "C", 1);
        $this->Cell(40, 5, "Especialidad", 1, 0, "C", 1);
        $this->Cell(33, 5, "Familiar", 1, 0, "C", 1);
        $this->Cell(20, 5, utf8_decode("Teléfono"), 1, 0, "C", 1);
        $this->Cell(30, 5, "Email", 1, 0, "C", 1);
        $this->Cell(20, 5, "FEC. REG.", 1, 1, "C", 1);
        
    }

    public function Footer() {
        $this->SetY(-15);
        
        $this->SetTextColor(0,0,0);

        
        $this->SetFont("Arial","",8);
        $this->Cell(100, 3, utf8_decode("Fecha de imprensión: ".date("d/m/Y H:i:s A")), 0, 0, 'L');
        $this->Cell(149,3, utf8_decode('Página ') . trim($this->PageNo() . ' de {nb}'), 0, 1, 'R');
        
    }

    public function reporte($data)
    {        
        
        $this->configuracion = Configuracion::find(1);
        $resultado = $data->resultado;
        
        $configuracion = Configuracion::find(1);

        $this->SetTopMargin(10);
        $this->SetLeftMargin(5);
        $this->SetRightMargin(15);
        $this->SetAutoPageBreak(1, 20);
        $this->AddPage("L",array(330,216));
        $this->SetTextColor(0, 0, 0);
        $this->AliasNbPages();
        
        foreach ($resultado as $key => $value) {
            $this->SetFont("Arial", "", 7.5);
            $nombres = $value->paterno." ".$value->materno." ".$value->nombre;

            $this->SetWidths(array(10,20,40,40,20,10,15,20,40,33,20,30,20));
            $this->SetAligns(array('R','L','L','R','C','J','C','R','R','R','R'));
            $fila = array(
                utf8_decode($key+1),    
                utf8_decode($value->name),
                utf8_decode($nombres),
                //utf8_decode($value->ci),
                utf8_decode($value->lugar_nacimiento),
                utf8_decode(date("d/m/Y",strtotime($value->fecha_nacimiento))),
                utf8_decode($value->edad),
                utf8_decode($value->genero),
                utf8_decode($value->estado_civil),
                utf8_decode($value->especialidad),
                utf8_decode($value->familiar_responsable),
                utf8_decode($value->telefono),
                utf8_decode($value->email),
                utf8_decode(date("d-m-Y", strtotime($value->updated_at))),
                
            );
            $this->Ln(1);
            $this->Row($fila, 3, 3, 0);
            $this->Ln(1);
            for ($i=$this->GetX(); $i < 317; $i=$i+1.7) { 
                $this->Line($i, $this->GetY(), $i+1, $this->GetY());
            }
            
        }
        
        $nombre= time()."_usuarios".'.pdf';
        if($data->tipo == "I")
          $this->Output($nombre, 'I');
        else if($data->tipo == "D")
          $this->Output($nombre, 'D');
        exit;//$this->Output();
        
    }

    var $widths;
    var $aligns;

    function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns = $a;
    }


    function Row($data, $alto_celda, $interlineado,$rectagulo)
    {
        //Calculate the height of the row
        $nb = 1;

        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        // $alto_celda=3;//// alto de las celdas
        $h = $alto_celda * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);

        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++)
        {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'C';
            
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            if($rectagulo)
            {
                $this->Rect($x, $y, $w, $h);    
            }
            
            //Print the text
            //$interlineado=3; // interlineado 
            $this->MultiCell($w, $interlineado, $data[$i], 0, $a);
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h)
    {
        //If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger)
        {
            //$this->AddPage($this->CurOrientation);
            /*$this->SetTopMargin(5);
            $this->SetLeftMargin(18);
            $this->SetRightMargin(5);*/

            $this->SetAutoPageBreak(1, 25);
            $this->AddPage('L',array(330,216));
        }
    }

    function NbLines($w, $txt)
    {
        //Computes the number of lines a MultiCell of width w will take
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb)
        {
            $c = $s[$i];
            if ($c == "\n")
            {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l+=$cw[$c];
            if ($l > $wmax)
            {
                if ($sep == -1)
                {
                    if ($i == $j)
                        $i++;
                }
                else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }
}

