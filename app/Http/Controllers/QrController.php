<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class QrController extends Controller
{
    //

    // public function generate()
    // {
    //     // Simple QR code generation
    //     return QrCode::size(200)->generate('Hello World!');
        
    //     // For PDF generation (if you have dompdf installed)
    //     // $qrCode = QrCode::size(200)->generate('Hello World!');
    //     // $pdf = PDF::loadView('qr', compact('qrCode'));
    //     // return $pdf->stream();
    // }

    public function showForm()
    {
        return view('qr-form');
    }

    // public function generatePdf(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'message' => 'required|string'
    //     ]);

    //     $name = $request->input('name');
    //     $message = $request->input('message');

    //     // Generate QR code with the name
    //     $qrCode = QrCode::size(200)->generate($name);

    //     // Generate PDF
    //     $pdf = Pdf::loadView('qr-pdf', [
    //         'name' => $name,
    //         'message' => $message,
    //         'qrCode' => $qrCode
    //     ]);

    //     return $pdf->download('message-for-'.$name.'.pdf');
    // }

    public function generatePdf(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'required|string'
        ]);

        $name = $request->input('name');
        $message = $request->input('message');

        // Generate QR code as PNG image data
        $qrImage = QrCode::size(200)
                ->generate($name);
        
        // Convert to base64 for embedding in PDF
        $qrBase64 = 'data:image/png;base64,' . base64_encode($qrImage);

        $pdf = Pdf::loadView('qr-pdf', [
            'name' => $name,
            'message' => $message,
            'qrImage' => $qrBase64 // Pass base64 instead of SVG
        ]);

        return $pdf->download('message-for-'.$name.'.pdf');
    }


}




