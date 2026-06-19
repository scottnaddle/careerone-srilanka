<?php

namespace App\Http\Controllers;

use App\Models\TemporatyFile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    /**
     * Whitelisted, non-executable upload extensions.
     */
    private const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf', 'doc', 'docx', 'xls', 'xlsx'];
    private const ALLOWED_MIMES = 'jpg,jpeg,png,gif,webp,pdf,doc,docx,xls,xlsx';

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'upload' => 'required|file|mimes:' . self::ALLOWED_MIMES . '|max:10240', // 10 MB
        ]);

        if ($validator->fails()) {
            return response()->json(['uploaded' => 0, 'error' => ['message' => $validator->errors()->first('upload')]]);
        }

        $file = $request->file('upload');
        // Server-generated, random filename + whitelisted extension only — never trust the client name/extension.
        $extension = strtolower($file->getClientOriginalExtension());
        if (!in_array($extension, self::ALLOWED_EXTENSIONS, true)) {
            return response()->json(['uploaded' => 0, 'error' => ['message' => 'File type not allowed.']]);
        }
        $fileName = Str::uuid() . '.' . $extension;

        $file->move(public_path('storage/attachment_details'), $fileName);
        $url = asset('storage/attachment_details/' . $fileName);

        return response()->json(['fileName' => $fileName, 'uploaded' => 1, 'url' => $url]);
    }

    public function uploadFile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:' . self::ALLOWED_MIMES . '|max:10240', // 10 MB
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first('file')], 422);
        }

        $path = storage_path('app/public/attachment_details');
        !file_exists($path) && mkdir($path, 0777, true);
        $file = $request->file('file');
        $fileSize = $file->getSize() / 1024 / 1024;

        $extension = strtolower($file->getClientOriginalExtension());
        if (!in_array($extension, self::ALLOWED_EXTENSIONS, true)) {
            return response()->json(['error' => 'File type not allowed.'], 422);
        }
        $name = Str::uuid() . '.' . $extension;
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
