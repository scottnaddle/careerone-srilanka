<?php

namespace App\Http\Controllers\Admin;

use App\Constant\Constant;
use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use App\Models\CareerTestTraineeResult;
use App\Models\District;
use App\Models\Institute;
use App\Models\TvetHeadquater;
use App\Models\TvetType;
use Filament\Facades\Filament;
use Filament\Notifications\Auth\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CareerTestController extends Controller
{
    public function viewResult($id) {
        $result = CareerTestTraineeResult::where('id', $id)->first();
        if ($result) {
            switch ($result->test_type) {
                case 1:
                    return view('homepage.career-test.results.career-interest-test-result', compact('result'));
                case 2:
                    return view('homepage.career-test.results.career-key-test-result', compact('result'));
                case 3:
                case 4:
                    return \Redirect::back()->withErrors(['msg' => 'This test type result view is not yet available.']);
                default:
                    return \Redirect::back()->withErrors(['msg' => 'Unknown test type.']);
            }

        }
        return \Redirect::back()->withErrors(['msg' => 'Sorry, We can not find this result in system!']);
    }

    public function downloadResult($id) {
        $result = CareerTestTraineeResult::where('id', $id)->first();
        if ($result) {
            return response()->download($result->attachment);
        }
        return redirect()->route('trainee.career-guidance.career-test.list')->withErrors(trans('system.information.content_management.not_found'));
    }
}
