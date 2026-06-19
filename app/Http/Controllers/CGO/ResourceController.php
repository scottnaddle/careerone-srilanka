<?php

namespace App\Http\Controllers\CGO;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use App\Models\CareerGuidanceCategory;
use App\Models\CgoUser;
use App\Models\CompanyRecruiter;
use App\Models\Content;
use App\Models\Resource;
use App\Models\SchoolKid;
use App\Models\TraineeUser;
use App\Services\ContentViewLoggerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ResourceController extends Controller
{
    public function getResourceList(Request $request)
    {
        $keyword = $request->input('keyword', '');
        $categoryId = $request->input('category', 'all');
        $order = $request->input('order', 'desc');

        $contentsQuery = Resource::query();

        // Filter by keyword if provided
        if (!empty($keyword)) {
            $contentsQuery->where(function ($query) use ($keyword) {
                $query->where('title', 'ilike', "%$keyword%")
                    ->orWhere('intro', 'ilike', "%$keyword%");
            });
        }

        // Filter by category unless it is 'all'
        if ($categoryId !== 'all') {
            $contentsQuery->where('category_id', $categoryId);
        }

        // Sort by created_at
        $contentsQuery->orderBy('created_at', $order);

        $count = $contentsQuery->count();
        // Paginate
        $contents = $contentsQuery->paginate(9);

        // Get the list of categories to pass to the view
        $categories = CareerGuidanceCategory::all();

        return view('cgo.information.resource.list', compact(
            'contents', 'keyword', 'categories', 'categoryId', 'order', 'count'
        ));
    }

    public function getContentDetails($contentId, ContentViewLoggerService $logger) {
        $contentId = base64_decode($contentId);
        $writeLog = $logger->logView('resource', $contentId);
        $content = Resource::where('id', $contentId)->first();
        if ($content) {
            $user = $this->getAuthorContent($content->system, $content->created_by);
            $content->author = $user;
            $content->thumbnail = '/storage/'.$content->thumbnail;
            foreach ($content->comments as $item) {
                $user = $this->getAuthorContent($item->system, $item->answer_by);
                $item->user = $user;

                foreach ($item->children as $child) {
                    $childUser = $this->getAuthorContent($child->system, $child->answer_by);
                    $child->user = $childUser;
                }
            }
            return view('cgo.information.resource.content-details', compact('content'));
        }else {
            return back()->withErrors('Can not find the content');
        }

    }

    public function getAuthorContent($system, $id)
    {
        $user = null;
        switch ($system) {
            case 'cgo':
                $user = CgoUser::where(['id' => $id])->first();
                break;
            case 'company':
                $user = CompanyRecruiter::where(['id' => $id])->first();
                break;
            case 'admin':
                $user = AdminUser::where(['id' => $id])->first();
                break;
            case 'trainee':
                $user = TraineeUser::where(['id' => $id])->first();
                break;
            case 'schoolkid':
                $user = SchoolKid::where(['id' => $id])->first();
                break;
        }
        return $user;
    }

    public function downloadDocument($id) {
        $document = Resource::find($id);

        if ($document) {
            $attachmentDetails = 'storage/'.$document->attachment_details;
            if ($attachmentDetails && File::exists($attachmentDetails)) {
                $path = $attachmentDetails;

                // If it is a PDF, display it in the browser
                if ($document->content_type === 'document' && \Illuminate\Support\Str::endsWith($path, '.pdf')) {
                    return response()->file($path, [
                        'Content-Type' => 'application/pdf',
                        'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
                    ]);
                }

                // If it is not a PDF, download it
                return response()->download($path);
            }
        }

        return redirect()
            ->route('cgo.informations.content-management.documents.list')
            ->withErrors(trans('system.information.content_management.not_found'));
    }


}
