<?php

use App\Http\Controllers\Api\WhatsAppController;
use Illuminate\Support\Facades\Route;

Route::post('/whatsapp/webhook', [WhatsAppController::class, 'receiveOrder'])->name('receive.order');
