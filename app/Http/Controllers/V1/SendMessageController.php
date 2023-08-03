<?php

namespace App\Http\Controllers\V1;

use App\Events\SendMessage;
use Illuminate\Http\Request;

class SendMessageController extends Controller
{
    public function index()
    {
        event(new SendMessage());
        return true;
    }
}
