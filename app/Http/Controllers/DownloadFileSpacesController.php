<?php

namespace App\Http\Controllers;

use App\Models\Abrechnungssetting;
use App\Models\Invoice;
use Illuminate\Support\Facades\Storage;

class DownloadFileSpacesController extends Controller
{
    public function downloadFile($param)
    {
        if (auth()->user()->isUser) {
            if (str_starts_with($param, 'i'))
            {
                $parts = explode('+',$param);
                $invoice = Invoice::find($parts[1] );
                $path = 'app/realestates/'. $invoice->realestate->nekoId. '/invoices/'. $invoice->fileName;
                return Storage::disk('spaces')->download($path);
            }
            if (str_starts_with($param, 'abrhk_kosten'))
            {
                $parts = explode('+',$param);
                $obj = Abrechnungssetting::find($parts[1]);
                $path = 'app/realestates/'. $obj->realestate->nekoId. '/HK_ABR/'. $obj->hk_id. '/KOSTENUEBERSICHT.pdf';
                return Storage::disk('spaces')->download($path);
            }
            if (str_starts_with($param, 'abrhk_gesamt'))
            {
                $parts = explode('+',$param);
                $obj = Abrechnungssetting::find($parts[1]);
                $path = 'app/realestates/'. $obj->realestate->nekoId. '/HK_ABR/'. $obj->hk_id. '/GESAMTABRECHNUNG.pdf';
                return Storage::disk('spaces')->download($path);
            }
            if (str_starts_with($param, 'abrhk_nutzer'))
            {
                $parts = explode('+',$param);
                $obj = Abrechnungssetting::find($parts[1]);
                $path = 'app/realestates/'. $obj->realestate->nekoId. '/HK_ABR/'. $obj->hk_id. '/NUTZERABRECHNUNG.pdf';
                return Storage::disk('spaces')->download($path);
            }
            if (str_starts_with($param, 'abrbk'))
            {
                $parts = explode('+',$param);
                $obj = Abrechnungssetting::find($parts[1]);
                $path = 'app/realestates/'. $obj->realestate->nekoId. '/BK_ABR/'. $obj->bk_id. '/BETRIEBSKOSTENABRECHNUNG.pdf';
                return Storage::disk('spaces')->download($path);
            }
        } else {
            return redirect('/dashboard');
        }
    }

    public function showFile($param)
    {
        if (auth()->user()->isUser) {
            $parts = explode('+', $param);
            $invoice = Invoice::find($parts[1]);
            $path = 'app/realestates/'.$invoice->realestate->nekoId.'/invoices/'.$invoice->fileName;

            $file = Storage::disk('spaces')->get($path);
            $headers = [
                'Content-Type' => 'application/pdf',
            ];

            return response($file, 200, $headers);
        } else {
            return redirect('/dashboard');
        }

    }
}
