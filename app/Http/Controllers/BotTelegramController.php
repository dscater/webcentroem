<?php

namespace App\Http\Controllers;

use App\BotTelegram;
use Illuminate\Http\Request;

class BotTelegramController extends Controller
{
    public function index()
    {
        return BotTelegram::responder();
    }
}
