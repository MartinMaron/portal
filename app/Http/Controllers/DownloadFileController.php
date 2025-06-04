<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class DownloadFileController extends Controller
{
    public function downloadFile($file_name)
    {
        $path = Storage::disk('public')->path($file_name);
        return response()->download($path);

    }

    public function showFile($file_name)
    {
        $file = Storage::disk('public')->get($file_name);
        $headers = [
            'Content-Type' => 'application/pdf',
        ];

        return response($file, 200, $headers);

    }
}
