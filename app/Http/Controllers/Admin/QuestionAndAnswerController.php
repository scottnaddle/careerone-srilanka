<?php

namespace App\Http\Controllers\Admin;

use App\Models\QNAAnswer;
use App\Http\Controllers\Controller;
use App\Http\Requests\QNAUpdateRequest;
use App\Models\QNA;
use App\Models\QnaAttachment;
use Illuminate\Support\Facades\File;
class QuestionAndAnswerController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyReply(QNAAnswer $qNAAnswer)
    {
        if ($qNAAnswer) {
            foreach ($qNAAnswer->children as $reply) {
                $reply->delete();
            }

            $qNAAnswer->delete();
            return response()->json(['success' => true, 'message' => 'Reply deleted successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Reply not found'], 404);
        }
    }

    public function destroy($id)
    {
        // dd($id);
        $qNA = QNA::where('id', $id)->first();
        if (!$qNA) {
            return redirect()->route('filament.admin.resources.information.q-as.index')->withErrors('Q&A not found or already deleted.');
        }
        foreach ($qNA->replies as $reply) {
            foreach ($reply->children as $childReply) {
                $childReply->delete();
            }
            $reply->delete();
        }

        foreach ($qNA->attachments as $attachment) {
            if (file_exists($attachment->path)) {
                @unlink($attachment->path);
            }
            $attachment->delete();
        }
        $folder = 'storage/' . activeGuard() . '/qnas/attachment_details/' . $id;
        if (File::exists($folder)) File::deleteDirectory($folder);

        $qNA->delete();

        return redirect()->route('filament.admin.resources.information.q-as.index')->with('success', 'Delete successfully');
    }

    public function update(QNAUpdateRequest $request, QNA $qNA)
    {
        if ($request->has('attachment_details')) {
            foreach ($request->file('attachment_details') as $attachment) {
                $mimeType = $attachment->getMimeType();
                switch ($mimeType) {
                    case 'application/msword':
                        $fileType = 'doc';
                        break;
                    case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
                        $fileType = 'docx';
                        break;
                    case 'application/pdf':
                        $fileType = 'pdf';
                        break;
                    case 'image/png':
                        $fileType = 'image';
                        break;
                    case 'image/jpg':
                        $fileType = 'image';
                        break;
                    case 'image/jpeg':
                        $fileType = 'image';
                        break;
                    default:
                        $fileType = 'Unknown';
                }
                $storage_path = storage_path('app/public/' . activeGuard() . '/qnas/attachment_details/' . $qNA->id);
                $filename = pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $attachment->getClientOriginalExtension();
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                $fileSize = number_format($attachment->getSize() / 1048576, 2) . " MB";
                $attachment->move($storage_path, $fileNameToStore);
                $path = 'storage/' . activeGuard() . '/qnas/attachment_details/' . $qNA->id . '/' . $fileNameToStore;
                $qnaAttachment = new QnaAttachment();
                $qnaAttachment->qna_id = $qNA->id;
                $qnaAttachment->file_name = $filename;
                $qnaAttachment->path = $path;
                $qnaAttachment->file_type = $fileType;
                $qnaAttachment->file_size = $fileSize;
                $qnaAttachment->save();
            }
        }
        $data = $request->all();
        $qNA->update($data);

        return redirect()->route('filament.admin.resources.information.q-as.view', ['record' => $qNA]);
    }

    public function destroyAttachment($id, $qna_id)
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
}
