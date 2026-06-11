<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AiChatController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here we register API routes. The `/api/chat` endpoint is rate-limited
| to protect the Gemini budget and prevent spam.
|
*/

Route::post('/chat', [AiChatController::class, 'chat'])->middleware('throttle:15,1');
