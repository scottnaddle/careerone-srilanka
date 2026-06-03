<?php

namespace App\Http\Controllers;

use App\Models\CounselingAttachment;
use App\Models\Event;
use App\Models\EventAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class EventAttachmentController extends Controller
{

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, $event_id)
    {
        $attachement = EventAttachment::where('id', $id)->first();
        if ($attachement) {
            if (file_exists($attachement->path))
                @unlink($attachement->path);
            $attachement->delete();

            $folder = 'storage/' . activeGuard() . '/events/attachment_details/' . $event_id;

            $event = Event::where('id', $event_id)->first();
            if ($event) {
                if ($event->attachments->count() <= 0) {
                    if (File::exists($folder)) File::deleteDirectory($folder);
                }
            }

            return redirect()->back();

        }


        return redirect()->back()->withErrors('This content is not exist or you dont have permission');
    }

    public function previewAttachment($id)
    {
        $attachement = EventAttachment::where('id', $id)->first();
        if ($attachement) {
            return response()->file($attachement->path);
        }

        return redirect()->back()->withErrors('This content is not exist or you dont have permission');
    }
    public function showFileCounseling($id)
    {
        $attachement = CounselingAttachment::where('id', $id)->first();
        if ($attachement) {
            $filePath = storage_path('app/public/' . $attachement->path);
            if (file_exists($filePath)) {
                return response()->file($filePath);
            }
            return redirect()->back()->withErrors('File not found.');
        }
        return redirect()->back()->withErrors('This content is not exist or you dont have permission');
    }
    

}
