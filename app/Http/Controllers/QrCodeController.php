<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{
    public function generate(Request $request)
    {
        $request->validate([
            'url' => 'string'
        ]);

        $qrCode = QrCode::size(250)->generate($request->url);

        return Response::json(['qrcode' => $qrCode->toHtml()], 200);
    }
}
