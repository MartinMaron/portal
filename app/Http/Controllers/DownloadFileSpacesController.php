<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Abrechnungssetting;
use App\Models\Invoice;
use Illuminate\Support\Facades\Storage;

class DownloadFileSpacesController extends Controller
{
    public function downloadFile($param)
    {
        if (Auth::User()->isUser) {
            if (str_starts_with($param, 'i'))
            {
                $parts = explode('+',$param);
                $invoice = Invoice::find($parts[1] );
                $path = 'app/realestates/'. $invoice->realestate->nekoId. '/invoices/'. $invoice->fileName;
                $fileContent = Storage::disk('spaces')->get($path);
                $fileName = basename($path);
                return response()->streamDownload(function () use ($fileContent) {
                    echo $fileContent;
                }, $fileName);
           }
            if (str_starts_with($param, 'abrhk_kosten'))
            {
                $parts = explode('+',$param);
                $obj = Abrechnungssetting::find($parts[1]);
                $path = 'app/realestates/'. $obj->realestate->nekoId. '/HK_ABR/'. $obj->hk_id. '/KOSTENUEBERSICHT.pdf';
                $fileContent = Storage::disk('spaces')->get($path);
                $fileName = basename($path);
                return response()->streamDownload(function () use ($fileContent) {
                    echo $fileContent;
                }, $fileName);
            }
            if (str_starts_with($param, 'abrhk_gesamt'))
            {
                $parts = explode('+',$param);
                $obj = Abrechnungssetting::find($parts[1]);
                $path = 'app/realestates/'. $obj->realestate->nekoId. '/HK_ABR/'. $obj->hk_id. '/GESAMTABRECHNUNG.pdf';
                $fileContent = Storage::disk('spaces')->get($path);
                $fileName = basename($path);
                return response()->streamDownload(function () use ($fileContent) {
                    echo $fileContent;
                }, $fileName);
            }
            if (str_starts_with($param, 'abrhk_nutzer'))
            {
                $parts = explode('+',$param);
                $obj = Abrechnungssetting::find($parts[1]);
                $path = 'app/realestates/'. $obj->realestate->nekoId. '/HK_ABR/'. $obj->hk_id. '/NUTZERABRECHNUNG.pdf';
                $fileContent = Storage::disk('spaces')->get($path);
                $fileName = basename($path);
                return response()->streamDownload(function () use ($fileContent) {
                    echo $fileContent;
                }, $fileName);
            }
            if (str_starts_with($param, 'abrbk'))
            {
                $parts = explode('+',$param);
                $obj = Abrechnungssetting::find($parts[1]);
                $path = 'app/realestates/'. $obj->realestate->nekoId. '/BK_ABR/'. $obj->bk_id. '/BETRIEBSKOSTENABRECHNUNG.pdf';
                $fileContent = Storage::disk('spaces')->get($path);
                $fileName = basename($path);
                return response()->streamDownload(function () use ($fileContent) {
                    echo $fileContent;
                }, $fileName);
            }
        } else {
            return redirect('/dashboard');
        }
    }

    public function showFile($param)
    {
        if (Auth::user()->isUser) {
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
