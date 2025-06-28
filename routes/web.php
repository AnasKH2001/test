<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;

use App\Http\Controllers\QrController;




Route::get('/', function () {
    return view('welcome');
});

Route::get('/generate-pdf', [PDFController::class, 'generatePDF']);



//Route::get('/qr', [QrController::class, 'generate']);
// Route::get('/qr-generator', [QrController::class, 'showForm']);


//POST

Route::post('/generate-qr-pdf', [QrController::class, 'generatePdf']);

