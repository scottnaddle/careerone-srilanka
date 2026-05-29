<?php

namespace App\Http\Controllers;

use App\Models\Institute;
use Illuminate\Http\Request;

class InstituteController extends Controller
{
    public function index() {
        $data = Institute::orderBy('name', 'asc')->get();
        return response()->json($data);
    }
}
