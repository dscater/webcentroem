<?php

namespace App\Http\Controllers\Reportes;

use App\Models\Configuracion;
use App\Helpers\FuncionesComunes;
//echo base_path('app');
//require_once base_path('app/library/fpdf/fpdf.php');
require_once base_path('app/Library/fpdf/fpdf.php');

class ReporteFactura extends \FPDF
{
    public function Header()
    {



        $this->SetY(10);




        $this->SetFont("Arial", "", 9);
        $this->MultiCell(67, 4, utf8_decode($this->configuracion->razon_social), 0, 'C');
        $this->SetFont("Arial", "", 9);
        $this->MultiCell(67, 4, utf8_decode($this->configuracion->direccion), 0, 'C');
        $this->Cell(67, 4, utf8_decode("TELF. " . $this->configuracion->telefono . " - " . $this->configuracion->celular), 0, 1, "C");
        $this->Cell(67, 4, utf8_decode($this->configuracion->ciudad . " - BOLIVIA"), 0, 1, "C");

        $this->Ln(2);

        $this->SetFont("Arial", "", 9);
        if ($this->factura->tipo_paciente == 'PACIENTE PARTICULAR') {
            $this->Cell(67, 5, "FACTURA", 0, 1, "C");
        } else {
            $this->Cell(67, 5, "COMPROBANTE", 0, 1, "C");
        }

        $this->Ln(2);

        for ($i = $this->GetX(); $i < 72; $i = $i + 1.7) {
            $this->Line($i, $this->GetY(), $i + 1, $this->GetY());
        }

        $this->Ln(2);

        $this->SetFont("Arial", "", 9);
        $this->Cell(67, 4, utf8_decode("NIT: " . $this->configuracion->nit), 0, 1, "C");
        $this->Cell(67, 4, utf8_decode("No FACTURA: " . FuncionesComunes::serearNumero(5, $this->factura->nro_factura)), 0, 1, "C");
        $this->Cell(67, 4, utf8_decode("No AUTORIZACIÓN: " . $this->factura->numero_autorizacion), 0, 1, "C");

        $this->Ln(2);

        for ($i = $this->GetX(); $i < 72; $i = $i + 1.7) {
            $this->Line($i, $this->GetY(), $i + 1, $this->GetY());
        }

        $this->Ln(2);

        $this->MultiCell(67, 4, utf8_decode($this->configuracion->actividad_economica), 0, 'C');

        $this->Cell(40, 4, utf8_decode("Fecha: " . date("d/m/Y", strtotime($this->factura->fecha_factura))), 0, 0, "L");
        $this->Cell(27, 4, utf8_decode("Hora: " . date("H:i", strtotime($this->factura->created_at))), 0, 1, "R");
        $this->Cell(67, 4, utf8_decode("NIT/CI: " . $this->factura->paciente_ci), 0, 1, "L");
        $this->Cell(67, 4, utf8_decode("Señor(es): " . $this->factura->paciente_nombre), 0, 1, "L");

        $this->Ln(2);
        for ($i = $this->GetX(); $i < 72; $i = $i + 1.7) {
            $this->Line($i, $this->GetY(), $i + 1, $this->GetY());
        }
        $this->Ln(2);
    }

    public function Footer()
    {
    }

    public function reporte($data)
    {
        $this->configuracion = Configuracion::find(1);
        $this->factura = $data->factura;

        //$resultado = $data->resultado;

        //$configuracion = Configuracion::find(1);

        $this->SetTopMargin(10);
        $this->SetLeftMargin(5);
        $this->SetRightMargin(5);
        $this->SetAutoPageBreak(1, 20);
        $this->AddPage("P", array(77, 279));
        $this->SetTextColor(0, 0, 0);
        $this->AliasNbPages();


        $total = 0;


        $this->Ln(1);


        $this->MultiCell(67, 4, utf8_decode("POR CONCEPTO: " . $this->factura->concepto), 0,  "L");
        $this->Ln(1);
        for ($i = $this->GetX(); $i < 72; $i = $i + 1.7) {
            $this->Line($i, $this->GetY(), $i + 1, $this->GetY());
        }
        $this->Ln(1);
        $this->Cell(67, 4, utf8_decode("MONTO: Bs. " . number_format($this->factura->monto, 2, ",", "")), 0, 1, "L");
        $this->Ln(1);
        for ($i = $this->GetX(); $i < 72; $i = $i + 1.7) {
            $this->Line($i, $this->GetY(), $i + 1, $this->GetY());
        }

        $this->Ln(2);



        $f = new FuncionesComunes();
        $monto = ucwords(strtolower($f->convertir(number_format($this->factura->monto, 2, ".", ""), $moneda = "Bolivianos")));
        $this->MultiCell(67, 4, utf8_decode("SON: " . $monto), 0, "L");

        for ($i = $this->GetX(); $i < 72; $i = $i + 1.7) {
            $this->Line($i, $this->GetY(), $i + 1, $this->GetY());
        }

        $this->Ln(2);



        $qr = "1548642781_7554593.png";

        $this->Ln(2);
        $this->Cell(67, 4, utf8_decode("CODIGO DE CONTROL: " . $this->factura->codigo_control), 0, 1, "L");
        $this->Cell(67, 4, utf8_decode("FECHA LIMITE EMISIÓN: " . date("d/m/Y", strtotime($this->factura->fecha_limite_emision))), 0, 1, "L");
        $this->Image(storage_path("app/public/qrcodes/" . $qr), (77 - 25) / 2, $this->GetY() + 5, 25, 25);
        $this->Ln(35);
        $this->MultiCell(67, 4, utf8_decode($this->configuracion->leyenda_factura), 0, "C");


        //$nombre= time()."_factura_".$resultado->id.'.pdf';
        $nombre = time() . "_factura_" . '.pdf';
        $this->Output($nombre, 'I');
        die;
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


    function Row($data, $alto_celda, $interlineado, $rectagulo)
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
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'C';

            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            if ($rectagulo) {
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
        if ($this->GetY() + $h > $this->PageBreakTrigger) {
            //$this->AddPage($this->CurOrientation);
            /*$this->SetTopMargin(5);
            $this->SetLeftMargin(18);
            $this->SetRightMargin(5);*/

            $this->SetAutoPageBreak(1, 25);
            $this->AddPage("P", array(77, 279));
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
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }

    function numtoletras($xcifra)
    {
        $xarray = array(
            0 => "Cero",
            1 => "UNO", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",
            "DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",
            "VEINTI", 30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA",
            100 => "CIEN", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"
        );

        $xcifra = trim($xcifra);
        $xlength = strlen($xcifra);
        $xpos_punto = strpos($xcifra, ".");
        $xaux_int = $xcifra;
        $xdecimales = "00";
        if (!($xpos_punto === false)) {
            if ($xpos_punto == 0) {
                $xcifra = "0" . $xcifra;
                $xpos_punto = strpos($xcifra, ".");
            }
            $xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
            $xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2); // obtengo los valores decimales
        }

        $XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
        $xcadena = "";
        for ($xz = 0; $xz < 3; $xz++) {
            $xaux = substr($XAUX, $xz * 6, 6);
            $xi = 0;
            $xlimite = 6; // inicializo el contador de centenas xi y establezco el lÃ­mite a 6 dÃ­gitos en la parte entera
            $xexit = true; // bandera para controlar el ciclo del While
            while ($xexit) {
                if ($xi == $xlimite) { // si ya llegÃ³ al lÃ­mite mÃ¡ximo de enteros
                    break; // termina el ciclo
                }

                $x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
                $xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dÃ­gitos)
                for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
                    switch ($xy) {
                        case 1: // checa las centenas
                            if (substr($xaux, 0, 3) < 100) { // si el grupo de tres dÃ­gitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas

                            } else {
                                $key = (int) substr($xaux, 0, 3);
                                if (TRUE === array_key_exists($key, $xarray)) {  // busco si la centena es nÃºmero redondo (100, 200, 300, 400, etc..)
                                    $xseek = $xarray[$key];
                                    $xsub = $this->subfijo($xaux); // devuelve el subfijo correspondiente (MillÃ³n, Millones, Mil o nada)
                                    if (substr($xaux, 0, 3) == 100)
                                        $xcadena = " " . $xcadena . " CIEN " . $xsub;
                                    else
                                        $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                    $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
                                } else { // entra aquÃ­ si la centena no fue numero redondo (101, 253, 120, 980, etc.)
                                    $key = (int) substr($xaux, 0, 1) * 100;
                                    $xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
                                    $xcadena = " " . $xcadena . " " . $xseek;
                                } // ENDIF ($xseek)
                            } // ENDIF (substr($xaux, 0, 3) < 100)
                            break;
                        case 2: // checa las decenas (con la misma lÃ³gica que las centenas)
                            if (substr($xaux, 1, 2) < 10) {
                            } else {
                                $key = (int) substr($xaux, 1, 2);
                                if (TRUE === array_key_exists($key, $xarray)) {
                                    $xseek = $xarray[$key];
                                    $xsub = $this->subfijo($xaux);
                                    if (substr($xaux, 1, 2) == 20)
                                        $xcadena = " " . $xcadena . " VEINTE " . $xsub;
                                    else
                                        $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                    $xy = 3;
                                } else {
                                    $key = (int) substr($xaux, 1, 1) * 10;
                                    $xseek = $xarray[$key];
                                    if (20 == substr($xaux, 1, 1) * 10)
                                        $xcadena = " " . $xcadena . " " . $xseek;
                                    else
                                        $xcadena = " " . $xcadena . " " . $xseek . " Y ";
                                } // ENDIF ($xseek)
                            } // ENDIF (substr($xaux, 1, 2) < 10)
                            break;
                        case 3: // checa las unidades
                            if (substr($xaux, 2, 1) < 1) { // si la unidad es cero, ya no hace nada

                            } else {
                                $key = (int) substr($xaux, 2, 1);
                                $xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)
                                $xsub = $this->subfijo($xaux);
                                $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                            } // ENDIF (substr($xaux, 2, 1) < 1)
                            break;
                    } // END SWITCH
                } // END FOR
                $xi = $xi + 3;
            } // ENDDO

            if (substr(trim($xcadena), -5, 5) == "ILLON") // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
                $xcadena .= " DE";

            if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
                $xcadena .= " DE";

            // ----------- esta lÃ­nea la puedes cambiar de acuerdo a tus necesidades o a tu paÃ­s -------
            if (trim($xaux) != "") {
                switch ($xz) {
                    case 0:
                        if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                            $xcadena .= "UN BILLON ";
                        else
                            $xcadena .= " BILLONES ";
                        break;
                    case 1:
                        if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                            $xcadena .= "UN MILLON ";
                        else
                            $xcadena .= " MILLONES ";
                        break;
                    case 2:
                        if ($xcifra < 1) {
                            $xcadena = "";
                        }
                        if ($xcifra >= 1 && $xcifra < 2) {
                            $xcadena = "";
                        }
                        if ($xcifra >= 2) {
                            $xcadena .= ""; //
                        }
                        break;
                } // endswitch ($xz)
            } // ENDIF (trim($xaux) != "")
            // ------------------      en este caso, para MÃ©xico se usa esta leyenda     ----------------
            $xcadena = str_replace("VEINTI ", "VEINTI", $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
            $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
            $xcadena = str_replace("UN UN", "UN", $xcadena); // quito la duplicidad
            $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
            $xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena); // corrigo la leyenda
            $xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); // corrigo la leyenda
            $xcadena = str_replace("DE UN", "UN", $xcadena); // corrigo la leyenda
        } // ENDFOR ($xz)
        return trim($xcadena);
    }
    function subfijo($xx)
    { // esta funciÃ³n regresa un subfijo para la cifra
        $xx = trim($xx);
        $xstrlen = strlen($xx);
        if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
            $xsub = "";
        //
        if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
            $xsub = "MIL";
        //
        return $xsub;
    }
}
