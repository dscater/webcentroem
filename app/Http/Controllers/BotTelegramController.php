<?php

namespace App\Http\Controllers;

use App\BotTelegram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BotTelegramController extends Controller
{
    public function index()
    {
        Log::debug("Entro");
        return BotTelegram::responder();
    }

    public function prueba()
    {
        return "ad";
    }
}
