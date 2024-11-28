<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class ImageController extends Controller
{
    /**
     * Muestra una imagen almacenada en el directorio público.
     *
     * @param  string  $filename
     * @return \Illuminate\Http\Response
     */
    public function show($filename)
    {
        $path = public_path('storage/img/' . $filename);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }
}