<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;


Route::post('/webservice/send', function (Request $request) {
    $rand = rand(1, 10);
    if ($rand <= 3) { // 30% success
        return response()->json(['message' => 'ok'], 200);
    }

    $errors = [500, 500, 503, 422];
    $status = $errors[array_rand($errors)];
    Log::info('status: ' . $status);
    return response()->json(['message' => 'error', 'code' => $status], $status);

})->name("webservice.send");
