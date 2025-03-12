<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class DownloadFileController extends Controller
{
    public function downloadFile($file_name)
    {
        return Storage::disk('public')->download($file_name);

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
