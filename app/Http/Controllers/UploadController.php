<?php

namespace App\Http\Controllers;

use App\Models\TemporatyFile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UploadController extends Controller
{
    public function store(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $pathInfo = pathinfo($originName, PATHINFO_FILENAME);
            $extensionName = $request->file('upload')->getClientOriginalExtension();
            $fileName = $pathInfo . '-' . time() . '.' . $extensionName;

            $request->file('upload')->move(public_path('storage/attachment_details'), $fileName);
            $url = asset('storage/attachment_details/' . $fileName);

            return response()->json(['fileName' => $fileName, 'uploaded' => 1, 'url' => $url]);
        }

        return response()->json(['uploaded' => 0, 'error' => ['message' => 'File not uploaded.']]);
    }

    public function uploadFile(Request $request)
    {
        $path = storage_path('app/public/attachment_details');
        !file_exists($path) && mkdir($path, 0777, true);
        $file = $request->file('file');
        $fileSize = $file->getSize() / 1024 / 1024;

        $name = time() . '-' . $file->getClientOriginalName();
        $file->move($path, $name);
        return response()->json([
            'name' => $name,
            'file_size' => $fileSize
        ]);
    }

    public function fileDestroy(Request $request)
    {
        $path = storage_path('app/public/attachment_details/') . $request->filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return $request->filename;
    }
}
