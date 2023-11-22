<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BackupController extends Controller
{
    public function index()
    {
        return view("backup.index");
    }

    public function descargar()
    {
        $archivo_config = public_path("backups/ConfigBackup.txt");
        $lineas = file($archivo_config, FILE_IGNORE_NEW_LINES);

        $path_mysqldump = config('app.path_mysql');
        $dbname = "webcentroem_db";
        $file_name = $dbname . '_' . date("d_m_Y_H_i_s") . '.sql';
        $dbfile = public_path() . "/backups/" . $file_name;
        $dbuser = "root";
        $dbpass = "";
        if (file_exists($archivo_config)) {
            foreach ($lineas as $linea) {
                $array = explode("=", $linea);
                if ($array[0] == "PATH") {
                    $path_mysqldump = trim($array[1]);
                }
                if ($array[0] == "DBNAME") {
                    $dbname = $array[1];
                    $file_name = $dbname . '_' . date("d_m_Y_H_i_s") . '.sql';
                    $dbfile = public_path() . "/backups/" . $file_name;
                }
                if ($array[0] == "USER") {
                    $dbuser = $array[1];
                }
                if ($array[0] == "PASSWORD") {
                    $dbpass = $array[1];
                }
            }
        } else {
            $dbname = config('database.connections.mysql.database');
            $dbuser = config('database.connections.mysql.username');
            $dbpass = config('database.connections.mysql.password');
        }



        //save file
        $mysqldump = $path_mysqldump . "\mysqldump";
        if ($path_mysqldump == "") {
            $mysqldump = "mysqldump";
        }
        $command = "$mysqldump -u$dbuser $dbname > $dbfile";
        if ($dbpass != "") {
            $command = "$mysqldump -u$dbuser -p$dbpass $dbname > $dbfile";
        }
        exec($command, $output, $worked);
        // switch ($worked) {
        //     case 0:
        //         echo 'La base de datos <b>' . $dbname . '</b> se ha almacenado correctamente en la siguiente ruta ' . getcwd() . '/' . $dbfile . '</b>';
        //         break;
        //     case 1:
        //         echo 'Se ha producido un error al exportar <b>' . $dbname . '</b> a ' . getcwd() . '/' . $dbfile . '</b>';
        //         break;
        //     case 2:
        //         echo 'Se ha producido un error de exportación, compruebe la siguiente información: <br/><br/><table><tr><td>Nombre de la base de datos:</td><td><b>' . $dbname . '</b></td></tr><tr><td>Nombre de usuario MySQL:</td><td><b>' . $dbuser . '</b></td></tr><tr><td>Contraseña MySQL:</td><td><b>NOTSHOWN</b></td></tr><tr><td>Nombre de host MySQL:</td><td><b>' . $dbhost . '</b></td></tr></table>';
        //         break;
        // }
        if ($worked == 0) {
            return redirect(asset("/backups/" . $file_name));
        }
        return "Ocurrió un error al intentar descargar la base de datos";
    }
}
