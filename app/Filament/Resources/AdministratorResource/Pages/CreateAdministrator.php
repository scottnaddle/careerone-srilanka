<?php

namespace App\Filament\Resources\AdministratorResource\Pages;

use App\Filament\Resources\AdministratorResource;
use App\Mail\AdministratorAccountCreated;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Mail;
use Filament\Notifications\Notification;

class CreateAdministrator extends CreateRecord
{
    protected static string $resource = AdministratorResource::class;
    public ?string $plainPassword = null;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Store the plain password before hashing
        if (isset($data['password'])) {
            $this->plainPassword = $data['password'];
            $data['password'] = bcrypt($data['password']);
        }

        // Set username from email
        if (isset($data['email'])) {
            $data['username'] = $data['email'];
        }

        // Set default values
        $data['active'] = true;
        $data['verify_at'] = now();
        $data['email_verified_at'] = now();
        $data['verify_by'] = auth()->guard('admin')->id() ?? null;

        // Do not set tvet_type here; let handleRoleAssignment handle it
        if (isset($data['is_naita_admin']) && $data['is_naita_admin'] === true) {
            $data['tvet_type'] = 'NAITA';
        }

        return $data;
    }

    protected function afterCreate(): void
    {
        $administrator = $this->record;
        $formData = $this->form->getRawState();

        // Call handleRoleAssignment to handle role and tvet_type
        if (isset($formData['is_naita_admin'])) {
            AdministratorResource::handleRoleAssignment($administrator, $formData['is_naita_admin'], $formData);
        }

        try {
            // Send email if a plain password is available
            if ($this->plainPassword) {
                Mail::to($administrator->email)->send(new AdministratorAccountCreated($administrator, $this->plainPassword));

                Notification::make()
                    ->success()
                    ->title('Administrator Created')
                    ->body("Administrator {$administrator->fullName} has been created successfully. Login details have been sent to {$administrator->email}")
                    ->send();
            } else {
                Notification::make()
                    ->success()
                    ->title('Administrator Created')
                    ->body("Administrator {$administrator->fullName} has been created successfully.")
                    ->send();
            }

        } catch (\Exception $e) {
            \Log::error('Failed to send administrator account email: ' . $e->getMessage());

            Notification::make()
                ->warning()
                ->title('Account Created But Email Failed')
                ->body('Administrator account created but email could not be sent. Error: ' . $e->getMessage())
                ->send();
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
