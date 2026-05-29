<?php

namespace App\Http\Controllers;

use App\Models\OJT;
use App\Models\OJTAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class OJTAttachmentController extends Controller
{

    public function download($id) {
        $attachFile = OJTAttachment::where('id', $id)->first();
        if ($attachFile) {
            if (isset($attachFile->path)) {
                $path = $attachFile->path;
                return response()->download($path);
            }
        }
        return redirect()->back()->withErrors('Can not find this content!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, $ojt_id)
    {
        $attachement = OJTAttachment::where('id', $id)->first();
        if ($attachement) {
            if (file_exists($attachement->path))
                @unlink($attachement->path);
            $attachement->delete();

            $folder = 'storage/' . activeGuard() . '/job-support/ojt/attachment/' . $ojt_id;

            $ojt = OJT::where('id', $ojt_id)->first();
            if ($ojt) {
                if ($ojt->attachFiles->count() <= 0) {
                    if (File::exists($folder)) File::deleteDirectory($folder);
                }
            }

            return redirect()->back();
        }

        return redirect()->back()->withErrors('This content is not exist or you dont have permission');
    }
}
