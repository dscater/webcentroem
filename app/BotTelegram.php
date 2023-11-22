<?php

namespace App;

use App\Models\CitaMedica;
use App\Models\Persona;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class BotTelegram extends Model
{
    protected $fillable = [
        "chat_id",
        "comando",
        "valor",
        "estado",
    ];

    public static function token()
    {
        return config("app.telegram_token");
    }

    public static function responder()
    {
        try {
            $request = file_get_contents("php://input");
            $request = json_decode($request);
            // \Log::debug('Texto::' . serialize($request) . ' OBJETO EN STRING NORMALIN NORMALIN');
            if (isset($request->message)) {
                \Log::debug('Texto::' . $request->message->chat->id . ' CHAT ID');
            } elseif ($request->callback_query) {
                \Log::debug('Texto::' . $request->callback_query->from->id . ' CHAT ID - CALLBACKQUERY');
            }
            $texto = "";
            $chatId = 0;
            $firstName = "";
            $lastName = "";
            $nombreCompleto = $firstName . ' ' . $lastName;
            $tipo = 'mensaje';
            // validar si existe el indice 'entities' en el mensaje recibido del telegram
            if (isset($request->message)) {
                // validar que el type sea 'command'
                $texto = $request->message->text;
                $chatId = $request->message->chat->id;
                $firstName = $request->message->chat->first_name;
                $lastName = '';
                if (isset($request->message->chat->last_name)) {
                    $lastName = $request->message->chat->last_name ? $request->message->chat->last_name : '';
                }
                if (isset($request->message->entities)) {
                    if ($request->message->entities[0]->type == 'bot_command') {
                        $tipo = 'comando';
                    }
                }
            } elseif ($request->callback_query) {
                $tipo = 'callback';
                $texto = $request->callback_query->data;
                $chatId = $request->callback_query->from->id;
                $firstName = $request->callback_query->from->first_name;
                $lastName = '';
                if (isset($request->callback_query->from->last_name)) {
                    $lastName = $request->callback_query->from->last_name ? $request->callback_query->from->last_name : '';
                }
            }
            $resp = self::enviar($chatId, $texto, $tipo, $nombreCompleto);
            return 1;
        } catch (\Exception $e) {
            \Log::debug('Error bot:' . $e->getMessage());
        }
    }

    static function iniciaBot($chatId, $comando, $valor = null, $estado = 'PENDIENTE')
    {
        return BotTelegram::create([
            'chat_id' => $chatId,
            'comando' => $comando,
            'valor' => $valor,
            'estado' => $estado,
        ]);
    }

    // ENVIAR LOS MENSAJES DEACUERDO AL CHATID, TEXTO, TIPO
    public static function enviar($chatId, $texto, $tipo, $nombreCompleto)
    {
        $datos = [];
        $metodo = 'sendMessage';
        /*1. Comprobar el tipo de mensaje. Si  es o no un comando
             */
        if ($tipo == 'comando') {
            $datos = self::comando($chatId, $texto, $nombreCompleto);
        } elseif ($tipo == 'callback' || $tipo == 'mensaje') {
            // 1) VERIFICAR QUE COMANDO ó RESPUESTA PENDIENTE (en espera) TIENE REGISTRADO EN LA BD Y DEACUERDO A ESO
            // 2) DEVOLVER LA RESPUESTA DESEADA EN MENSAJE ó ARCHIVO
            $bot_mensaje = BotTelegram::where('chat_id', $chatId)
                ->where('estado', 'PENDIENTE')
                ->get()
                ->last();
            if ($bot_mensaje) {
                $datos = self::enEspera($chatId, $bot_mensaje, $texto);
            } else {
                $datos = self::texto($chatId, $texto);
            }
        }

        Log::debug('Texto::' . implode('-', $datos) . ' eee');

        return self::send($metodo, $datos);
    }

    // ENVIO DE MENSAJES AL TELEGRAM
    public static function send($metodo, $datos)
    {
        $url = "https://api.telegram.org/bot" . self::token() . "/" . $metodo;

        if (!$curld = curl_init()) {
            exit;
        }
        curl_setopt($curld, CURLOPT_HTTPHEADER, array(
            "Content-Type:multipart/form-data"
        ));
        curl_setopt($curld, CURLOPT_POST, true);
        curl_setopt($curld, CURLOPT_POSTFIELDS, $datos);
        curl_setopt($curld, CURLOPT_URL, $url);
        curl_setopt($curld, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curld, CURLOPT_SSL_VERIFYPEER, false);
        $output = curl_exec($curld);
        curl_close($curld);
        return json_decode($output, true);
    }

    // CONFIRMACION DE MENSAJES PARA LIMPIAR LOS UPDATES DEL TELEGRAM
    public static function confirmaMensajes($update_id)
    {
        $url = "https://api.telegram.org/bot" . self::token() . "" . "/getUpdates?offset=" . $update_id;
        file_get_contents($url);
        return true;
    }


    // PETICIONES EN ESPERA DE UNA RESPUESTA
    static function enEspera($chatId, $bot_mensaje, $texto = '')
    {
        $mensaje = "";
        $comando = $bot_mensaje->comando;
        $datos = [
            'chat_id' => $chatId,
            'remove_keyboard' => true,
            'text' => '',
            'parse_mode' => 'HTML'

        ];
        // \Log::debug('Texto::' . $comando . ' xxx');
        switch ($comando) {
            case "/ci":
                // buscar la primera persona con el ci
                $persona = Persona::where("state", 1)->where("ci", $texto)->get()->first();
                $mensaje = 'Perfecto desde ahora te envíare un mensaje de recordatorio un día antes de tus citas médicas. Que tengas un buen día.';
                if ($persona) {
                    $existe_registro_bot = PersonaTelegram::where("persona_id", $persona->id)
                        ->where("chat_id", $chatId)
                        ->get()->first();
                    if (!$existe_registro_bot) {
                        PersonaTelegram::create([
                            "persona_id" => $persona->id,
                            "chat_id" => $chatId
                        ]);
                    }

                    $bot_mensaje->valor = $texto;
                    $bot_mensaje->estado = 'ENVIADO';
                    $bot_mensaje->save();
                } else {
                    $mensaje = 'Lo siento el nro. de C.I. que me enviaste no se encuentra en nuestros regisros, intenta nuevamente.';
                }
                $datos = array(
                    'chat_id' => $chatId,
                    'remove_keyboard' => true, //REMOVER EL MENU DE BOTONES
                    'text' => $mensaje,
                    'parse_mode' => 'HTML'
                );
                break;
            case "/confirmar":
                $array_valor = explode("|", $bot_mensaje->valor);
                $cita = CitaMedica::find($array_valor[0]);
                $respuesta = trim($texto);
                $respuesta = mb_strtoupper($respuesta);

                $mensaje = "Muchas gracias por su respuesta";
                if ($respuesta == 'CANCELAR') {
                    $cita->estado = 'CANCELADO';
                    $cita->save();
                    $mensaje = "Muchas gracias por su respuesta. Su cita fue cancelada";
                }
                $bot_mensaje->estado = 'ENVIADO';
                $bot_mensaje->valor = $bot_mensaje->valor . $texto;
                $bot_mensaje->save();

                $datos = array(
                    'chat_id' => $bot_mensaje->chat_id,
                    'text' => $mensaje,
                    'parse_mode' => 'HTML'
                );
                break;
        }
        return $datos;
    }


    // PETICIONES EN FORMA DE TEXTO
    static function texto($chatId, $texto)
    {
        $texto = mb_strtoupper($texto);
        $datos = [
            'chat_id' => $chatId,
            'remove_keyboard' => true,
            'text' => '',
            'parse_mode' => 'HTML'

        ];

        switch ($texto) {
            case 'CAMBIAR':
                $rol_keyboard = [
                    'inline_keyboard' => [
                        [
                            ['text' => 'NUTRICIONISTA', 'callback_data' => 'NUTRICIONISTA'],
                            ['text' => 'CLIENTE', 'callback_data' => 'CLIENTE'],
                        ]
                    ]
                ];
                $encodedKeyboard = json_encode($rol_keyboard); //formatear el menú

                // armar los datos  de envio
                $datos = array(
                    'chat_id' => $chatId,
                    'reply_markup' => $encodedKeyboard,
                    'text' => 'Selecciona una de las siguientes opciones:',
                    'parse_mode' => 'HTML'
                );

                self::iniciaBot($chatId, '/ci', null, 'PENDIENTE');
                break;
            default:
                $datos = array(
                    'chat_id' => $chatId,
                    'text' => 'Lo siento no puedo responder a eso. Por favor verifica que estes realizando una consulta valida.',
                );
                break;
        }
        return $datos;
    }


    // PETICIONES EN FORMA DE COMANDOS
    static function comando($chatId, $texto, $nombreCompleto = '')
    {
        // 1) VERIFICAR SI EL USUARIO TIENE UN COMANDO (en espera) PENDIENTE EN LA BD
        // 1.1) SI TUVIERA ELIMINAR ESA ESPERA 
        // 2) REGISTRAR EL COMANDO EN LA BD Y DEVOLVER UN MENSAJE DEACUERDO AL COMANDO
        // ENVIAREMOS UN MENSAJE DEACUERDO AL COMANDO RECIBIDO
        $texto = mb_strtolower($texto);

        $mensaje = "";
        self::verificaAnteriores($chatId);
        $nuevo_bot = self::iniciaBot($chatId, $texto);
        $rol_keyboard = [];
        switch ($texto) {
            case '/start':
                $mensaje = "Hola " . $nombreCompleto . ", soy webcentroem_bot. Un asistente virtual que te hara recuerdo todas las citas médicas que tienes programadas.\n Para empezar necesito que me envíes tu nro. de C.I. (Ej.: 77878688).";
                $nuevo_bot->estado = 'ENVIADO';
                $nuevo_bot->save();
                // armar los datos  de envio
                $datos = array(
                    'chat_id' => $chatId,
                    'text' => $mensaje,
                    'parse_mode' => 'HTML'
                );
                self::iniciaBot($chatId, '/ci');
                break;
        }

        return $datos;
    }

    static function verificaAnteriores($chatId)
    {
        $existe_anterior = BotTelegram::where('chat_id', $chatId)
            ->where('estado', 'PENDIENTE')->get();
        foreach ($existe_anterior as $value) {
            // PONER EN ESTADO CANCELADO TODOS LOS QUE NO SE HALLAN CONFIRMADO
            // O QUE EL USUARIO NO HALLA RESPONDIDO
            $value->estado = 'CANCELADO';
            $value->save();
        }

        return true;
    }
}
