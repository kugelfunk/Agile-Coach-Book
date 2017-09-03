<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AttachmentsController extends Controller
{
    public function show($attachment_url)
    {

        $file = Storage::get('uploads/' . $attachment_url);
        $mimetype = Storage::mimeType('uploads/' . $attachment_url);
//        header("Content-type: image/jpeg");
        return response($file, 200)->header('Content-Type', $mimetype);
    }
}