<?php

namespace App\Filament\Pages;

use App\Models\AdminUser;
use App\Models\TraineeUser;
use App\Models\CgoUser;
use App\Models\CompanyRecruiter;
use App\Mail\UserPasswordReset;
use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Filament\Actions\Action;
use App\Services\Trainee\TraineeCasSyncService;

class EmergencyUserReset extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-triangle';
    protected static string $view = 'filament.pages.emergency-user-reset';

    public ?array $data = [];
    public $foundUser = null;
    public $userType = '';
    public $newlyGeneratedPassword = null;

    public function getTitle(): string
    {
        return __('emergency.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('emergency.title');
    }

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('userType')
                    ->label(__('emergency.user_type'))
                    ->options([
                        'admin' => __('emergency.types.admin'),
                        'trainee' => __('emergency.types.trainee'),
                        'cgo' => __('emergency.types.cgo'),
                        'company_recruiter' => __('emergency.types.recruiter'),
                    ])
                    ->required()
                    ->live()
                    ->afterStateUpdated(fn() => $this->resetState()),
                TextInput::make('searchValue')
                    ->label(__('emergency.search_label'))
                    ->placeholder(__('emergency.search_placeholder'))
                    ->required(),
            ])
            ->statePath('data');
    }

    private function resetState()
    {
        $this->foundUser = null;
        $this->newlyGeneratedPassword = null;
    }

    public function searchUser()
    {
        $this->resetState();
        $formData = $this->form->getState();
        $this->userType = $formData['userType'];
        $value = trim($formData['searchValue']);

        $user = match ($this->userType) {
            'admin' => AdminUser::where('email', $value)->orWhere('nic', $value)->first(),
            'trainee' => TraineeUser::where('email', $value)->orWhere('nic', $value)->first(),
            'cgo' => CgoUser::where('email', $value)->first(),
            'company_recruiter' => CompanyRecruiter::where('email', $value)->first(),
            default => null,
        };

        if (!$user) {
            Notification::make()->danger()->title(__('emergency.not_found'))->send();
        } else {
            $this->foundUser = $user;
            Notification::make()->success()->title(__('emergency.found_success'))->send();
        }
    }

    /**
     * Generate a random password that meets requirements:
     * - 8-16 characters
     * - At least 1 uppercase letter
     * - At least 1 number
     * - Only special character allowed is @
     */
    private function generateSecurePassword(int $length = 12): string
    {
        // Ensure length is between 8 and 16
        $length = max(8, min(16, $length));

        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numbers = '0123456789';
        $specialChar = '@'; // Only @ is allowed

        // Guarantee at least one of each required character type
        $password = [
            $uppercase[random_int(0, strlen($uppercase) - 1)],
            $numbers[random_int(0, strlen($numbers) - 1)],
            $specialChar, // Always use @
        ];

        // Fill the rest with random characters (only letters and numbers, no additional special chars)
        $allowedChars = $lowercase . $uppercase . $numbers;
        $remainingLength = $length - count($password);

        for ($i = 0; $i < $remainingLength; $i++) {
            $password[] = $allowedChars[random_int(0, strlen($allowedChars) - 1)];
        }

        // Shuffle to avoid predictable pattern (uppercase, number, @ at beginning)
        shuffle($password);

        return implode('', $password);
    }

    /**
     * Alternative: Generate password using Laravel's helper with custom rules
     * (Requires installing laravel/helpers package)
     */
    // private function generateSecurePasswordAlternative(): string
    // {
    //     return \Illuminate\Support\Str::password(12, letters: true, numbers: true, symbols: true, spaces: false);
    // }

    /**
     * Define the Reset Password action with a confirmation modal
     */
    public function resetPasswordAction(): Action
    {
        return Action::make('resetPassword')
            ->label(__('emergency.reset_btn'))
            ->color('danger')
            ->requiresConfirmation()
            ->modalHeading(__('emergency.confirm_modal_heading'))
            ->modalDescription(__('emergency.confirm_modal_desc'))
            ->form([
                TextInput::make('confirm_text')
                    ->label(__('emergency.confirm_input_label'))
                    ->placeholder('CONFIRM')
                    ->required()
                    ->rules(['in:CONFIRM'])
            ])
            ->action(function () {
                $this->performReset();
            });
    }

    protected function performReset()
    {
        if (!$this->foundUser) return;

        // Generate secure password meeting requirements
        $plainPassword = $this->generateSecurePassword(12); // You can adjust length (8-16)

        // Update the user information
        $this->foundUser->password = bcrypt($plainPassword);
        $this->foundUser->active = true;
        if ($this->userType != 'trainee') {
            $this->foundUser->verify_at = now();
            $this->foundUser->verify_by = auth()->guard('admin')->id();
        }

        if (in_array('email_verified_at', $this->foundUser->getFillable())) {
            $this->foundUser->email_verified_at = now();
        }

        $this->foundUser->save();

        if ($this->userType === 'trainee') {
            try {
                // Temporarily store the plain password to send to CAS
                $this->foundUser->password = $plainPassword;
                $casSyncService = new TraineeCasSyncService();
                $casSyncService->changePassword($this->foundUser);

                Notification::make()
                    ->success()
                    ->title('Synced SSO account')
                    ->send();
            } catch (\Exception $e) {
                Notification::make()
                    ->warning()
                    ->title('Failed to sync')
                    ->body($e->getMessage())
                    ->send();
            }
        }
        $this->newlyGeneratedPassword = $plainPassword;

        try {
            Mail::to($this->foundUser->email)->send(new UserPasswordReset($this->foundUser, $plainPassword, $this->userType));
            Notification::make()
                ->success()
                ->title(__('emergency.reset_success_title'))
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->warning()
                ->title(__('emergency.email_failed'))
                ->body($e->getMessage())
                ->send();
        }
    }
}
