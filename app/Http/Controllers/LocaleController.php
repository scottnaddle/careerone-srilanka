<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    public function setLocale($lang) {
        if (in_array($lang, ['en', 'sn', 'tm'])) {
            App::setLocale($lang);

            Session::put('locale', $lang);
        }

        return back();
    }
    public function showFile(Request $request)
    {
        $filePath = $request->get('file');
        if (!$filePath || !file_exists(public_path($filePath))) {
            abort(404);
        }
        return response()->file(public_path($filePath));
    }
}
