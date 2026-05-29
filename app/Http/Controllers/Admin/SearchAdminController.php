<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\DivisionalSecretariats;
use App\Models\Institute;
use App\Models\Province;
use Illuminate\Http\Request;


class SearchAdminController extends Controller
{
    public function showDistrict(Request $request, $id)
{
    $province = Province::findOrFail($id);

    $districts = District::where('prov_id', $id)->get();
    $district_ids = $districts->pluck('id')->toArray();
    $institutes = Institute::whereIn('dist_id', $district_ids)->orderBy('name', 'asc')->get();

    return response()->json([
        'districts' => $districts,
        'institutes' => $institutes
    ]);
}

public function showDivision(Request $request, $id)
{
    // Retrieve the specified district
    $district = District::findOrFail($id);
    $divisions = DivisionalSecretariats::where('dist_id', $id)->get();
    $division_ids = $divisions->pluck('ds_code',)->toArray();
    $institutes = Institute::whereIn('ds_id', $division_ids)->get();

    return response()->json([
        'divisions' => $divisions,
        'institutes' => $institutes
    ]);
}

    public function showInstitute(Request $request, $id){
        $institute= Institute::where('ds_id', $id)->get();
        return response()->json($institute);
    }
}
