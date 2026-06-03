<?php

namespace App\Filament\Resources\ResourceResource\Pages;

use App\Filament\Resources\ResourceResource;
use App\Models\AdminUser;
use App\Models\CgoUser;
use App\Models\CompanyRecruiter;
use App\Models\Content;
use App\Models\Resource;
use App\Models\SchoolKid;
use App\Models\TraineeUser;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewResource extends ViewRecord
{
    protected static string $resource = ResourceResource::class;
    protected static string $view = 'filament.resources.content.resource.content-detail';

    public $content;
    public $type;

    public function mount($record): void
    {
        parent::mount($record);
        $content = Resource::find($this->record->id);
        if($content) {
            $user = $this->getAuthorContent($content->system, $content->created_by);
            $content->author = $user;
            foreach ($content->comments as $item) {
                $user = $this->getAuthorContent($item->system, $item->answer_by);
                $item->user = $user;

                foreach ($item->children as $child) {
                    $childUser = $this->getAuthorContent($child->system, $child->answer_by);
                    $child->user = $childUser;
                }
            }
        }
        $this->content = $content;
        $this->content->thumbnail = asset('storage/'.$content->thumbnail);
        $this->type = 'resource';
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
}
