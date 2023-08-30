<?php
namespace App\Http\Controllers\Readers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Recinto;
use App\Models\Mesa;
use App\Models\MesaPartido;

require_once base_path('app/library/phpexcel/Classes/PHPExcel.php');

class ImportarExcelController extends Controller{

	public function formulario($mensaje=""){
		return view("reader.fileExcel");
	}
	

	
	public function read(){
        set_time_limit(0);
        
        $partidos = \DB::select("SELECT * from partido order by orden");

        if(!empty($_POST["vaciar_voto"])){
            try {
                \DB::select("delete from mesa_partido");
            } catch (\Illuminate\Database\QueryException $e) {
                //dd(gettype($e));die;
                
                $a = (Array) $e;
                
                return redirect("/importar-recinto")
                        ->with('status', 409)
                        ->with('lista', array($a["\x00*\x00message"]));
                
            }
        }
        if(!empty($_POST["vaciar_mesa"])){
            
            try {
                \DB::select("delete from mesa");
                
            } catch (\Illuminate\Database\QueryException $e) {
                //dd(gettype($e));die;
                
                $a = (Array) $e;
                
                return redirect("/importar-recinto")
                        ->with('status', 409)
                        ->with('lista', array($a["\x00*\x00message"]));
                
            }
        }
        if(!empty($_POST["vaciar_recinto"])){
            try {
                \DB::select("delete from recinto");
            } catch (\Illuminate\Database\QueryException $e) {
                //dd(gettype($e));die;
                
                $a = (Array) $e;
                
                return redirect("/importar-recinto")
                        ->with('status', 409)
                        ->with('lista', array($a["\x00*\x00message"]));
                
            }
            
        }

		$objPHPExcel = new \PHPExcel();
        $name  		 = $_FILES['archivo']['name'];
        if(empty($_FILES['archivo']['name'])){
            return redirect("/importar-recinto")
                    ->with('status', 409);
        };
		$tname  	 = $_FILES['archivo']['tmp_name'];
		$objPHPExcel = \PHPExcel_IOFactory::load($tname);
		$objPHPExcel	->	setActiveSheetIndex(0);       
		$sheetData 	 = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
        
        $errors = array();
        $data = array();
        foreach ($sheetData as $key => $value) {
            $distrito = trim($value["A"]);
            $zona = trim($value["B"]);
            $colegio = trim($value["C"]);
            $value["key"] = $key;

			if($key>1){
                $existe = \DB::select("SELECT exists (SELECT 1 from recinto 
                                        where distrito='$distrito'
                                        and zona='$zona'
                                        and colegio='$colegio') existe")[0]->existe;
                if($existe){
                    $errors[] = "Existe un registro en la tabla recinto con Distrito: $distrito, Zona: $zona, Colegio: $colegio en la fila $key.";
                    
                }

                if(empty($data)){
                    $data[] = $value;
                }
                else{
                    $errores = $this->verificarData($data, $value, $key);
                    if(!empty($errores)) {
                        $errors = array_merge($errors, $errores);
                    }
                    else{
                        $data[] = $value;
                    }
                }
                
			}
        }
        
        if(!empty($errors)){
            
            return redirect("/importar-recinto")
                    ->with('status', 409)
                    ->with('lista', $errors);
        }
        
        foreach ($data as $key => $value) {
			if($key>1){
                $recinto = new Recinto();
                $recinto->distrito = trim($value["A"]);
                $recinto->zona = trim($value["B"]);
                $recinto->colegio = trim($value["C"]);
                $recinto->cant_mesa = trim($value["D"]);
                $recinto->habilitados = trim($value["E"]);
                $recinto->save();

                if(!empty($_POST["registrar_mesa"])){
                    for($i=1; $i<=$recinto->cant_mesa; $i++){
                        $mesa = new Mesa();
                        $mesa->id_recinto = $recinto->id;
                        $mesa->numero = $i;
                        $mesa->blancos= 0;
                        $mesa->nulos = 0;
                        $mesa->emitidos= 0;
                        $mesa->anfora = 0;
                        $mesa->faltante = 0;
                        $mesa->save();
                        
                        if(!empty($partidos)){
                            foreach($partidos as $key1 => $value1){
                                $mesa_partido = new MesaPartido();
                                $mesa_partido->id_mesa = $mesa->id;
                                $mesa_partido->id_partido = $value1->id;
                                $mesa_partido->votos = 0;
                                $mesa_partido->save();
                            }
                        }
                        
                    }
                    
                    
                    
                    
                }
			}
        }
        
        return redirect("/importar-recinto")
                    ->with('status', 200);
    }	
    
    private function verificarData($data, $valores, $indice){
        
        $distrito = trim($valores["A"]);
        $zona = trim($valores["B"]);
        $colegio = trim($valores["C"]);
        $compuesto =  $distrito."||".$zona."||".$colegio;
        
        $errors = array();

        foreach ($data as $key => $value) {

            $distrito = trim($value["A"]);
            $zona = trim($value["B"]);
            $colegio = trim($value["C"]);

            if(trim($compuesto) == trim($distrito."||".$zona."||".$colegio)) {
                $errors[] = "Los datos de la fila $indice se repite en la fila  {$value['key']}. Datos que se repiten Distrito: $distrito, Zona: $zona, Colegio: $colegio.";
            }
        }

        return $errors;
    }
}
