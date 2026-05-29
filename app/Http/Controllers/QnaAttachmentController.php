<?php

namespace App\Http\Controllers;

use App\Models\QNA;
use App\Models\QnaAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class QnaAttachmentController extends Controller
{

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, $qna_id)
    {
        $attachement = QnaAttachment::where('id', $id)->first();
        if ($attachement) {
            if (file_exists($attachement->path))
                @unlink($attachement->path);
            $attachement->delete();
            $folder = 'storage/' . activeGuard() . '/qnas/attachment_details/' . $qna_id;

            $qna = QNA::where('id', $qna_id)->first();
            if ($qna) {
                if ($qna->attachments->count() <= 0) {
                    if (File::exists($folder)) File::deleteDirectory($folder);
                }
            }
            return redirect()->back();
        }

        return redirect()->back()->withErrors('This content is not exist or you dont have permission');
    }

    public function previewAttachment($id)
    {
        $attachement = QnaAttachment::where('id', $id)->first();
        if ($attachement) {
            return response()->file($attachement->path);
        }

        return redirect()->back()->withErrors('This content is not exist or you dont have permission');
    }
}
