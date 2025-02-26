<?php

namespace App\Http\Controllers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use function PHPUnit\Framework\returnArgument;

class DownloadFileController extends Controller
{
    function downloadFile($file_name){
        return Storage::disk('public')->download($file_name);

    }

    function showFile($file_name){
        $file = Storage::disk('public')->get($file_name);
        $headers = [
            'Content-Type' => 'application/pdf',
        ];

        return response($file, 200, $headers);

    }
}
