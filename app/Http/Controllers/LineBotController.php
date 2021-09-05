<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\LineBotService;

class LineBotController extends Controller
{

    public $lineBotService;

    public function __construct(LineBotService $lineBotService)
    {
        $this->lineBotService = $lineBotService;
    }

    public function webHook(Request $request)
    {
        return $this->lineBotService->webhook($request);
    }
}
