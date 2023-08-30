<?php
namespace App\Http\Controllers\Reportes;

use App\Models\Configuracion;
//echo base_path('app');
//require_once base_path('app/library/fpdf/fpdf.php');
require_once base_path('app/Library/fpdf/fpdf.php');

class ReporteHistoriaClinica extends \FPDF {

    public function Header() {
        $this->SetY(15);
        $this->Image('../public/img/'.$this->configuracion->logo, 15, 5, 30,20);
        /*$this->SetFont("Arial", "B", 9);
        $this->Cell(249, 4, utf8_decode($this->configuracion->actividad_economica), 0, 1, 'R');*/
        $this->SetFont("Arial", "B", 9);
        $this->Cell(320, 4, utf8_decode($this->configuracion->razon_social), 0, 1, 'R');

        $this->SetFont("Arial", "B", 15);
        $this->Cell(320, 5, utf8_decode("HISTORIA CLÍNICA"), 0, 1, "C");

        
        $this->Ln(5);

        $this->SetFillColor(215,215,215);
        $this->SetDrawColor(255,255,255);
        $y = $this->GetY();
        $this->SetFont("Arial", "B", 9);
        $this->Cell(10, 8, "NRO", 1, 0, "L", 1);
        $this->Cell(56, 8, "MOTIVO CONSULTA", 1, 0, "C", 1);
        $this->Cell(56, 8, "DOLENCIA ACTUAL", 1, 0, "C", 1);
        $x = $this->GetX() + 56;
        $this->MultiCell(56, 4, utf8_decode("ANTECEDENTES PATOLÓGICOS FAMILIARES"), 1, "C", 1);
        $this->SetXY($x, $y);
        $x = $this->GetX() + 56;
        $this->MultiCell(56, 4, utf8_decode("ANTECEDENTES PATOLÓGICOS PERSONALES"), 1, "C", 1);
        $this->SetXY($x, $y);
        $this->Cell(56, 8, utf8_decode("DIAGNÓSTICO"), 1, 0, "C", 1);
        $this->Cell(30, 8, "FEC. HORA", 1, 1, "C", 1);

        
        
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
        $this->SetRightMargin(5);
        $this->SetAutoPageBreak(1, 20);
        $this->AddPage("L",array(330,216));
        $this->SetTextColor(0, 0, 0);
        $this->AliasNbPages();
        

        
        if(!empty($resultado)) {
            $name = "";
            $id_especialidad = "";
            $name_doctor = "";
            foreach ($resultado as $key => $value) {
                
                $nombres = $value->paterno." ".$value->materno." ".$value->nombre;
                $nombres_doctor = $value->paterno_doctor." ".$value->materno_doctor." ".$value->nombre_doctor;

                if($name != $value->name) {
                    $name = $value->name;
                    
                    $this->SetX($this->GetX()+27);
                    $this->SetTextColor(0,0,255);
                    $this->SetFont("Arial", "", 9);

                    $this->Cell(18, 5, "PACIENTE: ", 0, 0, "L");
                    $this->Cell(18, 5, $value->name, 0, 0, "C");
                    $this->Cell(110, 5, $nombres, 0, 1, "L");
                    $id_especialidad = "";
                    $name_doctor = "";
                }

                if($id_especialidad != $value->id_especialidad) {
                    $id_especialidad = $value->id_especialidad;
                    
                    $this->SetX($this->GetX()+27);
                    $this->SetTextColor(0,0,255);
                    $this->SetFont("Arial", "", 9);

                    $this->Cell(30, 5, "ESPECIALIDAD: ", 0, 0, "L");
                    $this->Cell(263, 5, utf8_decode($value->especialidad), 0, 1, "L");
                }

                if($name_doctor != $value->name_doctor) {
                    $name_doctor = $value->name_doctor;
                    
                    $this->SetX($this->GetX()+27);
                    $this->SetTextColor(0,0,255);
                    $this->SetFont("Arial", "", 9);

                    $this->Cell(18, 5, "DOCTOR: ", 0, 0, "L");
                    $this->Cell(18, 5, $value->name_doctor, 0, 0, "C");
                    $this->Cell(110, 5, $nombres_doctor, 0, 1, "L");
                }

                $this->SetTextColor(0,0,0);

                /*$this->SetX($this->GetX()+27);

                $this->Cell(18, 5, "DOCTOR: ", 0, 0, "C");
                $this->Cell(18, 5, $value->name, 0, 0, "C");
                $this->Cell(110, 5, $nombres, 0, 1, "L");*/

                $this->SetFont("Arial", "", 9);

                $this->SetWidths(array(10,56,56,56,56,56,30));
                $this->SetAligns(array('R','L','L','L','L','L','C'));
                $fila = array(
                    utf8_decode($key+1),    
                    utf8_decode($value->motivo_consulta),
                    utf8_decode($value->dolencia_actual),
                    utf8_decode($value->antecedente_familiar),
                    utf8_decode($value->antecedente_personal),
                    utf8_decode($value->diagnostico),
                    utf8_decode(date("d-m-Y H:i", strtotime($value->fecha_hora))),
                );
                $this->Ln(1);
                $this->Row($fila, 3, 3, 0);
                $this->Ln(1);
                for ($i=$this->GetX(); $i < 324; $i=$i+1.7) { 
                    $this->Line($i, $this->GetY(), $i+1, $this->GetY());
                }
                
            }
        }
        
        $nombre= time()."_historia_clinica".'.pdf';
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

