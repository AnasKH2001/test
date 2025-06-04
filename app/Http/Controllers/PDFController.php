<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

//use Barryvdh\DomPDF\Facade as PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PDFController extends Controller
{
    public function generatePDF()
    {
        $qrCode = QrCode::size(100)->generate('Hello World!'); // Replace with your URL or data

        $pdf = PDF::loadView('pdf.qr_code', ['qrCode' => $qrCode]);

        return $pdf->download('qr_code.pdf');
    }

}
