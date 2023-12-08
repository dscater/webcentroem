<?php

namespace App\Http\Controllers\Reportes;

use App\Models\Configuracion;
use App\Helpers\FuncionesComunes;
//echo base_path('app');
//require_once base_path('app/library/fpdf/fpdf.php');
require_once base_path('app/Library/fpdf/fpdf.php');

class ReporteFacturas extends \FPDF
{

    var $angle = 0;

    public function Header()
    {
        $this->SetY(15);
        $this->Image('../public/img/' . $this->configuracion->logo, 8, 10, 30, 20);
        /*$this->SetFont("Arial", "B", 9);
        $this->Cell(249, 4, utf8_decode($this->configuracion->actividad_economica), 0, 1, 'R');*/
        $this->SetFont("Arial", "B", 9);
        $this->Cell(200, 4, utf8_decode($this->configuracion->razon_social), 0, 1, 'R');
        $this->Ln(3);
        $this->SetFont("Arial", "B", 15);
        $this->Cell(200, 5, utf8_decode("REPORTE DE PAGOS"), 0, 1, "C");


        $this->Ln(10);

        $this->SetFillColor(215, 215, 215);
        $this->SetDrawColor(255, 255, 255);

        $this->SetFont("Arial", "B", 9);
        $this->Cell(17, 5, utf8_decode("Código"), 1, 0, "L", 1);
        $this->Cell(20, 5, "Nro. Factura", 1, 0, "L", 1);
        $this->Cell(20, 5, "Fecha", 1, 0, "C", 1);
        $this->Cell(25, 5, "CI/NIT", 1, 0, "C", 1);
        $this->Cell(80, 5, "Paciente", 1, 0, "L", 1);
        $this->Cell(38, 5, "Monto", 1, 1, "C", 1);
    }

    public function Footer()
    {
        $this->SetY(-15);

        $this->SetTextColor(0, 0, 0);


        $this->SetFont("Arial", "", 8);
        $this->Cell(100, 3, utf8_decode("Fecha de imprensión: " . date("d/m/Y H:i:s A")), 0, 0, 'L');
        $this->Cell(100, 3, utf8_decode('Página ') . trim($this->PageNo() . ' de {nb}'), 0, 1, 'R');
    }

    public function reporte($data)
    {

        $this->configuracion = Configuracion::find(1);
        $resultado = $data->resultado;

        //$configuracion = Configuracion::find(1);

        $this->SetTopMargin(10);
        $this->SetLeftMargin(8);
        $this->SetRightMargin(8);
        $this->SetAutoPageBreak(1, 20);
        $this->AddPage("P", array(216, 279));
        $this->SetTextColor(0, 0, 0);
        $this->AliasNbPages();




        $especialidad = "";

        $total = 0;

        if (!empty($resultado)) {
            foreach ($resultado as $key => $value) {

                if ($especialidad != $value->especialidad) {
                    $especialidad = $value->especialidad;

                    $this->SetFont("Arial", "", 9);

                    $this->SetX($this->GetX() + 20);
                    $this->Cell(25, 5, "Especialidad: ", 0, 0, "L");
                    $this->SetFont("Arial", "B", 9);
                    $this->Cell(160, 5, utf8_decode($especialidad), 0, 1, "L");
                }

                $this->SetFont("Arial", "", 7.5);

                $this->SetWidths(array(17, 20, 20, 25, 80, 38));
                $this->SetAligns(array('L', 'R', 'C', 'R', 'L', "R"));
                $fila = array(
                    utf8_decode($value->id),
                    utf8_decode(FuncionesComunes::serearNumero(8, $value->nro_factura)),
                    utf8_decode(date("d-m-Y", strtotime($value->fecha_factura))),
                    utf8_decode($value->paciente_ci),
                    utf8_decode($value->paciente_nombre . ($value->tipo_paciente == 'PACIENTE ASEGURADO' ? ($value->institucion != '' ? ' - "' . $value->institucion . '"' : '') : '')),
                    utf8_decode($value->monto_total),
                );
                $this->Ln(1);
                $this->Row($fila, 3, 3, 0);
                $this->Ln(1);
                $this->SetX($this->GetX());
                $this->Cell(25, 5, "Concepto: ", 0, 0, "L");
                $this->MultiCell(175, 5, utf8_decode($value->concepto), 0, "L");
                $this->Ln(1);
                for ($i = $this->GetX(); $i < 208; $i = $i + 1.7) {
                    $this->Line($i, $this->GetY(), $i + 1, $this->GetY());
                }
                $total += (float)$value->monto_total;
            }
        }
        $this->SetFont("Arial", "B", 10);
        $this->Ln(4);
        $fila = array(
            utf8_decode(""),
            utf8_decode(""),
            utf8_decode(""),
            utf8_decode(""),
            utf8_decode("TOTAL"),
            utf8_decode(number_format($total, 2, ".", "")),
        );
        $this->Row($fila, 3, 3, 0);


        $nombre = time() . "_pagos" . '.pdf';
        if ($data->tipo == "I")
            $this->Output($nombre, 'I');
        else if ($data->tipo == "D")
            $this->Output($nombre, 'D');
        exit; //$this->Output();

    }

    function SetFontSize($size)
    {
        // Set font size in points
        if ($this->FontSizePt == $size)
            return;
        $this->FontSizePt = $size;
        $this->FontSize = $size / $this->k;
        if ($this->page > 0)
            $this->_out(sprintf('BT /F%d %.2F Tf ET', $this->CurrentFont['i'], $this->FontSizePt));
    }
    function AjustaCelda($ancho, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '', $scale = false, $force = true)
    {
        $TamanoInicial = $this->FontSizePt;
        $TamanoLetra = $this->FontSizePt;
        $Decremento = 0.8;
        while ($this->GetStringWidth($txt) > $ancho)
            $this->SetFontSize($TamanoLetra -= $Decremento);
        $this->Cell($ancho, $h, $txt, $border, $ln, $align, $fill, $link, $scale, $force);
        $this->SetFontSize($TamanoInicial);
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

    // END FUNCTION

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
    function fecha_literal($Fecha, $Formato = 4)
    {
        $dias = array(0 => 'Domingo', 1 => 'Lunes', 2 => 'Martes', 3 => 'MiÃ¨rcoles', 4 => 'Jueves', 5 => 'Viernes', 6 => 'SÃ bado');
        $meses = array(
            1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril', 5 => 'mayo', 6 => 'junio',
            7 => 'julio', 8 => 'agosto', 9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre'
        );
        $aux = date_parse($Fecha);
        switch ($Formato) {
            case 1:  // 04/10/10
                return date('d/m/y', strtotime($Fecha));
            case 2:  //04/oct/10
                return sprintf('%02d/%s/%02d', $aux['day'], substr($meses[$aux['month']], 0, 3), $aux['year'] % 100);
            case 3:   //octubre 4, 2010
                return $meses[$aux['month']] . ' ' . sprintf('%.2d', $aux['day']) . ', ' . $aux['year'];
            case 4:   // 4 de octubre de 2010
                return $aux['day'] . ' de ' . $meses[$aux['month']] . ' de ' . $aux['year'];
            case 5:   //lunes 4 de octubre de 2010
                $numeroDia = date('w', strtotime($Fecha));
                return $dias[$numeroDia] . ' ' . $aux['day'] . ' de ' . $meses[$aux['month']] . ' de ' . $aux['year'];
            case 6:
                return date('d/m/Y', strtotime($Fecha));
            default:
                return date('d/m/Y', strtotime($Fecha));
        }
    }


    //  TABULACION DE TEXTO //////////////////////////////////////


    public function getAlto($description, $column_width)
    {
        $total_string_width = $this->GetStringWidth($description);
        $number_of_lines = $total_string_width / ($column_width - 1);
        $number_of_lines = ceil($number_of_lines);  // Round it up.
        $line_height = 5;                             // Whatever your line height is.

        $height_of_cell = $number_of_lines * $line_height;

        $height_of_cell = ceil($height_of_cell);    // Round it up.
        return $height_of_cell;
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
            $this->AddPage("P", array(216, 279));
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

    //  TABULACION DE TEXTO //////////////////////////////////////

    // rectangulo con curvas
    function RoundedRect($x, $y, $w, $h, $r, $style = '', $angle = '1234')
    {
        $k = $this->k;
        $hp = $this->h;
        if ($style == 'F')
            $op = 'f';
        elseif ($style == 'FD' or $style == 'DF')
            $op = 'B';
        else
            $op = 'S';
        $MyArc = 4 / 3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2f %.2f m', ($x + $r) * $k, ($hp - $y) * $k));

        $xc = $x + $w - $r;
        $yc = $y + $r;
        $this->_out(sprintf('%.2f %.2f l', $xc * $k, ($hp - $y) * $k));
        if (strpos($angle, '2') === false)
            $this->_out(sprintf('%.2f %.2f l', ($x + $w) * $k, ($hp - $y) * $k));
        else
            $this->_Arc($xc + $r * $MyArc, $yc - $r, $xc + $r, $yc - $r * $MyArc, $xc + $r, $yc);

        $xc = $x + $w - $r;
        $yc = $y + $h - $r;
        $this->_out(sprintf('%.2f %.2f l', ($x + $w) * $k, ($hp - $yc) * $k));
        if (strpos($angle, '3') === false)
            $this->_out(sprintf('%.2f %.2f l', ($x + $w) * $k, ($hp - ($y + $h)) * $k));
        else
            $this->_Arc($xc + $r, $yc + $r * $MyArc, $xc + $r * $MyArc, $yc + $r, $xc, $yc + $r);

        $xc = $x + $r;
        $yc = $y + $h - $r;
        $this->_out(sprintf('%.2f %.2f l', $xc * $k, ($hp - ($y + $h)) * $k));
        if (strpos($angle, '4') === false)
            $this->_out(sprintf('%.2f %.2f l', ($x) * $k, ($hp - ($y + $h)) * $k));
        else
            $this->_Arc($xc - $r * $MyArc, $yc + $r, $xc - $r, $yc + $r * $MyArc, $xc - $r, $yc);

        $xc = $x + $r;
        $yc = $y + $r;
        $this->_out(sprintf('%.2f %.2f l', ($x) * $k, ($hp - $yc) * $k));
        if (strpos($angle, '1') === false) {
            $this->_out(sprintf('%.2f %.2f l', ($x) * $k, ($hp - $y) * $k));
            $this->_out(sprintf('%.2f %.2f l', ($x + $r) * $k, ($hp - $y) * $k));
        } else
            $this->_Arc($xc - $r, $yc - $r * $MyArc, $xc - $r * $MyArc, $yc - $r, $xc, $yc - $r);
        $this->_out($op);
    }

    function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
    {
        $h = $this->h;
        $this->_out(sprintf(
            '%.2f %.2f %.2f %.2f %.2f %.2f c ',
            $x1 * $this->k,
            ($h - $y1) * $this->k,
            $x2 * $this->k,
            ($h - $y2) * $this->k,
            $x3 * $this->k,
            ($h - $y3) * $this->k
        ));
    }
    function Rotate($angle, $x = -1, $y = -1)
    {
        if ($x == -1)
            $x = $this->x;

        if ($y == -1)
            $y = $this->y;
        if ($this->angle != 0)
            $this->_out('Q');
        $this->angle = $angle;
        if ($angle != 0) {
            $angle *= M_PI / 180;
            $c = cos($angle);
            $s = sin($angle);
            $cx = $x * $this->k;
            $cy = ($this->h - $y) * $this->k;
            $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm', $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy));
        }
    }

    function _endpage()
    {
        if ($this->angle != 0) {
            $this->angle = 0;
            $this->_out('Q');
        }
        //parent::_endpage();
    }

    function Circle($x, $y, $r, $style = 'D')
    {
        $this->Ellipse($x, $y, $r, $r, $style);
    }

    function Ellipse($x, $y, $rx, $ry, $style = 'D')
    {
        if ($style == 'F')
            $op = 'f';
        elseif ($style == 'FD' || $style == 'DF')
            $op = 'B';
        else
            $op = 'S';
        $lx = 4 / 3 * (M_SQRT2 - 1) * $rx;
        $ly = 4 / 3 * (M_SQRT2 - 1) * $ry;
        $k = $this->k;
        $h = $this->h;
        $this->_out(sprintf(
            '%.2F %.2F m %.2F %.2F %.2F %.2F %.2F %.2F c',
            ($x + $rx) * $k,
            ($h - $y) * $k,
            ($x + $rx) * $k,
            ($h - ($y - $ly)) * $k,
            ($x + $lx) * $k,
            ($h - ($y - $ry)) * $k,
            $x * $k,
            ($h - ($y - $ry)) * $k
        ));
        $this->_out(sprintf(
            '%.2F %.2F %.2F %.2F %.2F %.2F c',
            ($x - $lx) * $k,
            ($h - ($y - $ry)) * $k,
            ($x - $rx) * $k,
            ($h - ($y - $ly)) * $k,
            ($x - $rx) * $k,
            ($h - $y) * $k
        ));
        $this->_out(sprintf(
            '%.2F %.2F %.2F %.2F %.2F %.2F c',
            ($x - $rx) * $k,
            ($h - ($y + $ly)) * $k,
            ($x - $lx) * $k,
            ($h - ($y + $ry)) * $k,
            $x * $k,
            ($h - ($y + $ry)) * $k
        ));
        $this->_out(sprintf(
            '%.2F %.2F %.2F %.2F %.2F %.2F c %s',
            ($x + $lx) * $k,
            ($h - ($y + $ry)) * $k,
            ($x + $rx) * $k,
            ($h - ($y + $ly)) * $k,
            ($x + $rx) * $k,
            ($h - $y) * $k,
            $op
        ));
    }
}
