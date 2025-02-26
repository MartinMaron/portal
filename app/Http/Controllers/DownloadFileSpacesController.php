<?php

namespace App\Http\Controllers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Invoice;
use Illuminate\Support\Facades\Storage;
use function PHPUnit\Framework\returnArgument;



class DownloadFileSpacesController extends Controller
{

    function  downloadFile($param){
        if (auth()->user()->isUser){
            $parts = explode('-',$param);
            $invoice = Invoice::find($parts[1] );
            $path = 'app/realestates/'. $invoice->realestate->nekoId. '/invoices/'. $invoice->fileName;
            return Storage::disk('spaces')->download($path);
        }else{
            return redirect('/dashboard'); 
        }
    }

    function  showFile($param){
        if (auth()->user()->isUser){
            $parts = explode('-',$param);
            $invoice = Invoice::find($parts[1] );
            $path = 'app/realestates/'. $invoice->realestate->nekoId. '/invoices/'. $invoice->fileName;

            $file = Storage::disk('spaces')->get($path);
            $headers = [
                'Content-Type' => 'application/pdf',
            ];
        return response($file, 200, $headers);
        }else{
            return redirect('/dashboard'); 
    }

    }

}
