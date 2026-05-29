<?php

namespace App\Http\Controllers\Api\Trainee;

use App\Http\Controllers\Controller;
use App\Models\MobileAppVersion;
use Illuminate\Http\Request;

class MobileAppVersionController extends Controller
{
    public function store(Request $request) {
        $validated = $request->validate([
            'version' => 'required|string|max:255',
            'description' => 'nullable|string',
            'platform' => 'required|string|in:android,ios',
        ]);

        $version = MobileAppVersion::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Version added successfully',
            'data' => $version,
        ]);
    }


    public function latest(Request $request)
    {
        $platform = $request->query('platform');

        if (!$platform) {
            return response()->json([
                'success' => false,
                'message' => 'Platform is required (e.g., android or ios).',
            ], 400);
        }

        $latest = MobileAppVersion::where('platform', $platform)
            ->orderByDesc('id') // or 'created_at'
            ->first();

        if (!$latest) {
            return response()->json([
                'success' => false,
                'message' => 'No version found for the given platform.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $latest,
        ]);
    }
}
