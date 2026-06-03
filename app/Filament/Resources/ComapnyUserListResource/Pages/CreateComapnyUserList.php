<?php

namespace App\Filament\Resources\ComapnyUserListResource\Pages;

use App\Filament\Resources\ComapnyUserListResource;
use App\Models\CompanyRecruiter;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;
use App\Mail\RecruiterAccountCreated;
use Illuminate\Support\Facades\Mail;

class CreateComapnyUserList extends CreateRecord
{
    protected static string $resource = ComapnyUserListResource::class;
    protected $plainPassword;
    public function getHeading(): string|Htmlable {
        return trans('admin/performance.Create New Company Recruiter');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->plainPassword = $data['password'];
        $data['password'] = bcrypt($data['password']);
        $baseUsername = explode('@', $data['email'])[0];
        $username = $baseUsername;
        $counter = 1;
        while (CompanyRecruiter::where('username', $username)->exists()) {
            $username = $baseUsername . $counter++;
        }
        $data['username'] = $username;
        $data['verify_at'] = now();
        $data['email_verified_at'] = now();
        $data['verify_by'] = auth()->guard('admin')->user()->id;
        return $data;
    }
    protected function afterCreate(): void
    {
        $recruiter = $this->record;

        try {
            Mail::to($recruiter->email)->send(new RecruiterAccountCreated($recruiter, $this->plainPassword));
            // Bạn có thể thêm flash message thành công nếu muốn
            \Filament\Notifications\Notification::make()
                ->success()
                ->title('Email sent')
                ->body('Recruiter account created and email sent successfully.')
                ->send();
        } catch (\Exception $e) {
            // Ghi log lỗi nhưng không làm gián đoạn flow
            \Log::error('Failed to send recruiter account email: ' . $e->getMessage());
            \Filament\Notifications\Notification::make()
                ->warning()
                ->title('Email failed')
                ->body('Account created but email could not be sent. Error: ' . $e->getMessage())
                ->send();
        }
    }
}
