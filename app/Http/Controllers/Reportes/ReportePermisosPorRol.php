<?php  
namespace App\Http\Controllers\Reportes;

use App\Helpers\FuncionesComunes;

include_once base_path("app/Library/fpdf/fpdf.php");





class ReportePermisosPorRol extends \FPDF
{
 
    var $tituloEncabezado;
    var $tamanioCampo;
    var $tituloHeader;
    var $altoCelda;
    var $tamLetra;
    var $bordeCelda;
    var $configuracion;
    public function Header() {
        $this->cabecera_general();
        //$this->cabecera2();
    }
    public function cabecera_general()
    {          
        
        
        
        $this->SetY(10);
        $this->SetX(300);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(30,5, utf8_decode('Página ') . $this->PageNo() . ' de {nb}', 0, 1, 'L'); 
        $this->SetX(300);
        $this->Cell(30,5, utf8_decode("Fecha: ".date("d/m/Y")), 0, 1, 'L'); 
    
        $this->Ln(3);
        

        $this->SetFont('Arial', 'B', 15);
        $this->Cell(320, 6, utf8_decode("REPORTE DE PERMISOS POR ROL"), 0, 1, 'C');        
        
        $this->Ln(3);       
        
        
    }
    public function cabecera2()
    {   

        

        
        
        
    }
    public function cabecera3()
    {     
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(50, 6, utf8_decode("Datos de ROL:"), 0, 1, 'L');
        $this->SetFont('Arial', 'B', 9);

        $this->Cell(25, 6, utf8_decode("id_rol:"), 1, 0, 'L');
        $this->Cell(70, 6, utf8_decode("Nombre:"), 1, 0, 'L');
        $this->Cell(70, 6, utf8_decode("Slug:"), 1, 0, 'L');
        $this->Cell(110, 6, utf8_decode("Descripción"), 1, 0, 'L');
        $this->Cell(30, 6, utf8_decode("Especial"), 1, 1, 'L');
        

        $this->SetFont('Arial', '', 9);

        if(!empty($this->data->roles))
        {
            foreach ($this->data->roles as $key => $value) {
                $this->SetWidths(array( 25,70,70,110,30,15,15,32,32,32));
                $this->SetRectangulo(array( 1,1,1,1,1,1,1,1,1,1));
                $this->SetFuente(array( "","","","","","","","","","","",""));
                $this->SetAligns(array( "L", "L", "L", "L","L", "L","L","L", "L", "L", "L","L", "L","L"));
                
                
                
                
                $data = array(
                            utf8_decode($value->id),
                            utf8_decode(trim($value->name)),
                            utf8_decode($value->slug),
                            utf8_decode($value->description),
                            utf8_decode($value->special),
                        );

                $this->Row($data, 5, 5,false,false); 
                //$this->Ln(1);
            }
        }
    }
    public function cabecera4()
    {     
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(50, 6, utf8_decode("PERMISOS ASIGNADOS DE ACUERDO A LOS ROLES ASIGNADOS:"), 0, 1, 'L');
        $this->SetFont('Arial', 'B', 9);

        $this->Cell(25, 6, utf8_decode("ID_PERMISO:"), 1, 0, 'L');
        $this->Cell(70, 6, utf8_decode("ROL:"), 1, 0, 'L');
        $this->Cell(70, 6, utf8_decode("Nombre:"), 1, 0, 'L');
        $this->Cell(70, 6, utf8_decode("Slug:"), 1, 0, 'L');
        $this->Cell(80, 6, utf8_decode("Descripción"), 1, 1, 'L');
        
        
        

        $this->SetFont('Arial', '', 9);

        if(!empty($this->data->roles_permisos))
        {
            foreach ($this->data->roles_permisos as $key => $value) {
                $this->SetWidths(array( 25,70,70,70,80,15,32,32,32));
                $this->SetRectangulo(array( 1,1,1,1,1,1,1,1,1,1));
                $this->SetFuente(array( "","","","","","","","","","","",""));
                $this->SetAligns(array( "L", "L", "L", "L","L", "L","L","L", "L", "L", "L","L", "L","L"));
                
                
                
                
                $data = array(
                            utf8_decode($value->id),
                            utf8_decode($value->rol),
                            utf8_decode(trim($value->name)),
                            utf8_decode($value->slug),
                            utf8_decode($value->description),
                            
                            
                            
                        );

                $this->Row($data, 5, 5,false,false); 
                //$this->Ln(1);
            }
        }        
    }

    public function pie() {
        
        
    }
    public function reporte($data)
    {   
        $this->data = $data;

        ini_set("session.auto_start", 0); 
        

        $this->SetTopMargin(10);
        $this->SetLeftMargin(8);
        $this->SetRightMargin(8);
        $this->AliasNbPages();
        $this->SetAutoPageBreak(1, 15);
        //$this->AddPage('P', 'Legal');
        $this->AddPage('L',array(340,220));
        
        
        $this->cabecera2();
        $this->cabecera3();
        $this->cabecera4();
        

        
        /*if(!empty($data->resultado))
        {
            foreach ($data->resultado as $key => $value) {
                $this->SetFont('Arial', '', 9);
                //$this->SetTextColor(10, 105, 170);

                $this->SetWidths(array( 32,32,32,32,32,32,32,32,32,32));
                $this->SetRectangulo(array( 0,0,0,0,0,0,0,0,0,0));
                $this->SetFuente(array( "","","","","","","","","","","",""));
                $this->SetAligns(array( "C", "C", "C", "C","C", "C","C","C", "C", "C", "C","C", "C","C"));
                $this->SetColorRow(array( 
                                        array(255, 255, 255), 
                                        array(255, 255, 255), 
                                        array(255, 255, 255), 
                                        array(255, 255, 255),
                                        array(255, 255, 255), 
                                        array(255, 255, 255),
                                        array(255, 255, 255),
                                        array(255, 255, 255),
                                        array(255, 255, 255),
                                        array(255, 255, 255),
                                        array(255, 255, 255),
                                        array(255, 255, 255)
                                    ));
                
                $y=$this->GetY();
                $tipo_cargo = "";
                if($value->tipo_cargo=='D'){$tipo_cargo="DOCENTE";}
                else if($value->tipo_cargo=='A'){$tipo_cargo="ADMINISTRATIVO";}+
                $item = FuncionesComunes::serearNumero(5,$value->item);
                $data = array(
                            utf8_decode($value->gestion),
                            utf8_decode(strtoupper($this->mes_literal($value->mes))),
                            utf8_decode($value->servicio),
                            utf8_decode($value->codigo_rue),
                            utf8_decode($item),
                            utf8_decode($value->codigo_cargo),
                            utf8_decode($tipo_cargo),
                            utf8_decode(trim($value->cargo)),
                            utf8_decode($value->dias_trabajado),
                            utf8_decode($value->horas)
                        );

                $this->Row($data, 3, 3,false,true); 
                $this->Ln(1);
                
                
                $data = array(
                            utf8_decode(strtoupper($value->departamento)),
                            utf8_decode(trim($value->distrito)),
                            utf8_decode($value->area),
                            utf8_decode($value->nivel),
                            utf8_decode($value->mcr_area),
                            utf8_decode($value->mcr_codigo),
                            utf8_decode($value->origen),
                            utf8_decode($value->techo),
                            utf8_decode($value->compulsa_definidor)
                        );

                $this->Row($data, 3, 3,false,true);

                $numero_documento = FuncionesComunes::serearNumero(8,trim($value->numero_documento));
                $data = array(
                            utf8_decode(strtoupper($value->codigo_rda)),
                            utf8_decode($numero_documento),
                            utf8_decode($value->paterno),
                            utf8_decode($value->materno),
                            utf8_decode($value->nombre1),
                            utf8_decode($value->nombre2),
                            utf8_decode($value->porcentaje_categoria),
                            utf8_decode($value->fecha_designacion),
                            utf8_decode($value->fecha_acta_posecion),
                            utf8_decode($value->tipo_pago)
                        );
                $this->Ln(1);
                $this->Row($data, 3, 3,false,true); 
                $this->Line(10,$this->GetY(),330,$this->GetY());
                $this->Ln(1);
            }
        }*/
        

        $this->Output('reporte1.pdf', 'I');die;
    } 
    function SetFontSize($size) {
           // Set font size in points
           if ($this->FontSizePt == $size)
               return;
           $this->FontSizePt = $size;
           $this->FontSize = $size / $this->k;
           if ($this->page > 0)
               $this->_out(sprintf('BT /F%d %.2F Tf ET', $this->CurrentFont['i'], $this->FontSizePt));
       }
    function AjustaCelda($ancho, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $scale=false, $force=true) {
     $TamanoInicial = $this->FontSizePt;
     $TamanoLetra = $this->FontSizePt;
     $Decremento = 0.8;
     while($this->GetStringWidth($txt) > $ancho)
       $this->SetFontSize($TamanoLetra -= $Decremento);
     $this->Cell($ancho, $h, $txt, $border, $ln, $align, $fill, $link, $scale, $force);
     $this->SetFontSize($TamanoInicial);
    }
    function numtoletras($xcifra)
    {
    $xarray = array(0 => "Cero",
        1 => "UNO", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",
        "DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",
        "VEINTI", 30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA",
        100 => "CIEN", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"
    );
//
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
                            if (TRUE === array_key_exists($key, $xarray)){  // busco si la centena es nÃºmero redondo (100, 200, 300, 400, etc..)
                                $xseek = $xarray[$key];
                                $xsub = $this->subfijo($xaux); // devuelve el subfijo correspondiente (MillÃ³n, Millones, Mil o nada)
                                if (substr($xaux, 0, 3) == 100)
                                    $xcadena = " " . $xcadena . " CIEN " . $xsub;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
                            }
                            else { // entra aquÃ­ si la centena no fue numero redondo (101, 253, 120, 980, etc.)
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
                            }
                            else {
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
            $xcadena.= " DE";
 
        if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
            $xcadena.= " DE";
 
        // ----------- esta lÃ­nea la puedes cambiar de acuerdo a tus necesidades o a tu paÃ­s -------
        if (trim($xaux) != "") {
            switch ($xz) {
                case 0:
                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                        $xcadena.= "UN BILLON ";
                    else
                        $xcadena.= " BILLONES ";
                    break;
                case 1:
                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                        $xcadena.= "UN MILLON ";
                    else
                        $xcadena.= " MILLONES ";
                    break;
                case 2:
                    if ($xcifra < 1) {
                        $xcadena = "";
                    }
                    if ($xcifra >= 1 && $xcifra < 2) {
                        $xcadena = "";
                    }
                    if ($xcifra >= 2) {
                        $xcadena.= ""; //
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
    function fecha_literal($Fecha, $Formato = 4) {
        $dias = array(0 => 'Domingo', 1 => 'Lunes', 2 => 'Martes', 3 => 'Miércoles', 4 => 'Jueves', 5 => 'Viernes', 6 => 'Sábado');
        $meses = array(1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril', 5 => 'mayo', 6 => 'junio',
            7 => 'julio', 8 => 'agosto', 9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre');
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
                $numeroDia= date('w', strtotime($Fecha));
                return $dias[$numeroDia].' '.$aux['day'] . ' de ' . $meses[$aux['month']] . ' de ' . $aux['year'];
            case 6:
                return date('d/m/Y', strtotime($Fecha));
            default:
                return date('d/m/Y', strtotime($Fecha));
        }
    }
    function mes_literal($mes){
        $meses = array(1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril', 5 => 'mayo', 6 => 'junio',
            7 => 'julio', 8 => 'agosto', 9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre');
        if($mes!=null)
            return $meses[$mes];
        else
            return '';

    }
            
    function Footer()
    {
        
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
    var $rectangulo;
    var $fuente;
    var $colorRow;
    var $interlineado;

    function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths = $w;
    }

    function SetRectangulo($r)
    {
        //Set the array of column widths
        $this->rectangulo = $r;
    }
    function SetInterlineado($i)
    {
        //Set the array of column widths
        $this->interlineado = $i;
    }

    function SetColorRow($c)
    {
        //Set the array of column widths
        $this->colorRow = $c;
    }

    function SetFuente($f)
    {
        //Set the array of column widths
        $this->fuente = $f;
    }

    function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns = $a;
    }

    function Row($data, $alto_celda, $interlineado,$rect=true,$fondo=false)
    {

        //Calculate the height of the row
        $nb = 0;
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
            if(!empty($this->rectangulo)){

                if($this->rectangulo[$i]==1)
                    $this->Rect($x, $y, $w, $h);
            }

            /*if(!empty($this->fuente)){

                if($this->fuente[$i]=="B")
                    $this->SetFont("Arial","B",7);
                else
                    $this->SetFont("Arial","",7);
            }*/
            if(!empty($this->colorRow)){

                if(!empty($this->colorRow[$i]))
                    $this->SetFillColor($this->colorRow[$i][0],$this->colorRow[$i][1],$this->colorRow[$i][2]);     
                else
                    $this->SetFillColor(255,255,255);
            }
            //$this->SetFillColor(255,255,255);
            if(!empty($this->interlineado)){
                if(!empty($this->interlineado[$i]))
                    $interlineado = $this->interlineado[$i];     
                                    
            }
            //Print the text
            //$interlineado=3; // interlineado 
            $this->MultiCell($w, $interlineado, $data[$i], 0, $a,$fondo);
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
            $this->AddPage('L',array(340,220));
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

    //  TABULACION DE TEXTO //////////////////////////////////////
}

    