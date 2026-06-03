<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KeepTrainee;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class KeepTraineeController extends Controller
{
    public function markKeeped(Request $request)
    {
        $data = $request->all();
        $isKept = KeepTrainee::where([
            'keeper_id' => $data['keeper_id'],
            'trainee_id' => $data['trainee_id']
        ])->first();
        
        if (isset($data['redirect'])) {
            try {
                if ($isKept) {
                    $isKept->delete();
                } else {
                    KeepTrainee::create($data);
                }
                return redirect()->back();
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'fail', 
                    'code' => 201, 
                    'message' => $e->getMessage(),
                    'action' => 'null'
                ]);
            }
        } else {
            if ($isKept) {
                try {
                    $isKept->delete();
                    return response()->json(['status' => 'success', 'code' => 200, 'message' => 'You have unkept this trainee!', 'action' => 'unkeep']);
                } catch (ModelNotFoundException $e) {
                    return response()->json(['status' => 'fail', 'code' => 201, 'message' => $e, 'action' => 'null']);
                }
            }
            $keepTrainee = KeepTrainee::create($data);
            return response()->json(['status' => 'success', 'code' => 200, 'message' => 'You have kept this trainee!', 'action' => 'keep']);
        }
    }
}
