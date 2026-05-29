<?php

namespace App\Http\Controllers\Trainee;

use App\Http\Controllers\Controller;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompleteProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('trainee.auth');
    }

    public function show()
    {
        $user = Auth::guard('trainee')->user();
        $districts = District::orderBy('name')->get();
        return view('trainee.my-page.complete-profile', compact('user', 'districts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nic' => 'nullable|string|max:20|unique:trainee_users,nic,' . Auth::id(),
            'full_name' => 'required|string|min:2|max:100',
            'mobile' => 'nullable|string|max:20',
            'district_id' => 'nullable|exists:districts,id',
        ]);

        $user = Auth::guard('trainee')->user();
        $user->nic = $request->nic ?: null;
        $user->full_name = $request->full_name;
        $user->mobile = $request->mobile ?: null;
        $user->district_id = $request->district_id ?: null;
        $user->profile_incomplete = false;
        $user->save();

        return redirect()->route('trainee.my-page.my-page')
            ->with('message', __('trainee.my_page.profile_completed'));
    }
}
